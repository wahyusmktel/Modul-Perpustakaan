<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookSyncService
{
    public function __construct(private \App\Services\SarprasClient $sarpras) {}

    /**
     * Sinkron judul & eksemplar dari Sarpras.
     * @param array $filters contoh: ['q'=>'','year'=>null,'status'=>['Aktif']]
     * @return array summary
     */
    public function sync(array $filters = []): array
    {
        $createdBooks = 0;
        $updatedBooks = 0;
        $createdItems = 0;
        $updatedItems = 0;

        // tarik per halaman
        $page = 1;
        do {
            $resp = $this->sarpras->listBooks(array_merge($filters, [
                'per_page' => 100,
                'page' => $page,
                'sort' => 'name',
                'dir' => 'asc',
            ]));

            $data = $resp['data'] ?? [];
            if (empty($data)) break;

            DB::transaction(function () use ($data, &$createdBooks, &$updatedBooks, &$createdItems, &$updatedItems) {
                // Group per judul (title) + tahun (opsional) → kamu bisa ubah strategi grouping:
                $groups = collect($data)->groupBy(function ($a) {
                    // Normalisasi nama untuk judul
                    $title = trim((string)($a['name'] ?? 'Tanpa Judul'));
                    // Kalau mau bedakan per tahun, sertakan '|' . ($a['purchase_year'] ?? '')
                    return Str::of($title)->squish()->upper();
                });

                foreach ($groups as $key => $assets) {
                    $first = $assets->first();
                    $title = trim((string)($first['name'] ?? 'Tanpa Judul'));
                    $year  = $first['purchase_year'] ?? null;

                    // cari judul (books) by title + year (opsional)
                    $book = Book::query()
                        ->where('title', $title)
                        ->when($year, fn($q) => $q->where('year', (int)$year))
                        ->first();

                    $payloadBook = [
                        'title'    => $title,
                        'year'     => $year ? (int)$year : null,
                        // metadata tambahan bisa diisi nanti (authors, publisher, isbn...) via form/edit
                        'status'   => $book->status ?? 'available',
                    ];

                    if (!$book) {
                        $book = Book::create(array_merge([
                            'sarpras_asset_id' => $first['id'] ?? null, // contoh simpan salah satu
                        ], $payloadBook));
                        $createdBooks++;
                    } else {
                        $book->fill($payloadBook);
                        if ($book->isDirty()) {
                            $book->save();
                            $updatedBooks++;
                        }
                    }

                    // buat/cek eksemplar untuk setiap aset fisik
                    foreach ($assets as $a) {
                        $sarprasId = (int)($a['id'] ?? 0);
                        if (!$sarprasId) continue;

                        $barcode = $a['asset_code_ypt'] ?? null;
                        $statusMap = [
                            'Aktif'      => 'available',
                            'Dipinjam'   => 'on_loan',
                            'Maintenance' => 'repair',
                            'Rusak'      => 'poor',
                            'Disposed'   => 'lost', // atau archived jika mau
                        ];
                        $status = $statusMap[$a['status'] ?? 'Aktif'] ?? 'available';

                        $item = BookItem::query()->where('sarpras_asset_id', $sarprasId)->first();

                        if (!$item) {
                            // tentukan copy_no berikutnya
                            $nextCopy = (int) (BookItem::where('book_id', $book->id)->max('copy_no') ?? 0) + 1;

                            $item = BookItem::create([
                                'book_id'           => $book->id,
                                'sarpras_asset_id'  => $sarprasId,
                                'copy_no'           => $nextCopy,
                                'barcode'           => $barcode ?: ('BK-' . $book->id . '-' . $nextCopy),
                                'condition'         => 'good',
                                'status'            => $status,
                            ]);
                            $createdItems++;
                        } else {
                            $old = $item->only(['status', 'barcode']);
                            $item->status  = $status;
                            $item->barcode = $item->barcode ?: ($barcode ?: $item->barcode); // isi jika kosong
                            if ($item->isDirty()) {
                                $item->save();
                                $updatedItems++;
                            }

                            // pastikan tetap tertaut ke judul yang benar (kalau grouping berubah)
                            if ($item->book_id !== $book->id) {
                                $item->book_id = $book->id;
                                $item->save();
                            }
                        }
                    }
                }
            });

            $meta = $resp['meta'] ?? [];
            $last = (int)($meta['last_page'] ?? $page);
            $page++;
        } while ($page <= $last);

        return compact('createdBooks', 'updatedBooks', 'createdItems', 'updatedItems');
    }
}
