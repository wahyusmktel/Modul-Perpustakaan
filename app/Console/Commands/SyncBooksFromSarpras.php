<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BookSyncService;

class SyncBooksFromSarpras extends Command
{
    protected $signature = 'sarpras:sync-books {--year=} {--status=*}';
    protected $description = 'Sinkron buku & eksemplar dari Sarpras';

    public function handle(BookSyncService $svc)
    {
        $filters = [
            'year'   => $this->option('year'),
            'status' => $this->option('status') ?: ['Aktif', 'Dipinjam', 'Maintenance', 'Rusak'],
        ];
        $sum = $svc->sync($filters);
        $this->info('Sync done: ' . json_encode($sum));
        return self::SUCCESS;
    }
}
