-- MySQL dump 10.13  Distrib 5.7.10, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meals`
--

DROP TABLE IF EXISTS `meals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `calories` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meals_user_id_foreign` (`user_id`),
  KEY `meals_date_index` (`date`),
  KEY `meals_time_index` (`time`),
  CONSTRAINT `meals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meals`
--

LOCK TABLES `meals` WRITE;
/*!40000 ALTER TABLE `meals` DISABLE KEYS */;
INSERT INTO `meals` VALUES (1,3,'2016-05-26','15:47','Aut non impedit ut molestias ab sed. Et et quis alias reiciendis.',528,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(2,3,'2016-05-07','18:34','Et omnis ipsa aut dolores. Officiis nam laboriosam voluptas dolore.',1481,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(3,3,'2016-05-27','17:27','Repellendus quia est qui repellat at et ea illo. Eos est quia nobis.',727,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(4,3,'2016-05-17','16:36','Est facilis amet in in officiis a. Harum neque voluptatibus quia illum accusamus consectetur iusto.',266,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(5,3,'2016-05-31','03:17','Cum ea et voluptatem qui. Possimus temporibus iste quibusdam hic hic beatae.',1897,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(6,3,'2016-05-17','20:47','Nihil et enim quisquam. Quis maiores totam est reprehenderit.',2178,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(7,3,'2016-05-25','00:09','At id facilis adipisci culpa. Eos dolorem illo consequatur quia.',2129,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(8,4,'2016-05-16','22:09','Odio nihil et vero commodi. Voluptate est et ad.',1025,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(9,4,'2016-05-20','19:38','Est ut optio perspiciatis sint et. Maxime mollitia iusto adipisci debitis.',2214,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(10,4,'2016-05-07','08:54','Eius quasi ut autem voluptatem. Laboriosam optio dignissimos ut quia rerum.',1583,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(11,4,'2016-05-16','01:37','Ad illo sed rerum qui. Et rerum et officiis id. Omnis veritatis numquam maxime sed et molestiae.',2118,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(12,5,'2016-05-17','23:21','In hic facilis a quasi velit. Quia qui sint neque eos.',643,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(13,5,'2016-06-05','15:01','Maxime commodi minus ducimus voluptatibus aut dicta. Et ut assumenda quis sed nisi.',1577,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(14,5,'2016-05-11','08:28','Enim ex reprehenderit atque doloremque. Eligendi beatae ullam nihil.',1958,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(15,5,'2016-05-08','08:07','Quia voluptatum sunt quisquam exercitationem magnam. Aliquid in qui vero vero dolore veniam.',1348,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(16,5,'2016-05-09','14:34','Ipsam dolor sint quos. Non qui est consequatur ipsam exercitationem reiciendis optio amet.',2436,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(17,6,'2016-05-20','04:44','Natus voluptatibus fugiat dolorum quo. Quasi iure facere laborum quam nesciunt fugit quidem.',662,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(18,6,'2016-05-18','04:23','Odio consequatur id at. Qui voluptates dolor rem aliquid.',233,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(19,6,'2016-06-05','03:56','Sint expedita voluptatibus harum quia harum aut officia. Aut corporis et repellat est dolores.',212,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(20,6,'2016-05-26','22:43','Nam accusamus similique et. Cupiditate laboriosam nesciunt nemo sed.',1375,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(21,6,'2016-06-02','07:03','Provident et recusandae libero voluptatum explicabo. Officiis doloremque laboriosam aut illo.',1973,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(22,6,'2016-05-12','11:24','Quia quia numquam culpa. Dolorum perspiciatis minus saepe odit. Autem sed ut quia sed qui.',1663,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(23,7,'2016-06-05','02:37','Magnam ab ex omnis impedit. Nisi temporibus temporibus ducimus quidem. Voluptas vel sed nemo ut.',1376,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(24,7,'2016-06-06','01:03','Nihil similique dolores facilis dolores. Reiciendis omnis consectetur tempore et ipsum.',915,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(25,7,'2016-06-02','10:45','Eum voluptatem totam quia qui. Rem nesciunt nisi doloremque. Earum quam doloribus vitae.',430,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(26,7,'2016-05-25','09:45','Blanditiis sint dolor quasi nihil. Error perferendis nostrum dolores dolorem.',529,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(27,7,'2016-05-31','23:51','Sit harum et expedita. Sed facere sapiente laboriosam eos id.',2145,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(28,7,'2016-05-22','04:29','Veritatis quasi aperiam aliquam quia. Sapiente molestiae ut eum cupiditate eligendi.',1938,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(29,7,'2016-05-29','05:51','Quam repellat quia voluptatum eos vitae. Quia magni ab aliquid ut quasi dolore vel.',1705,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(30,8,'2016-06-05','10:42','Qui harum quo voluptates sint. Consequuntur veritatis fugit vitae reiciendis laborum enim et.',1640,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(31,8,'2016-06-05','21:31','Magnam voluptas quia tenetur et est non. Beatae animi sit enim.',1456,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(32,8,'2016-05-21','12:36','Ipsa facere dolores sed molestiae perspiciatis omnis. Vitae doloribus non debitis ea dignissimos.',1731,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(33,8,'2016-05-10','09:52','Sit expedita culpa perspiciatis pariatur doloribus voluptas. Occaecati aut libero fugit.',1400,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(34,8,'2016-05-10','16:51','Voluptas ducimus enim qui consectetur. Dolores unde unde praesentium nisi.',1434,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(35,9,'2016-06-06','05:33','Maxime voluptas accusantium nisi et. Tenetur dolore enim ut provident quia eius vel adipisci.',907,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(36,9,'2016-05-31','20:46','Voluptas perferendis vel iure aliquid. Tenetur quo ipsum aut reprehenderit illo officia.',2417,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(37,9,'2016-05-16','11:38','Omnis ullam aut omnis ut rerum. Ut sint odio provident tempore id dolorem soluta et.',1098,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(38,9,'2016-05-14','08:16','Nemo quo quibusdam natus velit. Libero quam praesentium consequatur natus non tenetur.',2018,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(39,9,'2016-05-11','02:08','Aut non ut consequatur autem aliquam. Nihil voluptas sit at reprehenderit repudiandae ipsa sint.',1201,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(40,9,'2016-06-04','02:49','Omnis ipsum ab voluptas repudiandae beatae. Voluptatum autem quae in quia.',364,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(41,9,'2016-05-20','08:01','Doloribus amet asperiores nihil. Nisi inventore ut qui id delectus. Ullam est optio dolorem qui.',820,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(42,9,'2016-05-27','07:03','A id omnis vero harum sunt vel. Est quas sunt ut dolorem aut dolores.',1137,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(43,10,'2016-05-15','06:01','Vitae voluptates accusantium dignissimos illo. Neque dolorum sed omnis similique.',342,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(44,10,'2016-05-11','22:41','Inventore et repellat alias occaecati non. Ipsum quae veniam sequi ullam saepe sequi.',499,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(45,10,'2016-05-11','19:05','Neque autem est quod. A quos rerum nisi perferendis dolor aut.',1860,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(46,10,'2016-05-29','10:35','Et eos reprehenderit quia. Placeat quam ipsum repudiandae a. Voluptates nostrum ut totam.',1585,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(47,10,'2016-05-19','20:25','Alias dolor cumque magni nobis. Harum animi sed aut voluptas laboriosam quod dolore sit.',944,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(48,11,'2016-05-30','04:08','Laudantium distinctio assumenda reiciendis perspiciatis. Dignissimos ut quia recusandae dolor amet.',2279,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(49,11,'2016-05-31','00:28','Blanditiis enim maiores et rerum asperiores ab et ut. Nihil deleniti pariatur eum laboriosam.',1187,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(50,11,'2016-05-08','03:59','Rem quia suscipit harum sed dolorum saepe. Sit et minima hic velit. Est aut ad animi.',2326,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(51,11,'2016-05-18','21:46','Nostrum ullam earum distinctio praesentium. Dolore eveniet est tenetur id velit consectetur.',1891,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(52,11,'2016-05-25','16:10','Quia eligendi modi voluptatem repellat accusantium. Veniam sapiente placeat temporibus aut.',2297,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(53,11,'2016-06-02','04:58','Quasi rerum blanditiis aspernatur doloremque iusto consectetur quia. Et dolorum est at doloribus.',337,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(54,12,'2016-05-22','16:44','Velit consequatur est autem aut saepe. Et omnis at reprehenderit. Qui velit enim ipsa nostrum.',602,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(55,12,'2016-06-03','11:29','Voluptatem sapiente nulla natus. Illo consequatur officia sit. Id animi temporibus vel tempora.',1976,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(56,12,'2016-06-04','03:20','Ipsa enim quod consequatur eum. Non omnis molestiae tenetur laudantium.',1165,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(57,12,'2016-05-12','17:30','Magni natus odit eius. Sed eveniet ut commodi tempore. Iure ut aut dicta error.',1921,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(58,12,'2016-05-25','08:37','Doloribus nihil autem id hic. Mollitia cumque quia qui corporis corrupti. Dolores eaque nemo alias.',578,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(59,12,'2016-05-09','04:51','Et similique delectus ut aliquam. Ut odit iste quia maiores et impedit ut.',790,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(60,12,'2016-05-23','22:02','Cupiditate corporis qui nostrum a. Perspiciatis omnis culpa qui non eum molestiae.',1676,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(61,12,'2016-05-25','14:57','Necessitatibus ad maxime et voluptatem. Cumque qui ut sit. Nesciunt rem aut quo magni.',930,'2016-06-06 16:28:25','2016-06-06 16:28:25');
/*!40000 ALTER TABLE `meals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_06_04_182941_create_failed_jobs_table',1),('2016_06_04_203828_entrust_setup_tables',1),('2016_06_06_142837_create_meals_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(2,1),(2,2);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'manage-record','Manage Records','Edit records of other users','2016-06-06 16:28:23','2016-06-06 16:28:23'),(2,'manage-user','Manage Users','Edit existing users','2016-06-06 16:28:23','2016-06-06 16:28:23');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrator','User is allowed to manage and edit other users and their records','2016-06-06 16:28:23','2016-06-06 16:28:23'),(2,'manager','User Manager','User is allowed to manage and edit other users','2016-06-06 16:28:23','2016-06-06 16:28:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `calories_per_day` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John Smith',2000,'admin@test.com','$2y$10$EEQOwaIegGrGwKt2SROjeu0NPuKSrk1HdgLE228C4KRtHeTR5YVDi',NULL,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(2,'Jack Doe',2000,'manager@test.com','$2y$10$AigZT4XKqWoZCHWopjThgOS.Tm94UbkCfgvBwUT.jpl8w1W6FXM2y',NULL,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(3,'Vance Rice',2000,'user1@test.com','$2y$10$nXG5BL.NdmC9P74/KaZWYuqet55UFxhraQipJJDFQJvDURkS5pFJG',NULL,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(4,'Whitney Crona',2000,'user2@test.com','$2y$10$lH6xEsC1zGo1Lu0bWRwD6efWJJMSGGVCO47c6itchuuhAbSQMX3S6',NULL,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(5,'Prof. Mallory Welch PhD',2000,'user3@test.com','$2y$10$4VqMkxOcFBgybdj8inQvN.IzVW/NiCkRcP6DweT8mjCBvLbhAsvHG',NULL,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(6,'Ms. Kamille Harris V',2000,'user4@test.com','$2y$10$YgCizyvJLLJj.HUWLi3mQe/12nHQMBqVcJWWDPxtdJgJgRY./Ayxu',NULL,'2016-06-06 16:28:24','2016-06-06 16:28:24'),(7,'Mr. Clement Little',2000,'user5@test.com','$2y$10$L7PhP/gaFHQGqwFqKeDLs.Wgb.6Kd1x3.DidJ1gSEz4EZCXnH1qNK',NULL,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(8,'Adam Wyman Sr.',2000,'user6@test.com','$2y$10$PfdJ.BnviLK7pROYVO539emIuueBCaE3WJUqOklosGN8jkGYwl3CG',NULL,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(9,'Arvid Bailey',2000,'user7@test.com','$2y$10$h/XZjMZAmHbJOla8Jbc4VuqheFemYMTsdrCd6qxPo1Uh.nLRqPWVi',NULL,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(10,'Claire Muller',2000,'user8@test.com','$2y$10$t22xeeE9/xWVeUBdN0Ydd.OBDN20lGrB9QE1HBriLnnzcoHtTYPmm',NULL,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(11,'Edwardo Runolfsson',2000,'user9@test.com','$2y$10$.VmhYTJm4EepbXnho4mA4.AWS7vRhIcpMZZ3JZSUtU8dp9fDfRZMy',NULL,'2016-06-06 16:28:25','2016-06-06 16:28:25'),(12,'Virgie Wehner',2000,'user10@test.com','$2y$10$uiM8Jyil0qlqr4Kzs0t12OXQad2dIQ2tP84XeZwc6SzQecFqSsaJG',NULL,'2016-06-06 16:28:25','2016-06-06 16:28:25');
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

-- Dump completed on 2016-06-06 17:20:07
