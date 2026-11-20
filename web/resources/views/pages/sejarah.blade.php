@extends('layouts.situs')

{{-- Halaman 3: Sejarah. Markup persis desain Stitch "Hal 3: Sejarah" (header dan footer memakai versi Hal. 2). --}}
@section('judul', 'Sejarah')
@section('deskripsi', 'Sejarah, visi, misi, dan tujuan '.($pengaturan['nama_sekolah'] ?? ''))
@section('body_kelas', 'bg-surface font-body-md text-body-md text-on-surface antialiased')
@section('main_kelas', 'w-full pt-29 bg-surface')

@use('App\Support\TeksFormat')

@php
    $h = $hero;
    $bio = $biografi;
    $lm = $linimasa;
    $vm = $visiMisi;
    $pim = $galeri['pimpinan'] ?? [];
    $fas = $galeri['fasilitas'] ?? [];
    $keg = $galeri['kegiatan'] ?? [];
@endphp

@section('konten')
<div class="flex flex-col w-full">
<!-- Hero Section Bleed under standard Shell Header -->
<section class="relative w-full -mt-29 pt-36 pb-20 lg:pb-28 bg-gradient-to-b from-primary via-primary-container to-surface overflow-hidden">
<div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>
<div class="absolute top-1/2 -right-40 w-[30rem] h-[30rem] rounded-full bg-tertiary-fixed-dim/15 blur-3xl pointer-events-none"></div>
<div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<div class="lg:col-span-7 space-y-6">
<div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-lowest/15 backdrop-blur-md text-secondary-fixed">
<span class="material-symbols-outlined text-[18px]">history_edu</span>
<span class="font-label-md text-label-md uppercase tracking-wider font-semibold">{{ $h['label'] ?? '' }}</span>
</div>
<h1 class="font-display-hero text-display-hero text-on-primary tracking-tight">
            {{ $h['judul_1'] ?? '' }} <br/>
<span class="text-secondary-fixed">{{ $h['judul_aksen'] ?? '' }}</span> <br/>
            {{ $h['judul_2'] ?? '' }}
          </h1>
<p class="font-body-lg text-body-lg text-primary-fixed max-w-xl">
            {{ $h['deskripsi'] ?? '' }}
          </p>
<div class="pt-2 flex flex-wrap items-center gap-4">
<a class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-secondary text-on-secondary font-label-lg text-label-lg shadow-lg hover:bg-secondary-container hover:text-on-secondary-container transition-all" href="#linimasa">
<span>{{ $h['tombol_1'] ?? '' }}</span>
<span class="material-symbols-outlined text-[18px]">arrow_downward</span>
</a>
<a class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface-container-lowest/10 backdrop-blur-md text-on-primary font-label-lg text-label-lg hover:bg-surface-container-lowest/20 transition-all" href="#biografi">
<span>{{ $h['tombol_2'] ?? '' }}</span>
<span class="material-symbols-outlined text-[18px]">menu_book</span>
</a>
</div>
<!-- Quick Stats Pill Bar -->
<div class="pt-6 grid grid-cols-3 gap-4 border-t border-primary-fixed/20 max-w-lg">
@foreach ($h['statistik'] ?? [] as $st)
<div>
<p class="font-headline-lg text-headline-lg {{ $st['kelas'] }} font-bold leading-none">{{ $st['nilai'] }}</p>
<p class="font-label-sm text-label-sm text-primary-fixed mt-1">{{ $st['label'] }}</p>
</div>
@endforeach
</div>
</div>
<div class="lg:col-span-5 relative">
<div class="relative mx-auto max-w-md lg:max-w-none">
<div class="absolute -inset-3 rounded-2xl bg-gradient-to-tr from-secondary/30 to-tertiary-fixed/30 transform rotate-2 blur-sm"></div>
<div class="relative bg-surface-container-lowest rounded-2xl p-3 shadow-2xl overflow-hidden">
<div class="h-96 w-full rounded-xl overflow-hidden relative">
<x-foto :src="$foto['hero'] ?? null" :alt="$h['kartu_judul'] ?? ''" class="w-full h-full object-cover" />
<div class="absolute inset-0 bg-gradient-to-t from-on-surface/80 via-transparent to-transparent flex flex-col justify-end p-6">
<span class="px-2.5 py-1 rounded-full bg-secondary text-on-secondary font-label-sm text-label-sm w-fit font-semibold mb-1">{{ $h['kartu_label'] ?? '' }}</span>
<h3 class="font-headline-sm text-headline-sm text-on-primary">{{ $h['kartu_judul'] ?? '' }}</h3>
<p class="font-body-sm text-body-sm text-primary-fixed">{{ $h['kartu_isi'] ?? '' }}</p>
</div>
</div>
<div class="p-4 bg-surface-container-low rounded-xl mt-3 flex items-start gap-3">
<span class="material-symbols-outlined text-secondary text-[28px] shrink-0">format_quote</span>
<p class="font-body-sm text-body-sm text-on-surface-variant italic">
                  {{ $h['kutipan'] ?? '' }}
                  <span class="block font-label-sm text-label-sm font-semibold text-primary not-italic mt-1">{{ $h['kutipan_sumber'] ?? '' }}</span>
</p>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Section 3: Biografi Sekolah & Warisan Rohani -->
<section class="w-full py-20 bg-surface" id="biografi">
<div class="max-w-7xl mx-auto px-6 lg:px-12">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<div class="lg:col-span-5 order-2 lg:order-1 relative">
<div class="relative space-y-4">
<div class="rounded-2xl overflow-hidden shadow-xl bg-surface-container">
<x-foto :src="$foto['arsip_1'] ?? null" alt="Foto arsip sejarah sekolah" class="w-full h-80 object-cover" />
</div>
<div class="grid grid-cols-2 gap-4">
<div class="rounded-xl overflow-hidden shadow-md bg-surface-container-high h-44">
<x-foto :src="$foto['arsip_2'] ?? null" alt="Foto arsip siswa" class="w-full h-full object-cover" />
</div>
<div class="rounded-xl bg-primary text-on-primary p-6 flex flex-col justify-between shadow-md">
<span class="material-symbols-outlined text-[32px] text-secondary-fixed">auto_stories</span>
<div>
<h4 class="font-headline-sm text-headline-sm">{{ $bio['pijar_judul'] ?? '' }}</h4>
<p class="font-body-sm text-body-sm text-primary-fixed mt-1">{{ $bio['pijar_isi'] ?? '' }}</p>
</div>
</div>
</div>
</div>
</div>
<div class="lg:col-span-7 order-1 lg:order-2 space-y-6">
<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-high text-primary">
<span class="material-symbols-outlined text-[16px]">church</span>
<span class="font-label-md text-label-md uppercase tracking-wider font-bold">{{ $bio['label'] ?? '' }}</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary">
            {{ $bio['judul'] ?? '' }}
          </h2>
<div class="space-y-4 font-body-md text-body-md text-on-surface-variant">
@foreach ($bio['paragraf'] ?? [] as $paragraf)
<p>
              {{ TeksFormat::inline($paragraf) }}
            </p>
@endforeach
</div>
<div class="p-5 rounded-xl bg-surface-container flex items-center gap-4">
<div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-on-primary shrink-0">
<span class="material-symbols-outlined text-[24px]">verified_user</span>
</div>
<div>
<p class="font-label-lg text-label-lg font-bold text-primary">{{ $bio['prinsip_judul'] ?? '' }}</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">{{ $bio['prinsip_isi'] ?? '' }}</p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Section 2: Timeline / Linimasa Sekolah -->
<section class="w-full py-20 bg-surface-container-low" id="linimasa">
<div class="max-w-7xl mx-auto px-6 lg:px-12">
<div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
<span class="px-3.5 py-1.5 rounded-full bg-surface-container text-primary font-label-md text-label-md font-bold uppercase tracking-wider">
          {{ $lm['label'] ?? '' }}
        </span>
<h2 class="font-headline-lg text-headline-lg text-primary">
          {{ $lm['judul'] ?? '' }}
        </h2>
<p class="font-body-md text-body-md text-on-surface-variant">
          {{ $lm['deskripsi'] ?? '' }}
        </p>
</div>
<div class="relative">
<div class="hidden md:block absolute left-1/2 top-4 bottom-4 w-1 -translate-x-1/2 bg-surface-container-highest"></div>
<div class="md:hidden absolute left-6 top-4 bottom-4 w-1 bg-surface-container-highest"></div>
<div class="space-y-12">
@foreach ($lm['item'] ?? [] as $it)
<div class="relative flex flex-col md:flex-row items-center gap-8">
@if ($it['sisi'] === 'kiri')
<div class="md:w-1/2 flex md:justify-end order-2 md:order-1 pl-16 md:pl-0">
<div class="bg-surface-container-lowest p-6 rounded-2xl {{ $it['kartu_kelas'] }} max-w-lg w-full">
<span class="px-3 py-1 rounded-full {{ $it['label_kelas'] }} font-label-md text-label-md font-bold inline-block mb-3">{{ $it['label'] }}</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $it['judul'] }}</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">
                  {{ $it['isi'] }}
                </p>
<div class="mt-4 flex items-center gap-2 {{ $it['catatan_kelas'] }} font-label-sm text-label-sm font-semibold">
<span class="material-symbols-outlined text-[16px]">{{ $it['catatan_ikon'] }}</span>
                  {{ $it['catatan'] }}
                </div>
</div>
</div>
<div class="absolute left-6 md:left-1/2 -translate-x-1/2 {{ $it['penanda_kelas'] }} {{ $it['penanda_bayangan'] ?? 'shadow-lg' }} ring-4 ring-surface-container-low z-20 order-1">
@if (! empty($it['penanda_ikon']))
<span class="material-symbols-outlined text-[20px]">{{ $it['penanda_ikon'] }}</span>
@else
<span class="font-label-sm text-label-sm font-bold">{{ $it['penanda'] }}</span>
@endif
</div>
<div class="md:w-1/2 order-3 pl-16 md:pl-8">
<span class="font-headline-lg text-headline-lg {{ $it['tahun_besar_kelas'] }} font-extrabold select-none">{{ $it['tahun_besar'] }}</span>
</div>
@else
<div class="md:w-1/2 flex md:justify-end order-3 md:order-1 pl-16 md:pl-8 text-right hidden md:block">
<span class="font-headline-lg text-headline-lg {{ $it['tahun_besar_kelas'] }} font-extrabold select-none">{{ $it['tahun_besar'] }}</span>
</div>
<div class="absolute left-6 md:left-1/2 -translate-x-1/2 {{ $it['penanda_kelas'] }} {{ $it['penanda_bayangan'] ?? 'shadow-lg' }} ring-4 ring-surface-container-low z-20 order-1">
@if (! empty($it['penanda_ikon']))
<span class="material-symbols-outlined text-[20px]">{{ $it['penanda_ikon'] }}</span>
@else
<span class="font-label-sm text-label-sm font-bold">{{ $it['penanda'] }}</span>
@endif
</div>
<div class="md:w-1/2 order-2 pl-16 md:pl-0">
<div class="bg-surface-container-lowest p-6 rounded-2xl {{ $it['kartu_kelas'] }} max-w-lg w-full">
<span class="px-3 py-1 rounded-full {{ $it['label_kelas'] }} font-label-md text-label-md font-bold inline-block mb-3">{{ $it['label'] }}</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $it['judul'] }}</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">
                  {{ $it['isi'] }}
                </p>
<div class="mt-4 flex items-center gap-2 {{ $it['catatan_kelas'] }} font-label-sm text-label-sm font-semibold">
<span class="material-symbols-outlined text-[16px]">{{ $it['catatan_ikon'] }}</span>
                  {{ $it['catatan'] }}
                </div>
</div>
</div>
@endif
</div>
@endforeach
</div>
</div>
</div>
</section>
<!-- Section 4 & 5: Visi, Misi & Tujuan Sekolah -->
<section class="w-full py-20 bg-surface">
<div class="max-w-7xl mx-auto px-6 lg:px-12">
<div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
<span class="px-3.5 py-1.5 rounded-full bg-surface-container-high text-primary font-label-md text-label-md font-bold uppercase tracking-wider">
          {{ $vm['label'] ?? '' }}
        </span>
<h2 class="font-headline-lg text-headline-lg text-primary">{{ $vm['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant">
          {{ $vm['deskripsi'] ?? '' }}
        </p>
</div>
<div class="rounded-2xl bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary p-8 md:p-12 mb-12 shadow-xl relative overflow-hidden">
<div class="absolute top-0 right-0 -mt-6 -mr-6 w-48 h-48 bg-secondary-container/20 rounded-full blur-2xl"></div>
<div class="relative z-10 max-w-3xl">
<div class="flex items-center gap-2 text-secondary-fixed mb-4">
<span class="material-symbols-outlined text-[24px]">church</span>
<span class="font-label-lg text-label-lg font-bold tracking-wide uppercase">{{ $vm['wesley_label'] ?? '' }}</span>
</div>
<blockquote class="font-headline-md text-headline-md text-on-primary italic leading-relaxed">
            {{ $vm['wesley_kutipan'] ?? '' }}
          </blockquote>
<p class="font-body-md text-body-md text-primary-fixed mt-4">
            {{ $vm['wesley_keterangan'] ?? '' }}
          </p>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
<div class="bg-surface-container-lowest p-8 md:p-10 rounded-2xl shadow-sm space-y-6">
<div class="w-14 h-14 rounded-xl bg-surface-container-high flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-[32px]">visibility</span>
</div>
<div>
<span class="font-label-md text-label-md uppercase tracking-wider text-secondary font-bold">{{ $vm['visi']['label'] ?? '' }}</span>
<h3 class="font-headline-lg text-headline-lg text-primary mt-1">{{ $vm['visi']['judul'] ?? '' }}</h3>
</div>
<p class="font-body-lg text-body-lg text-on-surface leading-relaxed">
            {{ $vm['visi']['isi'] ?? '' }}
          </p>
<div class="pt-4 border-t border-surface-container flex flex-wrap gap-2">
@foreach ($vm['visi']['tag'] ?? [] as $tag)
<span class="px-3 py-1 rounded-full bg-surface-container text-primary font-label-sm text-label-sm font-semibold">{{ $tag }}</span>
@endforeach
</div>
</div>
<div class="bg-surface-container-lowest p-8 md:p-10 rounded-2xl shadow-sm space-y-6">
<div class="w-14 h-14 rounded-xl bg-surface-container-high flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-[32px]">flag</span>
</div>
<div>
<span class="font-label-md text-label-md uppercase tracking-wider text-secondary font-bold">{{ $vm['misi']['label'] ?? '' }}</span>
<h3 class="font-headline-lg text-headline-lg text-primary mt-1">{{ $vm['misi']['judul'] ?? '' }}</h3>
</div>
<ul class="space-y-4 font-body-md text-body-md text-on-surface-variant">
@foreach ($vm['misi']['poin'] ?? [] as $poin)
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">check_circle</span>
<span>{{ $poin }}</span>
</li>
@endforeach
</ul>
</div>
</div>
<div class="bg-surface-container-low p-8 md:p-12 rounded-2xl shadow-sm">
<div class="max-w-2xl mb-8 space-y-2">
<span class="font-label-md text-label-md text-secondary font-bold uppercase tracking-wider">{{ $vm['tujuan']['label'] ?? '' }}</span>
<h3 class="font-headline-md text-headline-md text-primary">{{ $vm['tujuan']['judul'] ?? '' }}</h3>
<p class="font-body-md text-body-md text-on-surface-variant">
            {{ $vm['tujuan']['deskripsi'] ?? '' }}
          </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
@foreach ($vm['tujuan']['item'] ?? [] as $t)
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-xs">
<div class="w-12 h-12 rounded-lg {{ $t['ikon_kelas'] }} flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-[26px]">{{ $t['ikon'] }}</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $t['judul'] }}</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">
              {{ $t['isi'] }}
            </p>
</div>
@endforeach
</div>
</div>
</div>
</section>
<!-- Section 6: Layout Galeri Sekolah (3 Section Khusus) -->
<section class="w-full py-20 bg-surface-container">
<div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-24">
<!-- SUB-SECTION 1: Galeri Jajaran Petinggi Sekolah -->
<div>
<div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
<div>
<span class="px-3.5 py-1.5 rounded-full bg-surface-container-lowest text-primary font-label-md text-label-md font-bold uppercase tracking-wider">
              {{ $pim['label'] ?? '' }}
            </span>
<h2 class="font-headline-lg text-headline-lg text-primary mt-2">{{ $pim['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant">
              {{ $pim['deskripsi'] ?? '' }}
            </p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-[20px]">groups</span>
<span class="font-label-sm text-label-sm text-primary font-semibold">{{ $pim['meta'] ?? '' }}</span>
</div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
@foreach ($pim['item'] ?? [] as $p)
<div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
<div class="h-64 overflow-hidden relative bg-surface-container-high">
<x-foto :src="$p['foto']" :alt="$p['nama']" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
<div class="absolute top-3 left-3 px-2.5 py-1 rounded-full {{ $p['label_kelas'] }} font-label-sm text-label-sm font-semibold">
                {{ $p['label'] }}
              </div>
</div>
<div class="p-5">
<h4 class="font-headline-sm text-headline-sm text-primary">{{ $p['nama'] }}</h4>
<p class="font-label-md text-label-md text-secondary font-semibold mt-0.5">{{ $p['jabatan'] }}</p>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-2">{{ $p['isi'] }}</p>
</div>
</div>
@endforeach
</div>
</div>
<!-- SUB-SECTION 2: Galeri Fasilitas & Ekstrakulikuler -->
<div>
<div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
<div>
<span class="px-3.5 py-1.5 rounded-full bg-surface-container-lowest text-primary font-label-md text-label-md font-bold uppercase tracking-wider">
              {{ $fas['label'] ?? '' }}
            </span>
<h2 class="font-headline-lg text-headline-lg text-primary mt-2">{{ $fas['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant">
              {{ $fas['deskripsi'] ?? '' }}
            </p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary text-[20px]">architecture</span>
<span class="font-label-sm text-label-sm text-secondary font-semibold">{{ $fas['meta'] ?? '' }}</span>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach ($fas['item'] ?? [] as $f)
<div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
<div class="h-56 overflow-hidden relative">
<x-foto :src="$f['foto']" :alt="$f['kategori']" class="w-full h-full object-cover" />
<span class="absolute top-3 right-3 px-3 py-1 rounded-full {{ $f['label_kelas'] }}">{{ $f['label'] }}</span>
</div>
<div class="p-6">
<div class="flex items-center gap-2 {{ $f['kategori_kelas'] }} font-label-sm text-label-sm font-semibold mb-1">
<span class="material-symbols-outlined text-[18px]">{{ $f['ikon'] }}</span>
                {{ $f['kategori'] }}
              </div>
<h4 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $f['judul'] }}</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">{{ $f['isi'] }}</p>
</div>
</div>
@endforeach
</div>
</div>
<!-- SUB-SECTION 3: Galeri Kegiatan & Event Sekolah -->
<div>
<div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
<div>
<span class="px-3.5 py-1.5 rounded-full bg-surface-container-lowest text-primary font-label-md text-label-md font-bold uppercase tracking-wider">
              {{ $keg['label'] ?? '' }}
            </span>
<h2 class="font-headline-lg text-headline-lg text-primary mt-2">{{ $keg['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant">
              {{ $keg['deskripsi'] ?? '' }}
            </p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
<span class="font-label-sm text-label-sm text-primary font-semibold">{{ $keg['meta'] ?? '' }}</span>
</div>
</div>
@php($u = $keg['utama'] ?? [])
@php($sp = $keg['samping'] ?? [])
<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
<div class="md:col-span-8 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
<div class="h-80 overflow-hidden relative">
<x-foto :src="$u['foto'] ?? null" :alt="$u['judul'] ?? ''" class="w-full h-full object-cover" />
<div class="absolute inset-0 bg-gradient-to-t from-on-surface/80 via-transparent to-transparent flex items-end p-6">
<div>
<span class="px-3 py-1 rounded-full bg-secondary text-on-secondary font-label-sm text-label-sm font-bold">{{ $u['label'] ?? '' }}</span>
<h3 class="font-headline-md text-headline-md text-on-primary mt-2">{{ $u['judul'] ?? '' }}</h3>
<p class="font-body-sm text-body-sm text-primary-fixed mt-1">{{ $u['isi'] ?? '' }}</p>
</div>
</div>
</div>
<div class="p-6 bg-surface-container-low flex items-center justify-between">
<div class="flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm">
<span class="material-symbols-outlined text-[18px] text-primary">place</span>
                {{ $u['lokasi'] ?? '' }}
              </div>
<span class="text-secondary font-label-sm text-label-sm font-bold">{{ $u['frekuensi'] ?? '' }}</span>
</div>
</div>
<div class="md:col-span-4 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
<div class="h-48 overflow-hidden relative">
<x-foto :src="$sp['foto'] ?? null" :alt="$sp['judul'] ?? ''" class="w-full h-full object-cover" />
<span class="absolute top-3 right-3 px-2.5 py-0.5 rounded-full bg-surface-container-lowest/90 font-label-sm text-label-sm text-primary font-bold">{{ $sp['label'] ?? '' }}</span>
</div>
<div class="p-6 flex-1 flex flex-col justify-between">
<div>
<h4 class="font-headline-sm text-headline-sm text-primary">{{ $sp['judul'] ?? '' }}</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-2">{{ $sp['isi'] ?? '' }}</p>
</div>
<div class="mt-4 pt-4 border-t border-surface-container flex items-center justify-between font-label-sm text-label-sm text-secondary font-semibold">
<span>{{ $sp['catatan'] ?? '' }}</span>
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
@foreach ($keg['bawah'] ?? [] as $b)
<div class="md:col-span-4 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all">
<div class="h-48 overflow-hidden relative">
<x-foto :src="$b['foto']" :alt="$b['judul']" class="w-full h-full object-cover" />
<span class="absolute top-3 right-3 px-2.5 py-0.5 rounded-full bg-surface-container-lowest/90 font-label-sm text-label-sm text-primary font-bold">{{ $b['label'] }}</span>
</div>
<div class="p-6">
<h4 class="font-headline-sm text-headline-sm text-primary">{{ $b['judul'] }}</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-2">{{ $b['isi'] }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>
</section>
<!-- Section 7: Bottom Compact PPDB Banner -->
<x-banner-ppdb />
</div>
@endsection

@push('scripts')
    <script src="{{ \App\Support\Aset::url('js/beranda.js') }}" defer></script>
@endpush
