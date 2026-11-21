<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Aktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/** Kelola akun admin dan perannya (khusus Super Admin). */
class PenggunaController extends Controller
{
    public function index(): View
    {
        return view('admin.pengguna.index', [
            'pengguna' => User::query()->orderByDesc('is_active')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.pengguna.form', ['pengguna' => new User(['role' => User::ROLE_ADMIN_KONTEN, 'is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validasi($request);
        $pengguna = User::query()->create($data);
        Aktivitas::catat(Aktivitas::TAMBAH, 'Pengguna: '.$pengguna->email, $pengguna->id);

        return redirect()->route('admin.pengguna.index')->with('status', 'Akun '.$pengguna->name.' dibuat.');
    }

    public function edit(User $pengguna): View
    {
        return view('admin.pengguna.form', ['pengguna' => $pengguna]);
    }

    public function update(Request $request, User $pengguna): RedirectResponse
    {
        $data = $this->validasi($request, $pengguna);

        if ($pengguna->is($request->user())) {
            // Super Admin tidak boleh mengunci dirinya sendiri.
            $data['role'] = User::ROLE_SUPER_ADMIN;
            $data['is_active'] = true;
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $pengguna->update($data);
        Aktivitas::catat(Aktivitas::UBAH, 'Pengguna: '.$pengguna->email, $pengguna->id);

        return redirect()->route('admin.pengguna.index')->with('status', 'Akun '.$pengguna->name.' diperbarui.');
    }

    public function destroy(Request $request, User $pengguna): RedirectResponse
    {
        abort_if($pengguna->is($request->user()), 422, 'Anda tidak bisa menghapus akun sendiri.');

        Aktivitas::catat(Aktivitas::HAPUS, 'Pengguna: '.$pengguna->email, $pengguna->id);
        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('status', 'Akun dihapus.');
    }

    /** @return array<string, mixed> */
    private function validasi(Request $request, ?User $pengguna = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($pengguna)],
            'role' => ['required', Rule::in(array_keys(User::NAMA_PERAN))],
            'password' => [$pengguna ? 'nullable' : 'required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [], ['name' => 'nama', 'role' => 'peran']);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
