<?php

namespace App\Models\Concerns;

use App\Support\KontenPublik;

/**
 * Model yang memakai trait ini otomatis mengosongkan cache konten publik
 * setiap kali datanya disimpan atau dihapus dari panel admin.
 */
trait MenghapusCacheKonten
{
    protected static function bootMenghapusCacheKonten(): void
    {
        static::saved(fn () => KontenPublik::lupakan());
        static::deleted(fn () => KontenPublik::lupakan());
    }
}
