<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Identitas dan kontak sekolah dari database/data/settings.json.
     * Nilai awal disalin dari desain Stitch dan MENUNGGU VALIDASI pihak sekolah
     * (lihat Sheet "Validasi Data Website"). Ganti isi file JSON, lalu jalankan ulang seeder.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('data/settings.json')), true, flags: JSON_THROW_ON_ERROR);

        foreach ($data as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
