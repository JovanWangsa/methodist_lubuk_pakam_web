# Deploy ke VPS

Panduan ini dipakai di Sprint 1 (hari Kamis sampai Sabtu). Semua perintah dijalankan di VPS Ubuntu Server 24.04 LTS.

## 1. Siapkan server (sekali saja, sebagai root)

1. Dari laptop, salin public key SSH ke server: `ssh-copy-id root@IP_VPS`.
2. Upload skrip lalu jalankan:

   ```bash
   scp deploy/setup-vps.sh root@IP_VPS:/root/
   ssh root@IP_VPS "bash /root/setup-vps.sh"
   ```

3. Simpan isi `/root/methodist_lubuk_pakam_kredensial.txt` (password database `mp_web` dan `mp_api`) di tempat aman, lalu hapus file tersebut dari server.
4. Sejak langkah ini, login memakai `ssh deploy@IP_VPS`.

## 2. Arahkan domain

Di pengelola DNS domain sekolah, buat record:

- `A  methodistpakam.sch.id      -> IP_VPS`
- `A  www.methodistpakam.sch.id  -> IP_VPS`
- `A  api.methodistpakam.sch.id  -> IP_VPS`

Cek dengan `dig +short methodistpakam.sch.id` sampai muncul IP VPS.

## 3. Clone repository dan isi .env (sebagai deploy)

```bash
cd /var/www
git clone git@github.com:NAMA_ORG/methodist_lubuk_pakam_web.git
cd methodist_lubuk_pakam_web

cp web/.env.example web/.env
nano web/.env   # APP_ENV=production, APP_DEBUG=false, APP_URL=https://methodistpakam.sch.id,
                # DB_USERNAME=mp_web, DB_PASSWORD=..., API_URL=https://api.methodistpakam.sch.id,
                # ADMIN_PASSWORD=... (password kuat)
cd web && composer install --no-dev --optimize-autoloader && php artisan key:generate && cd ..

cp api/.env.example api/.env
nano api/.env   # NODE_ENV=production, DB_USERNAME=mp_api, DB_PASSWORD=...,
                # CORS_ORIGINS=https://methodistpakam.sch.id,https://www.methodistpakam.sch.id
```

Server perlu deploy key agar bisa `git clone`: buat dengan `ssh-keygen -t ed25519` sebagai user deploy, lalu tambahkan isi `~/.ssh/id_ed25519.pub` di GitHub (Settings repository, Deploy keys, read-only).

## 4. Deploy pertama

```bash
bash deploy/deploy.sh
cd web && php artisan db:seed --force && cd ..         # data awal, sekali saja
sudo mariadb methodist_lubuk_pakam_medan < deploy/sql/grant-api.sql # hak akses akun API (perlu sudo/root)
pm2 restart api
```

## 5. Nginx dan SSL (sebagai root)

```bash
cp deploy/nginx/methodistpakam.sch.id.conf /etc/nginx/sites-available/
cp deploy/nginx/api.methodistpakam.sch.id.conf /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/methodistpakam.sch.id.conf /etc/nginx/sites-enabled/
ln -s /etc/nginx/sites-available/api.methodistpakam.sch.id.conf /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

certbot --nginx -d methodistpakam.sch.id -d www.methodistpakam.sch.id -d api.methodistpakam.sch.id --redirect
```

Certbot memperpanjang sertifikat otomatis. Cek dengan `certbot renew --dry-run`.

## 6. Cek hasil

- `https://methodistpakam.sch.id` menampilkan Halaman 1.
- `https://methodistpakam.sch.id/up` mengembalikan status 200 (health check Laravel).
- `https://api.methodistpakam.sch.id/api/v1/health` mengembalikan `"database": "terhubung"`.
- `pm2 status` menampilkan proses `api` berstatus online.

## Deploy berikutnya

Setiap ada perubahan di branch `main`: `ssh deploy@IP_VPS "bash /var/www/methodist_lubuk_pakam_web/deploy/deploy.sh"`.
Di Sprint 4 perintah ini dijalankan otomatis oleh GitHub Actions.
