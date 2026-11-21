<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

/**
 * Pencatat log aktivitas admin: siapa mengubah apa, kapan, dari IP mana.
 */
class Aktivitas
{
    public const TAMBAH = 'tambah';

    public const UBAH = 'ubah';

    public const HAPUS = 'hapus';

    public const MASUK = 'masuk';

    public const KELUAR = 'keluar';

    public static function catat(string $aksi, string $objek, ?int $objekId = null): void
    {
        ActivityLog::query()->create([
            'user_id' => auth()->id(),
            'aksi' => $aksi,
            'objek' => Str::limit($objek, 97),
            'objek_id' => $objekId,
            'ip_address' => request()->ip(),
        ]);
    }
}
