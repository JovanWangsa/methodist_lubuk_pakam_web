<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;

/** GET /api/v1/units dan /api/v1/units/{kode}: data unit pendidikan (hanya baca). */
class UnitController extends Controller
{
    public function index(): JsonResponse
    {
        $units = Unit::query()
            ->orderBy('urutan')
            ->get(['kode', 'nama', 'deskripsi_singkat', 'gambar']);

        return response()->json(['data' => $units]);
    }

    public function show(string $kode): JsonResponse
    {
        $unit = Unit::query()
            ->where('kode', strtolower($kode))
            ->first(['kode', 'nama', 'deskripsi_singkat', 'gambar', 'npsn', 'akreditasi', 'alamat']);

        if (! $unit) {
            return response()->json(['message' => 'Unit tidak ditemukan.'], 404);
        }

        return response()->json(['data' => $unit]);
    }
}
