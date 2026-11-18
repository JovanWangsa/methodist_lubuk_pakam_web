<?php

namespace App\Support;

use App\Models\Setting;

class Tautan
{
    /** Tautan WhatsApp admin dari pengaturan no_admin_wa. */
    public static function whatsapp(): string
    {
        return 'https://wa.me/'.preg_replace('/\D/', '', Setting::ambil('no_admin_wa', ''));
    }

    /** Tautan unduh katalog/brosur PDF dari pengaturan katalog_url. */
    public static function katalog(): string
    {
        return Setting::ambil('katalog_url') ?: '#';
    }

    /**
     * Tautan panduan pendaftaran online dari pengaturan panduan_daftar_url.
     * Selama belum diisi, tombol diarahkan ke halaman Daftar.
     */
    public static function panduan(): string
    {
        return Setting::ambil('panduan_daftar_url') ?: route('ppdb.daftar');
    }

    /**
     * Tujuan tombol menurut jenisnya di data konten: daftar, katalog, atau wa.
     */
    public static function untuk(string $jenis): string
    {
        return match ($jenis) {
            'daftar' => route('ppdb.daftar'),
            'katalog' => self::katalog(),
            'panduan' => self::panduan(),
            'wa' => self::whatsapp(),
            default => '#',
        };
    }
}
