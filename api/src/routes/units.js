'use strict';

const { Router } = require('express');

const KODE_UNIT = ['tk', 'sd', 'smp', 'sma'];

/** GET /api/v1/units dan /api/v1/units/:kode: data unit pendidikan (hanya baca). */
module.exports = function unitsRouter({ db }) {
  const router = Router();

  router.get('/', async (req, res, next) => {
    try {
      const [rows] = await db.query(
        'SELECT kode, nama, deskripsi_singkat, gambar FROM units ORDER BY urutan',
      );
      res.json({ data: rows });
    } catch (err) {
      next(err);
    }
  });

  router.get('/:kode', async (req, res, next) => {
    const kode = String(req.params.kode).toLowerCase();

    if (!KODE_UNIT.includes(kode)) {
      return res.status(404).json({ message: 'Unit tidak ditemukan.' });
    }

    try {
      const [rows] = await db.query(
        'SELECT kode, nama, deskripsi_singkat, gambar, npsn, akreditasi, alamat FROM units WHERE kode = ? LIMIT 1',
        [kode],
      );

      if (rows.length === 0) {
        return res.status(404).json({ message: 'Unit tidak ditemukan.' });
      }

      return res.json({ data: rows[0] });
    } catch (err) {
      return next(err);
    }
  });

  return router;
};
