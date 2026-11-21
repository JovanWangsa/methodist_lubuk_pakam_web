# Website Sekolah Methodist Lubuk Pakam

Repository skripsi pengembangan website methodistpakam.sch.id (29 halaman, fullstack).

Arsitektur: **Laravel 13 untuk front-end dan back-end, MySQL (phpMyAdmin) untuk database.** Hosting sekolah hanya menjalankan PHP, jadi proyek ini tidak memakai Node.js, npm, Vite, maupun Express. CSS Tailwind sudah dibuat menjadi file jadi `web/public/css/situs.css`, dan JavaScript berupa file biasa di `web/public/js/`.

| Folder | Isi |
| --- | --- |
| `web/` | Laravel 13: tampilan (Blade + CSS Tailwind jadi), logika, API JSON, panel admin, migration database |
| `deploy/` | Panduan dan file untuk hosting cPanel (tanpa Terminal) |
| `docs/` | ERD (`erd.dbml`) dan hasil ekspor desain Stitch (`design/stitch/`) |
| `.github/` | CI GitHub Actions dan template pull request |

## Status Sprint 1 (16 sampai 22 November 2026)

- [x] Kerangka Laravel 13 (tanpa Node.js/npm, sesuai hosting PHP sekolah)
- [x] Migration 15 tabel, model, dan seeder dari data desain Stitch (`web/database/data/`)
- [x] Halaman 1 (Home pembuka), 2 (Homepage), 3 (Sejarah) persis desain Stitch
- [x] Header dan footer versi Hal. 2 di semua halaman, banner PPDB dan kotak PPDB mengambang versi Hal. 3
- [x] API JSON di Laravel: `GET /api/v1/health`, `GET /api/v1/units`, `GET /api/v1/units/{kode}`
- [x] CI: Pint, cek CSS Tailwind sudah dibuat ulang, tes Laravel (PHP 8.3, sama dengan hosting)
- [x] Panduan deploy ke hosting cPanel tanpa Terminal (`deploy/README.md`)
- [ ] Validasi data oleh pihak sekolah (Sheet "Validasi Data Website"), lalu perbarui `web/database/data/`
- [ ] Ganti kotak abu-abu dengan foto asli sekolah
- [ ] Deploy pertama ke hosting cPanel (lihat `deploy/README.md`)

## Status Sprint 2 (23 sampai 29 November 2026)

- [x] Panel admin di `/admin`: login, lupa password lewat email, batas 5 percobaan login per menit, 3 peran (Super Admin, Admin Konten, Admin PPDB), log aktivitas
- [x] Modul Slide (Halaman 1 dan Homepage), Angka, Konten Sekolah, Partnership, Pengaturan, Pengguna, Profil
- [x] Upload foto otomatis diubah ke WebP ukuran 640, 1280, 1920 px (ekstensi GD bawaan PHP); katalog PDF bisa diunggah
- [x] CSS admin terpisah (`public/css/admin.css`), sehingga CSS halaman publik tidak bertambah
- [x] Perbaikan: slide dan unit di cache disimpan sebagai array, karena Laravel 13 menolak membuka objek dari cache
- [ ] Halaman 4 sampai 25 (Unit Pendidikan): menunggu ekspor desain Stitch

Menu Unit Pendidikan, E-Learning, dan Daftar masih menampilkan halaman "sedang dibangun" sampai halamannya selesai.

## Panel admin

Buka http://localhost:8000/admin dan masuk dengan `ADMIN_EMAIL` dan `ADMIN_PASSWORD` dari `web/.env` (dibuat oleh seeder). Ganti password setelah login pertama lewat menu nama Anda di kanan atas.

| Peran | Bisa membuka |
| --- | --- |
| Super Admin | Semua menu, termasuk Pengguna dan Log Aktivitas |
| Admin Konten | Dasbor, Slide, Angka, Konten Sekolah, Partnership, Pengaturan |
| Admin PPDB | Dasbor (modul PPDB menyusul di Sprint 3) |

- Formulir Angka, Konten Sekolah, dan Partnership dibuat otomatis dari isi blok di tabel `konten_blok`. Daftar blok yang bisa diubah dan labelnya ada di `web/config/admin.php`. Class Tailwind, posisi grafik, dan nama rute tidak ditampilkan di formulir dan selalu dipertahankan, sehingga tampilan tetap sama dengan desain Stitch.
- Foto dan dokumen yang diunggah disimpan di `public/unggahan/` (tidak ikut Git). Di hosting, folder ini berada di `public_html/unggahan/`.
- Email lupa password memakai pengaturan `MAIL_*` di `.env`. Di laptop (`MAIL_MAILER=log`) isi email bisa dibaca di `storage/logs/laravel.log`.

## Kesetiaan pada desain Stitch

- Tailwind CSS sengaja memakai versi 3.4 (sama dengan Tailwind CDN yang dipakai Stitch) dengan `web/tailwind.config.js` yang disalin persis dari ekspor Stitch. Jangan upgrade ke Tailwind 4 tanpa membandingkan ulang tampilan.
- Font Plus Jakarta Sans, Inter, dan Material Symbols disimpan di server sendiri (`web/public/fonts/`). Font ikon dipangkas dari 4 MB menjadi sekitar 80 KB (77 ikon); cara menambah ikon ada di `web/public/fonts/README.md`.
- Hasil pembandingan di lebar 1280 px: Halaman 1 identik 100%. Isi Halaman 2 dan 3 identik; yang berbeda hanya bagian yang memang dipilih tim: kotak PPDB mengambang di Hal. 2, header dan footer Hal. 3 memakai versi Hal. 2, dan tahun hak cipta otomatis.
- Tambahan di luar desain: tombol menu (☰) di layar di bawah 1280 px, karena desain Stitch menyembunyikan menu atas di layar kecil tanpa pengganti.
- Revisi tim (18 November 2026) yang sengaja berbeda dari Stitch:
    - Kelima slide Homepage memakai tiga tombol yang sama dengan slide 1: "Daftar Online", "Katalog Sekolah", "Chat Admin" (`konten/beranda.tombol_slide.json`).
    - Banner PPDB di akhir halaman memakai model Homepage di semua halaman kecuali Halaman 1 (komponen `banner-ppdb`). Judul, deskripsi, dan tombolnya sama persis dengan Homepage (`konten/global.banner_ppdb.json` dan `konten/global.tombol_ppdb.json`).
    - Tombol gulir di sisi kanan layar (komponen `tombol-gulir`): pindah ke bagian berikutnya, dan kembali ke atas di ujung halaman. Tidak tampil bila halaman tidak bisa digulir.
    - Tujuan tombol "Panduan Daftar Online" diatur di `settings.panduan_daftar_url`; selama kosong, tombol menuju halaman Daftar.

## Mengubah teks dan data

Semua teks halaman ada di `web/database/data/`:

- `settings.json`: identitas dan kontak (nama, alamat, telepon, WhatsApp, email, NPSN, akreditasi).
- `slides.json`: 10 slide Halaman 1 dan 5 slide Homepage. Fotonya diunggah lewat admin, menu Slide.
- `konten/*.json`: isi setiap bagian halaman, satu file per bagian.

Semua nilai saat ini disalin dari desain Stitch dan **menunggu validasi** pihak sekolah. File ini hanya isi awal: setelah website berjalan, ubah isi lewat panel admin. Menjalankan `php artisan db:seed` lagi akan menimpa perubahan yang dibuat lewat admin.

## Prasyarat di laptop

1. PHP 8.3 atau 8.4 (sama dengan hosting: minimal 8.3). XAMPP resmi masih membawa PHP 8.2, jadi pasang PHP 8.4 terpisah di `C:\php` (Thread Safe, x64, dari https://windows.php.net/download/), salin `php.ini-development` menjadi `php.ini`, lalu aktifkan ekstensi `pdo_mysql`, `pdo_sqlite`, `sqlite3`, `mbstring`, `intl`, `fileinfo`, `gd`, `zip`, `openssl`, `curl`.
2. Composer 2 dan Git.
3. MySQL/MariaDB dari XAMPP dalam keadaan Start (phpMyAdmin di http://localhost/phpmyadmin).

Node.js dan npm **tidak** diperlukan. Cek dengan `php -v` dan `composer -V`.

## Menjalankan di laptop

1. Buka phpMyAdmin, buat database `methodist_lubuk_pakam_medan` dengan collation `utf8mb4_unicode_ci`.
2. Jalankan:

```bash
cd web
composer install
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
php artisan migrate --seed    # membuat 15 tabel dan data dari desain Stitch
php artisan serve
```

3. Buka http://localhost:8000 (`/`, `/beranda`, `/sejarah`) dan http://localhost:8000/api/v1/health (harus `"database":"terhubung"`).

## Mengubah tampilan (CSS Tailwind tanpa npm)

Ada dua file CSS jadi:

- `web/public/css/situs.css` untuk halaman publik, dari `resources/css/app.css` dan `tailwind.config.js`.
- `web/public/css/admin.css` untuk panel admin, dari `resources/css/admin.css` dan `tailwind.admin.config.js`.

Bila Anda **menambah class Tailwind baru** di file Blade, JSON data, atau JS, CSS harus dibuat ulang dengan Tailwind CLI standalone (satu file .exe, tanpa Node.js):

1. Unduh sekali `tailwindcss-windows-x64.exe` versi **v3.4.17** dari https://github.com/tailwindlabs/tailwindcss/releases/tag/v3.4.17, simpan di `web/` dengan nama `tailwindcss.exe` (sudah diabaikan Git).
2. Dari folder `web`, jalankan:

```bash
.\tailwindcss.exe -i resources/css/app.css -o public/css/situs.css --minify
.\tailwindcss.exe -c tailwind.admin.config.js -i resources/css/admin.css -o public/css/admin.css --minify
```

3. Muat ulang browser dengan Ctrl + F5, lalu commit file di `public/css/` bersama perubahan view-nya. CI akan gagal bila langkah ini terlupa.

Selama mengubah tampilan, tambahkan `--watch` supaya CSS dibuat ulang otomatis setiap file disimpan. Mengubah teks saja atau memakai class yang sudah ada tidak perlu membuat ulang CSS.

## Menjalankan tes

```bash
cd web
php artisan test
vendor/bin/pint --test
```

## Alur kerja Git

1. Ambil satu issue di GitHub Projects, lalu buat branch dari `develop`: `git checkout -b feature/hal-02-instagram`.
2. Commit kecil dengan format Conventional Commits: `feat: ...`, `fix: ...`, `style: ...`, `test: ...`, `docs: ...`.
3. Push lalu buka pull request ke `develop`. Minimal satu anggota lain mereview, dan CI harus hijau sebelum merge.
4. Di akhir sprint, `develop` digabung ke `main` dan diberi tag (`v0.1.0` untuk Sprint 1), lalu dideploy.

Jangan pernah commit file `.env`, password, atau token.

Akun Super Admin dibuat dari `ADMIN_EMAIL` dan `ADMIN_PASSWORD` di `web/.env`. Panel admin dibangun di Sprint 2.
