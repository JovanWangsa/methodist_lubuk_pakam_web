<?php

namespace Tests\Feature;

use App\Models\KontenBlok;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HalamanPublikTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_css_dan_js_dimuat_langsung_dari_public_tanpa_vite(): void
    {
        $this->assertFileExists(public_path('css/situs.css'));

        $this->get('/beranda')
            ->assertSee('/css/situs.css?v=', false)
            ->assertSee('/js/app.js?v=', false)
            ->assertSee('/js/beranda.js?v=', false)
            ->assertDontSee('/build/', false);
    }

    public function test_halaman_1_pembuka_sesuai_desain_stitch(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Perguruan Methodist')
            ->assertSee('Lubuk Pakam')
            ->assertSee('Jelajahi Sekolah')
            ->assertSee('Gedung Utama &amp; Kawasan Kampus', false)
            ->assertSee('01</span> / <span class="opacity-60">10</span>', false)
            ->assertDontSee('<footer', false);
    }

    public function test_halaman_2_beranda_memuat_tujuh_bagian(): void
    {
        $this->get('/beranda')
            ->assertOk()
            ->assertSee('Membangun Karakter Iman &amp; Keunggulan Global', false)
            ->assertSee('Tahun Melayani')
            ->assertSee('Kabar &amp; Aktivitas Terkini', false)
            ->assertSee('School in Numbers')
            ->assertSee('4 Pilar Karakter &amp; Kecakapan Siswa', false)
            ->assertSee('Kemitraan Strategis Pendidikan')
            ->assertSee('Bergabunglah Bersama Keluarga Besar Methodist Lubuk Pakam');
    }

    public function test_halaman_3_sejarah_memuat_linimasa_dan_galeri(): void
    {
        $this->get('/sejarah')
            ->assertOk()
            ->assertSee('Menerangi Negeri')
            ->assertSee('<strong>1 Agustus 1958</strong>', false)
            ->assertSee('Linimasa Langkah Iman &amp; Prestasi', false)
            ->assertSee('Jajaran Petinggi &amp; Pimpinan Sekolah', false);
    }

    public function test_header_footer_dan_ppdb_mengambang_ada_di_halaman_2_dan_3(): void
    {
        foreach (['/beranda', '/sejarah'] as $url) {
            $this->get($url)
                ->assertSee('NPSN: 10214051')
                ->assertSee('Hubungi Kami')
                ->assertSee('Gelombang 1: Diskon Uang Pangkal');
        }
    }

    public function test_menu_aktif_ditandai(): void
    {
        $this->get('/sejarah')->assertSee('aria-current="page" class="px-space-md py-space-sm transition-colors bg-primary-container', false);
    }

    public function test_menu_yang_belum_dibangun_tidak_404(): void
    {
        foreach (['/unit-pendidikan', '/daftar', '/e-learning'] as $url) {
            $this->get($url)->assertOk()->assertSee('sedang dibangun');
        }
    }

    public function test_nomor_whatsapp_dan_konten_diambil_dari_database(): void
    {
        $this->get('/beranda')->assertSee('wa.me/6281264976447', false);

        Setting::query()->where('key', 'no_admin_wa')->first()->update(['value' => '6281111111111']);
        $blok = KontenBlok::query()->where('kunci', 'beranda.kemitraan')->first();
        $blok->update(['data' => ['judul' => 'Mitra Baru'] + $blok->data]);

        $this->get('/beranda')
            ->assertSee('wa.me/6281111111111', false)
            ->assertSee('Mitra Baru');
    }

    public function test_foto_kosong_tampil_sebagai_kotak_abu_abu(): void
    {
        $this->get('/sejarah')->assertSee('bg-gray-300', false);
    }

    public function test_kelima_slide_beranda_memakai_tiga_tombol_yang_sama(): void
    {
        $html = $this->get('/beranda')->assertOk()->getContent();

        $this->assertSame(5, substr_count($html, '<span>Daftar Online</span>'));
        $this->assertSame(5, substr_count($html, '<span>Katalog Sekolah</span>'));
        // 5 di slide + 1 di banner PPDB.
        $this->assertSame(6, substr_count($html, '<span>Chat Admin</span>'));
    }

    public function test_banner_ppdb_sama_di_semua_halaman_kecuali_pembuka(): void
    {
        foreach (['/beranda', '/sejarah', '/unit-pendidikan'] as $url) {
            $this->get($url)
                ->assertSee('Bergabunglah Bersama Keluarga Besar Methodist Lubuk Pakam')
                ->assertDontSee('Jadilah Bagian dari Sejarah Keunggulan Kami')
                ->assertSee('Daftar Sekarang Online')
                ->assertSee('Panduan Daftar Online')
                ->assertSee('<span>Chat Admin</span>', false)
                ->assertDontSee('Brosur PPDB')
                ->assertDontSee('WA Admisi');
        }

        $this->get('/')->assertDontSee('Panduan Daftar Online');
    }

    public function test_tombol_gulir_ada_di_setiap_halaman(): void
    {
        foreach (['/', '/beranda', '/sejarah'] as $url) {
            $this->get($url)->assertSee('data-tombol-gulir', false);
        }
    }

    public function test_halaman_tetap_jalan_saat_konten_dibaca_ulang_dari_cache_file(): void
    {
        // Sama seperti di hosting (CACHE_STORE=file): permintaan kedua membaca slide dari cache.
        config(['cache.default' => 'file']);
        cache()->flush();

        foreach (['/', '/beranda'] as $url) {
            $this->get($url)->assertOk();
            $this->get($url)->assertOk();
        }

        cache()->flush();
    }
}
