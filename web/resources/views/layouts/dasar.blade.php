<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>
        @hasSection('judul')
            @yield('judul') |
        @endif
        {{ $pengaturan['nama_sekolah'] ?? config('app.name') }}
    </title>
    <meta name="description" content="@yield('deskripsi', ($pengaturan['nama_sekolah'] ?? config('app.name')).' — '.($pengaturan['moto'] ?? ''))">
    <meta property="og:title" content="@yield('judul', $pengaturan['nama_sekolah'] ?? config('app.name'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Aturan dasar bawaan desain Stitch, disalin apa adanya. --}}
    <style>@layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style>
    @stack('head')
</head>
<body class="@yield('body_kelas', 'bg-background font-body-md text-body-md text-on-surface antialiased')">
@yield('isi')
<x-tombol-gulir />
@stack('scripts')
</body>
</html>
