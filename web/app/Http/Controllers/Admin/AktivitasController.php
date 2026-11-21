<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\View\View;

/** Log aktivitas: siapa mengubah apa (khusus Super Admin). */
class AktivitasController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.aktivitas', [
            'log' => ActivityLog::query()->with('user')->latest('id')->paginate(30),
        ]);
    }
}
