# web/ — Aplikasi Laravel 13

Tampilan publik, panel admin, dan seluruh migration database. Panduan lengkap ada di README di folder induk repository.

Struktur penting:

- `routes/web.php`: daftar URL halaman.
- `app/Http/Controllers/HalamanPublikController.php`: Halaman 1 sampai 3.
- `app/Support/KontenPublik.php`: pengambilan slide dan blok konten dengan cache.
- `resources/views/layouts/`: `dasar` (kerangka HTML) dan `situs` (header, PPDB mengambang, footer).
- `resources/views/components/`: header, footer, banner PPDB, PPDB mengambang, foto.
- `resources/views/pages/`: view per halaman, markup disalin dari ekspor Stitch.
- `tailwind.config.js`: tema Tailwind 3 persis dari Stitch.
- `database/data/`: semua teks dan data halaman (menunggu validasi sekolah).
- `database/migrations/`: 15 tabel aplikasi.
