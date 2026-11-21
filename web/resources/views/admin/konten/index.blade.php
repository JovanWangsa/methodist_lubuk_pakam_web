@extends('admin.layouts.panel')

@section('judul', $infoGrup['judul'])

@section('isi')
<p class="font-body-md text-body-md text-on-surface-variant mb-space-md">{{ $infoGrup['keterangan'] }}</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
    @foreach ($blok as $kunci => $b)
        <a class="a-kartu block hover:shadow-md hover:border-primary/30 transition" href="{{ route('admin.konten.edit', $kunci) }}">
            <div class="flex items-start justify-between gap-space-sm">
                <h2 class="font-headline-sm text-headline-sm text-primary">{{ $b['judul'] }}</h2>
                <span aria-hidden="true" class="material-symbols-outlined text-primary">edit</span>
            </div>
            @isset($b['keterangan'])<p class="a-bantuan">{{ $b['keterangan'] }}</p>@endisset
            <p class="mt-space-sm font-label-sm text-label-sm text-on-surface-variant">
                Terakhir diubah: {{ isset($diubah[$kunci]) ? \Illuminate\Support\Carbon::parse($diubah[$kunci])->translatedFormat('d F Y H:i') : 'belum pernah' }}
            </p>
        </a>
    @endforeach
</div>
@endsection
