@extends('layouts.dasar')

{{-- Halaman 1: Home pembuka. Markup persis desain Stitch "Hal. 1: Home Splash". Tanpa footer, sesuai desain. --}}
@section('body_kelas', 'bg-surface font-body-md text-body-md text-on-surface antialiased min-h-screen flex items-center justify-center')

@php
    $total = $slides->count();
    $waTampil = $pengaturan['no_admin_tampil'] ?? '';
@endphp

@section('isi')
<main class="w-full"><div class="flex flex-col w-full relative min-h-screen overflow-hidden select-none bg-primary text-on-primary" data-pembuka>
<div class="absolute inset-0 w-full h-full z-0 overflow-hidden" id="slides-container">
@foreach ($slides as $slide)
<div @class([
    'slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out bg-cover bg-center',
    'opacity-100 scale-105 transition-transform duration-10000' => $loop->first,
    'opacity-0 pointer-events-none' => ! $loop->first,
]) data-judul="{{ $slide->judul }}" role="img" aria-label="{{ $slide->alt ?? $slide->judul }}" style="{{ $slide->gambar ? "background-image: url('".asset($slide->gambar)."')" : 'background-color: #d1d5db' }}"></div>
@endforeach
<div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/50 to-primary/80 mix-blend-multiply pointer-events-none"></div>
<div class="absolute inset-0 bg-radial from-transparent via-primary/40 to-primary/90 pointer-events-none"></div>
</div>
<div class="relative z-10 w-full max-w-7xl mx-auto px-6 pt-8 pb-32 flex flex-col justify-between min-h-screen">
<header class="flex flex-col sm:flex-row items-center justify-between gap-4 py-2">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-fixed flex items-center justify-center shadow-lg shadow-black/20">
<span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
</div>
<div>
<div class="flex items-center gap-2">
<span class="font-headline-sm text-headline-sm font-bold tracking-tight text-surface-bright">{{ $hero['merek'] ?? '' }}</span>
<span class="font-label-sm text-label-sm uppercase tracking-widest px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-fixed font-semibold">{{ $hero['merek_label'] ?? '' }}</span>
</div>
<p class="font-label-sm text-label-sm text-primary-fixed tracking-wider uppercase">{{ $pengaturan['lembaga_naungan'] ?? '' }}</p>
</div>
</div>
<div class="flex items-center gap-3">
<div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-lowest/10 backdrop-blur-md text-surface-bright">
<span class="material-symbols-outlined text-secondary-fixed-dim text-lg" style="font-variation-settings: 'FILL' 1;">verified</span>
<span class="font-label-md text-label-md">{{ $pengaturan['akreditasi'] ?? '' }}</span>
</div>
<a class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-label-md text-label-md font-semibold hover:bg-tertiary-fixed-dim transition-all shadow-md" href="{{ \App\Support\Tautan::whatsapp() }}" rel="noopener noreferrer" target="_blank">
<span class="material-symbols-outlined text-lg">chat</span>
<span>{{ $hero['admisi_label'] ?? '' }}: {{ $waTampil }}</span>
</a>
</div>
</header>
<div class="flex flex-col items-center text-center my-auto px-4 max-w-4xl mx-auto py-8">
<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-surface-container-lowest/15 backdrop-blur-md mb-6 shadow-sm">
<span class="material-symbols-outlined text-secondary-fixed text-base">church</span>
<span class="font-label-md text-label-md text-primary-fixed font-medium tracking-wide">{{ $hero['lencana'] ?? '' }}</span>
</div>
<h1 class="font-display-hero text-display-hero text-surface-bright tracking-tight mb-4 drop-shadow-md">
        {{ $hero['judul_1'] ?? '' }} <br/>
<span class="text-secondary-fixed">{{ $hero['judul_2'] ?? '' }}</span>
</h1>
<div class="flex items-center justify-center gap-3 text-surface-container-high mb-6">
<span class="h-px w-8 bg-secondary-fixed/60"></span>
<p class="font-headline-sm text-headline-sm italic tracking-widest text-secondary-fixed font-light">
          {{ $pengaturan['moto'] ?? '' }}
        </p>
<span class="h-px w-8 bg-secondary-fixed/60"></span>
</div>
<p class="font-body-lg text-body-lg text-surface-container-low max-w-2xl mb-10 leading-relaxed font-light drop-shadow">
        {{ $hero['deskripsi'] ?? '' }}
      </p>
<div class="flex flex-col sm:flex-row items-center gap-4 w-full justify-center">
<a class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-secondary-container text-on-secondary-fixed font-headline-sm text-headline-sm font-bold shadow-xl shadow-secondary-container/20 hover:scale-105 transition-all duration-300" href="{{ route('beranda') }}">
<span>{{ $hero['tombol_jelajahi'] ?? '' }}</span>
<span class="material-symbols-outlined transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
</a>
<a class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-surface-container-lowest/10 hover:bg-surface-container-lowest/20 backdrop-blur-md text-surface-bright font-label-lg text-label-lg transition-all" href="{{ \App\Support\Tautan::katalog() }}">
<span class="material-symbols-outlined text-secondary-fixed">download</span>
<span>{{ $hero['tombol_brosur'] ?? '' }}</span>
</a>
</div>
</div>
<div class="w-full flex flex-col md:flex-row items-center justify-between gap-4 pt-4 pb-2">
<div class="flex items-center gap-3">
<button aria-label="Slide Sebelumnya" class="w-10 h-10 rounded-full bg-surface-container-lowest/15 hover:bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center text-surface-bright transition-all" id="prev-slide" type="button">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<div class="font-label-lg text-label-lg text-primary-fixed tracking-widest px-2">
<span class="text-surface-bright font-bold" id="slide-num">01</span> / <span class="opacity-60">{{ str_pad((string) $total, 2, '0', STR_PAD_LEFT) }}</span>
</div>
<button aria-label="Slide Selanjutnya" class="w-10 h-10 rounded-full bg-surface-container-lowest/15 hover:bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center text-surface-bright transition-all" id="next-slide" type="button">
<span class="material-symbols-outlined">chevron_right</span>
</button>
<div aria-live="polite" class="hidden sm:inline-block font-label-md text-label-md text-surface-container-low pl-2 font-medium" id="slide-title">
          {{ $slides->first()?->judul }}
        </div>
</div>
<div class="flex items-center gap-1.5" id="dots-container">
@foreach ($slides as $slide)
<button aria-label="Slide {{ $loop->iteration }}" @class(['dot h-1.5 rounded-full transition-all', 'w-6 bg-secondary-fixed' => $loop->first, 'w-2 bg-surface-container-lowest/30 hover:bg-surface-container-lowest/60' => ! $loop->first]) data-index="{{ $loop->index }}" type="button"></button>
@endforeach
</div>
<div class="hidden lg:flex items-center gap-3 bg-surface-container-lowest/10 backdrop-blur-md px-4 py-2 rounded-xl text-left">
<span class="material-symbols-outlined text-secondary-fixed text-2xl">school</span>
<div>
<div class="font-label-sm text-label-sm text-secondary-fixed font-bold uppercase tracking-wider">{{ $hero['ppdb_label'] ?? '' }}</div>
<div class="font-body-sm text-body-sm text-surface-bright">{{ $hero['ppdb_teks'] ?? '' }}</div>
</div>
</div>
</div>
</div>
<nav aria-label="Menu utama" class="fixed bottom-4 inset-x-0 z-50 flex justify-center px-4 pointer-events-none">
<div class="w-full max-w-4xl bg-surface-container-lowest/90 backdrop-blur-xl text-on-surface rounded-2xl shadow-2xl p-2 pointer-events-auto flex items-center justify-between gap-1 sm:gap-2">
@foreach ($hero['menu'] ?? [] as $item)
@if ($loop->first)
<a class="flex-1 flex flex-col items-center justify-center py-2 px-1 rounded-xl text-primary bg-primary-fixed/30 font-semibold transition-all group" href="{{ route($item['rute']) }}">
<span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">{{ $item['ikon'] }}</span>
<span class="font-label-sm text-label-sm mt-0.5">{{ $item['teks'] }}</span>
</a>
@elseif ($loop->last)
<a class="flex-1 flex flex-col items-center justify-center py-2 px-1 rounded-xl bg-secondary text-on-secondary font-bold hover:brightness-110 transition-all shadow-md" href="{{ route($item['rute']) }}">
<span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">{{ $item['ikon'] }}</span>
<span class="font-label-sm text-label-sm mt-0.5">{{ $item['teks'] }}</span>
</a>
@else
<a class="flex-1 flex flex-col items-center justify-center py-2 px-1 rounded-xl text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all group" href="{{ route($item['rute']) }}">
<span class="material-symbols-outlined text-xl">{{ $item['ikon'] }}</span>
<span class="font-label-sm text-label-sm mt-0.5">{{ $item['teks'] }}</span>
</a>
@endif
@endforeach
</div>
</nav>
</div>
</main>
@endsection

@push('scripts')
    @vite('resources/js/pembuka.js')
@endpush
