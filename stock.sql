-- MySQL dump 10.13  Distrib 8.0.40, for macos14 (x86_64)
--
-- Host: localhost    Database: inventory_db
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Jamu Kuat','uploads/brand/media_696f5be6704d1.png','2026-01-20 03:41:42','2026-01-20 03:41:42');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"group_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:54:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"view users\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"create users\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"view reports\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"profile.manage\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"brand.manage\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:9:\"all.brand\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"brand.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:10:\"brand.edit\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"brand.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"warehouse.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:13:\"All.warehouse\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"warehouse.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"warehouse.edit\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"warehouse.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"supplier.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"All.supplier\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"supplier.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:13:\"supplier.edit\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:15:\"supplier.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"customer.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"All.customer\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"customer.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:13:\"customer.edit\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:15:\"customer.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:12:\"product.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:11:\"All.product\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:12:\"category.all\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:14:\"product.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"product.edit\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:14:\"product.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"purchase.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"All.purchase\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:15:\"purchase.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"purchase.return\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:15:\"purchase.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:9:\"Sale.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:8:\"All.sale\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:11:\"sale.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:11:\"sale.return\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:11:\"sale.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:8:\"due.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:7:\"All.due\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"transfer.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"All.transfer\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"transfer.create\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:13:\"transfer.edit\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"transfer.delete\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:11:\"report.menu\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:10:\"All.report\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:52;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:22:\"role.permission.manage\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:53;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:17:\"admin.user.manage\";s:1:\"c\";N;s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"d\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"manager\";s:1:\"d\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:4:\"user\";s:1:\"d\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"super-admin\";s:1:\"d\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:5:\"staff\";s:1:\"d\";s:3:\"web\";}}}',1768988854);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Minuman','minuman','2025-12-02 01:29:53','2025-12-02 01:29:53'),(2,'Jamu Bubuk','jamu-bubuk','2026-01-20 03:49:21','2026-01-20 03:49:21'),(3,'Jamu Cair','jamu-cair','2026-01-20 03:49:40','2026-01-20 03:49:40'),(4,'Pil','pil','2026-01-20 03:49:53','2026-01-20 03:49:53');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Toko Seger','seger@gmail.com','1243453645','Jl. Bugar 100','2026-01-20 03:48:16','2026-01-20 03:48:16');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_06_28_054128_create_brands_table',1),(5,'2025_06_29_074253_create_ware_houses_table',1),(6,'2025_06_29_172312_create_suppliers_table',1),(7,'2025_07_01_051331_create_customers_table',1),(8,'2025_07_02_041856_create_categories_table',1),(9,'2025_07_02_175021_create_products_table',1),(10,'2025_07_04_030355_create_product_images_table',1),(11,'2025_07_09_032303_create_purchases_table',1),(12,'2025_07_09_032315_create_purchase_items_table',1),(13,'2025_07_19_124002_create_return_purchases_table',1),(14,'2025_07_19_124017_create_return_purchase_items_table',1),(15,'2025_07_21_174957_create_sales_table',1),(16,'2025_07_21_175005_create_sale_items_table',1),(17,'2025_07_28_044721_create_sale_returns_table',1),(18,'2025_07_28_044733_create_sale_return_items_table',1),(19,'2025_08_02_164539_create_transfers_table',1),(20,'2025_08_02_164552_create_transfer_items_table',1),(21,'2025_08_09_144102_create_permission_tables',1),(22,'2025_08_09_152520_add_group_name_to_permissions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_group_name_name_guard_name_unique` (`group_name`,`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view users',NULL,'web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(2,'create users',NULL,'web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(3,'edit users',NULL,'web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(4,'delete users',NULL,'web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(5,'view reports',NULL,'web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(6,'dashboard.view',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(7,'profile.manage',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(8,'brand.manage',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(9,'all.brand',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(10,'brand.create',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(11,'brand.edit',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(12,'brand.delete',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(13,'warehouse.menu',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(14,'All.warehouse',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(15,'warehouse.create',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(16,'warehouse.edit',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(17,'warehouse.delete',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(18,'supplier.menu',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(19,'All.supplier',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(20,'supplier.create',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(21,'supplier.edit',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(22,'supplier.delete',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(23,'customer.menu',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(24,'All.customer',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(25,'customer.create',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(26,'customer.edit',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(27,'customer.delete',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(28,'product.menu',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(29,'All.product',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(30,'category.all',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(31,'product.create',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(32,'product.edit',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(33,'product.delete',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(34,'purchase.menu',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(35,'All.purchase',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(36,'purchase.create',NULL,'web','2026-01-20 02:38:31','2026-01-20 02:38:31'),(37,'purchase.return',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(38,'purchase.delete',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(39,'Sale.menu',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(40,'All.sale',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(41,'sale.create',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(42,'sale.return',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(43,'sale.delete',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(44,'due.menu',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(45,'All.due',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(46,'transfer.menu',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(47,'All.transfer',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(48,'transfer.create',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(49,'transfer.edit',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(50,'transfer.delete',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(51,'report.menu',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(52,'All.report',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(53,'role.permission.manage',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(54,'admin.user.manage',NULL,'web','2026-01-20 02:38:32','2026-01-20 02:38:32');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` json DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `warehouse_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_alert` int NOT NULL DEFAULT '10',
  `note` text COLLATE utf8mb4_unicode_ci,
  `product_qty` int NOT NULL DEFAULT '0',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_warehouse_id_foreign` (`warehouse_id`),
  KEY `products_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Jamu Pegel Linu','JPL001','[\"uploads/brand/media_696f5e4e0f651.png\"]',2,1,1,1,10000.00,10,'Ini Initial Stock',9,0.00,'Received','1','2026-01-20 03:51:58','2026-01-20 04:11:38');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `warehouse_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Received','Pending','Ordered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `grand_total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_warehouse_id_foreign` (`warehouse_id`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_purchase_items`
--

DROP TABLE IF EXISTS `return_purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `return_purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `return_purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_purchase_items_return_purchase_id_foreign` (`return_purchase_id`),
  KEY `return_purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `return_purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `return_purchase_items_return_purchase_id_foreign` FOREIGN KEY (`return_purchase_id`) REFERENCES `return_purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_purchase_items`
--

LOCK TABLES `return_purchase_items` WRITE;
/*!40000 ALTER TABLE `return_purchase_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `return_purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_purchases`
--

DROP TABLE IF EXISTS `return_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `return_purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `warehouse_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Received','Pending','Ordered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `grand_total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_purchases_warehouse_id_foreign` (`warehouse_id`),
  KEY `return_purchases_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `return_purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `return_purchases_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_purchases`
--

LOCK TABLES `return_purchases` WRITE;
/*!40000 ALTER TABLE `return_purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `return_purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(1,2),(5,2),(1,3),(1,4),(2,4),(3,4),(4,4),(5,4),(6,4),(7,4),(8,4),(9,4),(10,4),(11,4),(12,4),(13,4),(14,4),(15,4),(16,4),(17,4),(18,4),(19,4),(20,4),(21,4),(22,4),(23,4),(24,4),(25,4),(26,4),(27,4),(28,4),(29,4),(30,4),(31,4),(32,4),(33,4),(34,4),(35,4),(36,4),(37,4),(38,4),(39,4),(40,4),(41,4),(42,4),(43,4),(44,4),(45,4),(46,4),(47,4),(48,4),(49,4),(50,4),(51,4),(52,4),(53,4),(54,4),(6,5),(24,5),(29,5),(35,5),(36,5),(40,5),(41,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(2,'manager','web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(3,'user','web','2025-12-01 23:45:46','2025-12-01 23:45:46'),(4,'super-admin','web','2026-01-20 02:38:32','2026-01-20 02:38:32'),(5,'staff','web','2026-01-20 02:38:32','2026-01-20 02:38:32');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_items`
--

DROP TABLE IF EXISTS `sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_items_product_id_foreign` (`product_id`),
  KEY `sale_items_sale_id_foreign` (`sale_id`),
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_items`
--

LOCK TABLES `sale_items` WRITE;
/*!40000 ALTER TABLE `sale_items` DISABLE KEYS */;
INSERT INTO `sale_items` VALUES (1,1,1,10000.00,5,5,0.00,50000.00,'2026-01-20 03:54:19','2026-01-20 03:54:19'),(2,2,1,10000.00,6,6,0.00,60000.00,'2026-01-20 04:11:38','2026-01-20 04:11:38');
/*!40000 ALTER TABLE `sale_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_return_items`
--

DROP TABLE IF EXISTS `sale_return_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_return_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_return_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_return_items_product_id_foreign` (`product_id`),
  KEY `sale_return_items_sale_return_id_foreign` (`sale_return_id`),
  CONSTRAINT `sale_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_return_items_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_return_items`
--

LOCK TABLES `sale_return_items` WRITE;
/*!40000 ALTER TABLE `sale_return_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_return_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_returns`
--

DROP TABLE IF EXISTS `sale_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `warehouse_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Return','Pending','Ordered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `grand_total` decimal(15,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `full_paid` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_returns_warehouse_id_foreign` (`warehouse_id`),
  KEY `sale_returns_customer_id_foreign` (`customer_id`),
  CONSTRAINT `sale_returns_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_returns_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_returns`
--

LOCK TABLES `sale_returns` WRITE;
/*!40000 ALTER TABLE `sale_returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `warehouse_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Sale','Pending','Ordered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `grand_total` decimal(15,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `full_paid` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_warehouse_id_foreign` (`warehouse_id`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'2026-01-20',1,1,0.00,5000.00,'Pending','Pelanggan pertama',55000.00,50000.00,5000.00,NULL,'2026-01-20 03:54:19','2026-01-20 03:54:19'),(2,'2026-01-20',1,1,0.00,0.00,'Ordered','Ini Sudah di pesan',60000.00,60000.00,0.00,NULL,'2026-01-20 04:11:38','2026-01-20 04:11:38');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('bOgRaFA892DhKzCkddGqWIpzwxAHimYUDxrxqJpA',2,'127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiclJnSnNLczJFWmJQNjg4Q1lXWGhwcG9oTEhBY3JYcENMa1pXaVNVdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1768912952),('ZAGsWqHRJBUHlGeL1XkiPqaNNQHUD53LBGB4LWLT',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:147.0) Gecko/20100101 Firefox/147.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiblRvZVZJWjdwV0ZUellRalRIZXZ2Wjl2NnZNbXdBd2dlY0ZHc3FFVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1768956841);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Sehat Joss','SehatJoss@gmail.com','1234567890','Jl. Kencur 10 Bandung','2026-01-20 03:47:29','2026-01-20 03:47:29');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer_items`
--

DROP TABLE IF EXISTS `transfer_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfer_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transfer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_items_transfer_id_foreign` (`transfer_id`),
  KEY `transfer_items_product_id_foreign` (`product_id`),
  CONSTRAINT `transfer_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transfer_items_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer_items`
--

LOCK TABLES `transfer_items` WRITE;
/*!40000 ALTER TABLE `transfer_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfer_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `form_warehouse_id` bigint unsigned NOT NULL,
  `to_warehouse_id` bigint unsigned NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Transfer','Pending','Ordered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `grand_total` decimal(15,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `full_paid` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_form_warehouse_id_foreign` (`form_warehouse_id`),
  KEY `transfers_to_warehouse_id_foreign` (`to_warehouse_id`),
  CONSTRAINT `transfers_form_warehouse_id_foreign` FOREIGN KEY (`form_warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transfers_to_warehouse_id_foreign` FOREIGN KEY (`to_warehouse_id`) REFERENCES `ware_houses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfers`
--

LOCK TABLES `transfers` WRITE;
/*!40000 ALTER TABLE `transfers` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-12-01 23:38:15','$2y$12$fXK/vjKg07rsN7wooz3iOeRsKu87uDEsHOdbo556lpV/kiG9SWouq',NULL,NULL,NULL,'user','1','UVewRzGUoj','2025-12-01 23:38:15','2025-12-01 23:38:15'),(2,'roundsee','ronsinolast@gmail.com','2025-12-01 23:38:15','$2y$12$7LyaHkUB0Gac.j8lZ.RbW.o9eqg3sNbQdSgQD6/9ESbnBZkBybInW',NULL,NULL,NULL,'admin','1',NULL,'2025-12-01 23:40:12','2025-12-01 23:46:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ware_houses`
--

DROP TABLE IF EXISTS `ware_houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ware_houses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ware_houses_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ware_houses`
--

LOCK TABLES `ware_houses` WRITE;
/*!40000 ALTER TABLE `ware_houses` DISABLE KEYS */;
INSERT INTO `ware_houses` VALUES (1,'Gudang Utara','Gudut@gmail.com','6285320009','Bandung','2026-01-20 03:46:13','2026-01-20 03:46:13');
/*!40000 ALTER TABLE `ware_houses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-22  2:32:10
