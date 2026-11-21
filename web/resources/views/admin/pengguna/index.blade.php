@extends('admin.layouts.panel')

@section('judul', 'Pengguna')

@section('isi')
<div class="flex flex-wrap items-center justify-between gap-space-md mb-space-md">
    <p class="font-body-md text-body-md text-on-surface-variant">Super Admin mengatur semua; Admin Konten mengubah isi website; Admin PPDB mengelola pendaftar (Sprint 3).</p>
    <a class="a-tombol-utama" href="{{ route('admin.pengguna.create') }}"><span aria-hidden="true" class="material-symbols-outlined text-[20px]">person_add</span> Tambah pengguna</a>
</div>
<div class="a-kartu p-0 md:p-0 overflow-x-auto">
    <table class="a-tabel">
        <thead><tr><th>Nama</th><th>Email</th><th>Peran</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
        <tbody>
        @foreach ($pengguna as $p)
            <tr>
                <td class="font-semibold">{{ $p->name }} @if ($p->is(auth()->user()))<span class="a-lencana bg-surface-container-high text-primary">Anda</span>@endif</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->namaPeran() }}</td>
                <td>
                    @if ($p->is_active)
                        <span class="a-lencana bg-secondary-fixed text-on-secondary-fixed">Aktif</span>
                    @else
                        <span class="a-lencana bg-surface-container-highest text-on-surface-variant">Nonaktif</span>
                    @endif
                </td>
                <td class="text-right whitespace-nowrap">
                    <a class="a-tombol-kedua px-space-sm py-1" href="{{ route('admin.pengguna.edit', $p) }}"><span aria-hidden="true" class="material-symbols-outlined text-[18px]">edit</span> Ubah</a>
                    @unless ($p->is(auth()->user()))
                        <form class="inline" method="POST" action="{{ route('admin.pengguna.destroy', $p) }}" data-konfirmasi="Hapus akun {{ $p->name }}?">
                            @csrf @method('DELETE')
                            <button class="a-tombol-bahaya px-space-sm py-1" type="submit"><span aria-hidden="true" class="material-symbols-outlined text-[18px]">delete</span> Hapus</button>
                        </form>
                    @endunless
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
