<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as AturanPassword;
use Illuminate\View\View;

/**
 * Lupa password: kirim tautan ke email, lalu atur password baru lewat tautan itu.
 */
class LupaPasswordController extends Controller
{
    public function form(): View
    {
        return view('admin.auth.lupa-password');
    }

    public function kirim(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_THROTTLED) {
            return back()->withErrors(['email' => 'Tunggu sebentar sebelum meminta tautan lagi.']);
        }

        // Pesan yang sama untuk email terdaftar maupun tidak, supaya daftar akun admin tidak bisa ditebak.
        return back()->with('status', 'Bila email tersebut terdaftar, tautan atur ulang password sudah dikirim.');
    }

    public function formReset(Request $request, string $token): View
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', AturanPassword::min(8)->letters()->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill(['password' => $password, 'remember_token' => Str::random(60)])->save();
                event(new PasswordReset($user));
            },
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Tautan atur ulang tidak valid atau sudah kedaluwarsa. Minta tautan baru.']);
        }

        return redirect()->route('admin.login')->with('status', 'Password sudah diganti. Silakan masuk dengan password baru.');
    }
}
