@extends('layouts.situs')

@section('judul', $judul)

@section('konten')
<div class="flex flex-col w-full">
<section class="w-full bg-surface py-space-xl">
<div class="max-w-3xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin py-space-xl text-center">
<span class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase font-semibold mb-space-md">
<span class="material-symbols-outlined text-[16px]">schedule</span> Sedang dibangun
</span>
<h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">{{ $judul }}</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-space-xs">Halaman ini sedang dibangun dan dijadwalkan selesai di {{ $sprint }}.</p>
<a class="mt-space-lg inline-flex items-center gap-space-xs px-space-lg py-3 rounded-lg bg-primary-container text-on-primary font-label-lg text-label-lg" href="{{ route('beranda') }}">
<span class="material-symbols-outlined text-[20px]">home</span>
<span>Kembali ke Beranda</span>
</a>
</div>
</section>
<x-banner-ppdb />
</div>
@endsection
