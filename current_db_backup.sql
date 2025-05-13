-- MySQL dump 10.13  Distrib 9.2.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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
  `description` text COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Apparel','apparel','T-shirts, Hoodies, and more',NULL,'2025-04-09 08:46:27','2025-04-09 08:46:27'),(2,'Accessories','accessories','Mugs, Stickers, Hats, etc.',NULL,'2025-04-09 08:46:27','2025-04-09 08:46:27'),(3,'Digital','digital','Ebooks, Presets, Wallpapers, and other digital goods',NULL,'2025-04-09 08:46:27','2025-04-09 08:46:27');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_04_10_000001_create_categories_table',1),(5,'2025_04_10_000002_create_products_table',1),(6,'2025_04_10_000003_create_orders_table',1),(7,'2025_04_10_000004_create_order_items_table',1),(8,'2025_05_07_094240_add_deleted_at_to_users_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_items_order_id_product_id_unique` (`order_id`,`product_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (2,1,17,4,9.99,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(3,2,4,1,60.57,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(4,3,6,1,166.17,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(5,3,26,1,34.99,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(6,4,9,3,132.18,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(7,5,17,5,163.59,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(8,5,19,2,40.00,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(9,6,23,3,34.99,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(10,7,5,2,163.59,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(11,7,21,2,174.69,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(12,8,3,3,34.99,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(13,8,20,3,174.69,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(14,8,23,1,68.01,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(15,9,6,3,60.57,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(16,9,15,4,161.35,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(17,9,25,2,163.59,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(19,10,20,3,158.13,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(20,10,21,5,111.78,'2025-04-09 08:46:28','2025-04-09 08:46:28');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `billing_address` text COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_status_index` (`status`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'ORD910',234.71,'pending','123 Le Loi Street, District 1, Ho Chi Minh City, 700000, Vietnam','123 Le Loi Street, District 1, Ho Chi Minh City, 700000, Vietnam','Visa ending in 1234','pending',NULL,'2004-03-31 10:04:13','2025-04-11 06:40:04'),(2,2,'ORD563',60.57,'completed','456 Hai Ba Trung Street, Hoan Kiem District, Hanoi, 100000, Vietnam','789 Ly Thuong Kiet Street, Tan Binh District, Ho Chi Minh City, 700000, Vietnam','Mastercard ending in 5678','pending',NULL,'2017-12-30 18:54:02','2025-04-09 08:46:28'),(3,3,'ORD927',60.81,'completed','th	123 Main Street, Anytown, CA 90210, USA','123 Main Street, Anytown, CA 90210, USA','Amex ending in 3456','pending',NULL,'2017-09-27 17:22:31','2025-05-07 01:41:44'),(4,3,'ORD323',309.46,'pending','12 High Street, Anytown, London, W1A 1AA, United Kingdom','12 High Street, Anytown, London, W1A 1AA, United Kingdom','Visa ending in 2233','pending',NULL,'1978-06-19 01:53:48','2025-04-09 08:46:28'),(5,4,'ORD747',105.17,'completed','Apartment 101, The Manor, Me Tri Street, Nam Tu Liem District, Hanoi, 120000, Vietnam','Apartment 101, The Manor, Me Tri Street, Nam Tu Liem District, Hanoi, 120000, Vietnam','Visa ending in 9012','pending',NULL,'1973-01-13 04:21:33','2025-04-09 08:46:28'),(6,4,'ORD784',249.48,'pending','456 Maple Drive, Toronto, ON M5H 2N2, Canada','456 Maple Drive, Toronto, ON M5H 2N2, Canada','Mastercard ending in 3344','pending',NULL,'1987-04-30 06:06:21','2025-04-09 08:46:28'),(7,5,'ORD313',284.27,'pending','456 Oak Avenue, Springfield, IL 62704, USA','789 Pine Lane, Chicago, IL 60611, USA','Visa ending in 7890','pending',NULL,'1990-04-22 21:44:13','2025-04-09 08:46:28'),(8,5,'ORD064',251.61,'pending','88 Nguyen Hue Boulevard, District 1, Ho Chi Minh City, 700000, Vietnam','22 Vo Van Tan Street, District 3, Ho Chi Minh City, 700000, Vietnam','PayPal (han.le.example@email.com)','pending',NULL,'2016-12-11 20:30:01','2025-04-09 08:46:28'),(9,6,'ORD361',464.07,'completed','12 Ocean View Road, Bondi Beach, NSFW 69420, Australia','12 Ocean View Road, Bondi Beach, NSW 2026, Australia','Amex ending in 5566','pending',NULL,'2017-06-26 09:22:20','2025-04-09 08:46:28'),(10,6,'ORD533',89.39,'completed','Flat 5B, The Quays, Salford, M50 3AZ, United Kingdom','77 Park Lane, Manchester, M1 4BT, United Kingdom','PayPal (dj.example@email.co.uk)','pending',NULL,'2008-05-20 13:02:57','2025-04-09 08:46:28'),(11,2,'ORD111',2.00,'pending','101 River Road, Austin, TX 78701, USA','101 River Road, Austin, TX 78701, USA','Mastercard ending in 1122','pending',NULL,'2025-04-11 06:34:46','2025-04-11 06:34:46'),(12,4,'ORD112',2.00,'processing','789 King Street West, Apt 304, Vancouver, BC V6B 1A8, Canada','123 Robson Street, Vancouver, BC V6Z 2H7, Canada','Visa ending in 4455','pending',NULL,'2025-04-11 06:36:57','2025-05-07 07:15:45');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
INSERT INTO `password_reset_tokens` VALUES ('henryfivesquared@gmail.com','$2y$12$H3Vxo6AWlKwEpDECjTXs..lVWVWKP7iMVZO1T2SvOlGDHm9VVE2fO','2025-04-17 08:24:09');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `stock_quantity` int unsigned NOT NULL DEFAULT '0',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,2,'Leather Bracelet','leather-bracelet','Cool accessory to complement any outfit. Nice!',14.99,0,NULL,'https://media.istockphoto.com/id/1201365461/vi/anh/d%C3%A2y-%C4%91eo-c%E1%BB%95-tay-b%E1%BA%B1ng-da-%C4%91%C6%B0%E1%BB%A3c-c%C3%A1ch-ly-tr%C3%AAn-n%E1%BB%81n-tr%E1%BA%AFng.webp?s=2048x2048&w=is&k=20&c=8KH_q1sOGwRZADku_P-Y_GPjtbxRNMIUKw2GDj-EMXY=',1,'2025-04-09 08:46:27','2025-05-07 06:52:45'),(3,3,'Digital Art Pack','digital-art-pack','A small bundle of trendy digital wallpapers.',9.99,0,NULL,'https://media.istockphoto.com/id/1396217861/vi/vec-to/b%C3%ACa-s%C3%A1ng-t%E1%BA%A1o-ho%E1%BA%B7c-%C3%A1p-ph%C3%ADch-ngang-theo-phong-c%C3%A1ch-t%E1%BB%91i-thi%E1%BB%83u-hi%E1%BB%87n-%C4%91%E1%BA%A1i-cho-b%E1%BA%A3n-s%E1%BA%AFc-c%C3%B4ng-ty-x%C3%A2y.webp?s=2048x2048&w=is&k=20&c=c4QNgpKUGrWYRgZ4xhsBYqLmSaBc0rGvVjtxQXIeb38=',1,'2025-04-09 08:46:27','2025-04-24 08:10:26'),(4,2,'Casual Cap','casual-cap','Lightweight cap for sunny days.',12.49,4,NULL,'https://media.istockphoto.com/id/511586926/vi/anh/ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-tr%C6%B0%E1%BB%9Fng-th%C3%A0nh-%C4%91%E1%BB%99i-m%C5%A9-ng%E1%BB%93i-c%E1%BA%A1nh-c%C3%A2y.webp?s=2048x2048&w=is&k=20&c=T5lrWZtoufjdCjSb3qjDqH23UdFK6hn5tOlIz330DCA=',1,'2025-04-09 08:46:27','2025-05-07 06:18:18'),(5,1,'Eco-Friendly T-Shirt','eco-friendly-t-shirt','Sustainable fabric, modern fit.',19.95,0,NULL,'https://media.istockphoto.com/id/104641618/vi/anh/nh%C3%A0-m%C3%B4i-tr%C6%B0%E1%BB%9Dng-m%E1%BA%B7c-%C3%A1o-thun-t%C3%A1i-ch%E1%BA%BF.webp?s=2048x2048&w=is&k=20&c=wlNqx6kfqPk6em_Uk1C9pT9oXBXxg1zCGbnNiU-irHI=',1,'2025-04-09 08:46:27','2025-05-07 06:20:02'),(6,1,'tempore et ut','tempore-et-ut','Itaque et dolor sed culpa est dolorem. Quam ipsum molestias eius est. In atque voluptatem praesentium et voluptate.',40.00,0,NULL,'https://via.placeholder.com/300x300.png/002266?text=products+quia',1,'2025-04-09 08:46:27','2025-04-09 08:46:27'),(9,1,'dolore fugiat dolores','dolore-fugiat-dolores','Deserunt exercitationem itaque suscipit ut repudiandae. Tenetur commodi enim sit soluta neque ea. Enim consequatur nostrum est minima. Harum libero et quia quod molestiae quae fugiat ut.',175.43,0,NULL,'https://via.placeholder.com/300x300.png/00ff44?text=products+dolor',1,'2025-04-09 08:46:27','2025-04-09 08:46:27'),(11,1,'est blanditiis vel','est-blanditiis-vel','Expedita voluptatem enim voluptas quis excepturi sed necessitatibus. Alias numquam eaque voluptatem laboriosam. Rerum facilis ipsum perferendis deleniti. Voluptatem sapiente saepe a molestiae. Vel quos qui culpa debitis debitis delectus.',161.35,0,NULL,'https://via.placeholder.com/300x300.png/0000aa?text=products+quis',1,'2025-04-09 08:46:27','2025-04-09 08:46:27'),(12,1,'omnis eos consequatur','omnis-eos-consequatur','Nulla natus quo rerum quasi. Quod voluptatum ipsa voluptatibus quam enim. Magni natus aut officia nihil beatae facilis tempora qui. Dolorem aut quibusdam omnis vero eveniet ullam.',74.98,0,NULL,'https://via.placeholder.com/300x300.png/0000cc?text=products+nulla',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(13,2,'quos officia rerum','quos-officia-rerum','Eligendi aliquid voluptas assumenda commodi et. Accusantium quaerat dolores maiores explicabo vero sapiente totam. Qui voluptate mollitia ullam porro nostrum.',81.14,0,NULL,'https://via.placeholder.com/300x300.png/008833?text=products+architecto',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(14,2,'quidem fugiat architecto','quidem-fugiat-architecto','Eos magnam esse et ut beatae eligendi officia. Qui praesentium voluptas eius ipsam ipsam. Rem fugiat consectetur reprehenderit est ut. Voluptate nemo asperiores provident consectetur ullam harum laboriosam.',110.95,0,NULL,'https://via.placeholder.com/300x300.png/008844?text=products+non',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(15,2,'illo expedita autem','illo-expedita-autem','Rem autem sed aut qui dolor laboriosam. Culpa impedit maxime expedita fugiat vitae repudiandae. Perferendis molestiae ut cupiditate nihil.',60.57,0,NULL,'https://via.placeholder.com/300x300.png/007799?text=products+voluptatem',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(16,2,'doloribus quibusdam accusantium','doloribus-quibusdam-accusantium','Earum aliquam at eos dolorem. Architecto eos consequatur et eum rerum atque. Quia ipsam in quo dolores et unde qui est. Aliquam quam id dolorem sit et incidunt occaecati.',68.01,0,NULL,'https://via.placeholder.com/300x300.png/009999?text=products+eos',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(17,2,'maiores libero eveniet','maiores-libero-eveniet','Modi omnis beatae quas. At ipsa sit optio laborum ut. Sit possimus odit in nostrum minima molestias. Officiis iusto accusantium nisi. Aspernatur dolorum impedit qui repellendus non.',55.87,0,NULL,'https://via.placeholder.com/300x300.png/0055ee?text=products+pariatur',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(18,2,'qui et ad','qui-et-ad','Et quia temporibus nihil cum perferendis. Nisi maiores explicabo corporis ea eveniet occaecati. Fugiat cupiditate architecto ratione illum error. Quas maiores sint atque perferendis maxime quis. Ea corrupti quis similique ipsum alias.',111.78,0,NULL,'https://via.placeholder.com/300x300.png/002211?text=products+labore',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(19,2,'numquam inventore voluptatem','numquam-inventore-voluptatem','Praesentium quia ut dicta sunt ullam est. Quisquam qui tempora sunt. Non non et dolorum impedit maiores.',124.83,0,NULL,'https://via.placeholder.com/300x300.png/0000dd?text=products+excepturi',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(20,3,'minima ducimus eos','minima-ducimus-eos','Dolor laudantium enim non delectus. Sed ut laudantium aspernatur ut. Aut quis sapiente omnis ut eos commodi earum. Voluptatem sit ipsam qui unde dolores autem.',146.33,0,NULL,'https://via.placeholder.com/300x300.png/003377?text=products+error',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(21,3,'libero temporibus quas','libero-temporibus-quas','Quia dolor modi ullam eligendi qui. Repudiandae cum consequatur neque in perferendis occaecati suscipit. Quis est aliquam nesciunt corrupti autem blanditiis id. Laudantium illo recusandae beatae voluptates.',158.13,0,NULL,'https://via.placeholder.com/300x300.png/00ffaa?text=products+iure',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(22,3,'excepturi molestiae nam','excepturi-molestiae-nam','Rem veniam voluptatibus itaque aut fuga et voluptatum porro. Soluta nostrum amet sed impedit. Consequatur accusamus sit temporibus necessitatibus. In tenetur voluptas recusandae distinctio cupiditate ut. Neque esse dolores qui cum.',10.46,0,NULL,'https://via.placeholder.com/300x300.png/00cc33?text=products+autem',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(23,3,'inventore corporis harum','inventore-corporis-harum','Est eaque qui non minus soluta libero. Qui pariatur optio voluptatibus quia dolorem. Cumque quae non cum.',132.18,0,NULL,'https://via.placeholder.com/300x300.png/004433?text=products+nihil',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(24,3,'dolorem voluptatem fugit','dolorem-voluptatem-fugit','Alias est veniam eligendi aut. Ea fugit perferendis dolor et numquam.',166.17,0,NULL,'https://via.placeholder.com/300x300.png/00aa88?text=products+enim',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(25,3,'enim laudantium deserunt','enim-laudantium-deserunt','Molestias ut dicta aut corrupti culpa. Rerum quos recusandae et quaerat id veritatis consequatur omnis. Et quo a autem numquam tempora sit.',174.69,0,NULL,'https://via.placeholder.com/300x300.png/005533?text=products+velit',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(26,3,'quam dolores quia','quam-dolores-quia','Dolore placeat similique quia ullam. Est qui qui suscipit repellat qui qui voluptatibus. Ipsum minus quibusdam esse quo cumque quisquam dolor.',81.59,0,NULL,'https://via.placeholder.com/300x300.png/00bbdd?text=products+voluptas',1,'2025-04-09 08:46:28','2025-04-09 08:46:28'),(27,1,'AuraFlex Performance Tee 2','auraflex-performance-tee-2','The AuraFlex Performance Tee: Your go-to for active comfort and everyday style. Engineered for versatility.\r\n\r\n    Soft & Stretchy: Four-way stretch fabric moves with you.\r\n\r\n    Cool & Dry: Breathable and moisture-wicking material.\r\n\r\n    Stays Fresh: Odor-resistant technology built-in.\r\n\r\n    Versatile Design: Clean look transitions easily from gym to street.',28.99,15,NULL,'https://media.istockphoto.com/id/1072200596/vi/anh/ng%C6%B0%E1%BB%9Di-%C4%91%C3%A0n-%C3%B4ng-th%E1%BB%83-thao-m%E1%BB%89m-c%C6%B0%E1%BB%9Di-tr%C3%AAn-n%E1%BB%81n-%C4%91en.jpg?s=2048x2048&w=is&k=20&c=FJ1PTv9fGPqNbhbywVtAFjL645-h05iR1NlZyza73J4=',1,'2025-04-24 07:32:31','2025-05-07 01:42:14');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('sS04tRBhXy8hEJ2QeUnmKx9y0hyZ6toi6pCbYsNN',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2YwWFRoaTkzaTlDTU1lS3N0WTdmdGE0QkM1TEEwYVA4UERybFpUYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1746691631),('umGlPICxrmF7ey0fZh91VJjIPemS36YhgFQKe1rS',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVDQzVURpem8ydEc2MENiWEd1dFJxRDF6Nk0wQ01TdkVGeFN6aUtqaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1746672717),('vzFxVaFNGcsURMebWplN1NF93lIfn8cEPtWBYOV9',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3hOcXg2Rk8zSnM1Y2tnaUVPUmtyd3hnN3lNNzQ0R0hxRFNjR2MydiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1746693367);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com','2025-04-09 08:46:25','$2y$12$PIf0XxCSZjrYj17g5L8Vx.CjMjydZLbhJn3BmSCrux9ma9ebDGZ6m','admin',NULL,'2025-04-09 08:46:27','2025-05-07 06:25:38',NULL),(2,'Mrs. Helena Emmerich','hemmerich@example.org','2025-04-09 08:46:27','$2y$12$fYMDPGOIRU4SMZe0ntft7Oxyy4XTtPJHrh3AsBSj2ci21b/6la63.','customer','o6Ekadlw0R','2025-04-09 08:46:27','2025-04-09 08:46:27',NULL),(3,'Emie Wiegand','emiewie@example.com','2025-04-09 08:46:27','$2y$12$fYMDPGOIRU4SMZe0ntft7Oxyy4XTtPJHrh3AsBSj2ci21b/6la63.','customer','zbXTX1AJMC','2025-04-09 08:46:27','2025-04-09 08:46:27',NULL),(4,'Lowell Conn','loconn@example.com','2025-04-09 08:46:27','$2y$12$fYMDPGOIRU4SMZe0ntft7Oxyy4XTtPJHrh3AsBSj2ci21b/6la63.','customer','kgBHvtxAVa','2025-04-09 08:46:27','2025-04-09 08:46:27',NULL),(5,'Prof. Berenice Kihn DVM','berkihn@example.net','2025-04-09 08:46:27','$2y$12$fYMDPGOIRU4SMZe0ntft7Oxyy4XTtPJHrh3AsBSj2ci21b/6la63.','customer','jOlX0RXAjD','2025-04-09 08:46:27','2025-04-09 08:46:27',NULL),(6,'Ms. Anabelle Bernhard','parisian.anabernhard@example.org','2025-04-09 08:46:27','$2y$12$fYMDPGOIRU4SMZe0ntft7Oxyy4XTtPJHrh3AsBSj2ci21b/6la63.','customer','EHmUjUZXdP','2025-04-09 08:46:27','2025-04-09 08:46:27',NULL),(9,'Huy Vo','voquanghuy2806@gmail.com','2025-03-09 08:46:28','$2y$12$c5j.iZkIDT4cmuZzUE5Ev.x7B70CBIlKJlNqWiyPXe2.WeCu87n3u','customer','mmDPvTp6ocq8SsE5UYra1tf65Bpoq8vkXR139cFL8ccRm5li7and3sLNaDsY','2025-04-11 10:09:55','2025-05-07 09:51:22','2025-05-07 09:51:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-08 16:49:05
