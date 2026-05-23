-- =============================================================
-- alter_stage_8_10.sql
-- Migrasi tambahan untuk Tahap 8 - 10 (Divisi & Program Kerja)
-- Database tetap: himsi
--
-- Cara import:
-- 1. phpMyAdmin / Adminer: pilih DB `himsi` -> tab Import -> file ini.
-- 2. CLI: mysql -u root himsi < database/alter_stage_8_10.sql
--
-- Idempotent (aman dijalankan berulang) dan kompatibel dengan
-- MySQL 8.x maupun MariaDB.
-- Tidak akan men-drop tabel apapun.
-- =============================================================

USE himsi;

-- -------------------------------------------------------------
-- Helper: tambah kolom hanya jika belum ada
-- (pakai INFORMATION_SCHEMA + prepared statement)
-- -------------------------------------------------------------

-- divisions.focus
SET @c := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'divisions' AND COLUMN_NAME = 'focus');
SET @s := IF(@c = 0,
    'ALTER TABLE divisions ADD COLUMN focus TEXT NULL AFTER description',
    'SELECT 1');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- divisions.icon
SET @c := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'divisions' AND COLUMN_NAME = 'icon');
SET @s := IF(@c = 0,
    'ALTER TABLE divisions ADD COLUMN icon VARCHAR(50) NULL AFTER focus',
    'SELECT 1');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- divisions.status
SET @c := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'divisions' AND COLUMN_NAME = 'status');
SET @s := IF(@c = 0,
    "ALTER TABLE divisions ADD COLUMN status ENUM('active','inactive') NOT NULL DEFAULT 'active' AFTER icon",
    'SELECT 1');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- divisions.updated_at
SET @c := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'divisions' AND COLUMN_NAME = 'updated_at');
SET @s := IF(@c = 0,
    'ALTER TABLE divisions ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'SELECT 1');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- programs.status
SET @c := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'programs' AND COLUMN_NAME = 'status');
SET @s := IF(@c = 0,
    "ALTER TABLE programs ADD COLUMN status ENUM('active','inactive') NOT NULL DEFAULT 'active' AFTER event_date",
    'SELECT 1');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- programs.updated_at
SET @c := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'programs' AND COLUMN_NAME = 'updated_at');
SET @s := IF(@c = 0,
    'ALTER TABLE programs ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'SELECT 1');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- -------------------------------------------------------------
-- Backfill data lama agar tetap tampil di halaman publik
-- -------------------------------------------------------------
UPDATE divisions SET status = 'active' WHERE status IS NULL OR status = '';
UPDATE programs  SET status = 'active' WHERE status IS NULL OR status = '';

-- -------------------------------------------------------------
-- Default fokus & ikon untuk divisi seed (kalau masih kosong)
-- -------------------------------------------------------------
UPDATE divisions SET focus = 'Workshop, pelatihan, dan pengembangan kompetensi anggota.', icon = 'PP'
    WHERE name = 'Pendidikan dan Pengembangan' AND (focus IS NULL OR focus = '');

UPDATE divisions SET focus = 'Publikasi, dokumentasi, media sosial, dan branding organisasi.', icon = 'KI'
    WHERE name = 'Kominfo' AND (focus IS NULL OR focus = '');

UPDATE divisions SET focus = 'Komunikasi internal kampus dan kolaborasi eksternal.', icon = 'HM'
    WHERE name = 'Hubungan Masyarakat' AND (focus IS NULL OR focus = '');

UPDATE divisions SET focus = 'Program kewirausahaan dan kegiatan produktif HIMSI.', icon = 'KW'
    WHERE name = 'Kewirausahaan' AND (focus IS NULL OR focus = '');

UPDATE divisions SET focus = 'Kompetisi, kreativitas, kebersamaan, dan minat anggota.', icon = 'MB'
    WHERE name = 'Minat dan Bakat' AND (focus IS NULL OR focus = '');
