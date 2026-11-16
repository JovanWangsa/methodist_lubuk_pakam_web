<?php

namespace App\Support;

use App\Models\KontenBlok;
use App\Models\Slide;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Pintu tunggal untuk konten halaman publik. Semua hasil disimpan di cache dan
 * otomatis dikosongkan setiap kali admin mengubah slide, unit, atau blok konten.
 */
class KontenPublik
{
    /** Lama cache dalam detik (1 jam). */
    public const TTL = 3600;

    public static function slides(string $lokasi): Collection
    {
        return self::ingat("slides.$lokasi", fn () => Slide::query()->tampil($lokasi)->get());
    }

    /**
     * Isi satu blok konten, misalnya blok('beranda.kemitraan').
     *
     * @return array<string, mixed>
     */
    public static function blok(string $kunci): array
    {
        return self::ingat("blok.$kunci", fn () => KontenBlok::query()->where('kunci', $kunci)->value('data') ?? []);
    }

    public static function units(): Collection
    {
        return self::ingat('units', fn () => Unit::query()->orderBy('urutan')->get());
    }

    /**
     * Mengosongkan seluruh cache konten dengan menaikkan nomor versinya.
     */
    public static function lupakan(): void
    {
        Cache::forever('konten.versi', self::versi() + 1);
    }

    private static function versi(): int
    {
        return (int) Cache::get('konten.versi', 1);
    }

    private static function ingat(string $kunci, \Closure $ambil): mixed
    {
        return Cache::remember('konten.v'.self::versi().'.'.$kunci, self::TTL, $ambil);
    }
}
