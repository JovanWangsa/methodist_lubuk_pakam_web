<?php

use App\Http\Controllers\HalamanPublikController;
use Illuminate\Support\Facades\Route;

// Sprint 1: Halaman 1 sampai 3.
Route::get('/', [HalamanPublikController::class, 'pembuka'])->name('pembuka');
Route::get('/beranda', [HalamanPublikController::class, 'beranda'])->name('beranda');
Route::get('/sejarah', [HalamanPublikController::class, 'sejarah'])->name('sejarah');

// Menu yang halamannya dibangun di sprint berikutnya. Diganti saat fiturnya selesai.
Route::get('/unit-pendidikan', [HalamanPublikController::class, 'segera'])
    ->defaults('judul', 'Unit Pendidikan')->defaults('sprint', 'Sprint 2')->name('unit.index');
Route::get('/daftar', [HalamanPublikController::class, 'segera'])
    ->defaults('judul', 'Pendaftaran PPDB')->defaults('sprint', 'Sprint 3')->name('ppdb.daftar');
Route::get('/e-learning', [HalamanPublikController::class, 'segera'])
    ->defaults('judul', 'E-Learning')->defaults('sprint', 'Sprint 4')->name('elearning');
