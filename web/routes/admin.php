<?php

use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DasborController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\LupaPasswordController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\SlideController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
| Panel admin di /admin. Dimuat dari routes/web.php dengan awalan nama "admin.".
*/

$super = User::ROLE_SUPER_ADMIN;
$konten = User::ROLE_ADMIN_KONTEN;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.kirim');
    Route::get('lupa-password', [LupaPasswordController::class, 'form'])->name('password.lupa');
    Route::post('lupa-password', [LupaPasswordController::class, 'kirim'])->middleware('throttle:5,1')->name('password.kirim');
    Route::post('reset-password', [LupaPasswordController::class, 'reset'])->name('password.simpan');
});

Route::middleware(['auth', 'peran'])->group(function () use ($super, $konten) {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', DasborController::class)->name('dasbor');
    Route::get('profil', [ProfilController::class, 'edit'])->name('profil');
    Route::put('profil', [ProfilController::class, 'update'])->name('profil.simpan');

    Route::middleware("peran:{$super},{$konten}")->group(function () {
        Route::resource('slide', SlideController::class)->except('show');
        Route::get('konten/grup/{grup}', [KontenController::class, 'index'])->name('konten.index');
        Route::get('konten/{kunci}', [KontenController::class, 'edit'])->name('konten.edit');
        Route::put('konten/{kunci}', [KontenController::class, 'update'])->name('konten.update');
        Route::get('pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    Route::middleware("peran:{$super}")->group(function () {
        Route::resource('pengguna', PenggunaController::class)->except('show')->parameters(['pengguna' => 'pengguna']);
        Route::get('aktivitas', AktivitasController::class)->name('aktivitas');
    });
});
