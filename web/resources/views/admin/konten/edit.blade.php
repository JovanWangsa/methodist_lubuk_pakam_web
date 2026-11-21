@extends('admin.layouts.panel')

@section('judul', $definisi['judul'])

@section('isi')
<div class="flex flex-wrap items-center justify-between gap-space-sm mb-space-md">
    <a class="font-body-sm text-body-sm text-primary hover:underline" href="{{ route('admin.konten.index', $definisi['grup']) }}">&larr; {{ config('admin.grup.'.$definisi['grup'].'.judul') }}</a>
    <a class="a-tombol-kedua px-space-sm py-1" href="{{ route($definisi['halaman']) }}" rel="noopener" target="_blank"><span aria-hidden="true" class="material-symbols-outlined text-[18px]">open_in_new</span> Lihat halaman</a>
</div>
@isset($definisi['keterangan'])
    <p class="font-body-md text-body-md text-on-surface-variant mb-space-md">{{ $definisi['keterangan'] }}</p>
@endisset

<form method="POST" enctype="multipart/form-data" action="{{ route('admin.konten.update', $kunci) }}" class="space-y-space-md" data-form-konten>
    @csrf
    @method('PUT')
    <div class="a-kartu space-y-space-md">
        @include('admin.konten._isian', ['nilai' => $data, 'kolom' => '', 'nama' => '', 'tingkat' => 0])
    </div>
    <div class="sticky bottom-0 -mx-gutter-mobile md:mx-0 bg-surface-container-low/95 backdrop-blur py-space-sm px-gutter-mobile md:px-0 flex gap-space-sm">
        <button class="a-tombol-utama" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">save</span> Simpan</button>
        <a class="a-tombol-kedua" href="{{ route('admin.konten.index', $definisi['grup']) }}">Batal</a>
    </div>
</form>
@endsection
