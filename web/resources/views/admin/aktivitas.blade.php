@extends('admin.layouts.panel')

@section('judul', 'Log Aktivitas')

@section('isi')
<div class="a-kartu p-0 md:p-0 overflow-x-auto">
    <table class="a-tabel">
        <thead><tr><th>Waktu</th><th>Pengguna</th><th>Aksi</th><th>Objek</th><th>IP</th></tr></thead>
        <tbody>
        @forelse ($log as $l)
            <tr>
                <td class="whitespace-nowrap">{{ $l->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $l->user?->name ?? 'Akun terhapus' }}</td>
                <td><span class="a-lencana bg-surface-container-high text-primary">{{ $l->aksi }}</span></td>
                <td>{{ $l->objek }}</td>
                <td class="text-on-surface-variant">{{ $l->ip_address }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-on-surface-variant">Belum ada aktivitas.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-space-md">{{ $log->links('admin.paginasi') }}</div>
@endsection
