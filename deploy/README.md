# Deploy ke hosting cPanel (tanpa Terminal)

Hosting sekolah hanya menjalankan PHP dan MySQL, tanpa Node.js dan tanpa Terminal/SSH. Karena itu:

- `composer install` dijalankan di laptop, lalu folder `vendor` ikut diunggah.
- Database pertama kali diisi dengan **ekspor dari phpMyAdmin laptop**, lalu diimpor di phpMyAdmin hosting.
- Perintah `php artisan` yang sesekali dibutuhkan di server dijalankan lewat **Cron Jobs** cPanel (langkah 8).

Susunan folder di hosting (ganti `namaakun` dengan nama akun cPanel):

```
/home/namaakun/
├── methodist_lubuk_pakam_web/   ← isi folder web/ (kode, vendor, storage, .env). TIDAK bisa dibuka dari browser.
└── public_html/                 ← isi folder web/public/ + index.php dan .htaccess dari deploy/public_html/
```

## 1. Atur PHP di cPanel

1. Buka **MultiPHP Manager** (atau **Select PHP Version**), pilih domain `methodistpakam.sch.id`, lalu pilih **PHP 8.3** atau lebih baru.
2. Pastikan ekstensi ini aktif: `pdo_mysql`, `mbstring`, `intl`, `fileinfo`, `openssl`, `tokenizer`, `xml`, `ctype`, `curl`, `bcmath`, `gd`, `zip`.

## 2. Buat database

1. **MySQL Databases** → buat database, misalnya `methodist` (cPanel menjadikannya `namaakun_methodist`).
2. Buat user, misalnya `web`, dengan password kuat (gunakan Password Generator). Simpan password-nya.
3. **Add User To Database** → pilih user dan database tadi → centang **ALL PRIVILEGES**.

## 3. Ekspor database dari laptop

1. Di laptop, buka `web/.env` dan isi `ADMIN_PASSWORD` dengan password kuat. Akun admin ini ikut terbawa ke hosting.
2. Isi ulang database lokal: `php artisan migrate:fresh --seed` di folder `web`.
3. Buka phpMyAdmin laptop (http://localhost/phpmyadmin) → pilih `methodist_lubuk_pakam_medan` → tab **Export** → Quick, format SQL → **Export**. Hasilnya file `methodist_lubuk_pakam_medan.sql`.

## 4. Impor database di hosting

1. cPanel → **phpMyAdmin** → pilih `namaakun_methodist` di kiri.
2. Tab **Import** → pilih file `.sql` tadi → **Import**. Harus muncul pesan berhasil dan daftar tabel (users, settings, units, slides, konten_blok, dan lainnya).

## 5. Siapkan paket unggahan di laptop

Lakukan di salinan terpisah supaya folder kerja Anda tidak berubah.

1. Salin folder `web` ke tempat lain, misalnya `C:\Skripsi\rilis\methodist_lubuk_pakam_web`.
2. Di folder salinan itu jalankan:
   ```
   composer install --no-dev --optimize-autoloader
   ```
3. Hapus dari salinan: file `.env`, folder `tests`, dan isi `storage/logs` (kecuali `.gitignore`).
4. Klik kanan folder `methodist_lubuk_pakam_web` salinan → **Compress to ZIP file**.

## 6. Unggah dan pasang

1. cPanel → **File Manager** → **Settings** (kanan atas) → centang **Show Hidden Files (dotfiles)** → Save.
2. Buka folder `/home/namaakun` (bukan public_html) → **Upload** ZIP tadi → klik kanan → **Extract**. Hasilnya folder `/home/namaakun/methodist_lubuk_pakam_web`.
3. Buka `methodist_lubuk_pakam_web/public`, pilih semua isinya (`css`, `js`, `fonts`, `images`, `favicon.ico`, `robots.txt`, dan lainnya) → **Copy** ke `/home/namaakun/public_html`.
   Bila `public_html` sudah berisi file lama (misalnya `index.html` bawaan hosting), pindahkan dulu ke folder cadangan.
4. Unggah `deploy/public_html/index.php` dan `deploy/public_html/.htaccess` dari repo ke `public_html`, timpa yang ada.
   Bila nama folder aplikasi bukan `methodist_lubuk_pakam_web`, ubah baris `$aplikasi` di `index.php`.
5. Di `methodist_lubuk_pakam_web`, buat file `.env` dari isi `deploy/env.hosting.example`, lalu isi:
   - `APP_KEY`: salin dari `web/.env` laptop.
   - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: dari langkah 2.
6. Pastikan folder `storage` dan `bootstrap/cache` bisa ditulis: klik kanan → **Change Permissions** → `755` (centang "Recurse into subdirectories" untuk `storage`).

## 7. SSL dan cek hasil

1. cPanel → **SSL/TLS Status** → **Run AutoSSL**, tunggu sampai domain bergembok hijau.
2. Buka:
   - https://methodistpakam.sch.id → Halaman 1 (pembuka)
   - https://methodistpakam.sch.id/beranda dan /sejarah
   - https://methodistpakam.sch.id/api/v1/health → harus `"status":"ok"` dan `"database":"terhubung"`
3. Bila muncul **500 Server Error**, buka `methodist_lubuk_pakam_web/storage/logs/` dan baca file log terbaru. Penyebab tersering: `APP_KEY` kosong, data database di `.env` salah, atau versi PHP di bawah 8.3.

Panel admin ada di https://methodistpakam.sch.id/admin. Masuk dengan `ADMIN_EMAIL` dan `ADMIN_PASSWORD` yang dipakai saat langkah 3, lalu segera ganti password. Agar fitur lupa password mengirim email, isi `MAIL_MAILER=smtp` dan `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS` di `.env` hosting dengan akun email dari cPanel > Email Accounts.

## 8. Menjalankan perintah artisan tanpa Terminal (Cron Jobs)

Cari dulu alamat PHP 8.3 di hosting. Biasanya `/opt/cpanel/ea-php83/root/usr/bin/php`; bila tidak ada, coba `/usr/local/bin/php`.

Untuk menjalankan satu perintah, misalnya migration baru di sprint berikutnya:

1. cPanel → **Cron Jobs** → Common Settings: **Once Per Minute**.
2. Command:
   ```
   cd /home/namaakun/methodist_lubuk_pakam_web && /opt/cpanel/ea-php83/root/usr/bin/php artisan migrate --force >> storage/logs/cron.log 2>&1
   ```
3. Tunggu 1–2 menit, buka `storage/logs/cron.log` untuk melihat hasilnya, lalu **hapus** cron tersebut.

Perintah lain yang bisa dijalankan dengan cara yang sama: `php artisan db:seed --force`, `php artisan cache:clear`, `php artisan storage:link`.

Mulai Sprint 4 (sinkronisasi Instagram), satu cron dibiarkan permanen setiap menit:
```
/opt/cpanel/ea-php83/root/usr/bin/php /home/namaakun/methodist_lubuk_pakam_web/artisan schedule:run >> /dev/null 2>&1
```

## 9. Memperbarui website

| Yang berubah | Yang diunggah |
| --- | --- |
| View, controller, config, route | File yang berubah di `methodist_lubuk_pakam_web/` |
| CSS (`public/css/situs.css`, `admin.css`), JS, font | File yang berubah di `public_html/` |
| Package Composer baru | Folder `vendor` hasil `composer install --no-dev` (langkah 5) |
| Migration baru | File migration, lalu jalankan `migrate --force` lewat Cron (langkah 8) |
| Teks di `database/data/` | File JSON, lalu jalankan `db:seed --force` lewat Cron |

Foto dan PDF yang diunggah lewat admin tersimpan di `public_html/unggahan/`. Jangan menimpa atau menghapus folder ini saat memperbarui website, dan sertakan dalam backup.

Setelah mengubah data langsung di phpMyAdmin hosting, kosongkan cache dengan menghapus isi folder `storage/framework/cache/data` (atau jalankan `cache:clear` lewat Cron).
