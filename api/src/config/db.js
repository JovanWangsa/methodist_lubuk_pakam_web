'use strict';

const mysql = require('mysql2/promise');
const env = require('./env');

/**
 * Pool koneksi MySQL. Semua query wajib memakai placeholder (?) sehingga
 * nilai dari pengguna tidak pernah digabung langsung ke teks SQL.
 */
function createPool() {
  return mysql.createPool({
    ...env.db,
    waitForConnections: true,
    connectionLimit: 10,
    timezone: '+07:00',
    dateStrings: true,
  });
}

module.exports = { createPool };
