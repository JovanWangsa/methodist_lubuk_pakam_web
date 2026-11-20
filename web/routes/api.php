<?php

use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Support\Facades\Route;

/*
| API JSON (awalan /api otomatis dari bootstrap/app.php). Menggantikan layanan Express,
| karena hosting hanya menjalankan PHP. Dibatasi 120 permintaan per menit per IP.
*/
Route::prefix('v1')->middleware('throttle:120,1')->group(function () {
    Route::get('health', StatusController::class)->name('api.health');
    Route::get('units', [UnitController::class, 'index'])->name('api.units.index');
    Route::get('units/{kode}', [UnitController::class, 'show'])->name('api.units.show');
});
