<?php

namespace Database\Seeders;

use App\Models\KontenBlok;
use Illuminate\Database\Seeder;

class KontenBlokSeeder extends Seeder
{
    /**
     * Isi setiap bagian halaman dari database/data/konten/{kunci}.json.
     * Teks disalin dari desain Stitch dan MENUNGGU VALIDASI pihak sekolah.
     */
    public function run(): void
    {
        foreach (glob(database_path('data/konten/*.json')) as $file) {
            KontenBlok::query()->updateOrCreate(
                ['kunci' => basename($file, '.json')],
                ['data' => json_decode(file_get_contents($file), true, flags: JSON_THROW_ON_ERROR)],
            );
        }
    }
}
