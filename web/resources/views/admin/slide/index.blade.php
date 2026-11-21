@extends('admin.layouts.panel')

@use('App\Http\Controllers\Admin\SlideController')

@section('judul', 'Slide')

@section('isi')
<div class="flex flex-wrap items-center justify-between gap-space-md mb-space-md">
    <nav aria-label="Lokasi slide" class="inline-flex rounded-lg bg-surface-container-high p-1">
        @foreach (SlideController::LOKASI as $kode => $nama)
            <a @if ($lokasi === $kode) aria-current="page" @endif
               class="px-space-md py-1.5 rounded-md font-label-lg text-label-lg {{ $lokasi === $kode ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:text-primary' }}"
               href="{{ route('admin.slide.index', ['lokasi' => $kode]) }}">{{ $nama }}</a>
        @endforeach
    </nav>
    <a class="a-tombol-utama" href="{{ route('admin.slide.create', ['lokasi' => $lokasi]) }}"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">add</span> Tambah slide</a>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">
    @if ($lokasi === 'pembuka')
        Desain Halaman 1 memakai 10 slide. Foto ideal mendatar, minimal 1920 px.
    @else
        Desain Homepage memakai 5 slide. Tiga tombolnya diatur di Konten Sekolah &rarr; Tombol Slideshow Homepage.
    @endif
    Foto otomatis diubah ke WebP ukuran 640, 1280, dan 1920 px.
</p>
<div class="a-kartu p-0 md:p-0 overflow-x-auto">
    <table class="a-tabel">
        <thead><tr><th class="w-12">No.</th><th class="w-32">Foto</th><th>Judul</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
        <tbody>
        @forelse ($slides as $slide)
            <tr>
                <td>{{ $slide->urutan }}</td>
                <td>
                    @if ($slide->gambar)
                        <img alt="" class="w-28 h-16 rounded-md object-cover" loading="lazy" src="{{ asset(str_replace('-1920.webp', '-640.webp', $slide->gambar)) }}">
                    @else
                        <div class="w-28 h-16 rounded-md bg-gray-300 flex items-center justify-center text-on-surface-variant font-label-sm text-label-sm">Belum ada</div>
                    @endif
                </td>
                <td>
                    <p class="font-semibold">{{ $slide->judul }}</p>
                    @if ($slide->atribut['lencana']['teks'] ?? null)
                        <p class="text-on-surface-variant">{{ $slide->atribut['lencana']['teks'] }}</p>
                    @endif
                </td>
                <td>
                    @if ($slide->aktif)
                        <span class="a-lencana bg-secondary-fixed text-on-secondary-fixed">Tampil</span>
                    @else
                        <span class="a-lencana bg-surface-container-highest text-on-surface-variant">Disembunyikan</span>
                    @endif
                </td>
                <td class="text-right whitespace-nowrap">
                    <a class="a-tombol-kedua px-space-sm py-1" href="{{ route('admin.slide.edit', $slide) }}"><span aria-hidden="true" class="material-symbols-outlined text-[18px]">edit</span> Ubah</a>
                    <form class="inline" method="POST" action="{{ route('admin.slide.destroy', $slide) }}" data-konfirmasi="Hapus slide &quot;{{ $slide->judul }}&quot; beserta fotonya?">
                        @csrf @method('DELETE')
                        <button class="a-tombol-bahaya px-space-sm py-1" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[18px]">delete</span> Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-on-surface-variant">Belum ada slide.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
