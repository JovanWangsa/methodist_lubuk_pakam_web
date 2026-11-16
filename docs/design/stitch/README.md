# Ekspor desain Google Stitch

Simpan hasil ekspor Stitch di folder ini. Untuk setiap layar, simpan file HTML dan PNG-nya dengan nama sesuai nomor halaman, plus satu file `DESIGN.md` untuk seluruh proyek.

## Cara ekspor

1. Buka proyek di Stitch, pilih satu layar.
2. Klik ikon kode (`< >`), unduh HTML-nya. Unduh juga gambar PNG layar tersebut.
3. Ulangi untuk semua layar, atau gunakan opsi ekspor ZIP bila tersedia.

## Penamaan file

| File | Halaman |
| --- | --- |
| `hal-01-home-pembuka.html` | 1. Home pembuka |
| `hal-02-homepage.html` | 2. Homepage |
| `hal-03-sejarah.html` | 3. Sejarah |
| `hal-04-unit-pendidikan.html` | 4. Induk Unit Pendidikan |
| `hal-05-tk-gerbang.html` | 5. TK (gerbang unit) |
| `hal-06-tk-home.html` | 6. Home unit TK |
| `hal-07-tk-profil.html` | 7. Profil unit TK |
| `hal-08-tk-informasi.html` | 8. Informasi unit TK |
| `hal-09-tk-ppdb.html` | 9. PPDB unit TK |
| `hal-10` sampai `hal-14` | SD (gerbang, home, profil, informasi, PPDB) |
| `hal-15` sampai `hal-19` | SMP (gerbang, home, profil, informasi, PPDB) |
| `hal-20` sampai `hal-25` | SMA (gerbang, home, profil, informasi, alumni, PPDB) |
| `hal-26-elearning-login.html` | 26. Login E-Learning |
| `hal-27-ppdb-siswa.html` | 27. Formulir PPDB: informasi siswa |
| `hal-28-ppdb-orang-tua.html` | 28. Formulir PPDB: informasi orang tua |
| `hal-29-ppdb-dokumen.html` | 29. Formulir PPDB: lampiran dokumen |

Karena halaman unit memakai satu template, cukup ekspor layar untuk satu unit (misalnya TK) bila desain keempat unit sama, ditambah layar Alumni SMA.

## Cara memindahkan desain ke kode

1. Salin nilai `colors`, `fontFamily`, dan `borderRadius` dari blok `tailwind.config` di HTML Stitch ke `@theme` di `web/resources/css/app.css`. Pertahankan nama token `primer`, `aksen`, dan `kartu` agar class di view tidak perlu diubah.
2. Hapus `<script src="https://cdn.tailwindcss.com">` dari HTML Stitch; Tailwind sudah di-build lewat Vite.
3. Pindahkan potongan HTML per bagian ke view Blade yang sesuai, lalu ganti teks yang ditulis langsung dengan data dari database (`$slides`, `$pengaturan`, dan seterusnya).
