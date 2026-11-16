<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $table = 'settings';

    protected $guarded = ['id'];

    /** Kunci cache untuk seluruh pengaturan. */
    public const CACHE_KEY = 'settings.semua';

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    /**
     * Semua pengaturan dalam bentuk [key => value], disimpan di cache.
     *
     * @return array<string, string|null>
     */
    public static function semua(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::query()->pluck('value', 'key')->all());
    }

    public static function ambil(string $key, ?string $default = null): ?string
    {
        return static::semua()[$key] ?? $default;
    }
}
