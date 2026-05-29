-- Migration: Add gallery and members tables for divisions
-- Run this after the initial himsi.sql
-- File: database/migration_divisi_gallery.sql

USE himsi;

-- Tabel gallery kegiatan divisi
CREATE TABLE IF NOT EXISTS division_galleries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    division_id INT NOT NULL,
    title VARCHAR(200) DEFAULT '',
    image VARCHAR(255) NOT NULL,
    caption TEXT,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (division_id) REFERENCES divisions(id) ON DELETE CASCADE
);

-- Tabel anggota divisi
CREATE TABLE IF NOT EXISTS division_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    division_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    position VARCHAR(100) DEFAULT '',
    photo VARCHAR(255) DEFAULT '',
    is_leader TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (division_id) REFERENCES divisions(id) ON DELETE CASCADE
);

-- Tambah kolom ke divisions
ALTER TABLE divisions ADD COLUMN cover_image VARCHAR(255) DEFAULT '';
ALTER TABLE divisions ADD COLUMN tagline VARCHAR(255) DEFAULT '';

-- Update divisions dengan cover dan tagline
UPDATE divisions SET cover_image = '', tagline = 'Pusat informasi dan publikasi digital' WHERE id = 2;
UPDATE divisions SET cover_image = '', tagline = 'Pengembangan SDM & pelatihan' WHERE id = 1;
UPDATE divisions SET cover_image = '', tagline = 'Jalin komunikasi & kolaborasi' WHERE id = 3;
UPDATE divisions SET cover_image = '', tagline = 'Wirausaha & produk kreatif' WHERE id = 4;
UPDATE divisions SET cover_image = '', tagline = 'Ekstrakurikuler & kompetisi' WHERE id = 5;
