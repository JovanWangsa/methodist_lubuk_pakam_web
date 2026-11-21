<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\InstagramToken;
use App\Models\PpdbPendaftar;
use App\Models\Slide;
use App\Models\Unit;
use App\Models\User;
use Illuminate\View\View;

class DasborController extends Controller
{
    public function __invoke(): View
    {
        $pendaftar = PpdbPendaftar::query()
            ->selectRaw('unit_id, status, count(*) as jumlah')
            ->groupBy('unit_id', 'status')
            ->get();

        return view('admin.dasbor', [
            'units' => Unit::query()->orderBy('urutan')->get(),
            'pendaftar' => $pendaftar,
            'totalPendaftar' => (int) $pendaftar->sum('jumlah'),
            'slideAktif' => Slide::query()->where('aktif', true)->count(),
            'slideTanpaFoto' => Slide::query()->where('aktif', true)->whereNull('gambar')->count(),
            'penggunaAktif' => User::query()->where('is_active', true)->count(),
            'token' => InstagramToken::query()->latest('id')->first(),
            'aktivitas' => ActivityLog::query()->with('user')->latest('id')->limit(8)->get(),
        ]);
    }
}
