-- ========================================
-- SQL MIGRATION: FIX E-RAPOR HARDCODED VALUES
-- Created: 2025-10-13
-- Description: Menambahkan field yang hilang dan tabel baru untuk mengatasi hardcoded values di e-rapor
-- ========================================

USE `apdate_dev`;

-- ========================================
-- 1. ALTER TABLE mt_users_siswa
-- Menambahkan field yang hilang untuk data siswa
-- ========================================
ALTER TABLE `mt_users_siswa`
ADD COLUMN `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') DEFAULT 'Laki-laki' AFTER `tanggal_lahir`,
ADD COLUMN `status_keluarga` VARCHAR(50) DEFAULT 'Anak Kandung' AFTER `jenis_kelamin`,
ADD COLUMN `anak_ke` TINYINT DEFAULT 1 AFTER `status_keluarga`,
ADD COLUMN `tanggal_diterima` DATE NULL AFTER `anak_ke`,
ADD COLUMN `kelas_diterima` VARCHAR(10) NULL AFTER `tanggal_diterima`;

-- ========================================
-- 2. CREATE TABLE mt_sekolah
-- Tabel untuk menyimpan informasi sekolah
-- ========================================
CREATE TABLE IF NOT EXISTS `mt_sekolah` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama_sekolah` VARCHAR(200) NOT NULL,
  `npsn` VARCHAR(20) NOT NULL,
  `nis` VARCHAR(50) NULL,
  `nss` VARCHAR(50) NULL,
  `nds` VARCHAR(50) NULL,
  `alamat_lengkap` TEXT NOT NULL,
  `kode_pos` VARCHAR(10) NULL,
  `telepon` VARCHAR(20) NULL,
  `kelurahan` VARCHAR(100) NULL,
  `kecamatan` VARCHAR(100) NULL,
  `kabupaten_kota` VARCHAR(100) NULL,
  `provinsi` VARCHAR(100) NULL,
  `website` VARCHAR(255) NULL,
  `email` VARCHAR(100) NULL,
  `logo_path` VARCHAR(255) DEFAULT 'assets/logo-sekolah.jpg',
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data default sekolah
INSERT INTO `mt_sekolah` (
  `nama_sekolah`, `npsn`, `nis`, `nss`, `nds`,
  `alamat_lengkap`, `kode_pos`, `telepon`,
  `kelurahan`, `kecamatan`, `kabupaten_kota`, `provinsi`,
  `website`, `email`, `is_active`
) VALUES (
  'SMP NEGERI 1 RANCABUNGUR',
  '20200659',
  '2010202343390',
  NULL,
  NULL,
  'Jalan Letkol Atang Senjaja, Desa Pasirgaok',
  '16310',
  '(0251) 8423707',
  'Pasirgaok',
  'Rancabungur',
  'Bogor',
  'Jawa Barat',
  'http://smpn1rancabungur.sch.id',
  'smpn1rancabungur@gmail.com',
  1
);

-- ========================================
-- 3. CREATE TABLE mt_kepala_sekolah
-- Tabel untuk menyimpan data kepala sekolah
-- ========================================
CREATE TABLE IF NOT EXISTS `mt_kepala_sekolah` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `periode_id` BIGINT NOT NULL,
  `nama_lengkap` VARCHAR(200) NOT NULL,
  `nip` VARCHAR(50) NOT NULL,
  `gelar_depan` VARCHAR(50) NULL,
  `gelar_belakang` VARCHAR(50) NULL,
  `tanggal_mulai` DATE NULL,
  `tanggal_selesai` DATE NULL,
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_periode` (`periode_id`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data kepala sekolah default
INSERT INTO `mt_kepala_sekolah` (
  `periode_id`, `nama_lengkap`, `nip`,
  `gelar_depan`, `gelar_belakang`,
  `tanggal_mulai`, `is_active`
) VALUES (
  1,
  'Siti Hodijah',
  '197509192008012004',
  '',
  'S.H., M.Pd.',
  '2018-07-01',
  1
);

-- ========================================
-- 4. CREATE TABLE mt_setting_rapor
-- Tabel untuk menyimpan konfigurasi rapor
-- ========================================
CREATE TABLE IF NOT EXISTS `mt_setting_rapor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `value` TEXT NULL,
  `description` VARCHAR(255) NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert setting default
INSERT INTO `mt_setting_rapor` (`code`, `value`, `description`) VALUES
('kkm_default', '72', 'Kriteria Ketuntasan Minimal Default'),
('kota_tandatangan', 'Bogor', 'Kota untuk tanda tangan di rapor'),
('tampilkan_foto_siswa', '1', 'Tampilkan foto siswa di rapor (1=Ya, 0=Tidak)');

-- ========================================
-- 5. UPDATE mt_users_siswa - Set default values untuk data existing
-- ========================================
UPDATE `mt_users_siswa`
SET
  `jenis_kelamin` = 'Laki-laki',
  `status_keluarga` = 'Anak Kandung',
  `anak_ke` = 1,
  `tanggal_diterima` = '2018-07-01',
  `kelas_diterima` = 'VII'
WHERE `jenis_kelamin` IS NULL;

-- ========================================
-- SELESAI
-- ========================================
