'use strict';

const express = require('express');
const helmet = require('helmet');
const cors = require('cors');
const { rateLimit } = require('express-rate-limit');
const env = require('./config/env');
const healthRouter = require('./routes/health');
const unitsRouter = require('./routes/units');
const { notFound, errorHandler } = require('./middlewares/errorHandler');

/**
 * Membuat aplikasi Express. Database diberikan dari luar (dependency injection)
 * agar tes bisa memakai database tiruan tanpa MySQL.
 */
function createApp({ db, corsOrigins = env.corsOrigins } = {}) {
  if (!db) {
    throw new Error('createApp membutuhkan koneksi database (db).');
  }

  const app = express();

  app.disable('x-powered-by');
  app.set('trust proxy', 1); // berjalan di belakang Nginx
  app.use(helmet());
  app.use(cors({ origin: corsOrigins, methods: ['GET', 'POST', 'PUT'] }));
  app.use(express.json({ limit: '100kb' }));

  const v1 = express.Router();
  v1.use(rateLimit({ windowMs: 60 * 1000, limit: 120, standardHeaders: 'draft-8', legacyHeaders: false }));
  v1.use('/health', healthRouter({ db }));
  v1.use('/units', unitsRouter({ db }));
  // Sprint 3: v1.use('/ppdb', ppdbRouter({ db }));
  // Sprint 4: v1.use('/instagram', instagramRouter({ db }));

  app.use('/api/v1', v1);
  app.use(notFound);
  app.use(errorHandler);

  return app;
}

module.exports = { createApp };
