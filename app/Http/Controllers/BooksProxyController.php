<?php

namespace App\Http\Controllers;

use App\Services\SarprasClient;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BooksProxyController extends Controller
{
    public function index(Request $request, SarprasClient $api)
    {
        // Ambil filter
        $q      = (string) $request->get('q', '');
        $year   = $request->get('year');                 // string/int atau null
        $status = (array) $request->get('status', []);   // array

        // Paksa per_page = 10
        $query = array_merge($request->all(), [
            'per_page' => 10,
        ]);
        // Pastikan status[] dikirim sebagai array (bukan string)
        if (!empty($status)) {
            $query['status'] = $status;
        }

        // Ambil dari API Sarpras
        $resp  = $api->listBooks($query);

        // Bentuk paginator lokal dari JSON API (seperti sebelumnya)
        $data = collect($resp['data'] ?? []);
        $meta = $resp['meta'] ?? [];
        $currentPage = (int)($meta['current_page'] ?? 1);
        $perPage     = (int)($meta['per_page'] ?? 10);
        $total       = (int)($meta['total'] ?? $data->count());

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $data,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('books.index'), 'query' => $request->query()]
        );

        // Opsi Tahun & Status (sederhana; bisa nanti diganti dari API kalau perlu)
        $currentYear = (int) now()->year;
        $years = range($currentYear, 1990); // desc
        $allStatuses = ['Aktif', 'Dipinjam', 'Maintenance', 'Rusak', 'Disposed'];

        return view('books.index', [
            'books'      => $data,
            'paginator'  => $paginator,
            'q'          => $q,
            'year'       => $year,
            'statuses'   => $status,
            'years'      => $years,
            'allStatuses' => $allStatuses,
        ]);
    }

    public function show(int $id, SarprasClient $api)
    {
        $book = $api->getBook($id);
        return view('books.show', compact('book'));
    }

    public function create()
    {
        // Sederhana dulu: form manual (ID referensi diisi angka).
        // Next step bisa kita tarik master data dari Sarpras lewat endpoint khusus.
        $allStatuses = ['Aktif', 'Dipinjam', 'Maintenance', 'Rusak', 'Disposed'];
        $years = range((int)now()->year, 1990);
        return view('books.create', compact('allStatuses', 'years'));
    }

    public function store(Request $request, SarprasClient $api)
    {
        // Minimal payload yang diterima API Sarpras
        $payload = $request->validate([
            'name'                => 'required|string|max:255',
            'purchase_year'       => 'required|digits:4|integer|min:1900',
            'institution_id'      => 'required|integer',
            'building_id'         => 'required|integer',
            'room_id'             => 'required|integer',
            'faculty_id'          => 'required|integer',
            'department_id'       => 'required|integer',
            'person_in_charge_id' => 'required|integer',
            'asset_function_id'   => 'required|integer',
            'funding_source_id'   => 'required|integer',
            'purchase_cost'       => 'required|numeric|min:0',
            'status'              => 'nullable|string',
        ]);

        // Lempar ke Sarpras
        $api->createBook($payload);

        return redirect()
            ->route('books.index', ['q' => $payload['name']])
            ->with('success', 'Buku berhasil dibuat di Sarpras.');
    }

    public function update(int $id, Request $request, SarprasClient $api)
    {
        $payload = $request->validate([
            'name'               => 'sometimes|required|string|max:255',
            'purchase_year'      => 'sometimes|required|digits:4',
            'institution_id'     => 'sometimes|required|integer',
            'building_id'        => 'nullable|integer',
            'room_id'            => 'nullable|integer',
            'person_in_charge_id' => 'nullable|integer',
            'purchase_cost'      => 'nullable|numeric',
            'status'             => 'nullable|string',
        ]);
        $api->updateBook($id, $payload);
        return back()->with('success', 'Buku diupdate (Sarpras).');
    }

    public function destroy(int $id, SarprasClient $api)
    {
        $api->deleteBook($id);
        return redirect()->route('books.index')->with('success', 'Buku dihapus (Sarpras).');
    }

    // ===== Export Helpers =====
    private function fetchAllBooks(Request $request, SarprasClient $api): Collection
    {
        // tarik semua halaman sesuai filter aktif
        $page = 1;
        $all = collect();
        do {
            $query = array_merge($request->all(), ['per_page' => 100, 'page' => $page]);
            $resp = $api->listBooks($query);
            $chunk = collect($resp['data'] ?? []);
            $all = $all->merge($chunk);

            $meta  = $resp['meta'] ?? [];
            $last  = (int)($meta['last_page'] ?? $page);
            $page++;
        } while ($chunk->isNotEmpty() && $page <= $last);

        return $all;
    }

    public function exportExcel(Request $request, SarprasClient $api)
    {
        $rows = $this->fetchAllBooks($request, $api)->map(function ($a) {
            return [
                'Kode Aset YPT' => $a['asset_code_ypt'] ?? '-',
                'Nama'          => $a['name'] ?? '-',
                'Tahun'         => $a['purchase_year'] ?? '-',
                'Gedung'        => $a['building'] ?? '-',
                'Ruang'         => $a['room'] ?? '-',
                'PIC'           => $a['person_in_charge'] ?? '-',
                'Status'        => $a['status'] ?? '-',
                'Harga (Rp)'    => $a['purchase_cost'] ?? 0,
            ];
        })->values()->toArray();

        $export = new class($rows) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function __construct(private array $data) {}
            public function array(): array
            {
                return $this->data;
            }
            public function headings(): array
            {
                return array_keys($this->data[0] ?? ['Data' => 'Kosong']);
            }
        };

        $file = 'perpus-buku-' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download($export, $file);
    }

    public function exportPdf(Request $request, SarprasClient $api)
    {
        $rows = $this->fetchAllBooks($request, $api)->map(function ($a) {
            return [
                'asset_code_ypt' => $a['asset_code_ypt'] ?? '-',
                'name'           => $a['name'] ?? '-',
                'purchase_year'  => $a['purchase_year'] ?? '-',
                'building'       => $a['building'] ?? '-',
                'room'           => $a['room'] ?? '-',
                'person_in_charge' => $a['person_in_charge'] ?? '-',
                'status'         => $a['status'] ?? '-',
                'purchase_cost'  => $a['purchase_cost'] ?? 0,
            ];
        })->values();

        $pdf = Pdf::loadView('books.report-pdf', [
            'rows'    => $rows,
            'printed' => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('perpus-buku-' . now()->format('Ymd_His') . '.pdf');
    }
}
