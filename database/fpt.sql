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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `activity_log` */

insert  into `activity_log`(`id`,`log_name`,`description`,`subject_type`,`event`,`subject_id`,`causer_type`,`causer_id`,`properties`,`batch_uuid`,`created_at`,`updated_at`) values 
(1,'project','created','App\\Models\\Project','created',1,'App\\Models\\User',2,'{\"attributes\": {\"status\": \"sedang_diproses\", \"dipilih_oleh\": 2}}',NULL,'2026-09-05 16:30:15','2026-09-05 16:30:15'),
(2,'project','created','App\\Models\\Project','created',2,'App\\Models\\User',2,'{\"attributes\": {\"status\": \"sedang_diproses\", \"dipilih_oleh\": 2}}',NULL,'2026-09-06 00:57:06','2026-09-06 00:57:06'),
(3,'project','created','App\\Models\\Project','created',3,'App\\Models\\User',2,'{\"attributes\": {\"status\": \"sedang_diproses\", \"dipilih_oleh\": 2}}',NULL,'2026-09-06 01:26:57','2026-09-06 01:26:57'),
(4,'project','updated','App\\Models\\Project','updated',3,'App\\Models\\User',2,'{\"old\": {\"status\": \"sedang_diproses\"}, \"attributes\": {\"status\": \"tutup\"}}',NULL,'2026-09-06 03:17:38','2026-09-06 03:17:38');

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
(1,'Cabang Medan','Medan, Sumatera Utara','Sumatera','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(2,'Cabang Padang','Padang, Sumatera Barat','Sumatera','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(3,'Cabang Palembang','Palembang, Sumatera Selatan','Sumatera','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(4,'Cabang Lampung','Bandar Lampung, Lampung','Sumatera','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(5,'Cabang Jakarta','Jakarta Utara, DKI Jakarta','Jawa','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(6,'Cabang Cirebon','Cirebon, Jawa Barat','Jawa','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(7,'Cabang Pekalongan','Pekalongan, Jawa Tengah','Jawa','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(8,'Cabang Semarang','Semarang, Jawa Tengah','Jawa','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(9,'Cabang Surabaya','Surabaya, Jawa Timur','Jawa','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(10,'Cabang Denpasar','Denpasar, Bali','Bali & Nusa Tenggara','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(11,'Cabang Kupang','Kupang, Nusa Tenggara Timur','Bali & Nusa Tenggara','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(12,'Cabang Pontianak','Pontianak, Kalimantan Barat','Kalimantan','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(13,'Cabang Banjarmasin','Banjarmasin, Kalimantan Selatan','Kalimantan','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(14,'Cabang Balikpapan','Balikpapan, Kalimantan Timur','Kalimantan','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(15,'Cabang Makassar','Makassar, Sulawesi Selatan','Sulawesi','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(16,'Cabang Manado','Manado, Sulawesi Utara','Sulawesi','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(17,'Cabang Bitung','Bitung, Sulawesi Utara','Sulawesi','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(18,'Cabang Ambon','Ambon, Maluku','Maluku & Papua','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(19,'Cabang Ternate','Ternate, Maluku Utara','Maluku & Papua','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(20,'Cabang Sorong','Sorong, Papua Barat','Maluku & Papua','2026-09-04 10:21:13','2026-09-04 10:21:13');

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

insert  into `cache`(`key`,`value`,`expiration`) values 
('laravel-cache-cabang5_2@fpt.test|127.0.0.1','i:1;',1788625262),
('laravel-cache-cabang5_2@fpt.test|127.0.0.1:timer','i:1788625262;',1788625262);

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

/*Table structure for table `kategori_komoditi` */

DROP TABLE IF EXISTS `kategori_komoditi`;

CREATE TABLE `kategori_komoditi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_komoditi_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kategori_komoditi` */

insert  into `kategori_komoditi`(`id`,`nama`,`created_at`,`updated_at`) values 
(1,'Ikan','2026-09-04 10:21:25','2026-09-04 10:21:25'),
(2,'Udang','2026-09-04 10:21:25','2026-09-04 10:21:25'),
(3,'Kepiting','2026-09-04 10:21:25','2026-09-04 10:21:25'),
(4,'Cumi & Gurita','2026-09-04 10:21:25','2026-09-04 10:21:25'),
(5,'Belalang','2026-09-05 00:40:27','2026-09-05 00:40:27');

/*Table structure for table `komoditi` */

DROP TABLE IF EXISTS `komoditi`;

CREATE TABLE `komoditi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint unsigned DEFAULT NULL,
  `status` enum('menunggu_approval','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_approval',
  `diusulkan_oleh` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `komoditi_nama_unique` (`nama`),
  KEY `komoditi_diusulkan_oleh_foreign` (`diusulkan_oleh`),
  KEY `komoditi_approved_by_foreign` (`approved_by`),
  KEY `komoditi_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `komoditi_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `komoditi_diusulkan_oleh_foreign` FOREIGN KEY (`diusulkan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `komoditi_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_komoditi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `komoditi` */

insert  into `komoditi`(`id`,`nama`,`kategori_id`,`status`,`diusulkan_oleh`,`approved_by`,`created_at`,`updated_at`) values 
(1,'Kembung Kuring',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(2,'Tongkol',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(3,'Tenggiri',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(4,'Kakap Merah',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(5,'Kerapu',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(6,'Kakaktua',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(7,'Bawal',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(8,'Tuna Sirip Kuning',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(9,'Layang',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(10,'Selar',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(11,'Bandeng',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(12,'Cakalang',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(13,'Baronang',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(14,'Ekor Kuning',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(15,'Giant Trevally (GT)',1,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(16,'Udang Vaname',2,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(17,'Lobster',2,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(18,'Rajungan',3,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(19,'Kepiting Bakau',3,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(20,'Gurita',4,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(21,'Cumi-cumi',4,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(22,'apa ini cok',5,'disetujui',2,2,'2026-09-05 00:40:50','2026-09-05 00:40:50'),
(23,'Saputra',3,'disetujui',13,2,'2026-09-05 16:23:58','2026-09-05 16:26:41'),
(24,'kita',1,'disetujui',13,2,'2026-09-05 16:24:34','2026-09-05 16:26:31'),
(25,'Sendiri',4,'disetujui',13,2,'2026-09-05 16:26:04','2026-09-05 16:26:21');

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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `komoditi_size` */

insert  into `komoditi_size`(`id`,`komoditi_id`,`nama_size`,`urutan`,`status`,`diusulkan_oleh`,`approved_by`,`created_at`,`updated_at`) values 
(1,1,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(2,1,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(3,1,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(4,1,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(5,2,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(6,2,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(7,2,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(8,2,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(9,3,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(10,3,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(11,3,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(12,3,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(13,4,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(14,4,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(15,4,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(16,4,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(17,5,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(18,5,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(19,5,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(20,5,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(21,6,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(22,6,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(23,6,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(24,6,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(25,7,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(26,7,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(27,7,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(28,7,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(29,8,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(30,8,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(31,8,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(32,8,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(33,9,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(34,9,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(35,9,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(36,9,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(37,10,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(38,10,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(39,10,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(40,10,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(41,11,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(42,11,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(43,11,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(44,11,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(45,12,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(46,12,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(47,12,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(48,12,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(49,13,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(50,13,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(51,13,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(52,13,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(53,14,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(54,14,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(55,14,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(56,14,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(57,15,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(58,15,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(59,15,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(60,15,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(61,16,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(62,16,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(63,16,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(64,16,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(65,17,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(66,17,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(67,17,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(68,17,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(69,18,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(70,18,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(71,18,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(72,18,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(73,19,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(74,19,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(75,19,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(76,19,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(77,20,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(78,20,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(79,20,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(80,20,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(81,21,'1000UP',10,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(82,21,'500-1000',20,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(83,21,'300-500',30,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(84,21,'200-300',40,'disetujui',2,2,'2026-09-04 10:21:26','2026-09-04 10:21:26');

/*Table structure for table `komoditi_tag` */

DROP TABLE IF EXISTS `komoditi_tag`;

CREATE TABLE `komoditi_tag` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `komoditi_id` bigint unsigned NOT NULL,
  `nama_tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ditambahkan_oleh` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `komoditi_tag_komoditi_id_nama_tag_unique` (`komoditi_id`,`nama_tag`),
  KEY `komoditi_tag_ditambahkan_oleh_foreign` (`ditambahkan_oleh`),
  CONSTRAINT `komoditi_tag_ditambahkan_oleh_foreign` FOREIGN KEY (`ditambahkan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `komoditi_tag_komoditi_id_foreign` FOREIGN KEY (`komoditi_id`) REFERENCES `komoditi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `komoditi_tag` */

insert  into `komoditi_tag`(`id`,`komoditi_id`,`nama_tag`,`ditambahkan_oleh`,`created_at`,`updated_at`) values 
(1,6,'Ikan Bebek',2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(2,15,'Ikan Gabui',2,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(3,15,'Ikan Kuwe',2,'2026-09-04 10:21:25','2026-09-04 10:21:25');

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
) ENGINE=InnoDB AUTO_INCREMENT=305 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `match_suggestion` */

insert  into `match_suggestion`(`id`,`penawaran_id`,`penawaran_rincian_id`,`permintaan_id`,`permintaan_rincian_id`,`skor_matching`,`status`,`approved_by`,`catatan`,`created_at`,`updated_at`) values 
(1,1,1,49,100,89.29,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(2,1,1,85,169,89.03,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(3,2,3,32,64,77.10,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(4,2,4,24,47,87.10,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(5,2,4,32,65,83.93,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(6,4,6,25,49,82.62,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(7,4,6,86,171,73.80,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(8,4,7,2,3,95.75,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(9,4,8,6,10,73.45,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(10,4,8,25,50,91.17,'terbuka',NULL,NULL,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(11,5,9,8,13,78.57,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(12,5,9,20,38,85.21,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(13,5,9,56,111,99.17,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(14,5,9,75,150,79.36,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(15,5,11,8,14,78.55,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(16,5,11,19,37,95.55,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(17,5,11,36,73,72.81,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(18,5,11,56,113,85.75,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(19,5,11,75,151,88.92,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(20,6,12,30,59,96.20,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(21,6,12,84,167,92.09,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(22,6,13,15,25,91.00,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(23,6,14,15,26,71.30,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(24,6,14,30,61,91.08,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(25,6,14,52,106,89.88,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(26,7,16,50,103,90.68,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(27,10,21,59,120,93.84,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(28,10,21,87,174,84.36,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(29,11,22,30,59,85.11,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(30,11,22,84,167,87.92,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(31,11,23,15,25,71.73,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(32,12,24,77,154,96.72,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(33,12,25,29,57,82.63,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(34,12,25,77,155,96.19,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(35,12,26,29,58,75.72,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(36,13,27,50,102,87.28,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(37,13,28,50,103,88.31,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(38,14,30,6,10,87.10,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(39,14,30,25,50,72.79,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(40,15,31,38,77,85.81,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(41,15,31,72,146,98.01,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(42,16,32,71,143,92.08,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(43,16,33,71,144,71.71,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(44,16,34,71,145,83.35,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(45,17,35,99,190,93.57,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(46,17,36,13,22,95.91,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(47,17,36,39,80,74.91,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(48,18,38,11,19,91.46,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(49,18,38,17,30,71.75,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(50,18,38,51,104,98.07,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(51,18,39,11,20,93.39,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(52,18,39,17,31,84.64,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(53,18,39,35,69,83.44,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(54,18,39,51,105,91.18,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(55,19,40,11,19,95.19,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(56,19,40,17,30,72.06,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(57,19,40,51,104,93.91,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(58,19,41,11,20,96.71,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(59,19,41,17,31,86.71,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(60,19,41,35,69,85.35,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(61,19,41,51,105,94.19,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(62,19,42,12,21,87.54,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(63,19,42,17,32,92.11,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(64,19,42,35,71,80.92,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(65,20,43,15,24,90.12,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(66,20,43,30,60,82.83,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(67,20,43,84,168,94.79,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(68,20,44,15,25,71.80,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(69,20,45,15,26,73.31,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(70,20,45,30,61,86.75,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(71,21,46,90,178,83.56,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(72,23,48,29,56,71.92,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(73,23,49,29,57,93.17,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(74,23,49,77,155,84.27,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(75,24,50,10,16,74.84,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(76,24,51,3,4,74.58,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(77,24,51,10,17,83.84,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(78,24,51,42,84,76.93,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(79,24,51,82,164,98.14,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(80,24,52,10,18,73.94,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(81,26,55,40,81,96.58,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(82,26,55,66,135,97.51,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(83,26,56,7,11,79.64,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(84,26,56,26,51,71.44,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(85,26,56,46,93,77.73,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(86,26,56,66,136,88.84,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(87,26,57,40,82,86.26,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(88,27,58,22,43,94.98,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(89,28,59,1,1,76.75,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(90,28,59,44,87,74.60,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(91,28,60,1,2,81.71,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(92,28,60,43,86,78.19,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(93,28,60,62,129,98.55,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(94,28,60,69,140,90.43,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(95,29,61,50,102,94.52,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(96,29,62,50,103,95.33,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(97,30,64,37,74,84.93,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(98,30,65,37,76,88.58,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(99,30,65,81,162,88.34,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(100,30,66,9,15,81.67,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(101,30,66,81,163,84.34,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(102,31,67,93,181,87.98,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(103,32,68,4,6,76.88,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(104,32,68,27,54,87.12,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(105,32,69,4,7,95.98,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(106,32,69,18,35,73.94,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(107,32,69,60,123,87.76,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(108,33,70,4,6,89.35,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(109,33,70,27,54,77.77,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(110,33,70,34,68,85.72,'terbuka',NULL,NULL,'2026-09-04 10:21:29','2026-09-04 10:21:29'),
(111,34,71,3,4,72.13,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(112,34,71,10,17,99.71,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(113,34,71,42,84,73.23,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(114,34,71,82,164,83.11,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(115,34,72,10,18,74.56,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(116,34,73,58,117,76.52,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(117,34,73,82,165,74.35,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(118,36,77,54,109,82.98,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(119,36,77,79,157,81.82,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(120,36,79,79,158,93.01,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(121,38,83,10,16,75.09,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(122,38,84,3,4,79.97,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(123,38,84,10,17,76.36,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(124,38,85,10,18,74.15,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(125,39,86,4,5,79.12,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(126,39,86,18,33,77.06,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(127,39,86,27,53,98.28,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(128,39,86,60,121,77.79,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(129,40,87,16,28,92.44,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(130,40,87,48,96,97.51,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(131,40,87,89,176,92.25,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(132,41,88,24,46,75.60,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(133,43,90,82,164,91.26,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(134,43,92,82,165,90.31,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(135,44,93,57,114,74.87,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(136,44,93,91,179,82.04,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(137,44,94,57,115,98.74,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(138,45,96,30,59,82.27,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(139,45,96,84,167,84.56,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(140,45,97,15,26,71.78,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(141,45,97,30,61,98.97,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(142,45,97,52,106,97.32,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(143,46,98,4,7,84.68,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(144,46,98,18,35,72.23,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(145,46,98,60,123,80.04,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(146,47,99,98,187,95.35,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(147,47,100,97,186,74.07,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(148,47,100,98,188,90.15,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(149,47,101,98,189,90.43,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(150,48,102,64,131,86.68,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(151,48,102,67,137,96.93,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(152,48,102,92,180,89.65,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(153,48,103,64,132,87.68,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(154,49,105,30,59,72.54,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(155,49,105,84,167,73.01,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(156,49,106,15,24,87.02,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(157,49,106,30,60,96.69,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(158,49,106,84,168,83.81,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(159,49,107,15,26,72.40,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(160,49,107,30,61,93.10,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(161,49,107,52,106,94.49,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(162,51,109,97,186,94.93,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(163,51,109,98,188,77.29,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(164,51,110,98,189,71.76,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(165,52,112,41,83,76.42,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(166,54,116,1,2,76.56,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(167,54,116,69,140,94.68,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(168,55,117,32,64,74.89,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(169,56,119,53,107,74.82,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(170,58,121,29,56,85.66,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(171,58,122,77,154,79.29,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(172,58,123,29,58,72.97,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(173,59,124,10,16,74.47,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(174,59,125,10,17,95.69,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(175,59,125,42,84,73.73,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(176,59,126,58,117,99.19,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(177,60,127,59,118,81.65,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(178,60,128,59,120,80.46,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(179,60,128,87,174,76.30,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(180,61,129,59,118,97.01,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(181,62,131,7,12,71.03,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(182,62,131,26,52,75.19,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(183,62,131,46,94,93.97,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(184,63,132,62,128,98.55,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(185,64,133,14,23,82.91,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(186,64,133,24,45,81.13,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(187,64,134,24,47,89.15,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(188,64,134,32,65,93.51,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(189,65,135,29,56,74.59,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(190,65,136,29,57,77.65,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(191,65,136,77,155,90.82,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(192,65,137,29,58,74.27,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(193,65,137,94,183,96.51,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(194,66,138,97,186,74.53,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(195,66,138,98,188,92.44,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(196,66,139,98,189,81.40,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(197,67,140,16,27,89.09,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(198,67,140,90,177,79.51,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(199,67,141,16,29,96.73,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(200,67,141,48,97,87.79,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(201,67,141,90,178,93.64,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(202,68,142,11,20,93.24,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(203,68,142,17,31,84.54,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(204,68,142,35,69,83.35,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(205,68,142,51,105,91.04,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(206,68,143,12,21,77.97,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(207,68,143,17,32,80.05,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(208,68,143,35,71,74.96,'terbuka',NULL,NULL,'2026-09-04 10:21:30','2026-09-04 10:21:30'),
(209,69,144,32,64,79.61,'dipilih',NULL,NULL,'2026-09-04 10:21:31','2026-09-05 16:30:15'),
(210,69,145,24,46,78.03,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(211,69,146,24,47,79.13,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(212,69,146,32,65,77.43,'dipilih',NULL,NULL,'2026-09-04 10:21:31','2026-09-05 16:30:15'),
(213,70,147,82,164,84.64,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(214,71,149,37,74,85.97,'dipilih',NULL,NULL,'2026-09-04 10:21:31','2026-09-06 00:57:06'),
(215,71,149,59,118,89.68,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(216,71,150,37,76,76.24,'dipilih',NULL,NULL,'2026-09-04 10:21:31','2026-09-06 00:57:06'),
(217,71,150,81,162,76.33,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(218,71,150,83,166,74.47,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(219,71,150,87,173,78.74,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(220,71,151,9,15,94.83,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(221,71,151,59,120,80.59,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(222,71,151,81,163,74.62,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(223,71,151,87,174,76.38,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(224,72,152,40,82,75.60,'dipilih',NULL,NULL,'2026-09-04 10:21:31','2026-09-06 01:26:57'),
(225,73,153,22,43,87.34,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(226,75,156,8,13,98.90,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(227,75,156,20,38,86.28,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(228,75,156,56,111,78.49,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(229,75,156,75,150,96.46,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(230,75,157,19,36,79.35,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(231,75,157,36,72,99.06,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(232,75,157,56,112,80.05,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(233,75,158,8,14,94.78,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(234,75,158,19,37,82.15,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(235,75,158,36,73,78.16,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(236,75,158,56,113,89.72,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(237,75,158,75,151,86.41,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(238,76,160,76,152,90.54,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(239,76,161,73,148,99.54,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(240,77,162,76,153,97.74,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(241,77,163,73,148,89.47,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(242,78,164,25,49,75.61,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(243,78,164,86,171,88.63,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(244,78,165,25,50,74.64,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(245,81,169,43,85,77.56,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(246,81,169,62,127,77.06,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(247,81,170,62,128,89.42,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(248,82,171,82,164,99.29,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(249,82,172,82,165,94.06,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(250,84,176,11,19,82.64,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(251,84,176,17,30,75.81,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(252,84,177,11,20,99.10,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(253,84,177,17,31,88.20,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(254,84,177,35,69,86.72,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(255,84,178,28,55,86.47,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(256,84,178,35,70,88.50,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(257,85,179,9,15,99.72,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(258,85,179,81,163,75.63,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(259,86,180,17,30,74.32,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(260,86,180,51,104,81.37,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(261,86,181,28,55,79.06,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(262,86,181,35,70,78.07,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(263,88,183,45,90,85.16,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(264,88,184,45,91,78.49,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(265,88,184,61,124,73.86,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(266,88,184,100,191,92.82,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(267,88,185,23,44,72.53,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(268,88,185,61,126,84.52,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(269,88,185,74,149,78.88,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(270,88,185,100,193,89.68,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(271,90,188,50,102,95.63,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(272,90,189,50,103,97.89,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(273,91,190,71,145,90.61,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(274,92,191,97,186,76.32,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(275,92,191,98,188,98.77,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(276,93,193,83,166,71.61,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(277,93,193,87,173,73.15,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(278,93,194,59,120,80.87,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(279,93,194,87,174,88.05,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(280,94,195,8,13,97.93,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(281,94,195,20,38,85.74,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(282,94,195,56,111,78.20,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(283,94,195,75,150,95.58,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(284,94,197,8,14,82.21,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(285,94,197,19,37,94.67,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(286,94,197,36,73,74.02,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(287,94,197,56,113,92.49,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(288,94,197,75,151,97.02,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(289,95,198,94,182,72.25,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(290,95,200,94,183,84.55,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(291,96,201,16,27,97.22,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(292,96,202,16,28,89.58,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(293,96,202,48,96,98.55,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(294,96,202,89,176,89.41,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(295,97,203,57,116,92.52,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(296,97,203,96,185,80.87,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(297,98,204,77,154,82.56,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(298,98,204,94,182,72.44,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(299,99,206,63,130,92.91,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(300,100,207,59,118,89.69,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(301,100,208,83,166,75.97,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(302,100,208,87,173,81.68,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(303,100,209,59,120,98.79,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31'),
(304,100,209,87,174,87.34,'terbuka',NULL,NULL,'2026-09-04 10:21:31','2026-09-04 10:21:31');

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(31,'2026_08_27_000007_create_project_catatan_table',1),
(32,'2026_09_04_000001_create_kategori_komoditi_table',1),
(33,'2026_09_04_000002_migrate_komoditi_kategori_to_fk',1),
(34,'2026_09_04_000003_create_komoditi_tag_table',1);

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
(1,'App\\Models\\User',31);

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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran` */

insert  into `penawaran`(`id`,`user_id`,`komoditi_id`,`judul`,`tipe`,`jenis_penawaran`,`kondisi_ikan`,`keterangan`,`status`,`created_at`,`updated_at`) values 
(1,28,7,'Surplus Bawal - Cabang Bitung','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(2,14,14,'Surplus Ekor Kuning - Cabang Cirebon','Ekspor & Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(3,27,7,'Surplus Bawal - Cabang Bitung','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(4,9,17,'Surplus Lobster - Cabang Padang','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(5,18,2,'Surplus Tongkol - Cabang Surabaya','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(6,6,18,'Surplus Rajungan - Cabang Medan','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(7,7,3,'Surplus Tenggiri - Cabang Medan','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(8,21,3,'Surplus Tenggiri - Cabang Kupang','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(9,12,3,'Surplus Tenggiri - Cabang Lampung','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(10,9,20,'Surplus Gurita - Cabang Padang','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(11,29,18,'Surplus Rajungan - Cabang Ambon','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(12,10,1,'Surplus Kembung Kuring - Cabang Palembang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(13,6,3,'Surplus Tenggiri - Cabang Medan','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(14,27,17,'Surplus Lobster - Cabang Bitung','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(15,28,2,'Surplus Tongkol - Cabang Bitung','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(16,29,4,'Surplus Kakap Merah - Cabang Ambon','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(17,11,10,'Surplus Selar - Cabang Palembang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(18,20,15,'Surplus Giant Trevally (GT) - Cabang Denpasar','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(19,22,15,'Surplus Giant Trevally (GT) - Cabang Pontianak','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(20,20,18,'Surplus Rajungan - Cabang Denpasar','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(21,17,16,'Surplus Udang Vaname - Cabang Semarang','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(22,25,5,'Surplus Kerapu - Cabang Makassar','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(23,18,1,'Surplus Kembung Kuring - Cabang Surabaya','Ekspor & Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(24,8,19,'Surplus Kepiting Bakau - Cabang Padang','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(25,7,11,'Surplus Bandeng - Cabang Medan','Ekspor','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(26,20,4,'Surplus Kakap Merah - Cabang Denpasar','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(27,8,12,'Surplus Cakalang - Cabang Padang','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(28,17,6,'Surplus Kakaktua - Cabang Semarang','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(29,6,3,'Surplus Tenggiri - Cabang Medan','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(30,24,20,'Surplus Gurita - Cabang Balikpapan','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(31,9,8,'Surplus Tuna Sirip Kuning - Cabang Padang','Ekspor','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(32,9,5,'Surplus Kerapu - Cabang Padang','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(33,30,5,'Surplus Kerapu - Cabang Ternate','Ekspor & Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(34,21,19,'Surplus Kepiting Bakau - Cabang Kupang','Ekspor & Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(35,22,3,'Surplus Tenggiri - Cabang Pontianak','Ekspor','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(36,21,12,'Surplus Cakalang - Cabang Kupang','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(37,10,9,'Surplus Layang - Cabang Palembang','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(38,30,19,'Surplus Kepiting Bakau - Cabang Ternate','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(39,29,5,'Surplus Kerapu - Cabang Ambon','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(40,29,16,'Surplus Udang Vaname - Cabang Ambon','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(41,29,14,'Surplus Ekor Kuning - Cabang Ambon','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(42,27,7,'Surplus Bawal - Cabang Bitung','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(43,28,19,'Surplus Kepiting Bakau - Cabang Bitung','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(44,14,13,'Surplus Baronang - Cabang Cirebon','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(45,10,18,'Surplus Rajungan - Cabang Palembang','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(46,9,5,'Surplus Kerapu - Cabang Padang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(47,13,8,'Surplus Tuna Sirip Kuning - Cabang Jakarta','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(48,7,21,'Surplus Cumi-cumi - Cabang Medan','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(49,24,18,'Surplus Rajungan - Cabang Balikpapan','Ekspor & Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(50,10,19,'Surplus Kepiting Bakau - Cabang Palembang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(51,27,8,'Surplus Tuna Sirip Kuning - Cabang Bitung','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(52,23,9,'Surplus Layang - Cabang Banjarmasin','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(53,8,12,'Surplus Cakalang - Cabang Padang','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(54,23,6,'Surplus Kakaktua - Cabang Banjarmasin','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(55,24,14,'Surplus Ekor Kuning - Cabang Balikpapan','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(56,26,9,'Surplus Layang - Cabang Manado','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(57,17,1,'Surplus Kembung Kuring - Cabang Semarang','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(58,13,1,'Surplus Kembung Kuring - Cabang Jakarta','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(59,18,19,'Surplus Kepiting Bakau - Cabang Surabaya','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(60,8,20,'Surplus Gurita - Cabang Padang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(61,17,20,'Surplus Gurita - Cabang Semarang','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(62,17,4,'Surplus Kakap Merah - Cabang Semarang','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(63,31,6,'Surplus Kakaktua - Cabang Sorong','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(64,19,14,'Surplus Ekor Kuning - Cabang Surabaya','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(65,7,1,'Surplus Kembung Kuring - Cabang Medan','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(66,25,8,'Surplus Tuna Sirip Kuning - Cabang Makassar','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(67,13,16,'Surplus Udang Vaname - Cabang Jakarta','Ekspor & Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(68,30,15,'Surplus Giant Trevally (GT) - Cabang Ternate','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(69,28,14,'Surplus Ekor Kuning - Cabang Bitung','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','sedang_diproses','2026-09-04 10:21:27','2026-09-05 16:30:15'),
(70,28,19,'Surplus Kepiting Bakau - Cabang Bitung','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(71,25,20,'Surplus Gurita - Cabang Makassar','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','sedang_diproses','2026-09-04 10:21:27','2026-09-06 00:57:06'),
(72,21,4,'Surplus Kakap Merah - Cabang Kupang','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','sedang_diproses','2026-09-04 10:21:27','2026-09-06 01:26:57'),
(73,9,12,'Surplus Cakalang - Cabang Padang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(74,26,18,'Surplus Rajungan - Cabang Manado','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(75,14,2,'Surplus Tongkol - Cabang Cirebon','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(76,12,13,'Surplus Baronang - Cabang Lampung','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(77,11,13,'Surplus Baronang - Cabang Palembang','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(78,17,17,'Surplus Lobster - Cabang Semarang','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(79,16,3,'Surplus Tenggiri - Cabang Semarang','Ekspor & Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(80,8,7,'Surplus Bawal - Cabang Padang','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(81,27,6,'Surplus Kakaktua - Cabang Bitung','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(82,18,19,'Surplus Kepiting Bakau - Cabang Surabaya','Ekspor','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(83,23,18,'Surplus Rajungan - Cabang Banjarmasin','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(84,15,15,'Surplus Giant Trevally (GT) - Cabang Pekalongan','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(85,29,20,'Surplus Gurita - Cabang Ambon','Ekspor','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(86,9,15,'Surplus Giant Trevally (GT) - Cabang Padang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(87,6,21,'Surplus Cumi-cumi - Cabang Medan','Ekspor','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(88,10,11,'Surplus Bandeng - Cabang Palembang','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(89,8,11,'Surplus Bandeng - Cabang Padang','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(90,20,3,'Surplus Tenggiri - Cabang Denpasar','Ekspor & Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(91,19,4,'Surplus Kakap Merah - Cabang Surabaya','Ekspor','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(92,27,8,'Surplus Tuna Sirip Kuning - Cabang Bitung','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(93,21,20,'Surplus Gurita - Cabang Kupang','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(94,16,2,'Surplus Tongkol - Cabang Semarang','Lokal','Produksi Sendiri','Segar','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(95,6,1,'Surplus Kembung Kuring - Cabang Medan','Ekspor','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(96,28,16,'Surplus Udang Vaname - Cabang Bitung','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(97,24,13,'Surplus Baronang - Cabang Balikpapan','Lokal','Produksi Sendiri','Beku - Cold Storage','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(98,31,1,'Surplus Kembung Kuring - Cabang Sorong','Ekspor & Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(99,11,9,'Surplus Layang - Cabang Palembang','Lokal','Produksi Sendiri','Segar - Baru Ditangkap','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(100,26,20,'Surplus Gurita - Cabang Manado','Lokal','Produksi Sendiri','Beku','Stok surplus musim panen, kualitas baik.','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27');

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran_detail_ekspor` */

insert  into `penawaran_detail_ekspor`(`id`,`penawaran_id`,`sertifikasi`,`kontinuitas_suplai`,`negara_tujuan`,`created_at`,`updated_at`) values 
(1,2,'HACCP','Musiman, tergantung hasil tangkapan','Singapura','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(2,3,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','Singapura','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(3,6,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','Uni Eropa','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(4,8,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','Uni Eropa','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(5,9,'HACCP + MSC','Musiman, tergantung hasil tangkapan','China','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(6,15,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','China','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(7,16,NULL,'Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(8,21,NULL,'Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(9,22,'BRC','Musiman, tergantung hasil tangkapan','Korea Selatan','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(10,23,NULL,'Musiman, tergantung hasil tangkapan','Uni Eropa','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(11,24,NULL,'Rutin 2 minggu sekali','Amerika Serikat','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(12,25,'MSC','Musiman, tergantung hasil tangkapan','Singapura','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(13,28,'MSC','Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(14,30,'HACCP','Bisa kontinu jika ada kepastian pembeli','Korea Selatan','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(15,31,'HACCP','Bisa kontinu jika ada kepastian pembeli','Korea Selatan','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(16,33,'HACCP + MSC','Bisa kontinu jika ada kepastian pembeli','Singapura','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(17,34,NULL,'Musiman, tergantung hasil tangkapan','Jepang','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(18,35,NULL,'Musiman, tergantung hasil tangkapan','Jepang','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(19,36,'HACCP + MSC','Musiman, tergantung hasil tangkapan','Amerika Serikat','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(20,37,'BRC','Rutin tiap minggu, kapasitas stabil','Singapura','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(21,43,'HACCP + MSC','Musiman, tergantung hasil tangkapan','Malaysia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(22,49,'BRC','Rutin tiap minggu, kapasitas stabil','Malaysia','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(23,52,'BRC','Musiman, tergantung hasil tangkapan','Uni Eropa','2026-09-04 10:21:26','2026-09-04 10:21:26'),
(24,53,'BRC','Rutin 2 minggu sekali','Amerika Serikat','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(25,57,'HACCP + MSC','Rutin 2 minggu sekali','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(26,61,'HACCP','Rutin 2 minggu sekali','Uni Eropa','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(27,63,'HACCP','Rutin 2 minggu sekali','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(28,65,'BRC','Musiman, tergantung hasil tangkapan','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(29,67,'HACCP','Musiman, tergantung hasil tangkapan','Uni Eropa','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(30,68,'MSC','Rutin tiap minggu, kapasitas stabil','Amerika Serikat','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(31,70,'BRC','Rutin 2 minggu sekali','China','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(32,71,'BRC','Rutin tiap minggu, kapasitas stabil','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(33,74,NULL,'Rutin tiap minggu, kapasitas stabil','Uni Eropa','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(34,76,NULL,'Rutin tiap minggu, kapasitas stabil','Uni Eropa','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(35,77,'MSC','Rutin 2 minggu sekali','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(36,79,'HACCP + MSC','Musiman, tergantung hasil tangkapan','China','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(37,80,'HACCP','Musiman, tergantung hasil tangkapan','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(38,81,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','China','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(39,82,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','Korea Selatan','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(40,83,NULL,'Musiman, tergantung hasil tangkapan','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(41,85,'BRC','Rutin 2 minggu sekali','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(42,87,'HACCP','Bisa kontinu jika ada kepastian pembeli','China','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(43,89,'MSC','Musiman, tergantung hasil tangkapan','Korea Selatan','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(44,90,NULL,'Rutin tiap minggu, kapasitas stabil','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(45,91,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','Singapura','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(46,95,'BRC','Rutin tiap minggu, kapasitas stabil','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(47,98,NULL,'Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27');

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
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penawaran_rincian_size` */

insert  into `penawaran_rincian_size`(`id`,`penawaran_id`,`komoditi_size_id`,`harga`,`kuantiti`,`created_at`,`updated_at`) values 
(1,1,26,101000.00,607.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(2,1,28,81000.00,1982.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(3,2,54,120000.00,1132.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(4,2,56,100000.00,626.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(5,3,26,73000.00,1736.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(6,4,66,88000.00,98.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(7,4,67,68000.00,1313.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(8,4,68,48000.00,127.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(9,5,5,66000.00,1523.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(10,5,7,46000.00,1384.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(11,5,8,26000.00,1684.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(12,6,69,105000.00,1612.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(13,6,71,85000.00,150.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(14,6,72,65000.00,1479.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(15,7,10,86000.00,279.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(16,7,11,66000.00,1487.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(17,8,10,99000.00,682.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(18,8,12,79000.00,1900.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(19,9,9,120000.00,798.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(20,9,11,100000.00,549.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(21,10,80,113000.00,750.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(22,11,69,72000.00,709.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(23,11,71,52000.00,1823.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(24,12,2,111000.00,537.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(25,12,3,91000.00,556.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(26,12,4,71000.00,635.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(27,13,9,73000.00,814.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(28,13,11,53000.00,1679.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(29,13,12,33000.00,410.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(30,14,68,103000.00,1935.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(31,15,5,108000.00,632.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(32,16,13,107000.00,1507.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(33,16,14,87000.00,52.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(34,16,15,67000.00,1544.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(35,17,37,84000.00,1376.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(36,17,38,64000.00,477.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(37,17,40,44000.00,383.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(38,18,57,66000.00,1370.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(39,18,58,46000.00,1031.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(40,19,57,87000.00,1167.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(41,19,58,67000.00,903.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(42,19,60,47000.00,852.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(43,20,70,96000.00,1803.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(44,20,71,76000.00,1748.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(45,20,72,56000.00,580.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(46,21,63,75000.00,610.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(47,22,17,78000.00,595.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(48,23,1,112000.00,79.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(49,23,3,92000.00,303.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(50,24,73,60000.00,1642.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(51,24,74,40000.00,662.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(52,24,75,20000.00,1843.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(53,25,41,114000.00,1059.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(54,25,43,94000.00,209.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(55,26,13,111000.00,1017.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(56,26,14,91000.00,1460.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(57,26,15,71000.00,487.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(58,27,48,88000.00,890.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(59,28,21,87000.00,226.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(60,28,24,67000.00,1007.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(61,29,9,83000.00,1155.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(62,29,11,63000.00,1214.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(63,29,12,43000.00,1551.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(64,30,77,100000.00,1965.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(65,30,79,80000.00,1590.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(66,30,80,60000.00,544.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(67,31,31,89000.00,483.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(68,32,18,106000.00,1400.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(69,32,20,86000.00,1059.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(70,33,18,60000.00,207.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(71,34,74,93000.00,1421.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(72,34,75,73000.00,1591.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(73,34,76,53000.00,194.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(74,35,9,72000.00,1499.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(75,35,11,52000.00,560.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(76,35,12,32000.00,1356.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(77,36,46,102000.00,270.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(78,36,47,82000.00,474.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(79,36,48,62000.00,553.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(80,37,34,91000.00,1589.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(81,37,35,71000.00,1194.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(82,37,36,51000.00,410.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(83,38,73,72000.00,1563.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(84,38,74,52000.00,304.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(85,38,75,32000.00,1748.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(86,39,17,86000.00,1233.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(87,40,62,92000.00,950.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(88,41,55,94000.00,1039.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(89,42,28,110000.00,240.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(90,43,74,101000.00,440.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(91,43,75,81000.00,1980.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(92,43,76,61000.00,1976.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(93,44,49,87000.00,1868.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(94,44,50,67000.00,1211.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(95,44,52,47000.00,1258.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(96,45,69,114000.00,576.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(97,45,72,94000.00,1076.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(98,46,20,102000.00,1874.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(99,47,29,115000.00,1605.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(100,47,30,95000.00,1851.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(101,47,31,75000.00,615.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(102,48,81,114000.00,536.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(103,48,82,94000.00,1352.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(104,48,84,74000.00,437.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(105,49,69,96000.00,119.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(106,49,70,76000.00,686.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(107,49,72,56000.00,800.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(108,50,73,119000.00,1058.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(109,51,30,73000.00,302.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(110,51,31,53000.00,53.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(111,51,32,33000.00,1529.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(112,52,33,113000.00,1356.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(113,52,34,93000.00,1072.00,'2026-09-04 10:21:26','2026-09-04 10:21:26'),
(114,53,45,109000.00,1257.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(115,54,23,115000.00,1542.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(116,54,24,95000.00,1798.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(117,55,54,112000.00,1644.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(118,56,33,111000.00,698.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(119,56,36,91000.00,226.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(120,57,1,113000.00,1380.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(121,58,1,61000.00,644.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(122,58,2,41000.00,1947.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(123,58,4,21000.00,1221.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(124,59,73,87000.00,1777.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(125,59,74,67000.00,1229.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(126,59,76,47000.00,869.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(127,60,77,90000.00,468.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(128,60,80,70000.00,1709.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(129,61,77,120000.00,1085.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(130,62,15,68000.00,722.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(131,62,16,48000.00,1543.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(132,63,23,78000.00,1093.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(133,64,53,79000.00,1870.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(134,64,56,59000.00,1720.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(135,65,1,100000.00,189.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(136,65,3,80000.00,918.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(137,65,4,60000.00,851.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(138,66,30,65000.00,1662.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(139,66,31,45000.00,343.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(140,67,61,90000.00,1587.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(141,67,63,70000.00,1064.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(142,68,58,76000.00,1038.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(143,68,60,56000.00,1874.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(144,69,54,70000.00,837.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(145,69,55,50000.00,725.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(146,69,56,30000.00,334.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(147,70,74,86000.00,303.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(148,70,75,66000.00,553.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(149,71,77,81000.00,1837.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(150,71,79,61000.00,205.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(151,71,80,41000.00,1689.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(152,72,15,106000.00,1414.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(153,73,48,109000.00,618.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(154,74,69,88000.00,1132.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(155,74,72,68000.00,1034.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(156,75,5,64000.00,419.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(157,75,6,44000.00,186.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(158,75,8,24000.00,581.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(159,76,49,72000.00,462.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(160,76,50,52000.00,1864.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(161,76,52,32000.00,915.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(162,77,51,98000.00,1061.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(163,77,52,78000.00,1388.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(164,78,66,92000.00,1245.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(165,78,68,72000.00,1163.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(166,79,10,119000.00,155.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(167,79,12,99000.00,898.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(168,80,26,107000.00,854.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(169,81,22,90000.00,216.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(170,81,23,70000.00,1607.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(171,82,74,117000.00,636.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(172,82,76,97000.00,1073.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(173,83,70,62000.00,629.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(174,83,71,42000.00,1635.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(175,83,72,22000.00,989.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(176,84,57,115000.00,413.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(177,84,58,95000.00,829.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(178,84,59,75000.00,140.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(179,85,80,90000.00,1385.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(180,86,57,106000.00,555.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(181,86,59,86000.00,844.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(182,87,83,104000.00,1988.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(183,88,41,103000.00,661.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(184,88,42,83000.00,1771.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(185,88,44,63000.00,1645.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(186,89,42,89000.00,1369.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(187,89,43,69000.00,1725.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(188,90,9,68000.00,1207.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(189,90,11,48000.00,953.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(190,91,15,100000.00,472.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(191,92,30,63000.00,1192.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(192,92,32,43000.00,1995.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(193,93,79,61000.00,74.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(194,93,80,41000.00,216.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(195,94,5,113000.00,405.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(196,94,7,93000.00,939.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(197,94,8,73000.00,1179.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(198,95,2,88000.00,1557.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(199,95,3,68000.00,1576.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(200,95,4,48000.00,1985.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(201,96,61,75000.00,1113.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(202,96,62,55000.00,829.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(203,97,51,86000.00,1007.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(204,98,2,111000.00,1440.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(205,99,33,103000.00,1666.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(206,99,34,83000.00,1211.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(207,100,77,76000.00,1836.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(208,100,79,56000.00,274.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(209,100,80,36000.00,621.00,'2026-09-04 10:21:27','2026-09-04 10:21:27');

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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan` */

insert  into `permintaan`(`id`,`user_id`,`komoditi_id`,`judul`,`tipe`,`keterangan`,`prioritas_warna`,`prioritas_tag`,`status`,`created_at`,`updated_at`) values 
(1,26,6,'Permintaan Kakaktua - Cabang Manado','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(2,27,17,'Permintaan Lobster - Cabang Bitung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(3,18,19,'Permintaan Kepiting Bakau - Cabang Surabaya','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(4,22,5,'Permintaan Kerapu - Cabang Pontianak','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(5,21,7,'Permintaan Bawal - Cabang Kupang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(6,17,17,'Permintaan Lobster - Cabang Semarang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(7,15,4,'Permintaan Kakap Merah - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(8,4,2,'Permintaan Tongkol Domestik - PT Sumber Laut Jaya','Lokal','Kebutuhan buyer, mohon segera dikonfirmasi.','merah','Urgent - buyer menunggu konfirmasi 3 hari','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(9,23,20,'Permintaan Gurita - Cabang Banjarmasin','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(10,11,19,'Permintaan Kepiting Bakau - Cabang Palembang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(11,8,15,'Permintaan Giant Trevally (GT) - Cabang Padang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(12,8,15,'Permintaan Giant Trevally (GT) - Cabang Padang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(13,19,10,'Permintaan Selar - Cabang Surabaya','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(14,13,14,'Permintaan Ekor Kuning - Cabang Jakarta','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(15,23,18,'Permintaan Rajungan - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(16,26,16,'Permintaan Udang Vaname - Cabang Manado','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(17,23,15,'Permintaan Giant Trevally (GT) - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(18,11,5,'Permintaan Kerapu - Cabang Palembang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(19,13,2,'Permintaan Tongkol - Cabang Jakarta','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(20,4,2,'Permintaan Tongkol Domestik - PT Sumber Laut Jaya','Lokal','Kebutuhan buyer, mohon segera dikonfirmasi.','kuning','Buyer lama, prioritas jaga hubungan','tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(21,23,16,'Permintaan Udang Vaname - Cabang Banjarmasin','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(22,24,12,'Permintaan Cakalang - Cabang Balikpapan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(23,26,11,'Permintaan Bandeng - Cabang Manado','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(24,20,14,'Permintaan Ekor Kuning - Cabang Denpasar','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(25,14,17,'Permintaan Lobster - Cabang Cirebon','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(26,29,4,'Permintaan Kakap Merah - Cabang Ambon','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(27,20,5,'Permintaan Kerapu - Cabang Denpasar','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(28,29,15,'Permintaan Giant Trevally (GT) - Cabang Ambon','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(29,20,1,'Permintaan Kembung Kuring - Cabang Denpasar','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(30,21,18,'Permintaan Rajungan - Cabang Kupang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(31,11,11,'Permintaan Bandeng - Cabang Palembang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(32,22,14,'Permintaan Ekor Kuning - Cabang Pontianak','Lokal','Kebutuhan stok cabang.',NULL,NULL,'sedang_diproses','2026-09-04 10:21:27','2026-09-05 16:30:15'),
(33,21,10,'Permintaan Selar - Cabang Kupang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(34,23,5,'Permintaan Kerapu - Cabang Banjarmasin','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(35,19,15,'Permintaan Giant Trevally (GT) - Cabang Surabaya','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(36,9,2,'Permintaan Tongkol - Cabang Padang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(37,17,20,'Permintaan Gurita - Cabang Semarang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'sedang_diproses','2026-09-04 10:21:28','2026-09-06 00:57:06'),
(38,30,2,'Permintaan Tongkol - Cabang Ternate','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(39,18,10,'Permintaan Selar - Cabang Surabaya','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(40,16,4,'Permintaan Kakap Merah - Cabang Semarang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'sedang_diproses','2026-09-04 10:21:28','2026-09-06 01:26:57'),
(41,17,9,'Permintaan Layang - Cabang Semarang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(42,30,19,'Permintaan Kepiting Bakau - Cabang Ternate','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(43,15,6,'Permintaan Kakaktua - Cabang Pekalongan','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(44,23,6,'Permintaan Kakaktua - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(45,13,11,'Permintaan Bandeng - Cabang Jakarta','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(46,30,4,'Permintaan Kakap Merah - Cabang Ternate','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(47,15,11,'Permintaan Bandeng - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(48,16,16,'Permintaan Udang Vaname - Cabang Semarang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(49,14,7,'Permintaan Bawal - Cabang Cirebon','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(50,27,3,'Permintaan Tenggiri - Cabang Bitung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(51,15,15,'Permintaan Giant Trevally (GT) - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(52,20,18,'Permintaan Rajungan - Cabang Denpasar','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(53,23,9,'Permintaan Layang - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(54,9,12,'Permintaan Cakalang - Cabang Padang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(55,26,9,'Permintaan Layang - Cabang Manado','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(56,31,2,'Permintaan Tongkol - Cabang Sorong','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(57,15,13,'Permintaan Baronang - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(58,6,19,'Permintaan Kepiting Bakau - Cabang Medan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(59,23,20,'Permintaan Gurita - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(60,23,5,'Permintaan Kerapu - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(61,12,11,'Permintaan Bandeng - Cabang Lampung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(62,3,6,'Permintaan Kakaktua Ekspor - PT Cipta Samudra','Ekspor','Kebutuhan buyer, mohon segera dikonfirmasi.','hijau','Peluang baru, belum ada komitmen pasti','tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(63,21,9,'Permintaan Layang - Cabang Kupang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(64,12,21,'Permintaan Cumi-cumi - Cabang Lampung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(65,27,8,'Permintaan Tuna Sirip Kuning - Cabang Bitung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(66,8,4,'Permintaan Kakap Merah - Cabang Padang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(67,15,21,'Permintaan Cumi-cumi - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(68,12,21,'Permintaan Cumi-cumi - Cabang Lampung','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(69,31,6,'Permintaan Kakaktua - Cabang Sorong','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(70,4,21,'Permintaan Cumi-cumi Ekspor - PT Nusantara Bahari','Ekspor','Kebutuhan buyer, mohon segera dikonfirmasi.','hijau','Kontrak rutin bulanan','tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(71,15,4,'Permintaan Kakap Merah - Cabang Pekalongan','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(72,13,2,'Permintaan Tongkol - Cabang Jakarta','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(73,22,13,'Permintaan Baronang - Cabang Pontianak','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(74,30,11,'Permintaan Bandeng - Cabang Ternate','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(75,6,2,'Permintaan Tongkol - Cabang Medan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(76,27,13,'Permintaan Baronang - Cabang Bitung','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(77,30,1,'Permintaan Kembung Kuring - Cabang Ternate','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(78,11,11,'Permintaan Bandeng - Cabang Palembang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(79,26,12,'Permintaan Cakalang - Cabang Manado','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(80,21,12,'Permintaan Cakalang - Cabang Kupang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(81,17,20,'Permintaan Gurita - Cabang Semarang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(82,12,19,'Permintaan Kepiting Bakau - Cabang Lampung','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(83,29,20,'Permintaan Gurita - Cabang Ambon','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(84,23,18,'Permintaan Rajungan - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(85,23,7,'Permintaan Bawal - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(86,7,17,'Permintaan Lobster - Cabang Medan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(87,15,20,'Permintaan Gurita - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(88,28,11,'Permintaan Bandeng - Cabang Bitung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(89,23,16,'Permintaan Udang Vaname - Cabang Banjarmasin','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(90,11,16,'Permintaan Udang Vaname - Cabang Palembang','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(91,27,13,'Permintaan Baronang - Cabang Bitung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(92,15,21,'Permintaan Cumi-cumi - Cabang Pekalongan','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(93,27,8,'Permintaan Tuna Sirip Kuning - Cabang Bitung','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(94,23,1,'Permintaan Kembung Kuring - Cabang Banjarmasin','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(95,29,15,'Permintaan Giant Trevally (GT) - Cabang Ambon','Ekspor','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(96,31,13,'Permintaan Baronang - Cabang Sorong','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(97,5,8,'Permintaan Tuna Sirip Kuning Domestik - PT Bahari Sejahtera','Lokal','Kebutuhan buyer, mohon segera dikonfirmasi.','kuning','Peluang baru, belum ada komitmen pasti','tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(98,12,8,'Permintaan Tuna Sirip Kuning - Cabang Lampung','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(99,16,10,'Permintaan Selar - Cabang Semarang','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(100,29,11,'Permintaan Bandeng - Cabang Ambon','Lokal','Kebutuhan stok cabang.',NULL,NULL,'tersedia','2026-09-04 10:21:28','2026-09-04 10:21:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan_detail_ekspor` */

insert  into `permintaan_detail_ekspor`(`id`,`permintaan_id`,`sertifikasi`,`kontinuitas_suplai`,`negara_tujuan`,`created_at`,`updated_at`) values 
(1,5,'HACCP + MSC','Rutin tiap minggu, kapasitas stabil','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(2,9,NULL,'Musiman, tergantung hasil tangkapan','Malaysia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(3,21,'BRC','Rutin tiap minggu, kapasitas stabil','Malaysia','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(4,33,'MSC','Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:27','2026-09-04 10:21:27'),
(5,34,NULL,'Musiman, tergantung hasil tangkapan','China','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(6,37,'HACCP','Musiman, tergantung hasil tangkapan','Uni Eropa','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(7,38,'MSC','Musiman, tergantung hasil tangkapan','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(8,41,'MSC','Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(9,43,NULL,'Musiman, tergantung hasil tangkapan','Amerika Serikat','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(10,54,'HACCP','Rutin 2 minggu sekali','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(11,62,'HACCP + MSC','Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(12,68,'MSC','Bisa kontinu jika ada kepastian pembeli','Uni Eropa','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(13,70,NULL,'Rutin 2 minggu sekali','Uni Eropa','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(14,71,'MSC','Rutin 2 minggu sekali','Uni Eropa','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(15,72,'HACCP + MSC','Rutin 2 minggu sekali','Uni Eropa','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(16,73,NULL,'Rutin 2 minggu sekali','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(17,76,'BRC','Bisa kontinu jika ada kepastian pembeli','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(18,79,'BRC','Rutin tiap minggu, kapasitas stabil','Malaysia','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(19,81,'HACCP + MSC','Rutin 2 minggu sekali','Amerika Serikat','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(20,82,'MSC','Musiman, tergantung hasil tangkapan','Amerika Serikat','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(21,90,'BRC','Rutin 2 minggu sekali','Korea Selatan','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(22,93,'HACCP + MSC','Bisa kontinu jika ada kepastian pembeli','Korea Selatan','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(23,94,'HACCP','Rutin tiap minggu, kapasitas stabil','Jepang','2026-09-04 10:21:28','2026-09-04 10:21:28'),
(24,95,'HACCP + MSC','Musiman, tergantung hasil tangkapan','Korea Selatan','2026-09-04 10:21:28','2026-09-04 10:21:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan_rincian_size` */

insert  into `permintaan_rincian_size`(`id`,`permintaan_id`,`komoditi_size_id`,`harga`,`kuantiti`,`created_at`,`updated_at`) values 
(1,1,21,80000.00,1005.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(2,1,24,60000.00,393.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(3,2,67,117000.00,1127.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(4,3,74,101000.00,101.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(5,4,17,119000.00,375.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(6,4,18,99000.00,321.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(7,4,20,79000.00,917.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(8,5,27,103000.00,1182.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(9,5,28,83000.00,152.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(10,6,68,96000.00,1103.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(11,7,14,100000.00,469.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(12,7,16,80000.00,53.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(13,8,5,91000.00,435.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(14,8,8,71000.00,480.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(15,9,80,66000.00,1398.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(16,10,73,116000.00,265.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(17,10,74,96000.00,1435.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(18,10,75,76000.00,242.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(19,11,57,92000.00,980.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(20,11,58,72000.00,804.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(21,12,60,110000.00,498.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(22,13,38,113000.00,412.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(23,14,53,89000.00,805.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(24,15,70,107000.00,1209.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(25,15,71,87000.00,105.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(26,15,72,67000.00,64.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(27,16,61,85000.00,1010.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(28,16,62,65000.00,1270.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(29,16,63,45000.00,1194.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(30,17,57,111000.00,80.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(31,17,58,91000.00,503.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(32,17,60,71000.00,628.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(33,18,17,110000.00,290.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(34,18,19,90000.00,263.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(35,18,20,70000.00,139.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(36,19,6,120000.00,58.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(37,19,8,100000.00,1434.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(38,20,5,114000.00,772.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(39,21,62,102000.00,1037.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(40,21,64,82000.00,926.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(41,22,45,115000.00,1108.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(42,22,46,95000.00,699.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(43,22,48,75000.00,1069.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(44,23,44,106000.00,139.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(45,24,53,128000.00,694.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(46,24,55,108000.00,194.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(47,24,56,88000.00,1098.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(48,25,65,105000.00,589.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(49,25,66,85000.00,233.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(50,25,68,65000.00,180.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(51,26,14,69000.00,70.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(52,26,16,49000.00,267.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(53,27,17,67000.00,1308.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(54,27,18,47000.00,799.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(55,28,59,86000.00,255.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(56,29,1,110000.00,1234.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(57,29,3,90000.00,234.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(58,29,4,70000.00,121.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(59,30,69,114000.00,1408.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(60,30,70,94000.00,771.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(61,30,72,74000.00,1039.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(62,31,41,127000.00,955.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(63,31,43,107000.00,1078.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(64,32,54,97000.00,268.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(65,32,56,77000.00,1348.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(66,33,37,121000.00,617.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(67,33,38,101000.00,251.00,'2026-09-04 10:21:27','2026-09-04 10:21:27'),
(68,34,18,85000.00,395.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(69,35,58,122000.00,462.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(70,35,59,102000.00,227.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(71,35,60,82000.00,310.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(72,36,6,105000.00,192.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(73,36,8,85000.00,158.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(74,37,77,114000.00,978.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(75,37,78,94000.00,893.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(76,37,79,74000.00,985.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(77,38,5,91000.00,1199.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(78,38,6,71000.00,274.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(79,38,7,51000.00,1103.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(80,39,38,118000.00,78.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(81,40,13,125000.00,901.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(82,40,15,105000.00,264.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(83,41,33,112000.00,290.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(84,42,74,128000.00,153.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(85,43,22,121000.00,857.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(86,43,24,101000.00,275.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(87,44,21,69000.00,1475.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(88,44,22,49000.00,1249.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(89,44,23,29000.00,593.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(90,45,41,109000.00,334.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(91,45,42,89000.00,501.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(92,45,43,69000.00,1175.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(93,46,14,115000.00,376.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(94,46,16,95000.00,1233.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(95,47,43,68000.00,1066.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(96,48,62,83000.00,871.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(97,48,63,63000.00,631.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(98,48,64,43000.00,1101.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(99,49,25,130000.00,1497.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(100,49,26,110000.00,944.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(101,49,27,90000.00,966.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(102,50,9,71000.00,1413.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(103,50,11,51000.00,1025.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(104,51,57,73000.00,1464.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(105,51,58,53000.00,728.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(106,52,72,91000.00,980.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(107,53,36,95000.00,1407.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(108,54,45,121000.00,299.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(109,54,46,101000.00,624.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(110,55,36,69000.00,1180.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(111,56,5,75000.00,1481.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(112,56,6,55000.00,555.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(113,56,8,35000.00,884.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(114,57,49,80000.00,303.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(115,57,50,60000.00,1160.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(116,57,51,40000.00,756.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(117,58,76,106000.00,893.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(118,59,77,112000.00,1205.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(119,59,78,92000.00,758.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(120,59,80,72000.00,596.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(121,60,17,73000.00,320.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(122,60,19,53000.00,177.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(123,60,20,33000.00,627.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(124,61,42,79000.00,228.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(125,61,43,59000.00,162.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(126,61,44,39000.00,796.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(127,62,22,86000.00,918.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(128,62,23,66000.00,1040.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(129,62,24,46000.00,1058.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(130,63,34,83000.00,925.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(131,64,81,103000.00,964.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(132,64,82,83000.00,797.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(133,64,83,63000.00,55.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(134,65,32,117000.00,1459.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(135,66,13,130000.00,1109.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(136,66,14,110000.00,917.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(137,67,81,75000.00,597.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(138,68,82,130000.00,711.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(139,68,84,110000.00,926.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(140,69,24,99000.00,1479.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(141,70,81,126000.00,1321.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(142,70,82,106000.00,502.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(143,71,13,104000.00,1109.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(144,71,14,84000.00,913.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(145,71,15,64000.00,687.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(146,72,5,98000.00,590.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(147,72,8,78000.00,1382.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(148,73,52,120000.00,901.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(149,74,44,69000.00,487.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(150,75,5,80000.00,475.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(151,75,8,60000.00,1062.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(152,76,50,87000.00,1276.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(153,76,51,67000.00,981.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(154,77,2,112000.00,603.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(155,77,3,92000.00,637.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(156,78,42,68000.00,1288.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(157,79,46,95000.00,685.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(158,79,48,75000.00,721.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(159,80,46,69000.00,220.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(160,80,47,49000.00,571.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(161,81,78,100000.00,1320.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(162,81,79,80000.00,972.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(163,81,80,60000.00,260.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(164,82,74,72000.00,621.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(165,82,76,52000.00,1338.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(166,83,79,103000.00,1376.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(167,84,69,72000.00,1187.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(168,84,70,52000.00,1490.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(169,85,26,92000.00,385.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(170,85,27,72000.00,1223.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(171,86,66,75000.00,773.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(172,87,78,68000.00,745.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(173,87,79,48000.00,704.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(174,87,80,28000.00,359.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(175,88,43,112000.00,1003.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(176,89,62,66000.00,1281.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(177,90,61,124000.00,503.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(178,90,63,104000.00,1350.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(179,91,49,125000.00,750.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(180,92,81,117000.00,351.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(181,93,31,102000.00,806.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(182,94,2,105000.00,117.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(183,94,4,85000.00,963.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(184,95,57,66000.00,207.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(185,96,51,126000.00,365.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(186,97,30,86000.00,251.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(187,98,29,96000.00,1356.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(188,98,30,76000.00,1243.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(189,98,31,56000.00,903.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(190,99,37,94000.00,1081.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(191,100,42,103000.00,1347.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(192,100,43,83000.00,472.00,'2026-09-04 10:21:28','2026-09-04 10:21:28'),
(193,100,44,63000.00,1079.00,'2026-09-04 10:21:28','2026-09-04 10:21:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project` */

insert  into `project`(`id`,`match_suggestion_id`,`penawaran_id`,`permintaan_id`,`status`,`dipilih_oleh`,`created_at`,`updated_at`) values 
(1,209,69,32,'sedang_diproses',2,'2026-09-05 16:30:15','2026-09-05 16:30:15'),
(2,214,71,37,'sedang_diproses',2,'2026-09-06 00:57:06','2026-09-06 00:57:06'),
(3,224,72,40,'tutup',2,'2026-09-06 01:26:57','2026-09-06 03:17:38');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_catatan` */

insert  into `project_catatan`(`id`,`project_id`,`user_id`,`isi_catatan`,`created_at`,`updated_at`) values 
(1,1,2,'apa ni kuncilr','2026-09-05 16:40:49','2026-09-05 16:40:49'),
(2,1,2,'iya kah ni','2026-09-05 16:40:58','2026-09-05 16:40:58'),
(3,1,2,'ini juga apalah ni','2026-09-05 16:41:42','2026-09-05 16:41:42'),
(4,1,2,'aku tak tau apa yang ku rasakan','2026-09-05 16:42:59','2026-09-05 16:42:59'),
(5,1,2,'sd fsdf sf sfdfds fds fsdf sdf sd fsd fsdf ds fsd fdsf sdfsd fsdfsdf sdf sdf sdfds fsd fds f sdf sdf sdfs dfsdf sdf sdf','2026-09-05 16:50:46','2026-09-05 16:50:46'),
(6,3,2,'tidak jelas','2026-09-06 03:17:38','2026-09-06 03:17:38');

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
(1,'Cabang','web','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(2,'Pusat','web','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(3,'Admin','web','2026-09-04 10:21:13','2026-09-04 10:21:13');

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
('BeDuuPfPZl60C1rFryOXw9mZPiNovTMzc1SrIi08',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJNSDBqWUVYWGQwOUlMNzZLNEp6OUR6SXZQMGRsUWJTY0hSZ29wNHVGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2ZwdC50ZXN0XC9wcm9qZWN0P3N0YXR1cz10dXR1cCIsInJvdXRlIjoicHJvamVjdC5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1788664682),
('JEJKHKQ0Ac1I7nS4gUTmeUE195MSwjwvJrL6lttR',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKRnV4cXRWbDZrSXNYVFlXNlVIZ1Z6N3paZGlkdTdtM3FNeXV0MlAwIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjIsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9mcHQudGVzdFwvcHJvamVjdCIsInJvdXRlIjoicHJvamVjdC5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788694819),
('UK2TqN59VSjXIqmgGStlkHveSUiPPA6d43RbG0zd',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJNUDJ4eWNUOGI1VEJCbHNBclBMNmVMclRaanJNNXk0OG0xQ1BTVTZMIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvZnB0LnRlc3RcL3Byb2plY3QiLCJyb3V0ZSI6InByb2plY3QuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9',1788627886);

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`cabang_id`,`name`,`email`,`no_whatsapp`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,NULL,'Test User','test@example.com',NULL,'2026-09-04 10:21:12','$2y$12$UJ5pmqk4mLPrlR.Qm7hyqeFCKzUyizKrvEI0h5rnZf5.QbsT1L2QK','DDJuOr2A5p','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(2,NULL,'Admin Sistem','admin@fpt.test','08225422386',NULL,'$2y$12$ElB732jv.xzvdCrCw6mZrutSNUqIQZT0IQhMwbhUPj7zYeuTngMZO','MzlmoUtXDQxrk3Eoo8gTJKdVWGjwXULZGgK0c40JbbcF9ifjvAGFa3o5yXhI','2026-09-04 10:21:13','2026-09-04 10:21:13'),
(3,NULL,'Ramous Peppy','pusat1@fpt.test','08918940955',NULL,'$2y$12$MTXwY6UjXHZ8HJB2aFEawOInuKTyofKxkooy2RwzzTLnXRNqdT9ru',NULL,'2026-09-04 10:21:13','2026-09-04 10:21:13'),
(4,NULL,'Robertto','pusat2@fpt.test','08606750671',NULL,'$2y$12$NJkSUXmmfOHzPey39N3Bz.W5SI1rT2wTfqwfHlPwpI1gxjRWiCjqC',NULL,'2026-09-04 10:21:14','2026-09-04 10:21:14'),
(5,NULL,'Muhammad Alpanda','pusat3@fpt.test','08209907177',NULL,'$2y$12$mtDXZp/P6a1dPLqskyrVmOMzKRrwjSUOamD8TPKdK8SpwdgpixsT2',NULL,'2026-09-04 10:21:14','2026-09-04 10:21:14'),
(6,1,'Indah Wijaya','cabang1_1@fpt.test','08112828166',NULL,'$2y$12$RZ8SdvdND.rkMLWIWBfhiOsgJpzqhozi716QGkcl1QMPWFZlaibxC',NULL,'2026-09-04 10:21:15','2026-09-04 10:21:15'),
(7,1,'Sari Permana','cabang1_2@fpt.test','08541402665',NULL,'$2y$12$p.yPEgy9waarjJBKEkyj0.n.8RMh8Hdvhs4jIaO2hyfDfcKmBvFTK',NULL,'2026-09-04 10:21:15','2026-09-04 10:21:15'),
(8,2,'Vina Permana','cabang2_1@fpt.test','08525881521',NULL,'$2y$12$9QGRzMXYoIA48UERrh0lgun47mhLrtPzMa2HOfb.Wi6qEUT0li7y6',NULL,'2026-09-04 10:21:16','2026-09-04 10:21:16'),
(9,2,'Rahmat Saputra','cabang2_2@fpt.test','08541061376',NULL,'$2y$12$mIjTMbH3FySKqFVVehQ/JeFrcvAry9ElHdtaCqm9d9/xid/QrBfK2',NULL,'2026-09-04 10:21:16','2026-09-04 10:21:16'),
(10,3,'Rahmat Kusuma','cabang3_1@fpt.test','08117123905',NULL,'$2y$12$Yq2v/R/Ronr7k9MGxTuBdurK3mPkakamxwX0NU2/HWtEP6GrHqcu.',NULL,'2026-09-04 10:21:17','2026-09-04 10:21:17'),
(11,3,'Putri Nugroho','cabang3_2@fpt.test','08494024054',NULL,'$2y$12$MIyNhzrZ8ine9QOgDEoZ5Or3ou8tlwnd.Iqxoqt0E9dF5D.BkTxda',NULL,'2026-09-04 10:21:17','2026-09-04 10:21:17'),
(12,4,'Taufik Kusuma','cabang4_1@fpt.test','08565934355',NULL,'$2y$12$G6roW4/oFWYx9vPCiLN/kewOeYf/.QK0ktpAgQdrdg8VhhiLz5pN6',NULL,'2026-09-04 10:21:17','2026-09-04 10:21:17'),
(13,5,'Nur Pratama','cabang5_1@fpt.test','08963347530',NULL,'$2y$12$cucJPdzTJS6tUX5NRN1GhuKD/I7WuneeoXb6sxoBKgv5Yz6iVRXFq',NULL,'2026-09-04 10:21:18','2026-09-04 10:21:18'),
(14,6,'Joko Handoko','cabang6_1@fpt.test','08505425188',NULL,'$2y$12$TxXoW2z0uOcNiCa18vo8MuDk5FQaZxdQ06N8FkwxAaOv/5B1e1nmO',NULL,'2026-09-04 10:21:18','2026-09-04 10:21:18'),
(15,7,'Nur Saputra','cabang7_1@fpt.test','08507949600',NULL,'$2y$12$vUe685USnXI42qjqlskSBOcasgFVwsfGm79UiwSTPNaQ7xrkuc5Jy',NULL,'2026-09-04 10:21:19','2026-09-04 10:21:19'),
(16,8,'Rahmat Siregar','cabang8_1@fpt.test','08388141858',NULL,'$2y$12$FZqRbN629zmMxkXHbiV7eO4EOj9ot5A6rMk1rElIk5EcqoT64FgiK',NULL,'2026-09-04 10:21:19','2026-09-04 10:21:19'),
(17,8,'Wawan Pratama','cabang8_2@fpt.test','08946746961',NULL,'$2y$12$fj5krBqrko0hKNOMGzaRZuHVPaf08pG7DdEJOWSmkWKB5.C/BwBWC',NULL,'2026-09-04 10:21:19','2026-09-04 10:21:19'),
(18,9,'Sari Saputra','cabang9_1@fpt.test','08924741040',NULL,'$2y$12$p4WghLGNBA020mrvXXqzHeM98t/VPrdzxjIxHA7T9ydiqjV/6QAS2',NULL,'2026-09-04 10:21:20','2026-09-04 10:21:20'),
(19,9,'Hendra Permana','cabang9_2@fpt.test','08731883366',NULL,'$2y$12$EmJfNdIl7iBc95p1OeUklekdTh212x7ILs6XwYdamDPuTEKNuQoZ2',NULL,'2026-09-04 10:21:20','2026-09-04 10:21:20'),
(20,10,'Taufik Handoko','cabang10_1@fpt.test','08296729852',NULL,'$2y$12$VL2CtHacl7OLXBcQBikit.dITOUyN49ppQhfXcmQBm2ntGxRr2spu',NULL,'2026-09-04 10:21:21','2026-09-04 10:21:21'),
(21,11,'Dewi Saputra','cabang11_1@fpt.test','08456019825',NULL,'$2y$12$NwrH05VXTnbxVh0koLMwLeP4Q2DBfDHN.9GwmGkPuwwVTPRLoSAMa',NULL,'2026-09-04 10:21:21','2026-09-04 10:21:21'),
(22,12,'Umar Permana','cabang12_1@fpt.test','08165040900',NULL,'$2y$12$8lVjWxQOk090E/6S7siyG.AmZzPt/bO/mndIECNt8dt9icW168nZG',NULL,'2026-09-04 10:21:21','2026-09-04 10:21:21'),
(23,13,'Hendra Handoko','cabang13_1@fpt.test','08938237123',NULL,'$2y$12$3gyJ32eV8I8lLT47wQT24Oi3zb0FW3JcJWgEo5taP.9VZYRnFKMjW',NULL,'2026-09-04 10:21:22','2026-09-04 10:21:22'),
(24,14,'Putri Santoso','cabang14_1@fpt.test','08617457518',NULL,'$2y$12$AGHRIGnbHTioeyHsm9GERuovm31BbzAveM6IJz7a4ZAIfT3tsLjEe',NULL,'2026-09-04 10:21:22','2026-09-04 10:21:22'),
(25,15,'Joko Santoso','cabang15_1@fpt.test','08386693891',NULL,'$2y$12$4Slzo1XsTl6KodEaeAOsH.gfwSz/LpjHgvRVthi9dNcnaJHdMISfO',NULL,'2026-09-04 10:21:23','2026-09-04 10:21:23'),
(26,16,'Yanto Santoso','cabang16_1@fpt.test','08119826735',NULL,'$2y$12$W96bfH93UD56eT8sJ9hZg.BDY3P56NtCHMuZpnNnygFQc6f6PWYTC',NULL,'2026-09-04 10:21:23','2026-09-04 10:21:23'),
(27,17,'Kartika Permana','cabang17_1@fpt.test','08589731431',NULL,'$2y$12$D2lv.0wNmuZQKj2b6CNlrOPNtWG9SCpwnUFx6HcOQTgnWCq/IA74a',NULL,'2026-09-04 10:21:23','2026-09-04 10:21:23'),
(28,17,'Umar Utami','cabang17_2@fpt.test','08165477545',NULL,'$2y$12$JTQASRtnpeyGnvLdIlktHu5ZXrcD.qSmpSrwwfzc/5QJI7bvkTHdi',NULL,'2026-09-04 10:21:24','2026-09-04 10:21:24'),
(29,18,'Zainal Kusuma','cabang18_1@fpt.test','08684151590',NULL,'$2y$12$auv1Uj/4mHBB4g8tJACyeOTWjzEqFR9aLU992v5aqZ/Fx6KJAjHkq',NULL,'2026-09-04 10:21:24','2026-09-04 10:21:24'),
(30,19,'Yanto Wijaya','cabang19_1@fpt.test','08948029320',NULL,'$2y$12$Vq6umjlCU5QpSb43J6rykO5csfRb7I83OGEwEkoRNXdNjtzWsvcxW',NULL,'2026-09-04 10:21:25','2026-09-04 10:21:25'),
(31,20,'Hendra Utami','cabang20_1@fpt.test','08491327671',NULL,'$2y$12$dKFAkujEUXjhrJi7cub81uE0cRqo/r.ysc8VAu/WGewC.4vQKSA6y',NULL,'2026-09-04 10:21:25','2026-09-04 10:21:25');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
