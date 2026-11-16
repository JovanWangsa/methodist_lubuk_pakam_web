#!/usr/bin/env bash
# Deploy versi terbaru branch main ke VPS. Jalankan sebagai user deploy:
#   bash /var/www/methodist_lubuk_pakam_web/deploy/deploy.sh
set -euo pipefail

APP_DIR="/var/www/methodist_lubuk_pakam_web"
cd "$APP_DIR"

echo "==> Ambil kode terbaru"
git fetch origin main
git reset --hard origin/main

echo "==> Laravel"
cd "$APP_DIR/web"
composer install --no-dev --optimize-autoloader --no-interaction --no-progress
npm ci --no-audit --no-fund
npm run build
php artisan migrate --force
[ -L public/storage ] || php artisan storage:link
php artisan optimize
chmod -R ug+rw storage bootstrap/cache

echo "==> Express"
cd "$APP_DIR/api"
npm ci --omit=dev --no-audit --no-fund
pm2 startOrReload ecosystem.config.cjs --update-env
pm2 save

echo "==> Bersihkan OPcache"
sudo /usr/bin/systemctl reload php8.4-fpm

echo "Deploy selesai: $(git -C "$APP_DIR" log -1 --pretty='%h %s')"
