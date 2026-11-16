@extends('layouts.dasar')

{{--
    Kerangka halaman 2 sampai 29: header dan footer persis versi Hal. 2 di Stitch,
    kotak PPDB mengambang persis versi Hal. 3.
--}}
@section('isi')
<x-header-situs />
<main class="@yield('main_kelas', 'w-full pt-20 bg-surface min-h-[calc(100vh-80px)]')">
@yield('konten')
</main>
<x-ppdb-mengambang />
<x-footer-situs />
@endsection
