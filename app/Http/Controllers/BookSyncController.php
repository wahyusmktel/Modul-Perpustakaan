<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookSyncService;

class BookSyncController extends Controller
{
    public function index()
    {
        // halaman dengan tombol Sync + ringkasan
        $last = cache()->get('books_sync_last');
        $sum  = cache()->get('books_sync_summary', []);
        return view('books.sync', compact('last', 'sum'));
    }

    public function run(Request $request, BookSyncService $svc)
    {
        // filter opsional dari form
        $filters = [
            'q'      => $request->get('q'),
            'year'   => $request->get('year'),
            'status' => $request->get('status') ?: ['Aktif', 'Dipinjam', 'Maintenance', 'Rusak'], // exclude Disposed by default
        ];

        $summary = $svc->sync($filters);
        cache()->forever('books_sync_last', now()->toDateTimeString());
        cache()->forever('books_sync_summary', $summary);

        return redirect()->route('books.sync.index')->with('success', 'Sinkronisasi selesai.');
    }
}
