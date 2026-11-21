@extends('admin.layouts.tamu')

@section('judul', 'Lupa Password')

@section('isi')
<h1 class="font-headline-sm text-headline-sm text-primary mb-space-xs">Lupa password</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">Masukkan email akun admin. Kami kirimkan tautan untuk membuat password baru.</p>
<form method="POST" action="{{ route('admin.password.kirim') }}" class="space-y-space-md">
    @csrf
    <div>
        <label class="a-label" for="email">Email</label>
        <input class="a-input" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
        @error('email')<p class="a-galat">{{ $message }}</p>@enderror
    </div>
    <button class="a-tombol-utama w-full" type="submit">
        <span aria-hidden="true" class="material-symbols-outlined text-[20px]">mail</span> Kirim tautan
    </button>
    <p class="text-center"><a class="font-body-sm text-body-sm text-primary hover:underline" href="{{ route('admin.login') }}">Kembali ke halaman masuk</a></p>
</form>
@endsection
