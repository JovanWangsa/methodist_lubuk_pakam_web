<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Penjaga panel admin. Tanpa parameter: cukup akun aktif.
 * Dengan parameter, misalnya peran:super_admin,admin_konten: akun aktif dengan salah satu peran itu.
 */
class PastikanPeran
{
    public function handle(Request $request, Closure $next, string ...$peran): Response
    {
        /** @var User|null $user */
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('admin.login'));
        }

        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Akun Anda sudah dinonaktifkan. Hubungi Super Admin.']);
        }

        if ($peran !== [] && ! $user->punyaPeran(...$peran)) {
            abort(403, 'Peran Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
