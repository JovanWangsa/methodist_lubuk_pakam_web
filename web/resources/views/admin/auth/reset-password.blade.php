@extends('admin.layouts.tamu')

@section('judul', 'Password Baru')

@section('isi')
<h1 class="font-headline-sm text-headline-sm text-primary mb-space-md">Buat password baru</h1>
<form method="POST" action="{{ route('admin.password.simpan') }}" class="space-y-space-md">
    @csrf
    <input name="token" type="hidden" value="{{ $token }}">
    <div>
        <label class="a-label" for="email">Email</label>
        <input class="a-input" id="email" name="email" type="email" value="{{ old('email', $email) }}" required>
        @error('email')<p class="a-galat">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="a-label" for="password">Password baru</label>
        <input class="a-input" id="password" name="password" type="password" autocomplete="new-password" required>
        <p class="a-bantuan">Minimal 8 karakter, berisi huruf dan angka.</p>
        @error('password')<p class="a-galat">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="a-label" for="password_confirmation">Ulangi password baru</label>
        <input class="a-input" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
    </div>
    <button class="a-tombol-utama w-full" type="submit">Simpan password</button>
</form>
@endsection
