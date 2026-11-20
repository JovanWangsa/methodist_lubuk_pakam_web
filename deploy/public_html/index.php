<?php

/*
| index.php KHUSUS HOSTING cPanel. Salin file ini ke public_html/ (menggantikan index.php
| dari web/public). Aplikasi Laravel diletakkan di luar public_html, di folder
| methodist_lubuk_pakam_web, sehingga .env, kode, dan vendor tidak bisa dibuka dari browser.
| Ganti nama folder di $aplikasi bila Anda memakai nama lain.
*/

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$aplikasi = dirname(__DIR__).'/methodist_lubuk_pakam_web';

// Mode perawatan (maintenance)...
if (file_exists($maintenance = $aplikasi.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader Composer (folder vendor ikut diunggah, karena hosting tidak punya Terminal)...
require $aplikasi.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $aplikasi.'/bootstrap/app.php';

// File publik (css, js, fonts, gambar) ada di public_html, bukan di methodist_lubuk_pakam_web/public.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
