<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\KontenBlok;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\User;
use App\Notifications\AturUlangPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

/**
 * Panel admin Sprint 2: login, peran, lupa password, slide, konten, pengaturan, pengguna.
 * Foto hasil unggahan ditulis ke folder public sementara, bukan ke public/ proyek.
 */
class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private string $publikSementara;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publikSementara = sys_get_temp_dir().'/mlp-public-'.uniqid();
        File::ensureDirectoryExists($this->publikSementara);
        $this->app->usePublicPath($this->publikSementara);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->publikSementara);

        parent::tearDown();
    }

    private function admin(string $peran = User::ROLE_SUPER_ADMIN, array $atribut = []): User
    {
        return User::factory()->create(['role' => $peran, 'is_active' => true, ...$atribut]);
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get('/admin/slide')->assertRedirect(route('admin.login'));
        $this->get('/admin/login')->assertOk()->assertSee('Masuk ke panel admin');
    }

    public function test_login_berhasil_mencatat_aktivitas(): void
    {
        $admin = $this->admin(atribut: ['email' => 'kepala@methodistpakam.sch.id', 'password' => 'Rahasia123']);

        $this->post('/admin/login', ['email' => 'kepala@methodistpakam.sch.id', 'password' => 'Rahasia123'])
            ->assertRedirect(route('admin.dasbor'));

        $this->assertAuthenticatedAs($admin);
        $this->assertDatabaseHas('activity_logs', ['user_id' => $admin->id, 'aksi' => 'masuk']);
        $this->get('/admin')->assertOk()->assertSee('Dasbor')->assertSee($admin->name);
    }

    public function test_password_salah_dan_akun_nonaktif_ditolak(): void
    {
        $this->admin(atribut: ['email' => 'a@methodistpakam.sch.id', 'password' => 'Rahasia123']);
        $this->admin(atribut: ['email' => 'b@methodistpakam.sch.id', 'password' => 'Rahasia123', 'is_active' => false]);

        $this->post('/admin/login', ['email' => 'a@methodistpakam.sch.id', 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->post('/admin/login', ['email' => 'b@methodistpakam.sch.id', 'password' => 'Rahasia123'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_dibatasi_lima_percobaan(): void
    {
        $this->admin(atribut: ['email' => 'a@methodistpakam.sch.id', 'password' => 'Rahasia123']);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => 'a@methodistpakam.sch.id', 'password' => 'salah']);
        }

        $respon = $this->post('/admin/login', ['email' => 'a@methodistpakam.sch.id', 'password' => 'Rahasia123']);
        $respon->assertSessionHasErrors('email');
        $this->assertStringStartsWith('Terlalu banyak percobaan masuk', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_akun_yang_dinonaktifkan_saat_masuk_langsung_dikeluarkan(): void
    {
        $admin = $this->admin(User::ROLE_ADMIN_KONTEN);
        $admin->update(['is_active' => false]);

        $this->actingAs($admin)->get('/admin')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_hak_akses_per_peran(): void
    {
        $ppdb = $this->admin(User::ROLE_ADMIN_PPDB);
        $konten = $this->admin(User::ROLE_ADMIN_KONTEN);

        $this->actingAs($ppdb)->get('/admin')->assertOk()->assertDontSee('Konten Sekolah');
        $this->actingAs($ppdb)->get('/admin/slide')->assertForbidden();
        $this->actingAs($ppdb)->get('/admin/pengaturan')->assertForbidden();

        $this->actingAs($konten)->get('/admin/slide')->assertOk();
        $this->actingAs($konten)->get('/admin/konten/grup/angka')->assertOk();
        $this->actingAs($konten)->get('/admin/pengguna')->assertForbidden();
        $this->actingAs($konten)->get('/admin/aktivitas')->assertForbidden();
    }

    public function test_lupa_password_mengirim_email_dan_password_bisa_diganti(): void
    {
        Notification::fake();
        $admin = $this->admin(atribut: ['email' => 'a@methodistpakam.sch.id']);

        $this->post('/admin/lupa-password', ['email' => 'a@methodistpakam.sch.id'])->assertSessionHas('status');
        $this->post('/admin/lupa-password', ['email' => 'tidakada@methodistpakam.sch.id'])->assertSessionHas('status');
        Notification::assertSentTo($admin, AturUlangPassword::class);
        Notification::assertCount(1);

        $token = Password::createToken($admin);
        $this->get("/admin/reset-password/{$token}?email=a@methodistpakam.sch.id")->assertOk()->assertSee('Buat password baru');

        $this->post('/admin/reset-password', [
            'token' => $token,
            'email' => 'a@methodistpakam.sch.id',
            'password' => 'PasswordBaru9',
            'password_confirmation' => 'PasswordBaru9',
        ])->assertRedirect(route('admin.login'));

        $this->post('/admin/login', ['email' => 'a@methodistpakam.sch.id', 'password' => 'PasswordBaru9'])
            ->assertRedirect(route('admin.dasbor'));
    }

    public function test_ubah_slide_beranda_dengan_foto_menjadi_webp_tiga_ukuran(): void
    {
        $slide = Slide::query()->where('lokasi', 'beranda')->orderBy('urutan')->firstOrFail();
        $kelasLencana = $slide->atribut['lencana']['kelas'];

        $this->actingAs($this->admin(User::ROLE_ADMIN_KONTEN))
            ->put("/admin/slide/{$slide->id}", [
                'judul' => 'Judul Slide Baru',
                'lencana_teks' => 'Lencana Baru',
                'lencana_ikon' => 'school',
                'deskripsi' => 'Deskripsi slide baru.',
                'urutan' => 1,
                'aktif' => 1,
                'gambar' => UploadedFile::fake()->image('gedung.jpg', 2400, 1200),
            ])
            ->assertRedirect(route('admin.slide.index', ['lokasi' => 'beranda']));

        $slide->refresh();
        $this->assertSame('Judul Slide Baru', $slide->judul);
        $this->assertSame('Lencana Baru', $slide->atribut['lencana']['teks']);
        $this->assertSame($kelasLencana, $slide->atribut['lencana']['kelas'], 'class Tailwind dari desain harus tetap');
        $this->assertMatchesRegularExpression('#^unggahan/slide/[0-9a-f-]+-1920\.webp$#', $slide->gambar);

        foreach ([640 => 640, 1280 => 1280, 1920 => 1920] as $ukuran => $lebar) {
            $file = public_path(str_replace('-1920.webp', "-{$ukuran}.webp", $slide->gambar));
            $this->assertFileExists($file);
            $this->assertSame($lebar, getimagesize($file)[0]);
            $this->assertSame('image/webp', getimagesize($file)['mime']);
        }

        $this->get('/beranda')->assertSee('Judul Slide Baru')->assertSee('Lencana Baru')->assertSee($slide->gambar);
        $this->assertDatabaseHas('activity_logs', ['aksi' => 'ubah', 'objek' => 'Slide: Judul Slide Baru']);

        $this->delete("/admin/slide/{$slide->id}")->assertRedirect();
        $this->assertFileDoesNotExist(public_path($slide->gambar));
        $this->assertModelMissing($slide);
    }

    public function test_foto_kecil_tidak_diperbesar_dan_file_bukan_gambar_ditolak(): void
    {
        $slide = Slide::query()->where('lokasi', 'pembuka')->firstOrFail();
        $admin = $this->admin(User::ROLE_ADMIN_KONTEN);
        $dasar = ['judul' => 'Foto kecil', 'urutan' => 1, 'aktif' => 1];

        $this->actingAs($admin)->put("/admin/slide/{$slide->id}", [...$dasar, 'gambar' => UploadedFile::fake()->image('kecil.png', 500, 300)])
            ->assertSessionHasNoErrors();
        $this->assertSame(500, getimagesize(public_path($slide->refresh()->gambar))[0]);

        $this->actingAs($admin)->put("/admin/slide/{$slide->id}", [...$dasar, 'gambar' => UploadedFile::fake()->create('virus.pdf', 10, 'application/pdf')])
            ->assertSessionHasErrors('gambar');
    }

    public function test_tambah_slide_pembuka_dan_tampil_di_halaman_1(): void
    {
        $this->actingAs($this->admin())->post('/admin/slide', [
            'lokasi' => 'pembuka',
            'judul' => 'Lapangan Olahraga Baru',
            'urutan' => 11,
            'aktif' => 1,
        ])->assertRedirect(route('admin.slide.index', ['lokasi' => 'pembuka']));

        $this->get('/')->assertSee('Lapangan Olahraga Baru');
    }

    public function test_ubah_angka_homepage_kolom_teknis_tetap_dan_daftar_bisa_ditambah(): void
    {
        $asli = KontenBlok::query()->where('kunci', 'beranda.angka')->value('data');
        $kiriman = ['__daftar' => 1];
        foreach ($asli as $i => $item) {
            $kiriman[$i] = ['ikon' => $item['ikon'], 'nilai' => $item['nilai'], 'label' => $item['label'], 'deskripsi' => $item['deskripsi']];
        }
        $kiriman[0]['nilai'] = '75+';
        unset($kiriman[4]);
        $kiriman[1764000000000] = ['ikon' => 'groups', 'nilai' => '1.200', 'label' => 'Siswa Aktif', 'deskripsi' => 'Jumlah siswa semua jenjang'];

        $this->actingAs($this->admin(User::ROLE_ADMIN_KONTEN))
            ->get('/admin/konten/beranda.angka')->assertOk()->assertSee('Tahun Melayani')->assertDontSee('kartu_kelas');

        $this->put('/admin/konten/beranda.angka', ['data' => $kiriman])
            ->assertRedirect(route('admin.konten.edit', 'beranda.angka'));

        $baru = KontenBlok::query()->where('kunci', 'beranda.angka')->value('data');
        $this->assertCount(5, $baru);
        $this->assertSame('75+', $baru[0]['nilai']);
        $this->assertSame($asli[0]['kartu_kelas'], $baru[0]['kartu_kelas']);
        $this->assertSame('Siswa Aktif', $baru[4]['label']);
        $this->assertSame($asli[4]['kartu_kelas'], $baru[4]['kartu_kelas'], 'item baru meniru class item terakhir');

        $this->get('/beranda')->assertSee('75+')->assertSee('Siswa Aktif');
    }

    public function test_school_in_numbers_geometri_grafik_tidak_bisa_diubah(): void
    {
        $asli = KontenBlok::query()->where('kunci', 'beranda.angka_sekolah')->value('data');

        $this->actingAs($this->admin(User::ROLE_ADMIN_KONTEN))->put('/admin/konten/beranda.angka_sekolah', [
            'data' => [
                'judul' => 'Sekolah Dalam Angka',
                'medali' => ['batang' => ['__daftar' => 1, 0 => ['tahun' => '2020', 'label' => '19', 'x' => 999]]],
            ],
        ])->assertSessionHasNoErrors();

        $baru = KontenBlok::query()->where('kunci', 'beranda.angka_sekolah')->value('data');
        $this->assertSame('Sekolah Dalam Angka', $baru['judul']);
        $this->assertSame('19', $baru['medali']['batang'][0]['label']);
        $this->assertSame($asli['medali']['batang'][0]['x'], $baru['medali']['batang'][0]['x']);
        $this->assertSame($asli['medali']['batang'][0]['isi'], $baru['medali']['batang'][0]['isi']);
        $this->assertSame($asli['deskripsi'], $baru['deskripsi'], 'kolom yang tidak dikirim tetap');
    }

    public function test_unggah_foto_hero_sejarah_lewat_editor_konten(): void
    {
        $this->actingAs($this->admin())->put('/admin/konten/sejarah.foto', [
            'data' => [],
            'berkas' => ['hero' => UploadedFile::fake()->image('hero.jpg', 1600, 900)],
        ])->assertSessionHasNoErrors();

        $foto = KontenBlok::query()->where('kunci', 'sejarah.foto')->value('data');
        $this->assertStringStartsWith('unggahan/konten/', $foto['hero']);
        $this->assertFileExists(public_path($foto['hero']));

        $this->put('/admin/konten/sejarah.foto', ['data' => [], 'hapus' => ['hero' => '1']]);
        $this->assertNull(KontenBlok::query()->where('kunci', 'sejarah.foto')->value('data')['hero']);
        $this->assertFileDoesNotExist(public_path($foto['hero']));
    }

    public function test_blok_yang_tidak_terdaftar_404(): void
    {
        $this->actingAs($this->admin())->get('/admin/konten/rahasia.apa')->assertNotFound();
        $this->get('/admin/konten/grup/tidakada')->assertNotFound();
    }

    public function test_pengaturan_nomor_wa_divalidasi_dan_mengubah_tautan_publik(): void
    {
        $admin = $this->admin(User::ROLE_ADMIN_KONTEN);
        $isian = Setting::semua();

        $this->actingAs($admin)->put('/admin/pengaturan', [...$isian, 'no_admin_wa' => '0812-abc'])
            ->assertSessionHasErrors('no_admin_wa');

        $this->put('/admin/pengaturan', [
            ...$isian,
            'no_admin_wa' => '6281200001111',
            'katalog_pdf' => UploadedFile::fake()->create('katalog.pdf', 200, 'application/pdf'),
        ])->assertSessionHasNoErrors();

        $katalog = Setting::ambil('katalog_url');
        $this->assertStringStartsWith('unggahan/dokumen/katalog-sekolah-', $katalog);
        $this->assertFileExists(public_path($katalog));

        $this->get('/beranda')->assertSee('https://wa.me/6281200001111', false)->assertSee(asset($katalog), false);
    }

    public function test_super_admin_mengelola_pengguna(): void
    {
        $super = $this->admin();

        $this->actingAs($super)->post('/admin/pengguna', [
            'name' => 'Staf PPDB',
            'email' => 'ppdb@methodistpakam.sch.id',
            'role' => User::ROLE_ADMIN_PPDB,
            'is_active' => 1,
            'password' => 'Ppdb2026a',
            'password_confirmation' => 'Ppdb2026a',
        ])->assertRedirect(route('admin.pengguna.index'));

        $baru = User::query()->where('email', 'ppdb@methodistpakam.sch.id')->firstOrFail();
        $this->assertSame(User::ROLE_ADMIN_PPDB, $baru->role);

        $this->put("/admin/pengguna/{$baru->id}", [
            'name' => 'Staf PPDB',
            'email' => 'ppdb@methodistpakam.sch.id',
            'role' => User::ROLE_ADMIN_PPDB,
        ])->assertRedirect();
        $this->assertFalse($baru->refresh()->is_active, 'tanpa centang = nonaktif');

        // Super Admin tidak bisa menurunkan peran atau menonaktifkan dirinya sendiri, dan tidak bisa menghapus dirinya.
        $this->put("/admin/pengguna/{$super->id}", ['name' => $super->name, 'email' => $super->email, 'role' => User::ROLE_ADMIN_PPDB]);
        $this->assertSame(User::ROLE_SUPER_ADMIN, $super->refresh()->role);
        $this->assertTrue($super->is_active);
        $this->delete("/admin/pengguna/{$super->id}")->assertStatus(422);

        $this->delete("/admin/pengguna/{$baru->id}")->assertRedirect();
        $this->assertModelMissing($baru);

        $this->get('/admin/aktivitas')->assertOk()->assertSee('Pengguna: ppdb@methodistpakam.sch.id');
        $this->assertSame(3, ActivityLog::query()->where('objek', 'Pengguna: ppdb@methodistpakam.sch.id')->count());
    }

    public function test_ganti_password_sendiri_butuh_password_lama(): void
    {
        $admin = $this->admin(atribut: ['password' => 'Lama12345']);

        $this->actingAs($admin)->put('/admin/profil', ['name' => 'Baru', 'password_lama' => 'keliru', 'password' => 'Baru12345', 'password_confirmation' => 'Baru12345'])
            ->assertSessionHasErrors('password_lama');

        $this->put('/admin/profil', ['name' => 'Baru', 'password_lama' => 'Lama12345', 'password' => 'Baru12345', 'password_confirmation' => 'Baru12345'])
            ->assertSessionHasNoErrors();
        $this->assertTrue(password_verify('Baru12345', $admin->refresh()->password));
    }

    public function test_keluar(): void
    {
        $this->actingAs($this->admin())->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
