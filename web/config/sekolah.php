<?php

return [

    /*
    | Alamat layanan API Express (dipakai fitur PPDB dan Instagram mulai Sprint 3).
    */
    'api_url' => env('API_URL', 'http://localhost:3000'),

    /*
    | Akun Super Admin pertama yang dibuat oleh seeder. Ganti lewat .env.
    */
    'admin' => [
        'email' => env('ADMIN_EMAIL', 'admin@methodistpakam.sch.id'),
        'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
    ],

    /*
    | Lima menu utama website, dipakai navbar atas dan navigasi bawah Halaman 1.
    */
    'menu' => [
        ['label' => 'Home', 'route' => 'beranda', 'ikon' => 'home'],
        ['label' => 'Sejarah', 'route' => 'sejarah', 'ikon' => 'buku'],
        ['label' => 'Unit Pendidikan', 'route' => 'unit.index', 'ikon' => 'sekolah'],
        ['label' => 'E-Learning', 'route' => 'elearning', 'ikon' => 'laptop'],
        ['label' => 'Daftar', 'route' => 'ppdb.daftar', 'ikon' => 'daftar'],
    ],

];
