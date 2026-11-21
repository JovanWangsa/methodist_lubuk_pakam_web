@extends('admin.layouts.tamu')

@section('judul', 'Masuk')

@section('isi')
<h1 class="font-headline-sm text-headline-sm text-primary mb-space-md">Masuk ke panel admin</h1>
<form method="POST" action="{{ route('admin.login.kirim') }}" class="space-y-space-md" novalidate>
    @csrf
    <div>
        <label class="a-label" for="email">Email</label>
        <input class="a-input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
        @error('email')<p class="a-galat">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="a-label" for="password">Password</label>
        <input class="a-input" id="password" name="password" type="password" autocomplete="current-password" required>
        @error('password')<p class="a-galat">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2 font-body-sm text-body-sm">
            <input class="rounded border-outline-variant text-primary" name="ingat" type="checkbox" value="1"> Ingat saya
        </label>
        <a class="font-body-sm text-body-sm text-primary hover:underline" href="{{ route('admin.password.lupa') }}">Lupa password?</a>
    </div>
    <button class="a-tombol-utama w-full" type="submit">
        <span aria-hidden="true" class="material-symbols-outlined text-[20px]">login</span> Masuk
    </button>
</form>
@endsection
