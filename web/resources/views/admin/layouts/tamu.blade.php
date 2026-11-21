@extends('admin.layouts.kerangka')

@section('kerangka')
<main class="min-h-screen flex items-center justify-center px-gutter-mobile py-space-xl">
    <div class="w-full max-w-md">
        <div class="flex items-center gap-space-sm mb-space-lg justify-center">
            <div class="w-11 h-11 rounded-lg bg-primary-container text-on-primary flex items-center justify-center shadow-sm">
                <span aria-hidden="true" class="material-symbols-outlined text-[26px]">school</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline-sm text-headline-sm text-primary font-bold">{{ $pengaturan['header_judul'] ?? 'Perguruan Methodist' }}</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">Panel Admin Website</span>
            </div>
        </div>
        <div class="a-kartu">
            @if (session('status'))
                <div class="mb-space-md rounded-lg bg-secondary-fixed/60 text-on-secondary-fixed px-space-md py-2 font-body-sm text-body-sm" role="status">{{ session('status') }}</div>
            @endif
            @yield('isi')
        </div>
        <p class="mt-space-md text-center font-body-sm text-body-sm text-on-surface-variant">
            <a class="hover:text-primary" href="{{ route('beranda') }}">&larr; Kembali ke website</a>
        </p>
    </div>
</main>
@endsection
