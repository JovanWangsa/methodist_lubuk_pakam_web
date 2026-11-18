@extends('layouts.situs')

{{-- Halaman 2: Homepage. Markup persis desain Stitch "Hal. 2: Homepage". --}}
@section('judul', 'Beranda')
@section('main_kelas', 'w-full pt-20 bg-surface min-h-[calc(100vh-80px)]')

@use('App\Support\Tautan')

@php
    $ig = $instagramBlok;
    $sin = $angkaSekolah;
    $vm = $visiMisi;
@endphp

@section('konten')
<div class="flex flex-col w-full">
<!-- 1. SLIDESHOW SECTION -->
<section class="relative w-full overflow-hidden bg-primary text-on-primary" data-beranda-slider>
<div class="relative w-full h-[620px] lg:h-[700px]" id="hero-slider">
@foreach ($slides as $slide)
@php($a = $slide->atribut ?? [])
<div @class(['slide-item absolute inset-0 transition-opacity duration-1000 ease-in-out', 'opacity-100 z-20' => $loop->first, 'opacity-0 z-10 pointer-events-none' => ! $loop->first])>
<div class="w-full h-full bg-cover bg-center" role="img" aria-label="{{ $slide->alt ?? $slide->judul }}" style="{{ $slide->gambar ? "background-image: url('".asset($slide->gambar)."')" : 'background-color: #d1d5db' }}">
<div class="w-full h-full bg-gradient-to-r from-primary/95 via-primary/75 to-transparent flex items-center">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin w-full">
<div class="max-w-2xl">
@if (! empty($a['lencana']))
<span class="{{ $a['lencana']['kelas'] }}">
<span class="material-symbols-outlined text-[16px]">{{ $a['lencana']['ikon'] }}</span> {{ $a['lencana']['teks'] }}
                </span>
@endif
<{{ $a['tag'] ?? 'h2' }} class="{{ $a['judul_kelas'] ?? 'font-display-hero text-display-hero text-on-primary mb-space-md' }}">
                  {{ $slide->judul }}
                </{{ $a['tag'] ?? 'h2' }}>
<p class="font-body-lg text-body-lg text-surface-container-highest/90 mb-space-xl">
                  {{ $a['deskripsi'] ?? '' }}
                </p>
<div class="flex flex-wrap items-center gap-space-md">
@foreach ($tombolSlide as $tombol)
<a class="{{ $tombol['kelas'] }}" href="{{ Tautan::untuk($tombol['jenis']) }}" @if ($tombol['jenis'] === 'wa') rel="noopener" target="_blank" @endif>
@if (! empty($tombol['ikon']))
<span class="material-symbols-outlined text-[20px]">{{ $tombol['ikon'] }}</span>
@endif
<span>{{ $tombol['teks'] }}</span>
</a>
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>
@endforeach
</div>
<!-- Slider Navigation Dots & Controls -->
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin relative pb-space-lg z-30 -mt-16 flex items-center justify-between">
<div class="flex items-center gap-space-sm bg-primary-container/80 backdrop-blur-md px-space-md py-space-xs rounded-full">
@foreach ($slides as $slide)
<button aria-label="Slide {{ $loop->iteration }}" @class(['slider-dot w-3 h-3 rounded-full transition-all', 'bg-secondary-container' => $loop->first, 'bg-surface-container-lowest/40 hover:bg-surface-container-lowest' => ! $loop->first]) data-ke="{{ $loop->index }}" type="button"></button>
@endforeach
</div>
<div class="flex items-center gap-space-xs">
<button aria-label="Slide sebelumnya" class="w-10 h-10 rounded-full bg-primary-container/70 hover:bg-primary-container text-on-primary flex items-center justify-center transition-colors shadow-sm" data-sebelumnya type="button">
<span class="material-symbols-outlined text-[20px]">chevron_left</span>
</button>
<button aria-label="Slide berikutnya" class="w-10 h-10 rounded-full bg-primary-container/70 hover:bg-primary-container text-on-primary flex items-center justify-center transition-colors shadow-sm" data-berikutnya type="button">
<span class="material-symbols-outlined text-[20px]">chevron_right</span>
</button>
</div>
</div>
</section>
<!-- 2. NUMERIC KEY METRICS STRIP -->
<section class="w-full bg-surface-container-lowest -mt-4 relative z-30 shadow-md">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin py-space-xl">
<div class="grid grid-cols-2 lg:grid-cols-5 gap-space-md md:gap-space-lg text-center items-center">
@foreach ($angka as $m)
<div class="{{ $m['kartu_kelas'] }}">
<div class="w-10 h-10 mx-auto mb-space-xs rounded-full {{ $m['ikon_kelas'] }} flex items-center justify-center">
<span class="material-symbols-outlined text-[22px]">{{ $m['ikon'] }}</span>
</div>
<span class="font-display-hero text-headline-lg font-bold text-primary block">{{ $m['nilai'] }}</span>
<span class="font-headline-sm text-headline-sm text-secondary block mt-0.5 font-bold">{{ $m['label'] }}</span>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ $m['deskripsi'] }}</p>
</div>
@endforeach
</div>
</div>
</section>
<!-- 3. LIVE INSTAGRAM FEED SECTION -->
<section class="w-full bg-surface py-space-xl">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-space-lg">
<div>
<div class="inline-flex items-center gap-space-xs px-space-sm py-1 rounded-full bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase font-semibold mb-space-xs">
<span class="material-symbols-outlined text-[16px]">photo_camera</span> {{ $ig['label'] ?? '' }}
          </div>
<h2 class="font-headline-lg text-headline-lg text-primary tracking-tight">{{ $ig['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant">{{ $ig['deskripsi'] ?? '' }} <span class="font-semibold text-primary">{{ '@'.($pengaturan['instagram_username'] ?? '') }}</span></p>
</div>
<a class="mt-space-md md:mt-0 inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-lowest text-primary font-label-lg text-label-lg shadow-sm hover:shadow-md transition-all" href="{{ $pengaturan['instagram_url'] ?? '#' }}" rel="noopener" target="_blank">
<span class="material-symbols-outlined text-[20px]">open_in_new</span>
<span>{{ $ig['tombol'] ?? '' }} {{ '@'.($pengaturan['instagram_username'] ?? '') }}</span>
</a>
</div>
<!-- 5 Instagram Feed Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-space-md">
@foreach ($postInstagram as $post)
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col group">
<div class="relative w-full aspect-square overflow-hidden">
<x-foto :src="$post['gambar']" :alt="\Illuminate\Support\Str::limit($post['caption'], 80)" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
@if (! empty($post['tag']))
<span class="absolute top-2 right-2 bg-surface/90 backdrop-blur-sm {{ $post['tag_warna'] }} font-label-sm text-label-sm px-2 py-0.5 rounded-full flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">{{ $post['tag_ikon'] }}</span> {{ $post['tag'] }}
            </span>
@endif
</div>
<div class="p-space-md flex-1 flex flex-col justify-between">
<p class="font-body-sm text-body-sm text-on-surface line-clamp-3 mb-space-sm">
              {{ $post['caption'] }}
            </p>
<div class="pt-space-xs flex items-center justify-between text-on-surface-variant font-label-sm text-label-sm">
@if ($post['suka'] !== null)
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-error" style="font-variation-settings: 'FILL' 1;">favorite</span> {{ $post['suka'] }}</span>
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">chat_bubble</span> {{ $post['komentar'] }}</span>
@endif
<span class="text-label-sm opacity-70">{{ $post['waktu'] }}</span>
</div>
</div>
</div>
@endforeach
</div>
</div>
</section>
<!-- 4. SCHOOL IN NUMBERS (STATISTIK AKUNTABILITAS DATA) -->
<section class="w-full bg-surface-container-low py-space-xl">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin">
<div class="text-center max-w-3xl mx-auto mb-space-xl">
<span class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase font-semibold mb-space-xs">
<span class="material-symbols-outlined text-[16px]">analytics</span> {{ $sin['label'] ?? '' }}
        </span>
<h2 class="font-headline-lg text-headline-lg text-primary tracking-tight">{{ $sin['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-space-xs">
          {{ $sin['deskripsi'] ?? '' }}
        </p>
</div>
<!-- Bento Grid for Data Accountability -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-space-lg">
@php($lulusan = $sin['lulusan'] ?? [])
<div class="md:col-span-7 bg-surface-container-lowest p-space-lg rounded-2xl shadow-sm flex flex-col justify-between">
<div>
<div class="flex items-center justify-between mb-space-md">
<div class="flex items-center gap-space-sm">
<div class="w-10 h-10 rounded-lg bg-primary-container text-on-primary flex items-center justify-center">
<span class="material-symbols-outlined text-[24px]">school</span>
</div>
<div>
<h3 class="font-headline-sm text-headline-sm text-primary">{{ $lulusan['judul'] ?? '' }}</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">{{ $lulusan['sub'] ?? '' }}</p>
</div>
</div>
<span class="font-display-hero text-headline-lg text-secondary font-bold">{{ $lulusan['persen'] ?? '' }}</span>
</div>
<p class="font-body-md text-body-md text-on-surface-variant mb-space-md">
              {{ $lulusan['deskripsi'] ?? '' }}
            </p>
<!-- Distribution mini bars -->
<div class="space-y-space-sm font-label-sm text-label-sm">
@foreach ($lulusan['bar'] ?? [] as $bar)
<div>
<div class="flex justify-between mb-1">
<span class="font-semibold text-on-surface">{{ $bar['label'] }}</span>
<span class="{{ $bar['teks_kelas'] }} font-bold">{{ $bar['persen'] }}%</span>
</div>
<div class="w-full h-2.5 bg-surface-container rounded-full overflow-hidden">
<div class="h-full {{ $bar['bar_kelas'] }} rounded-full" style="width: {{ (int) $bar['persen'] }}%"></div>
</div>
</div>
@endforeach
</div>
</div>
<div class="mt-space-lg pt-space-md flex items-center justify-between text-on-surface-variant font-label-sm text-label-sm bg-surface-container-low p-space-sm rounded-lg">
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-primary">verified</span> {{ $lulusan['verifikasi'] ?? '' }}</span>
<span class="font-bold text-primary">{{ $lulusan['tahun'] ?? '' }}</span>
</div>
</div>
@php($medali = $sin['medali'] ?? [])
<div class="md:col-span-5 bg-surface-container-lowest p-space-lg rounded-2xl shadow-sm flex flex-col justify-between">
<div>
<div class="flex items-center gap-space-sm mb-space-md">
<div class="w-10 h-10 rounded-lg bg-secondary-container text-on-secondary flex items-center justify-center">
<span class="material-symbols-outlined text-[24px]">emoji_events</span>
</div>
<div>
<h3 class="font-headline-sm text-headline-sm text-primary">{{ $medali['judul'] ?? '' }}</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">{{ $medali['sub'] ?? '' }}</p>
</div>
</div>
<!-- Inline SVG Bar Chart -->
<div class="w-full pt-space-xs">
<svg aria-label="{{ $medali['judul'] ?? '' }}" class="w-full h-44" fill="none" role="img" viewBox="0 0 340 180" xmlns="http://www.w3.org/2000/svg">
<line stroke="#E2E8F0" stroke-dasharray="2 2" stroke-width="1" x1="30" x2="330" y1="20" y2="20"></line>
<line stroke="#E2E8F0" stroke-dasharray="2 2" stroke-width="1" x1="30" x2="330" y1="60" y2="60"></line>
<line stroke="#E2E8F0" stroke-dasharray="2 2" stroke-width="1" x1="30" x2="330" y1="100" y2="100"></line>
<line stroke="#E2E8F0" stroke-width="1" x1="30" x2="330" y1="140" y2="140"></line>
@foreach ($medali['sumbu'] ?? [] as $s)
<text fill="#757682" font-size="10" text-anchor="end" x="20" y="{{ $s['y'] }}">{{ $s['teks'] }}</text>
@endforeach
@foreach ($medali['batang'] ?? [] as $b)
<rect fill="{{ $b['latar'][2] }}" height="{{ $b['latar'][1] }}" rx="4" width="36" x="{{ $b['x'] }}" y="{{ $b['latar'][0] }}"></rect>
<rect fill="{{ $b['isi'][2] }}" height="{{ $b['isi'][1] }}" @if ($b['isi'][3]) opacity="{{ $b['isi'][3] }}" @endif rx="4" width="36" x="{{ $b['x'] }}" y="{{ $b['isi'][0] }}"></rect>
<text fill="#131b2e" font-size="11" font-weight="600" text-anchor="middle" x="{{ $b['x'] + 18 }}" y="156">{{ $b['tahun'] }}</text>
<text fill="{{ $b['label_warna'] }}" font-size="{{ $b['label_ukuran'] }}" font-weight="{{ $b['label_tebal'] }}" text-anchor="middle" x="{{ $b['x'] + 18 }}" y="{{ $b['label_y'] }}">{{ $b['label'] }}</text>
@endforeach
</svg>
</div>
</div>
<div class="mt-space-sm bg-surface-container-high p-space-sm rounded-lg flex items-center justify-between text-label-sm font-label-sm text-primary">
<span class="flex items-center gap-1 font-semibold"><span class="material-symbols-outlined text-[16px]">trending_up</span> {{ $medali['ringkasan_kiri'] ?? '' }}</span>
<span>{{ $medali['ringkasan_kanan'] ?? '' }}</span>
</div>
</div>
@foreach ($sin['kartu_bawah'] ?? [] as $kartu)
<div class="md:col-span-6 bg-surface-container-lowest p-space-lg rounded-2xl shadow-sm flex items-center gap-space-lg">
<div class="w-20 h-20 rounded-2xl {{ $kartu['ikon_kelas'] }} flex-shrink-0 flex items-center justify-center">
<span class="material-symbols-outlined text-[42px]">{{ $kartu['ikon'] }}</span>
</div>
<div>
<div class="flex items-baseline gap-space-xs">
<span class="font-display-hero text-headline-lg font-bold text-primary">{{ $kartu['nilai'] }}</span>
<span class="font-headline-sm text-headline-sm text-secondary font-semibold">{{ $kartu['label'] }}</span>
</div>
<p class="font-body-md text-body-md text-on-surface-variant mt-1">
              {{ $kartu['deskripsi'] }}
            </p>
</div>
</div>
@endforeach
</div>
</div>
</section>
<!-- 5. VISI, MISI & 4 PILAR JOHN WESLEY -->
<section class="w-full bg-surface py-space-xl">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin">
<div class="relative overflow-hidden rounded-2xl bg-primary text-on-primary p-space-lg md:p-space-xl mb-space-xl shadow-lg">
<div class="relative z-10 max-w-4xl mx-auto text-center">
<span class="material-symbols-outlined text-secondary-container text-[48px] mb-space-xs opacity-90">format_quote</span>
<blockquote class="font-display-hero text-headline-md md:text-headline-lg italic font-medium leading-relaxed mb-space-md">
            {{ $vm['kutipan'] ?? '' }}
          </blockquote>
<p class="font-label-lg text-label-lg tracking-wider uppercase text-secondary-fixed">
            {{ $vm['kutipan_sumber'] ?? '' }}
          </p>
</div>
<div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>
<div class="absolute -left-20 -top-20 w-80 h-80 rounded-full bg-primary-container/40 blur-3xl pointer-events-none"></div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg mb-space-xl">
<div class="bg-surface-container-lowest p-space-lg md:p-space-xl rounded-2xl shadow-sm flex flex-col justify-between">
<div>
<div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase font-semibold mb-space-md">
<span class="material-symbols-outlined text-[16px]">visibility</span> {{ $vm['visi']['label'] ?? '' }}
            </div>
<h3 class="font-headline-lg text-headline-lg text-primary mb-space-md">
              {{ $vm['visi']['judul'] ?? '' }}
            </h3>
<p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
              {{ $vm['visi']['isi'] ?? '' }}
            </p>
</div>
<div class="mt-space-lg flex items-center gap-space-sm text-primary font-label-md text-label-md">
<span class="material-symbols-outlined text-[20px] text-secondary">check_circle</span>
<span>{{ $vm['visi']['catatan'] ?? '' }}</span>
</div>
</div>
<div class="bg-surface-container-lowest p-space-lg md:p-space-xl rounded-2xl shadow-sm">
<div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase font-semibold mb-space-md">
<span class="material-symbols-outlined text-[16px]">flag</span> {{ $vm['misi']['label'] ?? '' }}
          </div>
<h3 class="font-headline-lg text-headline-lg text-primary mb-space-md">
            {{ $vm['misi']['judul'] ?? '' }}
          </h3>
<ul class="space-y-space-md font-body-md text-body-md text-on-surface-variant">
@foreach ($vm['misi']['poin'] ?? [] as $poin)
<li class="flex items-start gap-space-sm">
<div class="w-6 h-6 rounded-full bg-primary-container text-on-primary flex-shrink-0 flex items-center justify-center font-bold text-label-sm mt-0.5">{{ $loop->iteration }}</div>
<span>{{ $poin }}</span>
</li>
@endforeach
</ul>
</div>
</div>
<div>
<div class="text-center max-w-2xl mx-auto mb-space-lg">
<h3 class="font-headline-lg text-headline-lg text-primary">{{ $vm['pilar']['judul'] ?? '' }}</h3>
<p class="font-body-md text-body-md text-on-surface-variant">{{ $vm['pilar']['deskripsi'] ?? '' }}</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
@foreach ($vm['pilar']['item'] ?? [] as $pilar)
<div class="bg-surface-container-low p-space-lg rounded-xl hover:bg-surface-container transition-all">
<div class="w-12 h-12 rounded-xl {{ $pilar['ikon_kelas'] }} flex items-center justify-center mb-space-md shadow-sm">
<span class="material-symbols-outlined text-[28px]">{{ $pilar['ikon'] }}</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-primary mb-space-xs">{{ $pilar['judul'] }}</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">{{ $pilar['isi'] }}</p>
</div>
@endforeach
</div>
</div>
</div>
</section>
<!-- 6. PARTNERSHIP SEKOLAH & JARINGAN KERJASAMA -->
<section class="w-full bg-surface-container-low py-space-xl">
<div class="max-w-7xl mx-auto px-gutter-mobile md:px-margin-tablet lg:px-margin">
<div class="text-center max-w-3xl mx-auto mb-space-xl">
<span class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase font-semibold mb-space-xs">
<span class="material-symbols-outlined text-[16px]">hub</span> {{ $kemitraan['label'] ?? '' }}
        </span>
<h2 class="font-headline-lg text-headline-lg text-primary tracking-tight">{{ $kemitraan['judul'] ?? '' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-space-xs">
          {{ $kemitraan['deskripsi'] ?? '' }}
        </p>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-space-md">
@foreach ($kemitraan['item'] ?? [] as $mitra)
<div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm text-center flex flex-col items-center justify-center hover:shadow-md transition-shadow">
<div class="w-14 h-14 rounded-full {{ $mitra['kelas'] }} flex items-center justify-center mb-space-sm font-headline-sm font-bold">
            {{ $mitra['singkatan'] }}
          </div>
<span class="font-headline-sm text-body-lg text-primary font-bold">{{ $mitra['nama'] }}</span>
<span class="font-label-sm text-label-sm text-on-surface-variant mt-1">{{ $mitra['keterangan'] }}</span>
</div>
@endforeach
</div>
</div>
</section>
<!-- 7. INTEGRATED PPDB CALLOUT BANNER -->
<x-banner-ppdb />
</div>
@endsection

@push('scripts')
    @vite('resources/js/beranda.js')
@endpush
