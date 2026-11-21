@extends('admin.layouts.panel')

@use('App\Http\Controllers\Admin\SlideController')

@php
    $baru = ! $slide->exists;
    $beranda = $slide->lokasi === 'beranda';
@endphp

@section('judul', ($baru ? 'Tambah Slide ' : 'Ubah Slide ').SlideController::LOKASI[$slide->lokasi])

@section('isi')
<form method="POST" enctype="multipart/form-data" action="{{ $baru ? route('admin.slide.store') : route('admin.slide.update', $slide) }}" class="grid grid-cols-1 lg:grid-cols-3 gap-space-lg">
    @csrf
    @unless ($baru) @method('PUT') @endunless
    <input name="lokasi" type="hidden" value="{{ $slide->lokasi }}">

    <div class="a-kartu lg:col-span-2 space-y-space-md">
        <div>
            <label class="a-label" for="judul">{{ $beranda ? 'Judul besar' : 'Keterangan foto (tampil di bawah slide)' }}</label>
            <input class="a-input" id="judul" maxlength="150" name="judul" type="text" value="{{ old('judul', $slide->judul) }}" required>
        </div>
        @if ($beranda)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
                <div class="sm:col-span-2">
                    <label class="a-label" for="lencana_teks">Teks lencana (di atas judul)</label>
                    <input class="a-input" id="lencana_teks" maxlength="80" name="lencana_teks" type="text" value="{{ old('lencana_teks', $slide->atribut['lencana']['teks'] ?? '') }}" required>
                </div>
                <div>
                    <label class="a-label" for="lencana_ikon">Ikon lencana</label>
                    <input class="a-input" id="lencana_ikon" maxlength="40" name="lencana_ikon" type="text" value="{{ old('lencana_ikon', $slide->atribut['lencana']['ikon'] ?? 'verified') }}">
                    <p class="a-bantuan">Nama ikon Material Symbols, misalnya verified.</p>
                </div>
            </div>
            <div>
                <label class="a-label" for="deskripsi">Deskripsi</label>
                <textarea class="a-input" id="deskripsi" maxlength="300" name="deskripsi" rows="3" required>{{ old('deskripsi', $slide->atribut['deskripsi'] ?? '') }}</textarea>
            </div>
        @endif
        <div>
            <label class="a-label" for="alt">Teks alternatif foto (untuk pembaca layar)</label>
            <input class="a-input" id="alt" maxlength="255" name="alt" type="text" value="{{ old('alt', $slide->alt) }}">
            <p class="a-bantuan">Kosongkan untuk memakai judul.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
            <div>
                <label class="a-label" for="urutan">Urutan</label>
                <input class="a-input" id="urutan" max="999" min="0" name="urutan" type="number" value="{{ old('urutan', $slide->urutan) }}" required>
            </div>
            <label class="flex items-center gap-2 font-body-md text-body-md sm:pt-7">
                <input name="aktif" type="hidden" value="0">
                <input class="rounded border-outline-variant text-primary" name="aktif" type="checkbox" value="1" @checked(old('aktif', $slide->aktif))>
                Tampilkan slide ini
            </label>
        </div>
    </div>

    <div class="a-kartu space-y-space-sm">
        <span class="a-label">Foto</span>
        <div class="aspect-video w-full rounded-lg overflow-hidden bg-gray-300" data-pratinjau-wadah>
            @if ($slide->gambar)
                <img alt="" class="w-full h-full object-cover" data-pratinjau src="{{ asset(str_replace('-1920.webp', '-1280.webp', $slide->gambar)) }}">
            @else
                <img alt="" class="w-full h-full object-cover hidden" data-pratinjau>
            @endif
        </div>
        <input accept="image/jpeg,image/png,image/webp" class="a-input" data-pratinjau-input name="gambar" type="file">
        <p class="a-bantuan">JPG, PNG, atau WebP, maksimal 8 MB.</p>
        @if ($slide->gambar)
            <label class="flex items-center gap-2 font-body-sm text-body-sm">
                <input class="rounded border-outline-variant text-error" name="hapus_gambar" type="checkbox" value="1"> Hapus foto (kembali ke kotak abu-abu)
            </label>
        @endif
    </div>

    <div class="lg:col-span-3 flex gap-space-sm">
        <button class="a-tombol-utama" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">save</span> Simpan</button>
        <a class="a-tombol-kedua" href="{{ route('admin.slide.index', ['lokasi' => $slide->lokasi]) }}">Batal</a>
    </div>
</form>
@endsection
