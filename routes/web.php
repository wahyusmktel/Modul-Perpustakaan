<?php

use App\Http\Controllers\BooksProxyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SarprasHealthController;
use App\Http\Controllers\SarprasProxyController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberImportController;
use App\Http\Controllers\BookSyncController;
use App\Http\Controllers\CirculationController;
use App\Http\Controllers\ReservationController;

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

    Route::get('/proxy/master/faculties',       [SarprasProxyController::class, 'faculties'])->name('proxy.master.faculties');
    Route::get('/proxy/master/departments',     [SarprasProxyController::class, 'departments'])->name('proxy.master.departments');
    Route::get('/proxy/master/asset-functions', [SarprasProxyController::class, 'assetFunctions'])->name('proxy.master.asset-functions');
    Route::get('/proxy/master/funding-sources', [SarprasProxyController::class, 'fundingSources'])->name('proxy.master.funding-sources');

    Route::get('/members',          [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create',   [MemberController::class, 'create'])->name('members.create');
    Route::post('/members',          [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::patch('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');

    Route::get('/members/import',           [MemberImportController::class, 'form'])->name('members.import.form');
    Route::post('/members/import',           [MemberImportController::class, 'import'])->name('members.import.handle');
    Route::get('/members/import/template',  [MemberImportController::class, 'template'])->name('members.import.template');

    Route::get('/admin/books/sync',     [BookSyncController::class, 'index'])->name('books.sync.index');
    Route::post('/admin/books/sync/run', [BookSyncController::class, 'run'])->name('books.sync.run');

    Route::get('/circulation/loan',          [CirculationController::class, 'loanForm'])->name('circulation.loan.form');
    Route::post('/circulation/loan/add-item', [CirculationController::class, 'loanAddItem'])->name('circulation.loan.addItem');
    Route::post('/circulation/loan/commit',   [CirculationController::class, 'loanCommit'])->name('circulation.loan.commit');
    Route::post('/circulation/loan/reset',    [CirculationController::class, 'loanReset'])->name('circulation.loan.reset');

    Route::get('/circulation/return',        [CirculationController::class, 'returnForm'])->name('circulation.return.form');
    Route::post('/circulation/return/process', [CirculationController::class, 'returnProcess'])->name('circulation.return.process');
    Route::post('/circulation/loan/{loan}/renew', [CirculationController::class, 'loanRenew'])
        ->name('circulation.loan.renew');

    // Reservasi
    Route::get('/reservations',            [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations',            [ReservationController::class, 'store'])->name('reservations.store');         // member + book_id
    Route::post('/reservations/{res}/ready', [ReservationController::class, 'markReady'])->name('reservations.ready');    // staff: tandai siap
    Route::post('/reservations/{res}/pick', [ReservationController::class, 'markPicked'])->name('reservations.pick');    // staff: diambil
    Route::post('/reservations/{res}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});

require __DIR__ . '/auth.php';
