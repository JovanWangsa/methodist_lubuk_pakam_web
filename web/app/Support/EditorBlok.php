<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Formulir generik untuk blok konten JSON (tabel konten_blok).
 *
 * Formulir hanya menampilkan kolom yang boleh diubah admin (teks, angka, foto).
 * Kolom teknis (class Tailwind, posisi grafik, rute) tidak ditampilkan dan nilainya
 * selalu diambil dari data lama, sehingga tampilan tetap sama persis dengan desain Stitch.
 */
class EditorBlok
{
    /** Penanda di formulir bahwa sebuah daftar ikut dikirim (agar daftar yang dikosongkan tetap tersimpan kosong). */
    public const PENANDA_DAFTAR = '__daftar';

    /** @param  array<string, mixed>  $definisi */
    public function __construct(private string $kunci, private array $definisi = []) {}

    public static function untuk(string $kunci): self
    {
        return new self($kunci, config('admin.blok')[$kunci] ?? []);
    }

    /** Apakah kolom ini disembunyikan dari formulir? */
    public function teknis(string $kolom, mixed $nilai): bool
    {
        if ($kolom === '') {
            return false;
        }

        if (in_array($kolom, config('admin.kolom_teknis', []), true) || str_ends_with($kolom, '_kelas')) {
            return true;
        }

        if (in_array($kolom, $this->definisi['sembunyi'] ?? [], true)) {
            return true;
        }

        // Daftar angka murni = koordinat grafik.
        return is_array($nilai) && $nilai !== [] && array_is_list($nilai)
            && collect($nilai)->every(fn ($v) => is_int($v) || is_float($v));
    }

    public function foto(string $kolom): bool
    {
        return $kolom === 'foto' || in_array($kolom, $this->definisi['foto'] ?? [], true);
    }

    public static function label(string|int $kolom): string
    {
        if (is_int($kolom)) {
            return '#'.($kolom + 1);
        }

        if ($kolom === '') {
            return 'Daftar item';
        }

        return config("admin.label.{$kolom}") ?? Str::ucfirst(str_replace('_', ' ', $kolom));
    }

    /** Teks panjang ditampilkan sebagai textarea. */
    public static function panjang(string|int $kolom, mixed $nilai): bool
    {
        return in_array($kolom, ['isi', 'deskripsi', 'kutipan', 'paragraf', 'caption', 'wesley_kutipan', 'prinsip_isi', 'pijar_isi', 'kartu_isi'], true)
            || (is_string($nilai) && mb_strlen($nilai) > 90);
    }

    /**
     * Menggabungkan kiriman formulir ke data lama.
     *
     * @param  array<string, mixed>  $asli
     * @return array<string, mixed>
     */
    public function gabung(array $asli, array $kiriman, array $berkas = [], array $hapus = []): array
    {
        $hasil = $this->gabungNilai($asli, '', true, $kiriman, $berkas, $hapus);

        // Foto lama yang sudah tidak dipakai (diganti, dihapus, atau itemnya dihapus) ikut dibuang.
        foreach (array_diff(self::daftarFoto($asli), self::daftarFoto($hasil)) as $path) {
            PengolahGambar::hapus($path);
        }

        return $hasil;
    }

    private function gabungNilai(mixed $asli, string|int $kolom, bool $ada, mixed $kiriman, mixed $berkas, mixed $hapus): mixed
    {
        if (is_string($kolom) && $this->teknis($kolom, $asli)) {
            return $asli;
        }

        if (is_string($kolom) && $this->foto($kolom)) {
            if ($berkas instanceof UploadedFile) {
                return PengolahGambar::simpan($berkas, 'konten');
            }

            return filter_var($hapus, FILTER_VALIDATE_BOOLEAN) ? null : $asli;
        }

        if (is_array($asli) && array_is_list($asli)) {
            return $ada && is_array($kiriman) ? $this->gabungDaftar($asli, $kiriman, $berkas, $hapus) : $asli;
        }

        if (is_array($asli)) {
            $hasil = [];

            foreach ($asli as $k => $v) {
                $hasil[$k] = $this->gabungNilai(
                    $v,
                    $k,
                    is_array($kiriman) && array_key_exists($k, $kiriman),
                    is_array($kiriman) ? ($kiriman[$k] ?? null) : null,
                    is_array($berkas) ? ($berkas[$k] ?? null) : null,
                    is_array($hapus) ? ($hapus[$k] ?? null) : null,
                );
            }

            return $hasil;
        }

        if (! $ada || is_array($kiriman)) {
            return $asli;
        }

        return match (true) {
            is_int($asli) => (int) $kiriman,
            is_float($asli) => (float) $kiriman,
            default => Str::limit(trim((string) $kiriman), 5000, ''),
        };
    }

    /**
     * @param  list<mixed>  $asli
     * @param  array<int|string, mixed>  $kiriman
     * @return list<mixed>
     */
    private function gabungDaftar(array $asli, array $kiriman, mixed $berkas, mixed $hapus): array
    {
        unset($kiriman[self::PENANDA_DAFTAR]);
        $contoh = $asli === [] ? '' : $asli[array_key_last($asli)];
        $hasil = [];

        foreach ($kiriman as $k => $item) {
            // Item lama memakai data lamanya sebagai dasar; item baru memakai item terakhir sebagai contoh
            // (kolom teknis seperti class ikut tersalin, kolom isian diambil dari kiriman).
            $dasar = is_int($k) && array_key_exists($k, $asli) ? $asli[$k] : self::kosongkan($contoh);
            $nilai = $this->gabungNilai(
                $dasar,
                $k,
                true,
                $item,
                is_array($berkas) ? ($berkas[$k] ?? null) : null,
                is_array($hapus) ? ($hapus[$k] ?? null) : null,
            );

            if (is_string($nilai) && $nilai === '') {
                continue;
            }

            $hasil[] = $nilai;
        }

        return $hasil;
    }

    /** Item kosong untuk tombol "Tambah" di formulir: semua isian dikosongkan, bentuknya sama. */
    public static function templat(mixed $contoh): mixed
    {
        return match (true) {
            is_array($contoh) && array_is_list($contoh) => $contoh === [] ? [] : [self::templat($contoh[0])],
            is_array($contoh) => array_map(fn ($v) => self::templat($v), $contoh),
            is_int($contoh) => 0,
            is_float($contoh) => 0.0,
            is_string($contoh) => '',
            default => null,
        };
    }

    /** Salinan item contoh dengan semua foto dikosongkan (item baru belum punya foto). */
    private static function kosongkan(mixed $contoh): mixed
    {
        if (is_array($contoh)) {
            return array_map(fn ($v) => self::kosongkan($v), $contoh);
        }

        return is_string($contoh) && str_starts_with($contoh, 'unggahan/') ? null : $contoh;
    }

    /** @return list<string> */
    private static function daftarFoto(mixed $data): array
    {
        return collect(Arr::flatten(Arr::wrap($data)))
            ->filter(fn ($v) => is_string($v) && str_starts_with($v, 'unggahan/'))
            ->values()
            ->all();
    }
}
