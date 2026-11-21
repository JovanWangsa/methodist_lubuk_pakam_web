@extends('admin.layouts.panel')

@section('judul', 'Profil Saya')

@section('isi')
<form method="POST" action="{{ route('admin.profil.simpan') }}" class="a-kartu max-w-2xl space-y-space-md">
    @csrf
    @method('PUT')
    <div>
        <label class="a-label" for="name">Nama</label>
        <input class="a-input" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <span class="a-label">Email dan peran</span>
        <p class="font-body-md text-body-md">{{ $user->email }} &middot; {{ $user->namaPeran() }}</p>
    </div>
    <fieldset class="border-t border-surface-container pt-space-md space-y-space-md">
        <legend class="font-label-lg text-label-lg text-primary">Ganti password (opsional)</legend>
        <div>
            <label class="a-label" for="password_lama">Password lama</label>
            <input class="a-input" id="password_lama" name="password_lama" type="password" autocomplete="current-password">
        </div>
        <div>
            <label class="a-label" for="password">Password baru</label>
            <input class="a-input" id="password" name="password" type="password" autocomplete="new-password">
            <p class="a-bantuan">Minimal 8 karakter, berisi huruf dan angka.</p>
        </div>
        <div>
            <label class="a-label" for="password_confirmation">Ulangi password baru</label>
            <input class="a-input" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
        </div>
    </fieldset>
    <button class="a-tombol-utama" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">save</span> Simpan</button>
</form>
@endsection
