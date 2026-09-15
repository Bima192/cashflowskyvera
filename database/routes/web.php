<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [TransactionController::class, 'index'])->name('kas.index');
    Route::post('/simpan', [TransactionController::class, 'store'])->name('kas.store');
    Route::delete('/hapus/{id}', [TransactionController::class, 'destroy'])->name('kas.destroy');

    // Transaksi
    Route::get('/transaksi', [TransactionController::class, 'transaksi'])->name('kas.transaksi');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kas.kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kas.kategori.store');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kas.kategori.destroy');

    // Rekening
    Route::get('/rekening', [RekeningController::class, 'index'])->name('kas.rekening');
    Route::post('/rekening', [RekeningController::class, 'store'])->name('kas.rekening.store');
    Route::delete('/rekening/{id}', [RekeningController::class, 'destroy'])->name('kas.rekening.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('kas.laporan');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('kas.laporan.pdf');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('kas.laporan.excel');
    Route::get('/laporan/export/pdf-tahunan', [LaporanController::class, 'exportTahunanPdf'])->name('kas.laporan.pdf.tahunan');
    Route::get('/laporan/export/excel-tahunan', [LaporanController::class, 'exportTahunanExcel'])->name('kas.laporan.excel.tahunan');
});