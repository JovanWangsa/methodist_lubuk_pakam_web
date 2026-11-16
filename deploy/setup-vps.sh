#!/usr/bin/env bash
# Menyiapkan VPS Ubuntu Server 24.04 LTS untuk website Sekolah Methodist Lubuk Pakam.
# Jalankan SEKALI sebagai root:  sudo bash setup-vps.sh
# Isi: user deploy, firewall, fail2ban, Nginx, PHP 8.4-FPM, Composer, MariaDB, Node.js 26 + PM2, Certbot.
set -euo pipefail

DEPLOY_USER="deploy"
APP_DIR="/var/www/methodist_lubuk_pakam_web"
DB_NAME="methodist_lubuk_pakam_medan"
CRED_FILE="/root/methodist_lubuk_pakam_kredensial.txt"

echo "==> 1. Update sistem dan paket dasar"
apt-get update
DEBIAN_FRONTEND=noninteractive apt-get upgrade -y
apt-get install -y curl git unzip ufw fail2ban software-properties-common ca-certificates openssl

echo "==> 2. User deploy (login dengan SSH key, bukan password)"
if ! id "$DEPLOY_USER" >/dev/null 2>&1; then
    adduser --disabled-password --gecos "" "$DEPLOY_USER"
fi
mkdir -p /home/$DEPLOY_USER/.ssh
if [ -f /root/.ssh/authorized_keys ] && [ ! -s /home/$DEPLOY_USER/.ssh/authorized_keys ]; then
    cp /root/.ssh/authorized_keys /home/$DEPLOY_USER/.ssh/authorized_keys
fi
chmod 700 /home/$DEPLOY_USER/.ssh
chmod 600 /home/$DEPLOY_USER/.ssh/authorized_keys 2>/dev/null || true
chown -R $DEPLOY_USER:$DEPLOY_USER /home/$DEPLOY_USER/.ssh
usermod -aG www-data "$DEPLOY_USER"

if [ -s /home/$DEPLOY_USER/.ssh/authorized_keys ]; then
    echo "    SSH key ditemukan: login root dan login password dimatikan."
    sed -i 's/^#\?PasswordAuthentication .*/PasswordAuthentication no/' /etc/ssh/sshd_config
    sed -i 's/^#\?PermitRootLogin .*/PermitRootLogin no/' /etc/ssh/sshd_config
    systemctl reload ssh
else
    echo "    PERINGATAN: belum ada SSH key untuk user $DEPLOY_USER. Login password TIDAK dimatikan."
    echo "    Tambahkan public key ke /home/$DEPLOY_USER/.ssh/authorized_keys lalu jalankan ulang skrip ini."
fi

echo "==> 3. Firewall (SSH, HTTP, HTTPS) dan fail2ban"
ufw allow OpenSSH
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable
systemctl enable --now fail2ban

echo "==> 4. Nginx dan PHP 8.4-FPM"
add-apt-repository -y ppa:ondrej/php
apt-get update
apt-get install -y nginx php8.4-fpm php8.4-cli php8.4-mysql php8.4-mbstring php8.4-xml \
    php8.4-curl php8.4-zip php8.4-gd php8.4-intl php8.4-bcmath php8.4-opcache
sed -i 's/^;\?opcache.enable=.*/opcache.enable=1/' /etc/php/8.4/fpm/php.ini
sed -i 's/^;\?upload_max_filesize = .*/upload_max_filesize = 10M/' /etc/php/8.4/fpm/php.ini
sed -i 's/^;\?post_max_size = .*/post_max_size = 12M/' /etc/php/8.4/fpm/php.ini
systemctl restart php8.4-fpm

echo "==> 5. Composer"
if ! command -v composer >/dev/null; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

echo "==> 6. MariaDB (sama jenisnya dengan MySQL di XAMPP)"
apt-get install -y mariadb-server
systemctl enable --now mariadb
if [ ! -f "$CRED_FILE" ]; then
    WEB_PASS=$(openssl rand -base64 24 | tr -d '/+=')
    API_PASS=$(openssl rand -base64 24 | tr -d '/+=')
    mariadb <<SQL
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'mp_web'@'localhost' IDENTIFIED BY '$WEB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO 'mp_web'@'localhost';
CREATE USER IF NOT EXISTS 'mp_api'@'localhost' IDENTIFIED BY '$API_PASS';
FLUSH PRIVILEGES;
SQL
    umask 077
    printf 'DB web (Laravel): mp_web / %s\nDB api (Express): mp_api / %s\n' "$WEB_PASS" "$API_PASS" > "$CRED_FILE"
    echo "    Kredensial database disimpan di $CRED_FILE (hanya bisa dibaca root)."
fi

echo "==> 7. Node.js 26 dan PM2"
if ! command -v node >/dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_26.x | bash -
    apt-get install -y nodejs
fi
npm install -g pm2
env PATH="$PATH:/usr/bin" pm2 startup systemd -u "$DEPLOY_USER" --hp "/home/$DEPLOY_USER"

echo "==> 8. Certbot untuk SSL Let's Encrypt"
apt-get install -y certbot python3-certbot-nginx

echo "==> 9. Folder aplikasi"
mkdir -p "$APP_DIR"
chown -R $DEPLOY_USER:www-data "$APP_DIR"

# Izinkan user deploy me-reload PHP-FPM (membersihkan OPcache) tanpa password.
echo "$DEPLOY_USER ALL=(root) NOPASSWD: /usr/bin/systemctl reload php8.4-fpm" > /etc/sudoers.d/deploy-php
chmod 440 /etc/sudoers.d/deploy-php

echo
echo "Selesai. Langkah berikutnya ada di deploy/README.md (clone repository, .env, Nginx, SSL)."
