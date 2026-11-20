# web/ — Aplikasi Laravel 13

Front-end dan back-end website (tanpa Node.js/npm): tampilan publik, API JSON, panel admin, dan seluruh migration database. Panduan lengkap ada di README di folder induk repository.

Struktur penting:

- `routes/web.php`: daftar URL halaman. `routes/api.php`: API JSON `/api/v1/...`.
- `app/Http/Controllers/HalamanPublikController.php`: Halaman 1 sampai 3.
- `app/Http/Controllers/Api/`: health check dan data unit (pengganti Express).
- `app/Support/KontenPublik.php`: pengambilan slide dan blok konten dengan cache.
- `app/Support/Aset.php`: alamat CSS/JS di `public/` dengan penanda versi.
- `resources/views/layouts/`: `dasar` (kerangka HTML) dan `situs` (header, PPDB mengambang, footer).
- `resources/views/components/`: header, footer, banner PPDB, PPDB mengambang, tombol gulir, foto.
- `resources/views/pages/`: view per halaman, markup disalin dari ekspor Stitch.
- `tailwind.config.js` dan `resources/css/app.css`: sumber CSS (tema Tailwind 3 persis dari Stitch).
- `public/css/situs.css`: CSS jadi yang dipakai website. Buat ulang dengan Tailwind CLI standalone bila menambah class baru.
- `public/js/`: JavaScript slider, menu HP, dan tombol gulir. `public/fonts/`: font.
- `database/data/`: semua teks dan data halaman (menunggu validasi sekolah).
- `database/migrations/`: 15 tabel aplikasi.
