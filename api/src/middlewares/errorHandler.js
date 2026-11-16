'use strict';

/** Rute yang tidak dikenal. */
function notFound(req, res) {
  res.status(404).json({ message: 'Endpoint tidak ditemukan.' });
}

/** Penanganan error terakhir: detail error hanya dicatat di log, tidak dikirim ke pengguna. */
// eslint-disable-next-line no-unused-vars
function errorHandler(err, req, res, next) {
  if (process.env.NODE_ENV !== 'test') {
    console.error(err);
  }

  res.status(err.status || 500).json({ message: 'Terjadi kesalahan pada server.' });
}

module.exports = { notFound, errorHandler };
