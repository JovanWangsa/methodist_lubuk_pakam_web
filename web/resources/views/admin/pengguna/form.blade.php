@extends('admin.layouts.panel')

@php($baru = ! $pengguna->exists)
@php($diriSendiri = $pengguna->is(auth()->user()))

@section('judul', $baru ? 'Tambah Pengguna' : 'Ubah Pengguna')

@section('isi')
<form method="POST" action="{{ $baru ? route('admin.pengguna.store') : route('admin.pengguna.update', $pengguna) }}" class="a-kartu max-w-2xl space-y-space-md">
    @csrf
    @unless ($baru) @method('PUT') @endunless
    <div>
        <label class="a-label" for="name">Nama</label>
        <input class="a-input" id="name" name="name" type="text" value="{{ old('name', $pengguna->name) }}" required>
    </div>
    <div>
        <label class="a-label" for="email">Email</label>
        <input class="a-input" id="email" name="email" type="email" value="{{ old('email', $pengguna->email) }}" required>
    </div>
    <div>
        <label class="a-label" for="role">Peran</label>
        <select class="a-input" id="role" name="role" @disabled($diriSendiri)>
            @foreach (\App\Models\User::NAMA_PERAN as $kode => $nama)
                <option value="{{ $kode }}" @selected(old('role', $pengguna->role) === $kode)>{{ $nama }}</option>
            @endforeach
        </select>
        @if ($diriSendiri)
            <input name="role" type="hidden" value="{{ $pengguna->role }}">
            <p class="a-bantuan">Peran dan status akun Anda sendiri tidak bisa diubah di sini.</p>
        @endif
    </div>
    <label class="flex items-center gap-2 font-body-md text-body-md">
        <input name="is_active" type="hidden" value="{{ $diriSendiri ? 1 : 0 }}">
        <input class="rounded border-outline-variant text-primary" name="is_active" type="checkbox" value="1" @checked(old('is_active', $pengguna->is_active)) @disabled($diriSendiri)>
        Akun aktif (bisa masuk ke panel admin)
    </label>
    <fieldset class="border-t border-surface-container pt-space-md space-y-space-md">
        <legend class="font-label-lg text-label-lg text-primary">{{ $baru ? 'Password' : 'Ganti password (kosongkan bila tidak diganti)' }}</legend>
        <div>
            <label class="a-label" for="password">Password</label>
            <input class="a-input" id="password" name="password" type="password" autocomplete="new-password" @required($baru)>
            <p class="a-bantuan">Minimal 8 karakter, berisi huruf dan angka.</p>
        </div>
        <div>
            <label class="a-label" for="password_confirmation">Ulangi password</label>
            <input class="a-input" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" @required($baru)>
        </div>
    </fieldset>
    <div class="flex gap-space-sm">
        <button class="a-tombol-utama" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">save</span> Simpan</button>
        <a class="a-tombol-kedua" href="{{ route('admin.pengguna.index') }}">Batal</a>
    </div>
</form>
@endsection
