@extends('admin.layouts.panel')

@section('judul', 'Dasbor')

@php
    $status = ['terkirim' => 'Terkirim', 'diverifikasi' => 'Diverifikasi', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'];
@endphp

@section('isi')
<p class="font-body-md text-body-md text-on-surface-variant mb-space-lg">Selamat datang, {{ auth()->user()->name }}.</p>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-lg">
    <div class="a-kartu">
        <p class="font-label-md text-label-md text-on-surface-variant">Pendaftar PPDB</p>
        <p class="font-display-hero text-headline-lg font-bold text-primary">{{ $totalPendaftar }}</p>
        <p class="a-bantuan">Formulir PPDB aktif mulai Sprint 3.</p>
    </div>
    <div class="a-kartu">
        <p class="font-label-md text-label-md text-on-surface-variant">Slide aktif</p>
        <p class="font-display-hero text-headline-lg font-bold text-primary">{{ $slideAktif }}</p>
        <p class="a-bantuan">{{ $slideTanpaFoto }} masih tanpa foto.</p>
    </div>
    <div class="a-kartu">
        <p class="font-label-md text-label-md text-on-surface-variant">Akun admin aktif</p>
        <p class="font-display-hero text-headline-lg font-bold text-primary">{{ $penggunaAktif }}</p>
    </div>
    <div class="a-kartu">
        <p class="font-label-md text-label-md text-on-surface-variant">Instagram</p>
        @if ($token)
            <p class="font-headline-sm text-headline-sm text-primary">Terhubung</p>
            <p class="a-bantuan">Token berlaku sampai {{ $token->expires_at?->translatedFormat('d F Y') ?? '-' }}.</p>
        @else
            <p class="font-headline-sm text-headline-sm text-on-surface-variant">Belum terhubung</p>
            <p class="a-bantuan">Sinkronisasi otomatis dipasang di Sprint 4.</p>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
    <section class="a-kartu">
        <h2 class="font-headline-sm text-headline-sm text-primary mb-space-sm">Pendaftar per unit dan status</h2>
        <div class="overflow-x-auto">
            <table class="a-tabel">
                <thead><tr><th>Unit</th>@foreach ($status as $label)<th class="text-right">{{ $label }}</th>@endforeach</tr></thead>
                <tbody>
                @foreach ($units as $unit)
                    <tr>
                        <td>{{ $unit->nama }}</td>
                        @foreach ($status as $kode => $label)
                            <td class="text-right">{{ (int) $pendaftar->where('unit_id', $unit->id)->where('status', $kode)->sum('jumlah') }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="a-kartu">
        <h2 class="font-headline-sm text-headline-sm text-primary mb-space-sm">Aktivitas terbaru</h2>
        <ul class="divide-y divide-surface-container">
            @forelse ($aktivitas as $log)
                <li class="py-2 flex items-start justify-between gap-space-md font-body-sm text-body-sm">
                    <span><span class="font-semibold">{{ $log->user?->name ?? 'Sistem' }}</span> {{ $log->aksi }} {{ $log->objek }}</span>
                    <time class="shrink-0 text-on-surface-variant" datetime="{{ $log->created_at->toIso8601String() }}">{{ $log->created_at->diffForHumans() }}</time>
                </li>
            @empty
                <li class="py-2 font-body-sm text-body-sm text-on-surface-variant">Belum ada aktivitas.</li>
            @endforelse
        </ul>
    </section>
</div>
@endsection
