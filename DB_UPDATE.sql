-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for apdate
CREATE DATABASE IF NOT EXISTS `apdate` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `apdate`;

-- Dumping structure for table apdate.mt_grading
CREATE TABLE IF NOT EXISTS `mt_grading` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `grade` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_min` int NOT NULL,
  `nilai_max` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_grading: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_grading` DISABLE KEYS */;
INSERT INTO `mt_grading` (`id`, `grade`, `keterangan`, `nilai_min`, `nilai_max`) VALUES
	(1, 'A', 'Siswa mampu melakukan tugasnya secara tepat dan komperensif', 81, 100),
	(2, 'B', 'Siswa mampu melakukan tugasnya secara tepat', 61, 80),
	(3, 'C', 'Siswa mampu melakukan tugasnya tetapi kurang tepat', 41, 60),
	(4, 'D', 'Siswa tidak tepat dalam melakukan tugasnya', 21, 40),
	(5, 'E', 'Siswa tidak melakukan tugasnya', 0, 20);
/*!40000 ALTER TABLE `mt_grading` ENABLE KEYS */;

-- Dumping structure for table apdate.mt_mata_pelajaran
CREATE TABLE IF NOT EXISTS `mt_mata_pelajaran` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_mata_pelajaran: ~6 rows (approximately)
/*!40000 ALTER TABLE `mt_mata_pelajaran` DISABLE KEYS */;
INSERT INTO `mt_mata_pelajaran` (`id`, `code`, `name`, `is_active`, `deleted_at`) VALUES
	(1, 'IND07', 'Bahasa Indonesia', '1', NULL),
	(2, 'ENG07', 'Bahasa Inggris', '1', NULL),
	(3, 'MTK07', 'Matematika', '1', NULL),
	(4, 'MTK08', 'Matematika', '1', NULL),
	(5, 'IND09', 'Bahasa Indonesia', '1', NULL),
	(6, 'IND08', 'Bahasa Indonesia', '1', NULL);
/*!40000 ALTER TABLE `mt_mata_pelajaran` ENABLE KEYS */;

-- Dumping structure for table apdate.mt_periode
CREATE TABLE IF NOT EXISTS `mt_periode` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `is_active` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_periode: ~0 rows (approximately)
/*!40000 ALTER TABLE `mt_periode` DISABLE KEYS */;
INSERT INTO `mt_periode` (`id`, `tahun_ajaran`, `is_active`, `deleted_at`) VALUES
	(1, '2025/2026', '1', NULL);
/*!40000 ALTER TABLE `mt_periode` ENABLE KEYS */;

-- Dumping structure for table apdate.mt_periode_semester
CREATE TABLE IF NOT EXISTS `mt_periode_semester` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `periode_id` bigint NOT NULL,
  `semester` tinyint NOT NULL,
  `is_active` tinyint NOT NULL,
  `is_close` tinyint NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_periode_semester: ~2 rows (approximately)
/*!40000 ALTER TABLE `mt_periode_semester` DISABLE KEYS */;
INSERT INTO `mt_periode_semester` (`id`, `periode_id`, `semester`, `is_active`, `is_close`, `deleted_at`) VALUES
	(1, 1, 1, 1, 0, NULL),
	(2, 1, 2, 0, 0, NULL);
/*!40000 ALTER TABLE `mt_periode_semester` ENABLE KEYS */;

-- Dumping structure for table apdate.mt_tingkat_kelas
CREATE TABLE IF NOT EXISTS `mt_tingkat_kelas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_tingkat_kelas: ~3 rows (approximately)
/*!40000 ALTER TABLE `mt_tingkat_kelas` DISABLE KEYS */;
INSERT INTO `mt_tingkat_kelas` (`id`, `code`, `name`, `deleted_at`) VALUES
	(1, '7', 'Kelas 7', NULL),
	(2, '8', 'Kelas 8', NULL),
	(3, '9', 'Kelas 9', NULL);
/*!40000 ALTER TABLE `mt_tingkat_kelas` ENABLE KEYS */;

-- Dumping structure for table apdate.mt_users_guru
CREATE TABLE IF NOT EXISTS `mt_users_guru` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `users_id` bigint DEFAULT NULL,
  `join_periode_id` bigint NOT NULL,
  `nip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_hp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_users_guru: ~3 rows (approximately)
/*!40000 ALTER TABLE `mt_users_guru` DISABLE KEYS */;
INSERT INTO `mt_users_guru` (`id`, `users_id`, `join_periode_id`, `nip`, `nama`, `email`, `nomor_hp`, `is_active`) VALUES
	(1, 6, 1, '012200141', 'Susyono AKBP', 'susyono@gmail.com', '0812345678', '1'),
	(2, 8, 1, '0122456', 'Saleh', 'saleh@gmail.com', '081111', '1'),
	(3, 9, 1, '01220014', 'Indra Gunawan', 'igun@gmail.com', '0812412314123', '1');
/*!40000 ALTER TABLE `mt_users_guru` ENABLE KEYS */;

-- Dumping structure for table apdate.mt_users_siswa
CREATE TABLE IF NOT EXISTS `mt_users_siswa` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `join_periode_id` bigint NOT NULL,
  `users_id` bigint NOT NULL,
  `current_kelas_id` bigint DEFAULT NULL,
  `nisn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `tanggal_lahir` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.mt_users_siswa: ~2 rows (approximately)
/*!40000 ALTER TABLE `mt_users_siswa` DISABLE KEYS */;
INSERT INTO `mt_users_siswa` (`id`, `join_periode_id`, `users_id`, `current_kelas_id`, `nisn`, `nama`, `tanggal_lahir`) VALUES
	(1, 1, 5, 1, '220014', 'Muhammad Ichsan Fathurrochman', '2025-06-10'),
	(2, 1, 7, 4, '220015', 'Dhimas Marwahyu', '2025-06-10');
/*!40000 ALTER TABLE `mt_users_siswa` ENABLE KEYS */;

-- Dumping structure for table apdate.m_menu
CREATE TABLE IF NOT EXISTS `m_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `menu_parent_id` int NOT NULL DEFAULT '0',
  `routes` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_config` int NOT NULL DEFAULT '0',
  `precedence` bigint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_parent_id` (`menu_parent_id`),
  KEY `name` (`name`,`routes`,`icon`,`is_config`),
  KEY `created_at` (`created_at`,`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.m_menu: ~14 rows (approximately)
/*!40000 ALTER TABLE `m_menu` DISABLE KEYS */;
INSERT INTO `m_menu` (`id`, `name`, `menu_parent_id`, `routes`, `icon`, `is_config`, `precedence`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Configuration', 0, NULL, 'fa-cog', 1, 0, '2020-10-30 18:19:55', '2020-10-30 18:19:55', NULL),
	(2, 'Menu Builder', 1, 'dashboard/configuration/menu_builder', 'fa-circle', 1, 1, '2020-10-30 18:19:55', '2021-08-31 09:11:10', NULL),
	(3, 'User Group', 1, 'dashboard/configuration/user_group', 'fa-circle', 1, 2, '2020-10-30 18:19:55', '2020-10-30 18:19:55', NULL),
	(4, 'Periode', 33, 'dashboard/master/periode', 'fa-circle', 0, 3, '2021-09-01 23:01:14', '2025-06-10 02:04:48', NULL),
	(5, 'User', 1, 'dashboard/configuration/user', 'fa-circle', 1, 2, '2020-10-30 18:19:55', '2020-10-30 18:19:55', NULL),
	(6, 'Mata Pelajaran', 33, 'dashboard/master/mata-pelajaran', 'fa-circle', 0, 2, '2021-09-01 23:01:14', '2025-06-10 02:04:40', NULL),
	(7, 'Data Siswa', 8, 'dashboard/kesiswaan/siswa', 'fa-circle', 0, 1, '2021-09-01 23:01:14', '2025-06-09 19:53:16', NULL),
	(8, 'Kesiswaan', 0, '', 'fa-users', 0, 2, '2021-09-01 23:01:14', '2025-06-09 19:52:57', NULL),
	(10, 'Tingkat Kelas', 33, 'dashboard/master/tingkat-kelas', 'fa-circle', 1, 1, '2024-04-08 03:03:57', '2025-06-09 19:51:34', NULL),
	(33, 'Master Data', 0, '', 'fa-list', 0, 1, '2025-06-10 02:50:36', '2025-06-10 02:50:36', NULL),
	(34, 'Data Guru', 8, 'dashboard/kesiswaan/guru', 'fa-circle', 0, 2, '2025-06-10 02:53:35', '2025-06-10 02:53:35', NULL),
	(35, 'Data Kelas', 8, 'dashboard/kesiswaan/kelas', 'fa-circle', 0, 3, '2025-06-10 02:54:26', '2025-06-10 02:54:26', NULL),
	(36, 'Generate Kelas Siswa', 0, 'dashboard/generate/kelas-siswa', 'fa-file', 0, 3, '2025-06-23 14:43:53', '2025-06-23 07:44:05', NULL),
	(37, 'Generate Jadwal Kelas', 0, 'dashboard/generate/jadwal-kelas', 'fa-file', 0, 5, '2025-06-28 14:34:00', '2025-07-29 07:50:32', NULL),
	(38, 'Grading E-Rapor', 0, 'dashboard/generate/closing-tahun-ajaran', 'fa-file', 0, 6, '2025-07-29 07:50:24', '2025-07-29 09:17:05', NULL);
/*!40000 ALTER TABLE `m_menu` ENABLE KEYS */;

-- Dumping structure for table apdate.m_users
CREATE TABLE IF NOT EXISTS `m_users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_group_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(225) NOT NULL,
  `password_raw` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`user_group_id`,`name`,`email`,`created_at`),
  KEY `deleted_at` (`deleted_at`),
  CONSTRAINT `m_users_ibfk_1` FOREIGN KEY (`user_group_id`) REFERENCES `m_users_group` (`id_grup`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table apdate.m_users: ~6 rows (approximately)
/*!40000 ALTER TABLE `m_users` DISABLE KEYS */;
INSERT INTO `m_users` (`id`, `user_group_id`, `username`, `name`, `email`, `password`, `password_raw`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'admin', 'Administrator', 'superadmin@admin.com', '$2y$10$jcYzWD8KQVlRAx2EjDfVy.en2HrBTv3rb0yQBRhYIz8a.V2TANAnG', 'admin123', '2025-06-07 19:44:14', '2025-06-08 02:44:14', NULL),
	(5, 3, '220014', 'Muhammad Ichsan Fathurrochman', '', '$2y$10$VRrvvEwloJHMMydT5DdsAuLwhymCBUgUhRZB.X41o.mZSLYDLLhzC', '20250610', '2025-06-10 02:34:03', '2025-06-10 09:34:03', NULL),
	(6, 2, '012200141', 'Susyono AKBP', 'susyono@gmail.com', '$2y$10$GC4932AilK1Nphhl4OrtK.yKMJSbMMGjriFDXLzGs0Z7GMQ8q6omC', '19700101', '2025-06-10 02:50:31', '2025-06-10 09:50:31', NULL),
	(7, 3, '220015', 'Dhimas Marwahyu', '', '$2y$10$kfRM.wY3NU5UstR0g3IujODObjSweQw1Vk3Fy.OOJ01JaCuhkb67y', '20250610', '2025-06-10 04:30:14', '2025-06-10 11:30:14', NULL),
	(8, 2, '0122456', 'Saleh', 'saleh@gmail.com', '$2y$10$kK4IFPip91S6aBoYiVub0eVk25YgUCZZwZuNzUzZ8jKXy7NfmzEHe', '20250610', '2025-06-10 04:30:38', '2025-06-10 11:30:38', NULL),
	(9, 2, '01220014', 'Indra Gunawan', 'igun@gmail.com', '$2y$10$wq0PwczqJFAg2oYQoKF8buhWxdMVWkzDw5X25g4GaXYx4WsG/H9MG', '23140503', '2025-06-23 03:30:49', '2025-06-23 10:30:49', NULL);
/*!40000 ALTER TABLE `m_users` ENABLE KEYS */;

-- Dumping structure for table apdate.m_users_group
CREATE TABLE IF NOT EXISTS `m_users_group` (
  `id_grup` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `menu_access` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_grup`),
  KEY `name` (`name`),
  KEY `created_at` (`created_at`,`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.m_users_group: ~3 rows (approximately)
/*!40000 ALTER TABLE `m_users_group` DISABLE KEYS */;
INSERT INTO `m_users_group` (`id_grup`, `name`, `menu_access`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Admin', '1,10,2,6,7,8,5,3', '2020-10-31 01:39:03', '2020-10-31 01:39:03', NULL),
	(2, 'Guru', '1,4,10,6,7,8', '2021-07-12 00:29:59', '2021-09-27 06:24:09', NULL),
	(3, 'Siswa', NULL, '2025-06-10 09:27:33', '2025-06-10 09:27:33', NULL);
/*!40000 ALTER TABLE `m_users_group` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_guru_mata_pelajaran
CREATE TABLE IF NOT EXISTS `tref_guru_mata_pelajaran` (
  `guru_id` bigint NOT NULL,
  `mata_pelajaran_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_guru_mata_pelajaran: ~6 rows (approximately)
/*!40000 ALTER TABLE `tref_guru_mata_pelajaran` DISABLE KEYS */;
INSERT INTO `tref_guru_mata_pelajaran` (`guru_id`, `mata_pelajaran_id`) VALUES
	(3, 1),
	(3, 6),
	(3, 5),
	(2, 3),
	(2, 4),
	(1, 2);
/*!40000 ALTER TABLE `tref_guru_mata_pelajaran` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_kelas
CREATE TABLE IF NOT EXISTS `tref_kelas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `periode_id` bigint NOT NULL,
  `tingkat_kelas_id` bigint NOT NULL,
  `guru_id` bigint NOT NULL,
  `kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_kelas: ~4 rows (approximately)
/*!40000 ALTER TABLE `tref_kelas` DISABLE KEYS */;
INSERT INTO `tref_kelas` (`id`, `periode_id`, `tingkat_kelas_id`, `guru_id`, `kelas`) VALUES
	(1, 1, 1, 3, '7.1'),
	(2, 1, 2, 3, '8.1'),
	(3, 1, 3, 1, '9.1'),
	(4, 1, 1, 1, '7.2');
/*!40000 ALTER TABLE `tref_kelas` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_kelas_jadwal_pelajaran
CREATE TABLE IF NOT EXISTS `tref_kelas_jadwal_pelajaran` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `semester_id` bigint NOT NULL,
  `kelas_id` bigint NOT NULL,
  `mata_pelajaran_id` bigint NOT NULL,
  `guru_id` bigint NOT NULL,
  `jumlah_pertemuan` int DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  `close_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_kelas_jadwal_pelajaran: ~9 rows (approximately)
/*!40000 ALTER TABLE `tref_kelas_jadwal_pelajaran` DISABLE KEYS */;
INSERT INTO `tref_kelas_jadwal_pelajaran` (`id`, `semester_id`, `kelas_id`, `mata_pelajaran_id`, `guru_id`, `jumlah_pertemuan`, `status`, `close_at`) VALUES
	(1, 1, 1, 1, 3, NULL, 0, NULL),
	(2, 1, 1, 3, 2, NULL, 0, NULL),
	(3, 1, 1, 2, 1, 20, 1, '2025-07-29 08:19:49'),
	(4, 1, 4, 1, 3, NULL, 0, NULL),
	(5, 1, 4, 3, 2, NULL, 0, NULL),
	(6, 1, 4, 2, 1, NULL, 0, NULL),
	(7, 1, 2, 6, 3, NULL, 0, NULL),
	(8, 1, 2, 4, 2, NULL, 0, NULL),
	(9, 1, 3, 5, 3, NULL, 0, NULL);
/*!40000 ALTER TABLE `tref_kelas_jadwal_pelajaran` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_kelas_mata_pelajaran
CREATE TABLE IF NOT EXISTS `tref_kelas_mata_pelajaran` (
  `kelas_id` bigint NOT NULL,
  `mata_pelajaran_id` bigint NOT NULL,
  `guru_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_kelas_mata_pelajaran: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_kelas_mata_pelajaran` DISABLE KEYS */;
INSERT INTO `tref_kelas_mata_pelajaran` (`kelas_id`, `mata_pelajaran_id`, `guru_id`) VALUES
	(1, 1, 3),
	(1, 3, 2),
	(1, 2, 1),
	(2, 6, 3),
	(2, 4, 2),
	(3, 5, 3),
	(4, 1, 3),
	(4, 3, 2),
	(4, 2, 1);
/*!40000 ALTER TABLE `tref_kelas_mata_pelajaran` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_kelas_siswa
CREATE TABLE IF NOT EXISTS `tref_kelas_siswa` (
  `kelas_id` bigint DEFAULT NULL,
  `siswa_id` bigint DEFAULT NULL,
  `status` enum('aktif','nonaktif','transfer','naik_kelas','tinggal_kelas') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'aktif',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_kelas_siswa: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_kelas_siswa` DISABLE KEYS */;
INSERT INTO `tref_kelas_siswa` (`kelas_id`, `siswa_id`, `status`, `updated_at`) VALUES
	(4, 2, 'aktif', '2025-06-28 07:18:40'),
	(1, 1, 'aktif', '2025-06-28 07:28:29');
/*!40000 ALTER TABLE `tref_kelas_siswa` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_periode_mata_pelajaran
CREATE TABLE IF NOT EXISTS `tref_periode_mata_pelajaran` (
  `periode_id` bigint NOT NULL,
  `tingkat_kelas_id` bigint NOT NULL,
  `mata_pelajaran_id` bigint NOT NULL,
  `guru_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_periode_mata_pelajaran: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_periode_mata_pelajaran` DISABLE KEYS */;
INSERT INTO `tref_periode_mata_pelajaran` (`periode_id`, `tingkat_kelas_id`, `mata_pelajaran_id`, `guru_id`) VALUES
	(1, 1, 1, 3),
	(1, 1, 3, 2),
	(1, 1, 2, 1),
	(1, 2, 6, 3),
	(1, 2, 4, 2),
	(1, 3, 5, 3);
/*!40000 ALTER TABLE `tref_periode_mata_pelajaran` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_pertemuan
CREATE TABLE IF NOT EXISTS `tref_pertemuan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jadwal_kelas_id` bigint NOT NULL,
  `pertemuan_ke` tinyint NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `close_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_pertemuan: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_pertemuan` DISABLE KEYS */;
INSERT INTO `tref_pertemuan` (`id`, `jadwal_kelas_id`, `pertemuan_ke`, `status`, `close_at`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 08:36:18'),
	(2, 3, 2, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-29 06:30:57'),
	(3, 3, 3, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(4, 3, 4, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(5, 3, 5, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(6, 3, 6, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(7, 3, 7, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(8, 3, 8, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(9, 3, 9, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(10, 3, 10, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(11, 3, 11, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(12, 3, 12, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(13, 3, 13, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(14, 3, 14, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(15, 3, 15, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(16, 3, 16, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(17, 3, 17, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(18, 3, 18, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(19, 3, 19, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46'),
	(20, 3, 20, 0, '2025-07-29 08:19:49', '2025-07-22 03:39:46', '2025-07-22 03:39:46');
/*!40000 ALTER TABLE `tref_pertemuan` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_pertemuan_absensi
CREATE TABLE IF NOT EXISTS `tref_pertemuan_absensi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pertemuan_id` bigint NOT NULL,
  `siswa_id` bigint NOT NULL,
  `coordinate` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tref_pertemuan_absensi: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_pertemuan_absensi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tref_pertemuan_absensi` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_pertemuan_diskusi
CREATE TABLE IF NOT EXISTS `tref_pertemuan_diskusi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pertemuan_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table apdate.tref_pertemuan_diskusi: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_pertemuan_diskusi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tref_pertemuan_diskusi` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_pertemuan_modul
CREATE TABLE IF NOT EXISTS `tref_pertemuan_modul` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pertemuan_id` bigint NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table apdate.tref_pertemuan_modul: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_pertemuan_modul` DISABLE KEYS */;
/*!40000 ALTER TABLE `tref_pertemuan_modul` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_pertemuan_pranala_luar
CREATE TABLE IF NOT EXISTS `tref_pertemuan_pranala_luar` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pertemuan_id` bigint NOT NULL,
  `judul` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table apdate.tref_pertemuan_pranala_luar: ~0 rows (approximately)
/*!40000 ALTER TABLE `tref_pertemuan_pranala_luar` DISABLE KEYS */;
/*!40000 ALTER TABLE `tref_pertemuan_pranala_luar` ENABLE KEYS */;

-- Dumping structure for table apdate.tref_pertemuan_tugas
CREATE TABLE IF NOT EXISTS `tref_pertemuan_tugas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pertemuan_id` bigint NOT NULL,
  `siswa_id` bigint DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table apdate.tref_pertemuan_tugas: ~1 rows (approximately)
/*!40000 ALTER TABLE `tref_pertemuan_tugas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tref_pertemuan_tugas` ENABLE KEYS */;

-- Dumping structure for table apdate.tr_rapor
CREATE TABLE IF NOT EXISTS `tr_rapor` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint NOT NULL,
  `semester_id` bigint NOT NULL,
  `nilai_akhir` bigint DEFAULT NULL,
  `is_close` tinyint NOT NULL DEFAULT '0',
  `grade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tr_rapor: ~0 rows (approximately)
/*!40000 ALTER TABLE `tr_rapor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_rapor` ENABLE KEYS */;

-- Dumping structure for table apdate.tr_rapor_penilaian
CREATE TABLE IF NOT EXISTS `tr_rapor_penilaian` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `rapor_id` bigint NOT NULL,
  `semester_id` bigint NOT NULL,
  `siswa_id` bigint NOT NULL,
  `jadwal_id` bigint NOT NULL,
  `nilai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `is_final` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table apdate.tr_rapor_penilaian: ~0 rows (approximately)
/*!40000 ALTER TABLE `tr_rapor_penilaian` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_rapor_penilaian` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
