/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `closing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `closing` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `cust_has_not_paid` int DEFAULT NULL,
  `main_balance` int NOT NULL,
  `receivables` int DEFAULT NULL,
  `debt` int DEFAULT NULL,
  `shop_receivables` int NOT NULL,
  `shop_capital` int NOT NULL,
  `who_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `closing_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `closing_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `closing_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `nominal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `closing_detail_closing_id_foreign` (`closing_id`),
  KEY `closing_detail_customer_id_foreign` (`customer_id`),
  CONSTRAINT `closing_detail_closing_id_foreign` FOREIGN KEY (`closing_id`) REFERENCES `closing` (`id`),
  CONSTRAINT `closing_detail_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `npwp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ongkosan` int DEFAULT NULL,
  `borongan` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `customer_alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_alias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `npwp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ongkosan` int DEFAULT NULL,
  `borongan` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_alias_customer_id_foreign` (`customer_id`),
  CONSTRAINT `customer_alias_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cv` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `who_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who_update` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `delivery_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_order` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_date` date NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned DEFAULT NULL,
  `driver_id` bigint unsigned DEFAULT NULL,
  `transaction_type` enum('Tempo Panjang','Kontan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `grand_total` int NOT NULL,
  `total_payment` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who_update` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cv_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_order_supplier_id_foreign` (`supplier_id`),
  KEY `delivery_order_vehicle_id_foreign` (`vehicle_id`),
  KEY `delivery_order_driver_id_foreign` (`driver_id`),
  KEY `delivery_order_cv_id_foreign` (`cv_id`),
  CONSTRAINT `delivery_order_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `delivery_order_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  CONSTRAINT `delivery_order_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  CONSTRAINT `delivery_order_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `delivery_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_order_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_sj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_faktur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_order_id` bigint unsigned NOT NULL,
  `stock_id` bigint unsigned NOT NULL,
  `purchase_amount` int NOT NULL,
  `subtotal` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_order_detail_delivery_order_id_foreign` (`delivery_order_id`),
  KEY `delivery_order_detail_stock_id_foreign` (`stock_id`),
  CONSTRAINT `delivery_order_detail_delivery_order_id_foreign` FOREIGN KEY (`delivery_order_id`) REFERENCES `delivery_order` (`id`),
  CONSTRAINT `delivery_order_detail_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `delivery_order_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_order_payment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `delivery_order_id` bigint unsigned NOT NULL,
  `amount` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `delivery_order_quota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_order_quota` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `delivery_order_id` bigint unsigned NOT NULL,
  `purchase_amount` int NOT NULL,
  `subtotal` int NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `purchase_date` date NOT NULL,
  `price_kg` int NOT NULL,
  `first_stock` int NOT NULL,
  `stock_in_use` int NOT NULL,
  `last_stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_order_quota_delivery_order_id_foreign` (`delivery_order_id`),
  KEY `delivery_order_quota_product_id_foreign` (`product_id`),
  CONSTRAINT `delivery_order_quota_delivery_order_id_foreign` FOREIGN KEY (`delivery_order_id`) REFERENCES `delivery_order` (`id`),
  CONSTRAINT `delivery_order_quota_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `driver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `driver` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_category_id` bigint unsigned NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_product_category_id_foreign` (`product_category_id`),
  CONSTRAINT `product_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_cv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_cv` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `cv_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_cv_role_id_cv_id_unique` (`role_id`,`cv_id`),
  KEY `role_cv_cv_id_foreign` (`cv_id`),
  CONSTRAINT `role_cv_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_cv_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `selling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `selling` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  `driver_id` bigint unsigned NOT NULL,
  `drivers_pocket_money` int NOT NULL,
  `net_profit` int NOT NULL,
  `grand_total` int NOT NULL,
  `total_payment` int NOT NULL,
  `purchasing_method` enum('tempo','titipan','kontan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('In Progress','On Progress','Completed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('cash','transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '2025-08-04 12:51:16',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `selling_customer_id_foreign` (`customer_id`),
  KEY `selling_vehicle_id_foreign` (`vehicle_id`),
  KEY `selling_driver_id_foreign` (`driver_id`),
  CONSTRAINT `selling_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `selling_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  CONSTRAINT `selling_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `selling_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `selling_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `selling_id` bigint unsigned NOT NULL,
  `stock_id` bigint unsigned NOT NULL,
  `price_kg` int NOT NULL,
  `price_sell` int NOT NULL,
  `qty` int NOT NULL,
  `subtotal` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `selling_detail_selling_id_foreign` (`selling_id`),
  KEY `selling_detail_stock_id_foreign` (`stock_id`),
  CONSTRAINT `selling_detail_selling_id_foreign` FOREIGN KEY (`selling_id`) REFERENCES `selling` (`id`),
  CONSTRAINT `selling_detail_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `spending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spending` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spending_category_id` bigint unsigned NOT NULL,
  `cv_id` bigint unsigned DEFAULT NULL,
  `mutation` enum('Uang Masuk','Uang Keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'CASH',
  `nominal` int DEFAULT NULL,
  `who_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who_update` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spending_spending_category_id_foreign` (`spending_category_id`),
  KEY `spending_cv_id_foreign` (`cv_id`),
  CONSTRAINT `spending_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`id`) ON DELETE CASCADE,
  CONSTRAINT `spending_spending_category_id_foreign` FOREIGN KEY (`spending_category_id`) REFERENCES `spending_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `spending_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spending_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `spending_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `purchase_date` date NOT NULL,
  `is_active` int NOT NULL,
  `price_kg` int NOT NULL,
  `first_stock` int NOT NULL,
  `stock_in_use` int NOT NULL,
  `last_stock` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_product_id_foreign` (`product_id`),
  CONSTRAINT `stock_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `npwp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cv_id` bigint unsigned NOT NULL,
  `percentage` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_cv_id_foreign` (`cv_id`),
  CONSTRAINT `tax_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_plate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vehicle_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_service` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `driver_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  `cv_id` bigint unsigned DEFAULT NULL,
  `who_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who_update` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_service_driver_id_foreign` (`driver_id`),
  KEY `vehicle_service_vehicle_id_foreign` (`vehicle_id`),
  KEY `vehicle_service_cv_id_foreign` (`cv_id`),
  CONSTRAINT `vehicle_service_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vehicle_service_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  CONSTRAINT `vehicle_service_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vehicle_service_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_service_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_service_id` bigint unsigned NOT NULL,
  `amount_of_expenditure` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_service_detail_vehicle_service_id_foreign` (`vehicle_service_id`),
  CONSTRAINT `vehicle_service_detail_vehicle_service_id_foreign` FOREIGN KEY (`vehicle_service_id`) REFERENCES `vehicle_service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_reset_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2023_10_25_021427_add_field_role_in_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2023_10_25_021554_create_table_product_category',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2023_10_25_021716_create_supplier_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2023_10_25_021814_create_driver_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2023_10_25_021915_create_spending_category_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2023_10_25_021936_create_customer_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2023_10_25_022034_create_vehicle_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2023_10_25_022128_create_spending_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2023_10_31_142949_create_role_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2023_11_12_120259_create_product_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2023_11_15_143424_create_delivery_order_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2023_11_22_130651_create_selling_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2023_11_22_130710_create_stock_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2023_11_22_130711_create_selling_detail_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2023_12_04_130047_create_delivery_order_detail_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2023_12_14_141148_create_vehicle_service_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2023_12_17_134747_create_vehicle_service_detail_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2023_12_26_071756_change_created_at_in_selling_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2024_01_02_143302_rename_name_table_product_category',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2024_01_12_172926_create_closing_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2024_01_12_174808_create_closing_detail_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2024_06_30_072536_create_delivery_order_quota_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2024_06_30_080616_remove_pickup_date_in_delivery_order',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2024_07_11_043517_create_delivery_order_payment_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2024_07_27_071221_set_nullable_driver_delivery_order_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2025_07_26_122831_add_npwp_to_supplier_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2025_07_26_145908_create_cv_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2025_07_26_145929_create_tax_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2025_07_26_155426_add_no_sj_to_delivery_order_quota_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2025_07_26_155439_add_no_faktur_to_delivery_order_quota_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2025_07_26_163142_drop_no_sj_and_no_faktur_from_delivery_order_quota_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_07_26_163824_add_delivery_order_quota_id_no_faktur_no_sj_to_stock_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_07_26_172406_del_column_quota_id_no_sj_no_faktur_from_stock_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2025_07_29_144120_add_cv_id_to_delivery_order_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2025_08_02_122927_add_column_npwp_into_customer_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2025_08_02_140353_create_customer_alias_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2025_08_02_144407_remove_deleted_at_from_customer_alias_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2025_08_06_131548_add_column_nik_into_customer_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2025_08_06_131604_add_column_nik_into_customer_alias_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2025_08_06_134806_add_column_nik_into_supplier_alias_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2025_09_11_151308_create_roles_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_09_11_151349_create_permissions_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_09_11_151357_create_role_permissions_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2025_09_11_151405_add_role_id_to_users_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2025_09_11_160548_alter_table_remove_user_field_in_users_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2025_09_12_175511_create_role_cv_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2025_09_12_190824_add_cv_id_to_spending_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2025_09_12_190835_add_cv_id_to_vehicle_service_table',6);
