# Website Sekolah Methodist Lubuk Pakam

Repository skripsi pengembangan website methodistpakam.sch.id (29 halaman, fullstack).

| Folder | Isi |
| --- | --- |
| `web/` | Laravel 13: halaman publik, panel admin, migration database |
| `api/` | Node.js + Express: API PPDB dan sinkronisasi Instagram |
| `deploy/` | Skrip setup VPS, skrip deploy, konfigurasi Nginx |
| `docs/` | ERD (`erd.dbml`) dan hasil ekspor desain Stitch (`design/stitch/`) |
| `.github/` | CI GitHub Actions dan template pull request |

## Status Sprint 1 (16 sampai 22 November 2026)

- [x] Kerangka Laravel 13 dan Express dalam satu repository
- [x] Migration 15 tabel, model, dan seeder dari data desain Stitch (`web/database/data/`)
- [x] Halaman 1 (Home pembuka), 2 (Homepage), 3 (Sejarah) persis desain Stitch
- [x] Header dan footer versi Hal. 2 di semua halaman, banner PPDB dan kotak PPDB mengambang versi Hal. 3
- [x] API: `GET /api/v1/health`, `GET /api/v1/units`, `GET /api/v1/units/{kode}`
- [x] CI: Pint, build Vite, tes Laravel, ESLint, tes Express
- [x] Skrip setup VPS, deploy, dan konfigurasi Nginx
- [ ] Validasi data oleh pihak sekolah (Sheet "Validasi Data Website"), lalu perbarui `web/database/data/`
- [ ] Ganti kotak abu-abu dengan foto asli sekolah
- [ ] Setup VPS dan deploy pertama (lihat `deploy/README.md`)

Menu Unit Pendidikan, E-Learning, dan Daftar menampilkan halaman "sedang dibangun" sampai sprint-nya tiba.

## Kesetiaan pada desain Stitch

- Tailwind CSS sengaja memakai versi 3.4 (sama dengan Tailwind CDN yang dipakai Stitch) dengan `web/tailwind.config.js` yang disalin persis dari ekspor Stitch. Jangan upgrade ke Tailwind 4 tanpa membandingkan ulang tampilan.
- Font Plus Jakarta Sans, Inter, dan Material Symbols disimpan di server sendiri (`web/resources/fonts/`). Font ikon dipangkas dari 4 MB menjadi sekitar 72 KB; cara menambah ikon ada di `web/resources/fonts/README.md`.
- Hasil pembandingan di lebar 1280 px: Halaman 1 identik 100%. Isi Halaman 2 dan 3 identik; yang berbeda hanya bagian yang memang dipilih tim: kotak PPDB mengambang di Hal. 2, header dan footer Hal. 3 memakai versi Hal. 2, dan tahun hak cipta otomatis.
- Satu tambahan di luar desain: tombol menu (☰) di layar di bawah 1280 px, karena desain Stitch menyembunyikan menu atas di layar kecil tanpa pengganti.

## Mengubah teks dan data

Semua teks halaman ada di `web/database/data/`:

- `settings.json`: identitas dan kontak (nama, alamat, telepon, WhatsApp, email, NPSN, akreditasi).
- `slides.json`: 10 slide Halaman 1 dan 5 slide Homepage. Isi `gambar` dengan path foto (misalnya `storage/slides/gedung.webp`) untuk mengganti kotak abu-abu.
- `konten/*.json`: isi setiap bagian halaman, satu file per bagian.

Semua nilai saat ini disalin dari desain Stitch dan **menunggu validasi** pihak sekolah. Setelah diubah, jalankan `php artisan db:seed`. Mulai Sprint 2, data ini diubah lewat panel admin.

## Prasyarat di laptop

1. PHP 8.3 atau 8.4. XAMPP resmi masih membawa PHP 8.2, jadi pilih salah satu:
    - Unduh PHP 8.4 (Thread Safe, x64) dari https://windows.php.net/download/, ganti isi folder `C:\xampp\php` dengan isinya (cadangkan folder lama dulu), lalu salin `php.ini-development` menjadi `php.ini` dan aktifkan ekstensi `pdo_mysql`, `mbstring`, `intl`, `fileinfo`, `gd`, `zip`, `openssl`, `curl`.
    - Atau pakai Laragon, yang sudah membawa PHP versi baru.
2. Composer 2, Node.js 26 LTS (atau 24 LTS), Git.
3. MySQL/MariaDB dari XAMPP dalam keadaan Start.

Cek dengan `php -v`, `composer -V`, `node -v`.

## Menjalankan di laptop

### 1. Database

Buka phpMyAdmin, buat database `methodist_lubuk_pakam_medan` dengan collation `utf8mb4_unicode_ci`.

### 2. Laravel (folder web)

```bash
cd web
composer install
cp .env.example .env          # Windows CMD: copy .env.example .env
php artisan key:generate
php artisan migrate --seed    # membuat 15 tabel dan data dari desain Stitch
npm install
npm run dev                   # biarkan berjalan, buka terminal baru untuk langkah berikut
php artisan serve
```

Buka http://localhost:8000. Halaman yang sudah jadi: `/`, `/beranda`, `/sejarah`.

### 3. Express (folder api)

```bash
cd api
cp .env.example .env
npm install
npm run dev
```

Buka http://localhost:3000/api/v1/health. Bila MySQL berjalan, hasilnya `"database": "terhubung"`.

Saat `npm run dev` dimulai, terminal langsung menulis apakah database terhubung. Bila gagal maka baca baris `Petunjuk:` di bawahnya. Penyebab paling umum: `DB_DATABASE` di `api/.env` berbeda dengan `web/.env` (keduanya harus `methodist_lubuk_pakam_medan`) atau MySQL di XAMPP belum di-Start.

## Menjalankan tes

```bash
cd web && php artisan test && vendor/bin/pint --test
cd api && npm test && npm run lint
```

## Alur kerja Git

1. Ambil satu issue di GitHub Projects, lalu buat branch dari `develop`: `git checkout -b feature/hal-02-instagram`.
2. Commit kecil dengan format Conventional Commits: `feat: ...`, `fix: ...`, `style: ...`, `test: ...`, `docs: ...`.
3. Push lalu buka pull request ke `develop`. Minimal satu anggota lain mereview, dan CI harus hijau sebelum merge.
4. Di akhir sprint, `develop` digabung ke `main` dan diberi tag (`v0.1.0` untuk Sprint 1), lalu dideploy.

Jangan pernah commit file `.env`, password, atau token.

Akun Super Admin dibuat dari `ADMIN_EMAIL` dan `ADMIN_PASSWORD` di `web/.env`. Panel admin dibangun di Sprint 2.
