<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Aktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Masuk dan keluar panel admin. Percobaan login dibatasi 5 kali per menit
 * untuk setiap pasangan email dan alamat IP.
 */
class AuthController extends Controller
{
    public const MAKS_PERCOBAAN = 5;

    public function formLogin(): View
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [], ['password' => 'password']);

        $kunci = 'login|'.Str::lower($data['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($kunci, self::MAKS_PERCOBAAN)) {
            $detik = RateLimiter::availableIn($kunci);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan masuk. Coba lagi dalam {$detik} detik.",
            ]);
        }

        if (! Auth::attempt([...$data, 'is_active' => true], $request->boolean('ingat'))) {
            RateLimiter::hit($kunci, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah, atau akun sudah dinonaktifkan.',
            ]);
        }

        RateLimiter::clear($kunci);
        $request->session()->regenerate();
        Aktivitas::catat(Aktivitas::MASUK, 'Panel admin');

        return redirect()->intended(route('admin.dasbor'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Aktivitas::catat(Aktivitas::KELUAR, 'Panel admin');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda sudah keluar.');
    }
}
