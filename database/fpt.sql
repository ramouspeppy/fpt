/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - fpt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `activity_log` */

DROP TABLE IF EXISTS `activity_log`;

CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `activity_log` */

/*Table structure for table `cabang` */

DROP TABLE IF EXISTS `cabang`;

CREATE TABLE `cabang` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_cabang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cabang` */

insert  into `cabang`(`id`,`nama_cabang`,`lokasi`,`region`,`created_at`,`updated_at`) values 
(1,'Cabang Medan','Medan, Sumatera Utara','Sumatera','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(2,'Cabang Padang','Padang, Sumatera Barat','Sumatera','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(3,'Cabang Palembang','Palembang, Sumatera Selatan','Sumatera','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(4,'Cabang Lampung','Bandar Lampung, Lampung','Sumatera','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(5,'Cabang Jakarta','Jakarta Utara, DKI Jakarta','Jawa','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(6,'Cabang Cirebon','Cirebon, Jawa Barat','Jawa','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(7,'Cabang Pekalongan','Pekalongan, Jawa Tengah','Jawa','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(8,'Cabang Semarang','Semarang, Jawa Tengah','Jawa','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(9,'Cabang Surabaya','Surabaya, Jawa Timur','Jawa','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(10,'Cabang Denpasar','Denpasar, Bali','Bali & Nusa Tenggara','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(11,'Cabang Kupang','Kupang, Nusa Tenggara Timur','Bali & Nusa Tenggara','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(12,'Cabang Pontianak','Pontianak, Kalimantan Barat','Kalimantan','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(13,'Cabang Banjarmasin','Banjarmasin, Kalimantan Selatan','Kalimantan','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(14,'Cabang Balikpapan','Balikpapan, Kalimantan Timur','Kalimantan','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(15,'Cabang Makassar','Makassar, Sulawesi Selatan','Sulawesi','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(16,'Cabang Manado','Manado, Sulawesi Utara','Sulawesi','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(17,'Cabang Bitung','Bitung, Sulawesi Utara','Sulawesi','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(18,'Cabang Ambon','Ambon, Maluku','Maluku & Papua','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(19,'Cabang Ternate','Ternate, Maluku Utara','Maluku & Papua','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(20,'Cabang Sorong','Sorong, Papua Barat','Maluku & Papua','2026-08-31 12:08:04','2026-08-31 12:08:04');

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
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

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
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

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
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

/*Data for the table `jobs` */

/*Table structure for table `komoditi` */

DROP TABLE IF EXISTS `komoditi`;

CREATE TABLE `komoditi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('menunggu_approval','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_approval',
  `diusulkan_oleh` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `komoditi_nama_unique` (`nama`),
  KEY `komoditi_diusulkan_oleh_foreign` (`diusulkan_oleh`),
  KEY `komoditi_approved_by_foreign` (`approved_by`),
  CONSTRAINT `komoditi_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `komoditi_diusulkan_oleh_foreign` FOREIGN KEY (`diusulkan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `komoditi` */

insert  into `komoditi`(`id`,`nama`,`kategori`,`status`,`diusulkan_oleh`,`approved_by`,`created_at`,`updated_at`) values 
(1,'Kembung Kuring','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(2,'Tongkol','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(3,'Tenggiri','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(4,'Kakap Merah','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(5,'Kerapu','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(6,'Kakaktua','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(7,'Bawal','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(8,'Tuna Sirip Kuning','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(9,'Layang','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(10,'Selar','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(11,'Bandeng','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(12,'Cakalang','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(13,'Baronang','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(14,'Ekor Kuning','Ikan','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(15,'Udang Vaname','Udang','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(16,'Lobster','Udang','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(17,'Rajungan','Kepiting','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(18,'Kepiting Bakau','Kepiting','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(19,'Gurita','Cumi & Gurita','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(20,'Cumi-cumi','Cumi & Gurita','disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15');

/*Table structure for table `komoditi_size` */

DROP TABLE IF EXISTS `komoditi_size`;

CREATE TABLE `komoditi_size` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `komoditi_id` bigint unsigned NOT NULL,
  `nama_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int DEFAULT NULL,
  `status` enum('menunggu_approval','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_approval',
  `diusulkan_oleh` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `komoditi_size_komoditi_id_nama_size_unique` (`komoditi_id`,`nama_size`),
  KEY `komoditi_size_diusulkan_oleh_foreign` (`diusulkan_oleh`),
  KEY `komoditi_size_approved_by_foreign` (`approved_by`),
  CONSTRAINT `komoditi_size_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `komoditi_size_diusulkan_oleh_foreign` FOREIGN KEY (`diusulkan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `komoditi_size_komoditi_id_foreign` FOREIGN KEY (`komoditi_id`) REFERENCES `komoditi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `komoditi_size` */

insert  into `komoditi_size`(`id`,`komoditi_id`,`nama_size`,`urutan`,`status`,`diusulkan_oleh`,`approved_by`,`created_at`,`updated_at`) values 
(1,1,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(2,1,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(3,1,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(4,1,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(5,2,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(6,2,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(7,2,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(8,2,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(9,3,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(10,3,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(11,3,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(12,3,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(13,4,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(14,4,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(15,4,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(16,4,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(17,5,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(18,5,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(19,5,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(20,5,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(21,6,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(22,6,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(23,6,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(24,6,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(25,7,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(26,7,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(27,7,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(28,7,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(29,8,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(30,8,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(31,8,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(32,8,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(33,9,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(34,9,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(35,9,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(36,9,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(37,10,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(38,10,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(39,10,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(40,10,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(41,11,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(42,11,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(43,11,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(44,11,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(45,12,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(46,12,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(47,12,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(48,12,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(49,13,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(50,13,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(51,13,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(52,13,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(53,14,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(54,14,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(55,14,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(56,14,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(57,15,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(58,15,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(59,15,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(60,15,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(61,16,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(62,16,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(63,16,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(64,16,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(65,17,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(66,17,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(67,17,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(68,17,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(69,18,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(70,18,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(71,18,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(72,18,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(73,19,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(74,19,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(75,19,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(76,19,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(77,20,'1000UP',10,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(78,20,'500-1000',20,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(79,20,'300-500',30,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16'),
(80,20,'200-300',40,'disetujui',2,2,'2026-08-31 12:08:16','2026-08-31 12:08:16');

/*Table structure for table `match_suggestion` */

DROP TABLE IF EXISTS `match_suggestion`;

CREATE TABLE `match_suggestion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penawaran_id` bigint unsigned NOT NULL,
  `penawaran_rincian_id` bigint unsigned DEFAULT NULL,
  `permintaan_id` bigint unsigned NOT NULL,
  `permintaan_rincian_id` bigint unsigned DEFAULT NULL,
  `skor_matching` decimal(5,2) DEFAULT NULL,
  `status` enum('terbuka','dipilih') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'terbuka',
  `approved_by` bigint unsigned DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `match_suggestion_penawaran_id_foreign` (`penawaran_id`),
  KEY `match_suggestion_permintaan_id_foreign` (`permintaan_id`),
  KEY `match_suggestion_approved_by_foreign` (`approved_by`),
  KEY `match_suggestion_penawaran_rincian_id_foreign` (`penawaran_rincian_id`),
  KEY `match_suggestion_permintaan_rincian_id_foreign` (`permintaan_rincian_id`),
  CONSTRAINT `match_suggestion_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `match_suggestion_penawaran_id_foreign` FOREIGN KEY (`penawaran_id`) REFERENCES `penawaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `match_suggestion_penawaran_rincian_id_foreign` FOREIGN KEY (`penawaran_rincian_id`) REFERENCES `penawaran_rincian_size` (`id`) ON DELETE CASCADE,
  CONSTRAINT `match_suggestion_permintaan_id_foreign` FOREIGN KEY (`permintaan_id`) REFERENCES `permintaan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `match_suggestion_permintaan_rincian_id_foreign` FOREIGN KEY (`permintaan_rincian_id`) REFERENCES `permintaan_rincian_size` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `match_suggestion` */

/*Table structure for table `media` */

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `media` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_01_01_000001_create_cabang_table',1),
(5,'2025_01_01_000002_add_columns_to_users_table',1),
(6,'2025_01_01_000003_create_penawaran_table',1),
(7,'2025_01_01_000004_create_penawaran_detail_ekspor_table',1),
(8,'2025_01_01_000005_create_permintaan_table',1),
(9,'2025_01_01_000006_create_permintaan_detail_ekspor_table',1),
(10,'2025_01_01_000007_create_match_suggestion_table',1),
(11,'2025_03_01_000001_remove_volume_harga_columns',1),
(12,'2025_03_01_000002_create_penawaran_rincian_grade_table',1),
(13,'2025_03_01_000003_create_permintaan_rincian_grade_table',1),
(14,'2025_03_01_000004_add_rincian_columns_to_match_suggestion',1),
(15,'2025_03_02_000001_update_match_suggestion_status_enum',1),
(16,'2025_04_01_000001_create_komoditi_table',1),
(17,'2025_04_01_000002_replace_jenis_ikan_with_komoditi_id',1),
(18,'2025_05_01_000001_create_penawaran_biaya_hpp_table',1),
(19,'2025_06_01_000001_add_jenis_penawaran_to_penawaran_table',1),
(20,'2026_08_26_235647_create_permission_tables',1),
(21,'2026_08_26_235656_create_activity_log_table',1),
(22,'2026_08_26_235657_add_event_column_to_activity_log_table',1),
(23,'2026_08_26_235658_add_batch_uuid_column_to_activity_log_table',1),
(24,'2026_08_26_235707_create_media_table',1),
(25,'2026_08_27_000001_create_komoditi_size_table',1),
(26,'2026_08_27_000002_rename_penawaran_rincian_grade_to_size',1),
(27,'2026_08_27_000003_rename_permintaan_rincian_grade_to_size',1),
(28,'2026_08_27_000004_update_penawaran_permintaan_status_enum',1),
(29,'2026_08_27_000005_update_match_suggestion_status_enum_v2',1),
(30,'2026_08_27_000006_create_project_table',1),
(31,'2026_08_27_000007_create_project_catatan_table',1);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values 
(3,'App\\Models\\User',2),
(2,'App\\Models\\User',3),
(2,'App\\Models\\User',4),
(2,'App\\Models\\User',5),
(1,'App\\Models\\User',6),
(1,'App\\Models\\User',7),
(1,'App\\Models\\User',8),
(1,'App\\Models\\User',9),
(1,'App\\Models\\User',10),
(1,'App\\Models\\User',11),
(1,'App\\Models\\User',12),
(1,'App\\Models\\User',13),
(1,'App\\Models\\User',14),
(1,'App\\Models\\User',15),
(1,'App\\Models\\User',16),
(1,'App\\Models\\User',17),
(1,'App\\Models\\User',18),
(1,'App\\Models\\User',19),
(1,'App\\Models\\User',20),
(1,'App\\Models\\User',21),
(1,'App\\Models\\User',22),
(1,'App\\Models\\User',23),
(1,'App\\Models\\User',24),
(1,'App\\Models\\User',25),
(1,'App\\Models\\User',26),
(1,'App\\Models\\User',27),
(1,'App\\Models\\User',28),
(1,'App\\Models\\User',29),
(1,'App\\Models\\User',30),
(1,'App\\Models\\User',31),
(1,'App\\Models\\User',32),
(1,'App\\Models\\User',33);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `penawaran` */

DROP TABLE IF EXISTS `penawaran`;

CREATE TABLE `penawaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `komoditi_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('Ekspor','Lokal','Ekspor & Lokal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lokal',
  `jenis_penawaran` enum('Produksi Sendiri','Trading') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Produksi Sendiri',
  `kondisi_ikan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('tersedia','sedang_diproses','selesai','tutup') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penawaran_user_id_foreign` (`user_id`),
  KEY `penawaran_komoditi_id_foreign` (`komoditi_id`),
  CONSTRAINT `penawaran_komoditi_id_foreign` FOREIGN KEY (`komoditi_id`) REFERENCES `komoditi` (`id`) ON DELETE SET NULL,
  CONSTRAINT `penawaran_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran` */

/*Table structure for table `penawaran_biaya_hpp` */

DROP TABLE IF EXISTS `penawaran_biaya_hpp`;

CREATE TABLE `penawaran_biaya_hpp` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penawaran_id` bigint unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penawaran_biaya_hpp_penawaran_id_foreign` (`penawaran_id`),
  CONSTRAINT `penawaran_biaya_hpp_penawaran_id_foreign` FOREIGN KEY (`penawaran_id`) REFERENCES `penawaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran_biaya_hpp` */

/*Table structure for table `penawaran_detail_ekspor` */

DROP TABLE IF EXISTS `penawaran_detail_ekspor`;

CREATE TABLE `penawaran_detail_ekspor` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penawaran_id` bigint unsigned NOT NULL,
  `sertifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kontinuitas_suplai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negara_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penawaran_detail_ekspor_penawaran_id_foreign` (`penawaran_id`),
  CONSTRAINT `penawaran_detail_ekspor_penawaran_id_foreign` FOREIGN KEY (`penawaran_id`) REFERENCES `penawaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran_detail_ekspor` */

/*Table structure for table `penawaran_rincian_size` */

DROP TABLE IF EXISTS `penawaran_rincian_size`;

CREATE TABLE `penawaran_rincian_size` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penawaran_id` bigint unsigned NOT NULL,
  `komoditi_size_id` bigint unsigned DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `kuantiti` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penawaran_rincian_grade_penawaran_id_foreign` (`penawaran_id`),
  KEY `penawaran_rincian_size_komoditi_size_id_foreign` (`komoditi_size_id`),
  CONSTRAINT `penawaran_rincian_grade_penawaran_id_foreign` FOREIGN KEY (`penawaran_id`) REFERENCES `penawaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penawaran_rincian_size_komoditi_size_id_foreign` FOREIGN KEY (`komoditi_size_id`) REFERENCES `komoditi_size` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran_rincian_size` */

/*Table structure for table `permintaan` */

DROP TABLE IF EXISTS `permintaan`;

CREATE TABLE `permintaan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `komoditi_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('Ekspor','Lokal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lokal',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `prioritas_warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prioritas_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('tersedia','sedang_diproses','selesai','tutup') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permintaan_user_id_foreign` (`user_id`),
  KEY `permintaan_komoditi_id_foreign` (`komoditi_id`),
  CONSTRAINT `permintaan_komoditi_id_foreign` FOREIGN KEY (`komoditi_id`) REFERENCES `komoditi` (`id`) ON DELETE SET NULL,
  CONSTRAINT `permintaan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan` */

/*Table structure for table `permintaan_detail_ekspor` */

DROP TABLE IF EXISTS `permintaan_detail_ekspor`;

CREATE TABLE `permintaan_detail_ekspor` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permintaan_id` bigint unsigned NOT NULL,
  `sertifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kontinuitas_suplai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negara_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permintaan_detail_ekspor_permintaan_id_foreign` (`permintaan_id`),
  CONSTRAINT `permintaan_detail_ekspor_permintaan_id_foreign` FOREIGN KEY (`permintaan_id`) REFERENCES `permintaan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan_detail_ekspor` */

/*Table structure for table `permintaan_rincian_size` */

DROP TABLE IF EXISTS `permintaan_rincian_size`;

CREATE TABLE `permintaan_rincian_size` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permintaan_id` bigint unsigned NOT NULL,
  `komoditi_size_id` bigint unsigned DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `kuantiti` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permintaan_rincian_grade_permintaan_id_foreign` (`permintaan_id`),
  KEY `permintaan_rincian_size_komoditi_size_id_foreign` (`komoditi_size_id`),
  CONSTRAINT `permintaan_rincian_grade_permintaan_id_foreign` FOREIGN KEY (`permintaan_id`) REFERENCES `permintaan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permintaan_rincian_size_komoditi_size_id_foreign` FOREIGN KEY (`komoditi_size_id`) REFERENCES `komoditi_size` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan_rincian_size` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

/*Table structure for table `project` */

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `match_suggestion_id` bigint unsigned NOT NULL,
  `penawaran_id` bigint unsigned NOT NULL,
  `permintaan_id` bigint unsigned NOT NULL,
  `status` enum('sedang_diproses','selesai','tutup') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sedang_diproses',
  `dipilih_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_match_suggestion_id_unique` (`match_suggestion_id`),
  KEY `project_penawaran_id_foreign` (`penawaran_id`),
  KEY `project_permintaan_id_foreign` (`permintaan_id`),
  KEY `project_dipilih_oleh_foreign` (`dipilih_oleh`),
  CONSTRAINT `project_dipilih_oleh_foreign` FOREIGN KEY (`dipilih_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_match_suggestion_id_foreign` FOREIGN KEY (`match_suggestion_id`) REFERENCES `match_suggestion` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_penawaran_id_foreign` FOREIGN KEY (`penawaran_id`) REFERENCES `penawaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_permintaan_id_foreign` FOREIGN KEY (`permintaan_id`) REFERENCES `permintaan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project` */

/*Table structure for table `project_catatan` */

DROP TABLE IF EXISTS `project_catatan`;

CREATE TABLE `project_catatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `isi_catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_catatan_project_id_foreign` (`project_id`),
  KEY `project_catatan_user_id_foreign` (`user_id`),
  CONSTRAINT `project_catatan_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_catatan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_catatan` */

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values 
(1,'Cabang','web','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(2,'Pusat','web','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(3,'Admin','web','2026-08-31 12:08:04','2026-08-31 12:08:04');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
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

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('AyEOSo9siLujD5wcV5coM1wDeqJ71rkH4LrnmIOA',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ1ZEwxSzQ3Nk1Wc09TWENFaFRsdjFzRXhscTRMbHg5YnFrTVF6RFFWIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2ZwdC50ZXN0XC9jYWJhbmciLCJyb3V0ZSI6ImNhYmFuZy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1788179695);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_cabang_id_foreign` (`cabang_id`),
  CONSTRAINT `users_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`cabang_id`,`name`,`email`,`no_whatsapp`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,NULL,'Test User','test@example.com',NULL,'2026-08-31 12:08:04','$2y$12$WTFCUJ7cjjSTfy8AN3XRVO2X.gPLZ3JMwsTi0qOoBuIPf5vXSN8KS','2HaHnsbmfM','2026-08-31 12:08:04','2026-08-31 12:08:04'),
(2,NULL,'Admin Sistem','admin@fpt.test','08203910991',NULL,'$2y$12$TB.XW2N3mr6o.wWnJsDmNepoceU6pUKtK6iMQ2yc1J4D9MLn4RSX2',NULL,'2026-08-31 12:08:04','2026-08-31 12:08:04'),
(3,NULL,'Ramous Peppy','pusat1@fpt.test','08874747257',NULL,'$2y$12$k83NU8QB0687x9T61QTyTe/0xqfs0IikmNHQWo2K.Yc429oNiLoGq',NULL,'2026-08-31 12:08:05','2026-08-31 12:08:05'),
(4,NULL,'Robertto','pusat2@fpt.test','08617741804',NULL,'$2y$12$z0xDY2.SsO9S/Nr3aZ24MuDJ3aiS937fjDHm8YPybeJBLn61l/70e',NULL,'2026-08-31 12:08:05','2026-08-31 12:08:05'),
(5,NULL,'Muhammad Alpanda','pusat3@fpt.test','08881238800',NULL,'$2y$12$I4olmn5IN0NgaZMg8bnShewWsJM62EDbGd8Gm/5aOi4MUUkxSAZxS',NULL,'2026-08-31 12:08:05','2026-08-31 12:08:05'),
(6,1,'Lestari Handoko','cabang1_1@fpt.test','08167719882',NULL,'$2y$12$TZIXfFpLPK770BPhVaO0putszhIi.J3hU7sWnnuJtH5JKOMZvvFe6',NULL,'2026-08-31 12:08:06','2026-08-31 12:08:06'),
(7,2,'Joko Santoso','cabang2_1@fpt.test','08425137361',NULL,'$2y$12$/AvIkEyRHW/fgO..4WdRheXMVjmcYZMbRk3LX3dUQ3qo1M/a2QKFy',NULL,'2026-08-31 12:08:06','2026-08-31 12:08:06'),
(8,2,'Zainal Santoso','cabang2_2@fpt.test','08725311442',NULL,'$2y$12$cxESrg/HFy722V9FWXDnZOCdgoVYAzkDXhQrpPrMHmq0fZ2LJuPXG',NULL,'2026-08-31 12:08:06','2026-08-31 12:08:06'),
(9,3,'Joko Wijaya','cabang3_1@fpt.test','08546871146',NULL,'$2y$12$jBPXV01bJSTEhsAi6qLuRuFc7cleSaD.FIMPX/B1UsL8RsczB9wFy',NULL,'2026-08-31 12:08:06','2026-08-31 12:08:06'),
(10,4,'Fitri Nugroho','cabang4_1@fpt.test','08511972423',NULL,'$2y$12$Ofb6FxbwZ3D4dyDS4.g8qeCrUR8IVAYobfmmLh9zTJaE60bCtyJhi',NULL,'2026-08-31 12:08:07','2026-08-31 12:08:07'),
(11,4,'Dewi Permana','cabang4_2@fpt.test','08699090665',NULL,'$2y$12$6PHRMdnRQfyQf7R9mz8US.gvO2pyQEST10adiPSvmdOyW/wmj3k7K',NULL,'2026-08-31 12:08:07','2026-08-31 12:08:07'),
(12,5,'Dewi Wijaya','cabang5_1@fpt.test','08656343633',NULL,'$2y$12$unD9ouV9ac6TdPvQg51iGexGVQzljsX/V74QWVMwJMczaYYyWbd5O',NULL,'2026-08-31 12:08:07','2026-08-31 12:08:07'),
(13,5,'Umar Permana','cabang5_2@fpt.test','08351356332',NULL,'$2y$12$T.LQEDzDW8dSrTNwVA3eluHOAWo7v9tB62nz4M6Ant3A0MW8VzXPW',NULL,'2026-08-31 12:08:08','2026-08-31 12:08:08'),
(14,6,'Gunawan Utami','cabang6_1@fpt.test','08688456068',NULL,'$2y$12$mR59t.r.uZKImNHhzK21AeJ.Ju/2csgIuB.Hp3rhDV4yJ.88xDt3u',NULL,'2026-08-31 12:08:08','2026-08-31 12:08:08'),
(15,6,'Rahmat Santoso','cabang6_2@fpt.test','08338963663',NULL,'$2y$12$sxsZOwYZqnfr51IKPWPw4ufkafrdKupI6O5V8/iNDd4/J6ZJAdyIe',NULL,'2026-08-31 12:08:08','2026-08-31 12:08:08'),
(16,7,'Sari Siregar','cabang7_1@fpt.test','08302487830',NULL,'$2y$12$WQ3C90Ixcz4jnEWsxobho.J6Uf01uMrnlZ.Ql9yn5GY3kskUALb3C',NULL,'2026-08-31 12:08:09','2026-08-31 12:08:09'),
(17,7,'Taufik Pratama','cabang7_2@fpt.test','08237611115',NULL,'$2y$12$Fm6gN0TZOH9q9gnxbZAV/.296Tu6Teot8fmZdkpSGKE8uv2Yy9Emi',NULL,'2026-08-31 12:08:09','2026-08-31 12:08:09'),
(18,8,'Budi Utami','cabang8_1@fpt.test','08555198923',NULL,'$2y$12$3MwkXOOIygOFnuB1XyBN1u6cGR790h09dQa0v77dRqmSFRleBh1ly',NULL,'2026-08-31 12:08:09','2026-08-31 12:08:09'),
(19,8,'Kartika Nugroho','cabang8_2@fpt.test','08142131672',NULL,'$2y$12$4mTlus15W0ilXw9YZQhEM.ReGdZFcq4UNO8X55lj9UpGL/l4zsXTy',NULL,'2026-08-31 12:08:09','2026-08-31 12:08:09'),
(20,9,'Citra Utami','cabang9_1@fpt.test','08294238295',NULL,'$2y$12$ay6KssCWLgfY0KTglkwfWOTmYlcA2W2onhUFDwrvP109xdDFyj/R.',NULL,'2026-08-31 12:08:10','2026-08-31 12:08:10'),
(21,10,'Eko Siregar','cabang10_1@fpt.test','08338204998',NULL,'$2y$12$vzD.Ky8o5VrqMnCJwg3dmuIn5hd1ZiEbH.FuAB8QZ5toSuuJPJOYa',NULL,'2026-08-31 12:08:10','2026-08-31 12:08:10'),
(22,11,'Kartika Santoso','cabang11_1@fpt.test','08387874757',NULL,'$2y$12$rF9wXN9YtScFgwe0FppKXeETFvslKMzBmcaEI2CrUYlzBk.Rz26F6',NULL,'2026-08-31 12:08:10','2026-08-31 12:08:10'),
(23,12,'Sari Pratama','cabang12_1@fpt.test','08878856008',NULL,'$2y$12$d1aJay9tL4ETQcdk2.Udjesd6tNbsukUzsv4oGVGP34Rh1q31XEwm',NULL,'2026-08-31 12:08:11','2026-08-31 12:08:11'),
(24,13,'Yanto Wijaya','cabang13_1@fpt.test','08754660720',NULL,'$2y$12$K/ZDd8p0bMEZBBA/HGNzTOgEAuHLv3RvJ.8i16W46l48DGsIGPw8q',NULL,'2026-08-31 12:08:11','2026-08-31 12:08:11'),
(25,13,'Gunawan Saputra','cabang13_2@fpt.test','08767964319',NULL,'$2y$12$Xzs/cf2BzGvzJUSsO0bEPOW7GUl2LVRt3bDOoPONDBhMyWZWXPvri',NULL,'2026-08-31 12:08:12','2026-08-31 12:08:12'),
(26,14,'Vina Saputra','cabang14_1@fpt.test','08558057572',NULL,'$2y$12$L33pqd6kLx8v6bN3qnhp5egbo/2AzO0UkoHT3KwMUFWhl.eSUnIgi',NULL,'2026-08-31 12:08:12','2026-08-31 12:08:12'),
(27,15,'Fitri Pratama','cabang15_1@fpt.test','08521471291',NULL,'$2y$12$lyN1uX2PdIWQ39H7chm8WOTHRaidqShll8wuCAMVY0kFONhIMhsV.',NULL,'2026-08-31 12:08:13','2026-08-31 12:08:13'),
(28,15,'Yanto Handoko','cabang15_2@fpt.test','08229905016',NULL,'$2y$12$J3fHxeU73.Kjrus0EM1RXu7Uc0tkkrQCL.unn2Gi5HKVO2awRyuMS',NULL,'2026-08-31 12:08:13','2026-08-31 12:08:13'),
(29,16,'Umar Permana','cabang16_1@fpt.test','08665500857',NULL,'$2y$12$TsO841t7Uqd0PG3YsZ7XKe2FTbT1HlGrZ/zb5kBP5Yq54cgQRLkYq',NULL,'2026-08-31 12:08:13','2026-08-31 12:08:13'),
(30,17,'Budi Santoso','cabang17_1@fpt.test','08152413520',NULL,'$2y$12$Sid.QsLF4DTvWucvYKPAx.EGEOCVCcEsYKWnjfxeu5regk89e5.AW',NULL,'2026-08-31 12:08:14','2026-08-31 12:08:14'),
(31,18,'Nur Handoko','cabang18_1@fpt.test','08155873141',NULL,'$2y$12$3tW4d3.gqOE.iOtoqDQqyuTbF2PNZk.nw7OkgavStvuHM6ZSF84JG',NULL,'2026-08-31 12:08:14','2026-08-31 12:08:14'),
(32,19,'Fitri Pratama','cabang19_1@fpt.test','08243340329',NULL,'$2y$12$CdA.VlQD569xwdU.Uw9jV.xIgtWprSSJb6mt2AiG5IQoDb9A8phki',NULL,'2026-08-31 12:08:15','2026-08-31 12:08:15'),
(33,20,'Joko Wijaya','cabang20_1@fpt.test','08362993905',NULL,'$2y$12$hPgYdLZKpp9Xepq.C7u3BehAIyhDvtSDEfJCf1udvHqtMgQv.Q/um',NULL,'2026-08-31 12:08:15','2026-08-31 12:08:15');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
