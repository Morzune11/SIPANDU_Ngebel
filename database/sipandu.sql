-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sipandu
-- CREATE DATABASE IF NOT EXISTS `sipandu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
-- USE `sipandu`;

-- Dumping structure for table sipandu.applicant_auths
CREATE TABLE IF NOT EXISTS `applicant_auths` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.applicant_auths: ~0 rows (approximately)

-- Dumping structure for table sipandu.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.cache: ~0 rows (approximately)

-- Dumping structure for table sipandu.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.cache_locks: ~0 rows (approximately)

-- Dumping structure for table sipandu.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table sipandu.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.jobs: ~0 rows (approximately)

-- Dumping structure for table sipandu.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.job_batches: ~0 rows (approximately)

-- Dumping structure for table sipandu.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.migrations: ~10 rows (approximately)
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_09_27_141856_create_applicant_auths_table', 1),
	(5, '2026_09_30_071449_create_staff_auths_table', 1),
	(6, '2026_10_02_002837_create_permit_types_table', 1),
	(7, '2026_10_02_134552_create_permit_applications_table', 1),
	(8, '2026_10_02_134556_create_permit_documents_table', 1),
	(9, '2026_10_04_083704_add_profile_fields_to_users_table', 1),
	(10, '2026_10_04_085204_create_notifications_table', 1);

-- Dumping structure for table sipandu.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.notifications: ~33 rows (approximately)
INSERT IGNORE INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('0ad27102-1cf0-4805-b680-f6febce913dc', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 5, '{"title":"Surat Disetujui!","message":"Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/7"}', NULL, '2026-10-07 22:44:39', '2026-10-07 22:44:39'),
	('0f1d03b3-3b1d-498e-859f-e95c89217f30', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 3, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Siti Aminah yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 06:27:42', '2026-10-07 06:27:42'),
	('14320fd2-f0d3-4bd1-98aa-5b8998bbd8e7', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 6, '{"title":"Status Berubah","message":"Pengajuan izin Anda kini berstatus: MENUNGGU_TTE","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/2"}', NULL, '2026-10-07 22:55:21', '2026-10-07 22:55:21'),
	('1a7bc1d1-b0e9-4a0e-a5ac-8a9dad871e5e', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 1, '{"title":"Pengajuan Baru","message":"Budi Santoso mengajukan izin baru.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/verifikasi\\/7"}', NULL, '2026-10-07 22:42:51', '2026-10-07 22:42:51'),
	('2380ca20-b83a-42e3-8259-4d902677bd51', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 4, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Siti Aminah yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 22:55:41', '2026-10-07 22:55:41'),
	('2a2e25b7-8cd8-4067-b1c1-9137be847c04', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 6, '{"title":"Surat Disetujui!","message":"Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/2"}', NULL, '2026-10-07 22:55:41', '2026-10-07 22:55:41'),
	('2de1b27d-1f5e-465d-9fcb-cffce4f3019a', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 4, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Budi Santoso yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 06:05:13', '2026-10-07 06:05:13'),
	('3e2364b9-852f-4308-9f81-c702610141cd', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 5, '{"title":"Surat Disetujui!","message":"Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/6"}', NULL, '2026-10-07 22:52:17', '2026-10-07 22:52:17'),
	('45836eae-e6c7-40d0-8fd3-14d71bb6e4db', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 2, '{"title":"Menunggu Pengesahan","message":"Ada dokumen atas nama Moch Arrizal menunggu TTE.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/persetujuan\\/8"}', '2026-10-07 23:50:01', '2026-10-07 23:49:00', '2026-10-07 23:50:01'),
	('5c0a6158-0fee-4754-94be-a76df307b157', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 1, '{"title":"Pengajuan Baru","message":"Moch Arrizal mengajukan izin baru.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/verifikasi\\/8"}', NULL, '2026-10-07 23:47:48', '2026-10-07 23:47:48'),
	('648fa941-1624-4df2-bf76-f85c097247a3', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 3, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Budi Santoso yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 22:44:39', '2026-10-07 22:44:39'),
	('663e5f2b-2f91-4eaf-8b45-b680d1b80b6c', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 4, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Moch Arrizal yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 23:50:07', '2026-10-07 23:50:07'),
	('6c0668f0-6a9f-4443-812b-bd4d45920b50', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 7, '{"title":"Status Berubah","message":"Pengajuan izin Anda kini berstatus: MENUNGGU_TTE","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/8"}', NULL, '2026-10-07 23:49:00', '2026-10-07 23:49:00'),
	('719a57c4-232f-4c09-a568-b939c1297358', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 5, '{"title":"Status Berubah","message":"Pengajuan izin Anda kini berstatus: MENUNGGU_TTE","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/6"}', NULL, '2026-10-07 22:51:53', '2026-10-07 22:51:53'),
	('741e0317-d128-4f18-b603-1c506b31b503', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 5, '{"title":"Surat Disetujui!","message":"Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/1"}', '2026-10-07 06:17:02', '2026-10-07 06:05:13', '2026-10-07 06:17:02'),
	('7979f3a9-9e71-492d-8bf4-dc50ab0ae934', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 1, '{"title":"Pengajuan Baru","message":"Budi Santoso mengajukan izin baru.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/verifikasi\\/6"}', '2026-10-07 06:04:55', '2026-10-07 06:03:23', '2026-10-07 06:04:55'),
	('8148dec7-1ca1-4c24-9a9d-f1362a3bef69', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 1, '{"title":"Revisi Berkas","message":"Moch Arrizal telah merevisi berkas pengajuannya.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/verifikasi\\/8"}', NULL, '2026-10-07 23:48:37', '2026-10-07 23:48:37'),
	('89f2b2fd-1f21-4994-aaf8-ed21141d4bff', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 3, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Budi Santoso yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', '2026-10-07 06:09:42', '2026-10-07 06:05:13', '2026-10-07 06:09:42'),
	('8ca4e9ab-a923-46f0-acf6-7a9d0a8d14fc', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 5, '{"title":"Status Berubah","message":"Pengajuan izin Anda kini berstatus: MENUNGGU_TTE","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/1"}', '2026-10-07 22:38:58', '2026-10-07 06:04:49', '2026-10-07 22:38:58'),
	('99741aa1-8ffb-444f-a4e6-0451e8e0476f', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 3, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Siti Aminah yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 22:55:41', '2026-10-07 22:55:41'),
	('9af2b71c-67e3-4aac-a651-79cc7e7ef9e7', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 5, '{"title":"Status Berubah","message":"Pengajuan izin Anda kini berstatus: MENUNGGU_TTE","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/7"}', NULL, '2026-10-07 22:43:46', '2026-10-07 22:43:46'),
	('a889e803-1ff5-482c-bcf1-02f274d4c52f', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 4, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Siti Aminah yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 06:27:42', '2026-10-07 06:27:42'),
	('ab0d0d3e-0de3-479e-ad05-51dfd7e7e926', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 2, '{"title":"Menunggu Pengesahan","message":"Ada dokumen atas nama Budi Santoso menunggu TTE.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/persetujuan\\/1"}', '2026-10-07 06:05:07', '2026-10-07 06:04:49', '2026-10-07 06:05:07'),
	('b717d38d-4cbf-453c-b2e3-2927fa19404d', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 6, '{"title":"Surat Disetujui!","message":"Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/4"}', NULL, '2026-10-07 06:27:42', '2026-10-07 06:27:42'),
	('bd370043-3720-437e-8952-d6a14a723d44', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 7, '{"title":"Surat Disetujui!","message":"Selamat! Surat pengajuan Anda telah disetujui (ACC) oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/8"}', NULL, '2026-10-07 23:50:07', '2026-10-07 23:50:07'),
	('be39ca79-48ff-4a38-9c9f-cbcfa528b6f9', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 4, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Budi Santoso yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 22:52:17', '2026-10-07 22:52:17'),
	('c0ac7221-fd7b-4363-8cc3-0c7873be0d21', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 2, '{"title":"Menunggu Pengesahan","message":"Ada dokumen atas nama Siti Aminah menunggu TTE.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/persetujuan\\/2"}', NULL, '2026-10-07 22:55:21', '2026-10-07 22:55:21'),
	('ccbcb310-8b5f-440f-b598-09f5188ea80e', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 3, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Budi Santoso yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 22:52:17', '2026-10-07 22:52:17'),
	('d6d5cad4-19a8-460b-bcc4-31bb266cd6e5', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 7, '{"title":"Status Berubah","message":"Pengajuan izin Anda kini berstatus: REVISI","url":"http:\\/\\/127.0.0.1:8000\\/pengajuan\\/8"}', NULL, '2026-10-07 23:48:25', '2026-10-07 23:48:25'),
	('da5474a8-d901-486d-8b46-1979ef6951c2', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 3, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Moch Arrizal yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 23:50:07', '2026-10-07 23:50:07'),
	('e65264ed-1363-4baf-9bbf-106292f7fb89', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 2, '{"title":"Menunggu Pengesahan","message":"Ada dokumen atas nama Budi Santoso menunggu TTE.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/persetujuan\\/7"}', NULL, '2026-10-07 22:43:46', '2026-10-07 22:43:46'),
	('ed7ac45e-62fd-4218-8fd1-9888f3ec60e8', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 2, '{"title":"Menunggu Pengesahan","message":"Ada dokumen atas nama Budi Santoso menunggu TTE.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/persetujuan\\/6"}', NULL, '2026-10-07 22:51:53', '2026-10-07 22:51:53'),
	('f51e831e-f9e1-4244-b936-2c919cd4d446', 'App\\Notifications\\PermitNotification', 'App\\Models\\User', 4, '{"title":"Tembusan Surat Baru","message":"Terdapat surat izin baru a\\/n Budi Santoso yang telah disahkan oleh Camat.","url":"http:\\/\\/127.0.0.1:8000\\/petugas\\/tembusan"}', NULL, '2026-10-07 22:44:39', '2026-10-07 22:44:39');

-- Dumping structure for table sipandu.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table sipandu.permit_applications
CREATE TABLE IF NOT EXISTS `permit_applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_pendaftaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `permit_type_id` bigint unsigned NOT NULL,
  `status` enum('diajukan','revisi','diproses','menunggu_tte','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `catatan_revisi` text COLLATE utf8mb4_unicode_ci,
  `file_surat_hasil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permit_applications_nomor_pendaftaran_unique` (`nomor_pendaftaran`),
  KEY `permit_applications_user_id_foreign` (`user_id`),
  KEY `permit_applications_permit_type_id_foreign` (`permit_type_id`),
  CONSTRAINT `permit_applications_permit_type_id_foreign` FOREIGN KEY (`permit_type_id`) REFERENCES `permit_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permit_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.permit_applications: ~8 rows (approximately)
INSERT IGNORE INTO `permit_applications` (`id`, `nomor_pendaftaran`, `user_id`, `permit_type_id`, `status`, `catatan_revisi`, `file_surat_hasil`, `created_at`, `updated_at`) VALUES
	(1, 'REG-202610-A001', 5, 1, 'selesai', NULL, NULL, '2026-10-07 05:39:12', '2026-10-07 06:05:13'),
	(2, 'REG-202610-B002', 6, 2, 'selesai', NULL, NULL, '2026-10-07 05:39:12', '2026-10-07 22:55:41'),
	(3, 'REG-202610-C003', 5, 2, 'revisi', 'Persyaratan kurang lengkap, mohon cek kembali KTP.', NULL, '2026-10-07 05:39:12', '2026-10-07 05:39:12'),
	(4, 'REG-202610-D004', 6, 1, 'selesai', NULL, NULL, '2026-10-07 05:39:12', '2026-10-07 06:27:42'),
	(5, 'REG-202610-E005', 5, 1, 'selesai', NULL, NULL, '2026-10-07 05:39:12', '2026-10-07 05:39:12'),
	(6, 'REG-202610-JB7I7U', 5, 1, 'selesai', NULL, NULL, '2026-10-07 06:03:22', '2026-10-07 22:52:17'),
	(7, 'REG-202610-ZQEJNF', 5, 2, 'selesai', NULL, NULL, '2026-10-07 22:42:51', '2026-10-07 22:44:39'),
	(8, 'REG-202610-ID1KTK', 7, 2, 'selesai', NULL, NULL, '2026-10-07 23:47:48', '2026-10-07 23:50:07');

-- Dumping structure for table sipandu.permit_documents
CREATE TABLE IF NOT EXISTS `permit_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permit_application_id` bigint unsigned NOT NULL,
  `nama_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permit_documents_permit_application_id_foreign` (`permit_application_id`),
  CONSTRAINT `permit_documents_permit_application_id_foreign` FOREIGN KEY (`permit_application_id`) REFERENCES `permit_applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.permit_documents: ~4 rows (approximately)
INSERT IGNORE INTO `permit_documents` (`id`, `permit_application_id`, `nama_dokumen`, `file_path`, `created_at`, `updated_at`) VALUES
	(1, 6, 'DFD lvl 1 (EPL).drawio.png', 'dokumen_persyaratan/9RoK8PFA38bsBfrXBff4BctYy7W5ngDJH9quDP2A.png', '2026-10-07 06:03:22', '2026-10-07 06:03:22'),
	(2, 7, 'Arsitektur IAAS Sederhana.drawio.png', 'dokumen_persyaratan/pkcbVBucBCpwFzRauxkCC7r9RQSLqGN7KldFsAhW.png', '2026-10-07 22:42:51', '2026-10-07 22:42:51'),
	(3, 8, 'DFD Level 0 (EPL).drawio.png', 'dokumen_persyaratan/uLaXKzkIkijZ4Ufjt6ucMTN0c8szk9ZOvWH5d5AX.png', '2026-10-07 23:47:48', '2026-10-07 23:47:48'),
	(4, 8, 'DFD level 1 (GT).drawio.png', 'dokumen_persyaratan/V7PyX9GxybA2JLovJJOxw5z8VUxUjhkgTUGTR80q.png', '2026-10-07 23:47:48', '2026-10-07 23:47:48');

-- Dumping structure for table sipandu.permit_types
CREATE TABLE IF NOT EXISTS `permit_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_izin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persyaratan` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Daftar syarat, dipisahkan dengan koma atau baris baru',
  `estimasi_hari` int NOT NULL DEFAULT '3',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.permit_types: ~2 rows (approximately)
INSERT IGNORE INTO `permit_types` (`id`, `nama_izin`, `persyaratan`, `estimasi_hari`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Surat Keterangan Domisili', '["Fotokopi KTP","Fotokopi KK","Surat Pengantar RT\\/RW"]', 3, 1, '2026-10-07 05:39:12', '2026-10-07 05:39:12'),
	(2, 'Surat Keterangan Usaha (SKU)', '["Fotokopi KTP","Fotokopi KK","Foto Tempat Usaha"]', 3, 1, '2026-10-07 05:39:12', '2026-10-07 05:39:12');

-- Dumping structure for table sipandu.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.sessions: ~4 rows (approximately)
INSERT IGNORE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('aLeusGtZapIBQvoEcENICF0dpvtVKRtpuSDr6AfZ', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.140.0 Chrome/150.0.7871.250 Electron/43.7.3 Safari/537.36', 'eyJfdG9rZW4iOiJ2ZldBeVIyUHVZSFI0QVp3dGlrYnlvaGlKcUl3Mkx1S1B3NHk1Q1JxIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BlbmdhanVhblwvOCIsInJvdXRlIjoicGVtb2hvbi5wZW5nYWp1YW4uc2hvdyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NywicGFzc3dvcmRfaGFzaF93ZWIiOiJkYWFkMmQ3YWI4Y2NkNjQwMDk5OTIyODQ5ZWM1YjYwZTkwYzMzMGY4NGM2ZGJmODc5MmFkMTE5NDA1M2YwMWJlIn0=', 1791442118),
	('eyDLVJV6pA8AkRMNVVz4QWyMNNy3vbhM1YYwZjeW', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJKZGZwYzV2QUY4bEFZdWlacjNmOVBUWXFVQm9HQ2w4Q1lGc20yN1B5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wZXR1Z2FzXC9wZXJzZXR1anVhblwvcml3YXlhdCIsInJvdXRlIjoiY2FtYXQucml3YXlhdC5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyLCJwYXNzd29yZF9oYXNoX3dlYiI6IjRjYjU0YTc5YzFlNWQ4M2E0MzBhNWViOGJjMjVmMTYwODM3NmY0MWZlNjI4N2FkYTNjY2MwZjgwZWJjYWJhNWEifQ==', 1791440102),
	('FGg6qboyGTuHxH26glb1b05hQjMeKrYEI2VN5sAX', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJvODZWMkdwYlFTcXVDMTBMeVVWd3I5cENQWFVJc0VBQ0k3Q1pZZ1NDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wZXR1Z2FzXC9wZXJzZXR1anVhblwvcml3YXlhdCIsInJvdXRlIjoiY2FtYXQucml3YXlhdC5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyLCJwYXNzd29yZF9oYXNoX3dlYiI6IjRjYjU0YTc5YzFlNWQ4M2E0MzBhNWViOGJjMjVmMTYwODM3NmY0MWZlNjI4N2FkYTNjY2MwZjgwZWJjYWJhNWEifQ==', 1791442241),
	('GQiu23Hlt1AXv2MXSW0TQri8wdXjuiexBfQjxMmh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJUakZrUUE0S0pWUWtLSXlSUWN2VFp3S1IwRHRyM2VFcVcwVXQzVTNEIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BldHVnYXNcL2xvZ2luIiwicm91dGUiOiJwZXR1Z2FzLmxvZ2luIn19', 1791442309);

-- Dumping structure for table sipandu.staff_auths
CREATE TABLE IF NOT EXISTS `staff_auths` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.staff_auths: ~0 rows (approximately)

-- Dumping structure for table sipandu.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('pemohon','admin','camat','admin_polsek','admin_koramil') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pemohon',
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tempat_tanggal_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nik_unique` (`nik`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sipandu.users: ~7 rows (approximately)
INSERT IGNORE INTO `users` (`id`, `nik`, `role`, `no_telepon`, `nama_lengkap`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `tempat_tanggal_lahir`, `jenis_kelamin`, `pekerjaan`, `alamat`) VALUES
	(1, '3502010000000001', 'admin', '081111111111', 'Administrator Kecamatan', 'admin@ngebel.go.id', NULL, '$2y$12$liYqnbJw49g5hTaw8srUQeVfFaEmrVQxzknTgSMrLgNFHEl7wLFKS', NULL, '2026-10-07 05:39:10', '2026-10-07 05:39:10', NULL, NULL, NULL, NULL),
	(2, '3502010000000002', 'camat', '082222222222', 'Camat', 'camat@ngebel.go.id', NULL, '$2y$12$.7FvENjwdVxqQwONYlnwg.1aR3ARU5a5uhdZf67nC9YGOxbmneE6a', NULL, '2026-10-07 05:39:11', '2026-10-07 23:50:30', NULL, NULL, NULL, NULL),
	(3, '3502010000000003', 'admin_polsek', '083333333333', 'Admin Polsek Ngebel', 'polsek@ngebel.go.id', NULL, '$2y$12$8H4JASMFuhhcNm4Gr/XQR.X8xAfk4.Q1yPGIclI72.X9krWLSbQVG', NULL, '2026-10-07 05:39:11', '2026-10-07 05:39:11', NULL, NULL, NULL, NULL),
	(4, '3502010000000004', 'admin_koramil', '084444444444', 'Admin Koramil Ngebel', 'koramil@ngebel.go.id', NULL, '$2y$12$m1ifAqmAd.WLrXjTzPPI7eJV/dkkdsxZ6Is5PVNw2SjvvYpcSMI7y', NULL, '2026-10-07 05:39:11', '2026-10-07 05:39:11', NULL, NULL, NULL, NULL),
	(5, '3502010000000005', 'pemohon', '085555555555', 'Budi Santoso', 'budi@gmail.com', NULL, '$2y$12$JScUbEzzvnzsiCUIn4UI7O8ggiyyRRV.gRi/NannEuE.0vIkBV4UO', NULL, '2026-10-07 05:39:12', '2026-10-07 05:39:12', 'Ponorogo, 17 Agustus 1990', 'Laki-laki', 'Wiraswasta', 'Jl. Telaga Ngebel No. 10, RT 01 RW 02, Kec. Ngebel'),
	(6, '3502010000000006', 'pemohon', '086666666666', 'Siti Aminah', 'siti@gmail.com', NULL, '$2y$12$FsX1nYuLVwB/4wTnB.ndp.CW2eFGa0GQ5kPaB.rw0Xbub5bWw/lmK', NULL, '2026-10-07 05:39:12', '2026-10-07 05:39:12', 'Madiun, 01 Januari 1995', 'Perempuan', 'Pegawai Swasta', 'Ds. Sahang, RT 03 RW 01, Kec. Ngebel'),
	(7, '3634721347638724', 'pemohon', '00934872894', 'Moch Arrizal', 'moch@gmail.com', NULL, '$2y$12$t5O6Y5kPs/yIBmrGasDy4e.r6rdUyo9b9XR0hXnkwTmmJI/OIyLzG', NULL, '2026-10-07 23:46:23', '2026-10-07 23:47:22', 'Surabay, 27-12-2010', 'Laki-laki', 'Mahasiswa', 'RT.09 RW.02 Sewulan Dagangan');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
