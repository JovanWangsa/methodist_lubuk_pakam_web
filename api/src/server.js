'use strict';

const env = require('./config/env');
const { createPool } = require('./config/db');
const { createApp } = require('./app');

const db = createPool();
const app = createApp({ db });

const PETUNJUK_DB = {
  ER_BAD_DB_ERROR: 'Database belum ada. Samakan DB_DATABASE di api/.env dengan nama database di phpMyAdmin.',
  ECONNREFUSED: 'MySQL belum menyala. Klik Start pada MySQL di XAMPP Control Panel atau cek DB_HOST dan DB_PORT.',
  ER_ACCESS_DENIED_ERROR: 'Username atau Password salah. Cek DB_USERNAME dan DB_PASSWORD di api/.env.',
  ER_NO_SUCH_TABLE: 'Tabel belum dibuat. Jalankan "php artisan migrate --seed" di folder web.',
};

async function cekDatabase() {
  try {
    await db.query('SELECT 1 FROM units LIMIT 1');
    console.log(`Database "${env.db.database}" di ${env.db.host}:${env.db.port} terhubung.`);
  } catch (err) {
    console.error(`Database "${env.db.database}" di ${env.db.host}:${env.db.port} GAGAL: ${err.code || ''} ${err.message}`);
    if (PETUNJUK_DB[err.code]) {
      console.error(`Petunjuk: ${PETUNJUK_DB[err.code]}`);
    }
  }
}

const server = app.listen(env.port, '127.0.0.1', () => {
  console.log(`API berjalan di http://127.0.0.1:${env.port}/api/v1 (${env.nodeEnv})`);
  cekDatabase();
  }
);

// Tutup koneksi dengan rapi saat PM2 me-restart layanan.
function berhenti() {
  server.close(async () => {
    await db.end();
    process.exit(0);
  });
}

process.on('SIGTERM', berhenti);
process.on('SIGINT', berhenti);
