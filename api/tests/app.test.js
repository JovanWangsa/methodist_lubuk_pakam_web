'use strict';

const request = require('supertest');
const { createApp } = require('../src/app');

const UNITS = [
  { kode: 'tk', nama: 'TK Methodist Lubuk Pakam', deskripsi_singkat: null, gambar: null },
  { kode: 'sd', nama: 'SD Methodist Lubuk Pakam', deskripsi_singkat: null, gambar: null },
];

/** Database tiruan: mencatat query yang dijalankan dan mengembalikan data contoh. */
function dbTiruan({ gagal = false } = {}) {
  const panggilan = [];
  return {
    panggilan,
    async query(sql, params = []) {
      panggilan.push({ sql, params });
      if (gagal) throw new Error('koneksi ditolak');
      if (sql.startsWith('SELECT 1')) return [[{ 1: 1 }]];
      if (sql.includes('WHERE kode = ?')) return [UNITS.filter((u) => u.kode === params[0])];
      return [UNITS];
    },
  };
}

describe('GET /api/v1/health', () => {
  test('200 dan database terhubung', async () => {
    const res = await request(createApp({ db: dbTiruan() })).get('/api/v1/health');
    expect(res.status).toBe(200);
    expect(res.body).toMatchObject({ status: 'ok', database: 'terhubung' });
  });

  test('503 bila database gagal', async () => {
    const res = await request(createApp({ db: dbTiruan({ gagal: true }) })).get('/api/v1/health');
    expect(res.status).toBe(503);
    expect(res.body.database).toBe('gagal');
  });

  test('header keamanan dari helmet terpasang', async () => {
    const res = await request(createApp({ db: dbTiruan() })).get('/api/v1/health');
    expect(res.headers['x-content-type-options']).toBe('nosniff');
    expect(res.headers['x-powered-by']).toBeUndefined();
  });
});

describe('GET /api/v1/units', () => {
  test('mengembalikan daftar unit', async () => {
    const res = await request(createApp({ db: dbTiruan() })).get('/api/v1/units');
    expect(res.status).toBe(200);
    expect(res.body.data).toHaveLength(2);
  });

  test('detail unit memakai query dengan placeholder', async () => {
    const db = dbTiruan();
    const res = await request(createApp({ db })).get('/api/v1/units/SD');
    expect(res.status).toBe(200);
    expect(res.body.data.kode).toBe('sd');
    expect(db.panggilan.at(-1).params).toEqual(['sd']);
  });

  test('kode unit di luar tk/sd/smp/sma ditolak tanpa query', async () => {
    const db = dbTiruan();
    const res = await request(createApp({ db })).get("/api/v1/units/x' OR '1'='1");
    expect(res.status).toBe(404);
    expect(db.panggilan).toHaveLength(0);
  });

  test('500 dengan pesan umum bila database error', async () => {
    const res = await request(createApp({ db: dbTiruan({ gagal: true }) })).get('/api/v1/units');
    expect(res.status).toBe(500);
    expect(res.body.message).toBe('Terjadi kesalahan pada server.');
  });
});

describe('CORS dan rute tidak dikenal', () => {
  test('origin sekolah diizinkan', async () => {
    const app = createApp({ db: dbTiruan(), corsOrigins: ['https://methodistpakam.sch.id'] });
    const res = await request(app).get('/api/v1/health').set('Origin', 'https://methodistpakam.sch.id');
    expect(res.headers['access-control-allow-origin']).toBe('https://methodistpakam.sch.id');
  });

  test('origin lain tidak diberi izin CORS', async () => {
    const app = createApp({ db: dbTiruan(), corsOrigins: ['https://methodistpakam.sch.id'] });
    const res = await request(app).get('/api/v1/health').set('Origin', 'https://situs-lain.com');
    expect(res.headers['access-control-allow-origin']).toBeUndefined();
  });

  test('404 untuk endpoint yang tidak ada', async () => {
    const res = await request(createApp({ db: dbTiruan() })).get('/api/v1/tidak-ada');
    expect(res.status).toBe(404);
  });
});
