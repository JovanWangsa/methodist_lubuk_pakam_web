-- Hak akses minimum untuk akun database Express (mp_api).
-- Jalankan SETELAH migration pertama:  sudo mariadb methodist_lubuk_pakam_medan < deploy/sql/grant-api.sql

-- Baca konten publik
GRANT SELECT ON methodist_lubuk_pakam_medan.units TO 'mp_api'@'localhost';
GRANT SELECT ON methodist_lubuk_pakam_medan.settings TO 'mp_api'@'localhost';

-- Tulis data PPDB (Sprint 3)
GRANT SELECT, INSERT, UPDATE ON methodist_lubuk_pakam_medan.ppdb_pendaftar TO 'mp_api'@'localhost';
GRANT SELECT, INSERT, UPDATE ON methodist_lubuk_pakam_medan.ppdb_orang_tua TO 'mp_api'@'localhost';
GRANT SELECT, INSERT, UPDATE ON methodist_lubuk_pakam_medan.ppdb_dokumen TO 'mp_api'@'localhost';

-- Sinkronisasi Instagram (Sprint 4)
GRANT SELECT, INSERT, UPDATE, DELETE ON methodist_lubuk_pakam_medan.instagram_posts TO 'mp_api'@'localhost';
GRANT SELECT, INSERT, UPDATE ON methodist_lubuk_pakam_medan.instagram_token TO 'mp_api'@'localhost';

FLUSH PRIVILEGES;
