<?php

use App\Http\Controllers\BooksProxyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SarprasHealthController;
use App\Http\Controllers\SarprasProxyController;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('books.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books',        [BooksProxyController::class, 'index'])->name('books.index');
    Route::get('/books/create',        [BooksProxyController::class, 'create'])->name('books.create');
    Route::get('/books/{id}',   [BooksProxyController::class, 'show'])->name('books.show');

    // nanti tombol tambah/update/delete bisa ditaruh di sini juga
    Route::post('/books',       [BooksProxyController::class, 'store'])->name('books.store');
    Route::patch('/books/{id}', [BooksProxyController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BooksProxyController::class, 'destroy'])->name('books.destroy');

    // export
    Route::get('/books/export/excel', [BooksProxyController::class, 'exportExcel'])->name('books.export.excel');
    Route::get('/books/export/pdf',   [BooksProxyController::class, 'exportPdf'])->name('books.export.pdf');

    // Health Check
    Route::get('/health/sarpras', [SarprasHealthController::class, 'show'])->name('health.sarpras.show');

    Route::get('/proxy/master/institutions', [SarprasProxyController::class, 'institutions'])->name('proxy.master.institutions');
    Route::get('/proxy/master/buildings',    [SarprasProxyController::class, 'buildings'])->name('proxy.master.buildings');
    Route::get('/proxy/master/rooms',        [SarprasProxyController::class, 'rooms'])->name('proxy.master.rooms');
    Route::get('/proxy/master/persons',      [SarprasProxyController::class, 'persons'])->name('proxy.master.persons');
});

require __DIR__ . '/auth.php';
