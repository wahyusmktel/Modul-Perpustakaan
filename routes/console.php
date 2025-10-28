<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan harian jam 01:00 (pakai timezone app: config('app.timezone'))
Schedule::command('sarpras:sync-books')
    ->dailyAt('01:00')
    ->withoutOverlapping()
    ->onOneServer(); // kalau pakai multi instance
