@extends('admin.layouts.panel')

@section('judul', 'Pengaturan')

@section('isi')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.pengaturan.update') }}" class="space-y-space-lg">
    @csrf
    @method('PUT')
    @foreach ($kelompok as $judul => $isian)
        <section class="a-kartu">
            <h2 class="font-headline-sm text-headline-sm text-primary mb-space-md">{{ $judul }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                @foreach ($isian as $kunci => $isi)
                    <div class="{{ $isi['jenis'] === 'textarea' ? 'md:col-span-2' : '' }}">
                        <label class="a-label" for="{{ $kunci }}">{{ $isi['label'] }}</label>
                        @if ($isi['jenis'] === 'textarea')
                            <textarea class="a-input" id="{{ $kunci }}" name="{{ $kunci }}" rows="3">{{ old($kunci, $nilai[$kunci] ?? '') }}</textarea>
                        @else
                            <input class="a-input" id="{{ $kunci }}" name="{{ $kunci }}" type="{{ $isi['jenis'] }}" value="{{ old($kunci, $nilai[$kunci] ?? '') }}" @isset($isi['pola']) pattern="{{ $isi['pola'] }}" @endisset>
                        @endif
                        @error($kunci)<p class="a-galat">{{ $message }}</p>@enderror
                    </div>
                @endforeach
                @if ($judul === 'Tautan & Dokumen')
                    <div class="md:col-span-2">
                        <label class="a-label" for="katalog_pdf">Unggah katalog sekolah (PDF, maksimal 10 MB)</label>
                        <input accept="application/pdf" class="a-input" id="katalog_pdf" name="katalog_pdf" type="file">
                        <p class="a-bantuan">
                            Bila diunggah, alamat katalog di atas otomatis diganti ke file ini.
                            @if (str_starts_with($nilai['katalog_url'] ?? '', 'unggahan/'))
                                File saat ini: <a class="text-primary underline" href="{{ asset($nilai['katalog_url']) }}" target="_blank" rel="noopener">buka PDF</a>.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </section>
    @endforeach
    <button class="a-tombol-utama" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">save</span> Simpan pengaturan</button>
</form>
@endsection
