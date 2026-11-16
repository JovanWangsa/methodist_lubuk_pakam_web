<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * 10 slide Halaman 1 dan 5 slide Homepage dari database/data/slides.json.
     * Kolom gambar kosong = kotak abu-abu polos sampai foto asli sekolah diunggah.
     */
    public function run(): void
    {
        $slides = json_decode(file_get_contents(database_path('data/slides.json')), true, flags: JSON_THROW_ON_ERROR);

        foreach ($slides as $slide) {
            Slide::query()->updateOrCreate(
                ['lokasi' => $slide['lokasi'], 'urutan' => $slide['urutan']],
                [
                    'judul' => $slide['judul'],
                    'gambar' => $slide['gambar'],
                    'alt' => $slide['alt'],
                    'atribut' => $slide['atribut'],
                    'aktif' => true,
                ],
            );
        }
    }
}
