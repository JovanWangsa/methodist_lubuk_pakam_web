@props(['kunci' => 'global.banner_ppdb'])
@php
    $b = \App\Support\KontenPublik::blok($kunci);
    $t = \App\Support\KontenPublik::blok('global.tombol_ppdb');
@endphp
{{-- Banner PPDB di akhir konten. Model dan tombolnya mengikuti Homepage (desain Stitch bagian 7)
     dan dipakai sama di semua halaman kecuali Halaman 1. --}}
<section class="w-full bg-surface py-space-xl">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin">
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary via-primary-container to-primary p-space-lg md:p-space-xl shadow-xl text-on-primary">
<div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-space-lg">
<div class="max-w-2xl text-center lg:text-left">
<span class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-secondary-container text-on-secondary font-label-sm text-label-sm uppercase font-semibold mb-space-sm">
<span class="material-symbols-outlined text-[16px]">campaign</span> {{ $b['label'] ?? '' }}
            </span>
<h3 class="font-display-hero text-headline-md md:text-headline-lg font-bold mb-space-xs">
              {{ $b['judul'] ?? '' }}
            </h3>
<p class="font-body-md text-body-md text-surface-container-highest/90">
              {{ $b['deskripsi'] ?? '' }}
            </p>
</div>
<div class="flex flex-col sm:flex-row items-center gap-space-sm flex-shrink-0 w-full sm:w-auto">
<a class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-space-xs px-space-lg py-3 rounded-lg bg-secondary-container text-on-secondary font-label-lg text-label-lg shadow-lg hover:brightness-110 transition-transform hover:-translate-y-0.5" href="{{ route('ppdb.daftar') }}">
<span class="material-symbols-outlined text-[20px]">how_to_reg</span>
<span>{{ $t['daftar'] ?? '' }}</span>
</a>
<a class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-space-xs px-space-md py-3 rounded-lg bg-surface-container-lowest/15 backdrop-blur-md text-on-primary font-label-lg text-label-lg hover:bg-surface-container-lowest/25 transition-colors" href="{{ \App\Support\Tautan::panduan() }}">
<span class="material-symbols-outlined text-[20px]">menu_book</span>
<span>{{ $t['panduan'] ?? '' }}</span>
</a>
<a class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-space-xs px-space-md py-3 rounded-lg bg-tertiary-container text-tertiary-fixed font-label-lg text-label-lg hover:brightness-125 transition-colors" href="{{ \App\Support\Tautan::whatsapp() }}" rel="noopener" target="_blank">
<span class="material-symbols-outlined text-[20px]">chat</span>
<span>{{ $t['wa'] ?? '' }}</span>
</a>
</div>
</div>
</div>
</div>
</section>