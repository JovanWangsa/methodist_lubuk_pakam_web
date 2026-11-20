<?php

namespace App\Support;

/**
 * Alamat file CSS/JS/font di folder public, tanpa Vite atau npm.
 * Ditambah ?v=<waktu ubah file> supaya browser langsung memuat versi baru setelah file diganti.
 */
class Aset
{
    public static function url(string $path): string
    {
        $path = ltrim($path, '/');
        $file = public_path($path);

        return asset($path).(is_file($file) ? '?v='.filemtime($file) : '');
    }
}
