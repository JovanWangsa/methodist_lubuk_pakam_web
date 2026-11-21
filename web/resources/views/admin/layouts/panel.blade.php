@extends('admin.layouts.kerangka')

@php
    $user = auth()->user();
    $menu = collect(config('admin.menu'))->filter(fn ($m) => $user->punyaPeran(...$m['peran']));
    $grupAktif = request()->route('grup') ?? (config('admin.blok')[request()->route('kunci')] ?? [])['grup'] ?? null;
@endphp

@section('kerangka')
<div class="min-h-screen lg:flex">
    {{-- Menu samping --}}
    <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:shrink-0 bg-primary text-on-primary lg:sticky lg:top-0 lg:h-screen" data-admin-menu id="admin-menu">
        <div class="flex items-center gap-space-sm px-space-md h-16 border-b border-on-primary/10">
            <div class="w-9 h-9 rounded-lg bg-primary-container flex items-center justify-center">
                <span aria-hidden="true" class="material-symbols-outlined text-[22px]">school</span>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="font-label-lg text-label-lg font-bold">Admin Website</span>
                <span class="font-label-sm text-label-sm text-on-primary/70">{{ $pengaturan['nama_singkat'] ?? '' }}</span>
            </div>
            <button aria-controls="admin-menu" class="lg:hidden ml-auto w-9 h-9 rounded-lg flex items-center justify-center hover:bg-primary-container" data-admin-menu-toggle type="button">
                <span class="sr-only">Tutup menu</span><span aria-hidden="true" class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav aria-label="Menu admin" class="flex-1 overflow-y-auto px-space-sm py-space-md space-y-0.5">
            @foreach ($menu as $m)
                @if (isset($m['judul']))
                    <p class="px-space-sm pt-space-md pb-1 font-label-sm text-label-sm uppercase tracking-wider text-on-primary/60">{{ $m['judul'] }}</p>
                @else
                    @php
                        $aktif = request()->routeIs($m['aktif']) && (! isset($m['grup']) || $m['grup'] === $grupAktif);
                    @endphp
                    <a @if ($aktif) aria-current="page" @endif
                       class="flex items-center gap-space-sm rounded-lg px-space-sm py-2 font-label-lg text-label-lg transition-colors {{ $aktif ? 'bg-primary-container text-on-primary shadow-sm' : 'text-on-primary/80 hover:bg-primary-container/60 hover:text-on-primary' }}"
                       href="{{ route($m['route'], $m['param'] ?? []) }}">
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px]">{{ $m['ikon'] }}</span>{{ $m['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>
        <div class="px-space-md py-space-sm border-t border-on-primary/10">
            <a class="flex items-center gap-space-sm font-body-sm text-body-sm text-on-primary/80 hover:text-on-primary" href="{{ route('beranda') }}" target="_blank" rel="noopener">
                <span aria-hidden="true" class="material-symbols-outlined text-[18px]">open_in_new</span> Lihat website
            </a>
        </div>
    </aside>

    <div class="flex-1 min-w-0 flex flex-col">
        <header class="sticky top-0 z-30 h-16 bg-surface-container-lowest/95 backdrop-blur border-b border-surface-container flex items-center justify-between gap-space-md px-gutter-mobile md:px-space-lg">
            <div class="flex items-center gap-space-sm min-w-0">
                <button aria-controls="admin-menu" aria-expanded="false" class="lg:hidden w-10 h-10 rounded-lg flex items-center justify-center text-primary hover:bg-surface-container" data-admin-menu-toggle type="button">
                    <span class="sr-only">Buka menu</span><span aria-hidden="true" class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="font-headline-sm text-headline-sm text-primary truncate">@yield('judul')</h1>
            </div>
            <div class="flex items-center gap-space-sm">
                <a class="hidden sm:flex flex-col items-end leading-tight hover:opacity-80" href="{{ route('admin.profil') }}">
                    <span class="font-label-md text-label-md text-on-surface">{{ $user->name }}</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">{{ $user->namaPeran() }}</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="a-tombol-kedua px-space-sm" title="Keluar" type="submit">
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px]">logout</span><span class="hidden md:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 w-full max-w-6xl mx-auto px-gutter-mobile md:px-space-lg py-space-lg">
            @if (session('status'))
                <div class="mb-space-md flex items-center gap-space-sm rounded-lg bg-secondary-fixed/60 text-on-secondary-fixed px-space-md py-2 font-body-sm text-body-sm" role="status">
                    <span aria-hidden="true" class="material-symbols-outlined text-[20px]">check_circle</span>{{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-space-md rounded-lg bg-error-container text-on-error-container px-space-md py-2 font-body-sm text-body-sm" role="alert">
                    <p class="font-semibold flex items-center gap-1"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">error</span>Ada isian yang perlu diperbaiki:</p>
                    <ul class="list-disc pl-space-lg mt-1">
                        @foreach ($errors->all() as $galat)<li>{{ $galat }}</li>@endforeach
                    </ul>
                </div>
            @endif
            @yield('isi')
        </main>
    </div>
</div>
@endsection
