<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Data awal website. Semua teks berasal dari desain Stitch dan menunggu validasi
     * pihak sekolah; ubah file di database/data/ lalu jalankan `php artisan db:seed`.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
            UnitSeeder::class,
            SlideSeeder::class,
            KontenBlokSeeder::class,
        ]);
    }
}
