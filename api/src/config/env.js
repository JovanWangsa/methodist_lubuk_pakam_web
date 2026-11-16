'use strict';

require('dotenv').config({ quiet: true });

/** Konfigurasi dibaca sekali dari .env agar mudah diuji dan tidak tersebar di banyak file. */
const env = {
  nodeEnv: process.env.NODE_ENV || 'development',
  port: Number(process.env.PORT || 3000),
  corsOrigins: (process.env.CORS_ORIGINS || 'http://localhost:8000')
    .split(',')
    .map((origin) => origin.trim())
    .filter(Boolean),
  db: {
    host: process.env.DB_HOST || '127.0.0.1',
    port: Number(process.env.DB_PORT || 3306),
    database: process.env.DB_DATABASE || 'methodist_lubuk_pakam_medan',
    user: process.env.DB_USERNAME || 'root',
    password: process.env.DB_PASSWORD || '',
  },
};

module.exports = env;
