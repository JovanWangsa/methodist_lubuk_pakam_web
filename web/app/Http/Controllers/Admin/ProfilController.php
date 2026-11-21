<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Aktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/** Ganti nama dan password akun sendiri. */
class ProfilController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profil', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'password_lama' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [], ['name' => 'nama', 'password_lama' => 'password lama', 'password' => 'password baru']);

        $user->name = $data['name'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();
        Aktivitas::catat(Aktivitas::UBAH, 'Profil sendiri', $user->id);

        return back()->with('status', 'Profil tersimpan.');
    }
}
