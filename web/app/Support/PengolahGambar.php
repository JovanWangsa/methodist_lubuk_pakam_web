<?php

namespace App\Support;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Mengolah foto yang diunggah admin: diubah ke WebP dan dibuat 3 ukuran lebar
 * (640, 1280, 1920 px) supaya HP tidak perlu mengunduh foto besar.
 * Hanya memakai ekstensi GD bawaan PHP, sehingga jalan di hosting cPanel biasa.
 *
 * File disimpan di public/unggahan/{folder}/{nama}-{lebar}.webp. Yang disimpan di database
 * adalah path versi 1920, misalnya unggahan/slide/9b1c...-1920.webp.
 */
class PengolahGambar
{
    /** @var list<int> */
    public const LEBAR = [640, 1280, 1920];

    public const KUALITAS = 80;

    /** Aturan validasi untuk input foto. */
    public const ATURAN = ['image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=8000,max_height=8000'];

    public static function simpan(UploadedFile $berkas, string $folder): string
    {
        $sumber = self::buka($berkas);
        $lebarAsli = imagesx($sumber);
        $tinggiAsli = imagesy($sumber);

        $folder = trim(Str::slug($folder), '/') ?: 'umum';
        $direktori = public_path('unggahan/'.$folder);
        File::ensureDirectoryExists($direktori);
        $nama = (string) Str::uuid();

        foreach (self::LEBAR as $lebar) {
            $target = min($lebar, $lebarAsli);
            $gambar = $target < $lebarAsli
                ? imagescale($sumber, $target, (int) round($tinggiAsli * $target / $lebarAsli), IMG_BICUBIC)
                : $sumber;

            imagesavealpha($gambar, true);
            imagewebp($gambar, "{$direktori}/{$nama}-{$lebar}.webp", self::KUALITAS);
        }

        return "unggahan/{$folder}/{$nama}-1920.webp";
    }

    /** Menghapus ketiga ukuran dari sebuah foto hasil unggahan. Path lain diabaikan. */
    public static function hapus(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'unggahan/') || ! str_ends_with($path, '.webp')) {
            return;
        }

        $dasar = preg_replace('/-\d+\.webp$/', '', $path);

        foreach (self::LEBAR as $lebar) {
            File::delete(public_path("{$dasar}-{$lebar}.webp"));
        }
    }

    /**
     * Nilai atribut srcset untuk <img>, atau null bila foto bukan hasil unggahan admin.
     */
    public static function srcset(?string $path): ?string
    {
        if (! $path || ! preg_match('/^(unggahan\/.+)-1920\.webp$/', $path, $cocok)) {
            return null;
        }

        return collect(self::LEBAR)
            ->map(fn (int $lebar) => asset("{$cocok[1]}-{$lebar}.webp")." {$lebar}w")
            ->implode(', ');
    }

    private static function buka(UploadedFile $berkas): GdImage
    {
        $gambar = @imagecreatefromstring((string) file_get_contents($berkas->getRealPath()));

        if (! $gambar instanceof GdImage) {
            throw ValidationException::withMessages(['gambar' => 'File gambar rusak atau formatnya tidak didukung.']);
        }

        imagepalettetotruecolor($gambar);

        return self::putarSesuaiExif($gambar, $berkas);
    }

    /** Foto dari HP sering tersimpan miring; putar sesuai data EXIF bila tersedia. */
    private static function putarSesuaiExif(GdImage $gambar, UploadedFile $berkas): GdImage
    {
        if (! function_exists('exif_read_data') || ! in_array($berkas->getMimeType(), ['image/jpeg', 'image/jpg'], true)) {
            return $gambar;
        }

        $orientasi = @exif_read_data($berkas->getRealPath())['Orientation'] ?? 1;
        $sudut = match ((int) $orientasi) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => 0,
        };

        if ($sudut === 0) {
            return $gambar;
        }

        return imagerotate($gambar, $sudut, 0);
    }
}
