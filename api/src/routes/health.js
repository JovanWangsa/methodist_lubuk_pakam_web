'use strict';

const { Router } = require('express');

/** GET /api/v1/health: memastikan layanan hidup dan database bisa dihubungi. */
module.exports = function healthRouter({ db }) {
  const router = Router();

  router.get('/', async (req, res) => {
    const mulai = Date.now();
    let database = 'terhubung';

    try {
      await db.query('SELECT 1');
    } catch (err) {
      database = 'gagal';
      if (process.env.NODE_ENV !== 'test') {
        console.error(`[health] Database gagal: ${err.code || ''} ${err.message}`);
      }
    }

    res.status(database === 'terhubung' ? 200 : 503).json({
      status: database === 'terhubung' ? 'ok' : 'gangguan',
      layanan: 'methodist_lubuk_pakam_api',
      database,
      waktu_ms: Date.now() - mulai,
      timestamp: new Date().toISOString(),
    });
  });

  return router;
};
