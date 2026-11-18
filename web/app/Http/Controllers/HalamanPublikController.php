<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Models\Slide;
use App\Support\KontenPublik;
use Illuminate\Contracts\View\View;

class HalamanPublikController extends Controller
{
    /**
     * Halaman 1: Home pembuka.
     */
    public function pembuka(): View
    {
        return view('pages.pembuka', [
            'slides' => KontenPublik::slides(Slide::LOKASI_PEMBUKA),
            'hero' => KontenPublik::blok('pembuka.hero'),
        ]);
    }

    /**
     * Halaman 2: Homepage (6 bagian + banner PPDB).
     */
    public function beranda(): View
    {
        $instagramBlok = KontenPublik::blok('beranda.instagram');

        return view('pages.beranda', [
            'slides' => KontenPublik::slides(Slide::LOKASI_BERANDA),
            'tombolSlide' => KontenPublik::blok('beranda.tombol_slide')['tombol'] ?? [],
            'angka' => KontenPublik::blok('beranda.angka'),
            'instagramBlok' => $instagramBlok,
            'postInstagram' => $this->postInstagram($instagramBlok),
            'angkaSekolah' => KontenPublik::blok('beranda.angka_sekolah'),
            'visiMisi' => KontenPublik::blok('beranda.visi_misi'),
            'kemitraan' => KontenPublik::blok('beranda.kemitraan'),
        ]);
    }

    /**
     * Halaman 3: Sejarah.
     */
    public function sejarah(): View
    {
        return view('pages.sejarah', [
            'hero' => KontenPublik::blok('sejarah.hero'),
            'biografi' => KontenPublik::blok('sejarah.biografi'),
            'linimasa' => KontenPublik::blok('sejarah.linimasa'),
            'visiMisi' => KontenPublik::blok('sejarah.visi_misi'),
            'galeri' => KontenPublik::blok('sejarah.galeri'),
            'foto' => KontenPublik::blok('sejarah.foto'),
        ]);
    }

    /**
     * Menu yang halamannya dibangun di sprint berikutnya, supaya tidak 404 saat demo.
     */
    public function segera(string $judul, string $sprint): View
    {
        return view('pages.segera', compact('judul', 'sprint'));
    }

    /**
     * Lima unggahan Instagram terbaru. Selama sinkronisasi (Sprint 4) belum berjalan,
     * yang tampil adalah lima kartu contoh dari desain dengan foto kotak abu-abu.
     *
     * @param  array<string, mixed>  $blok
     * @return list<array<string, mixed>>
     */
    private function postInstagram(array $blok): array
    {
        $posts = InstagramPost::query()->latest('posted_at')->limit(5)->get();

        if ($posts->isEmpty()) {
            return array_map(fn (array $c) => $c + ['gambar' => null, 'url' => null], $blok['contoh'] ?? []);
        }

        return $posts->map(fn (InstagramPost $p) => [
            'gambar' => $p->gambar_lokal,
            'url' => $p->permalink,
            'caption' => $p->caption,
            'tag' => null,
            'tag_ikon' => null,
            'tag_warna' => null,
            'suka' => null,
            'komentar' => null,
            'waktu' => $p->posted_at->locale('id')->diffForHumans(),
        ])->all();
    }
}
