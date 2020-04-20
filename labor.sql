-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: labor
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
-- Table structure for table `catalogs`
--

DROP TABLE IF EXISTS `catalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogs`
--

LOCK TABLES `catalogs` WRITE;
/*!40000 ALTER TABLE `catalogs` DISABLE KEYS */;
INSERT INTO `catalogs` VALUES (1,'entrada 1','INPUT','2020-03-02 06:51:26','2020-03-02 06:51:26'),(2,'proveedor 1','PROVIDER','2020-03-02 06:51:38','2020-03-02 06:51:38'),(3,'riesgo 1','RISK','2020-03-02 06:51:49','2020-03-02 06:51:49'),(4,'phva 1','PHVA','2020-03-02 06:52:00','2020-03-02 06:52:00'),(5,'Indicador 1','INDICATOR','2020-03-02 06:54:50','2020-03-02 06:54:50'),(6,'Indicador 2','INDICATOR','2020-03-02 06:54:56','2020-03-02 06:54:56'),(7,'entrada 2','INPUT','2020-03-02 19:55:48','2020-03-02 19:55:48'),(8,'proveedor 2','PROVIDER','2020-03-02 19:56:02','2020-03-02 19:56:02'),(9,'riesgo 2','RISK','2020-03-02 19:56:13','2020-03-02 19:56:13'),(10,'indicador 3','INDICATOR','2020-03-02 19:56:26','2020-03-02 19:56:26');
/*!40000 ALTER TABLE `catalogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
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
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
-- Table structure for table `macroprocesses`
--

DROP TABLE IF EXISTS `macroprocesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `macroprocesses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `macroprocess` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `macroprocesses`
--

LOCK TABLES `macroprocesses` WRITE;
/*!40000 ALTER TABLE `macroprocesses` DISABLE KEYS */;
INSERT INTO `macroprocesses` VALUES (1,'macroproceso 2','entrada 1','proveedor 2','a1','r1','p1','u1','riesgo 1','Indicador 2',0,'2020-03-02 06:56:14','2020-03-02 20:11:28'),(2,'macroproceso 2','entrada 1','proveedor 1','aa','rr','pp','uu','riesgo 1','Indicador 2',0,'2020-03-02 07:20:00','2020-03-02 07:20:00'),(3,'macroproceso 1','entrada 2','proveedor 2','as','res 1','pro 1','u3','riesgo 2','indicador 3',0,'2020-03-02 19:58:27','2020-03-02 19:58:27'),(4,'David','Hine','Hine','Hine','Hine','Hine','Hine','Hine','Hine',0,'2020-03-27 00:58:10','2020-03-27 00:58:10');
/*!40000 ALTER TABLE `macroprocesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2020_04_01_000000_create_macroprocess_table',1),(2,'2014_10_12_000000_create_users_table',2),(3,'2014_10_12_100000_create_password_resets_table',2),(4,'2019_08_19_000000_create_failed_jobs_table',2),(5,'2019_09_13_023425_create_projects_table',2),(6,'2019_09_13_023524_create_project_structures_table',2),(7,'2019_09_13_155024_create_permission_tables',2),(8,'2019_10_08_053835_create_jobs_table',2),(9,'2019_10_13_002127_create_catalogs_table',2),(10,'2019_10_17_035056_create_parameters_table',2),(11,'2019_10_18_154209_create_variables_table',2),(12,'2019_10_22_052248_create_subparameters_table',2),(13,'2019_11_27_204339_create_templates_table',2),(14,'2020_02_07_015937_create_notifications_table',2),(15,'2020_02_11_030135_create_websockets_statistics_entries_table',2),(16,'2020_02_17_045756_create_tasks_table',2),(17,'2020_02_28_022131_create_questions_table',2),(18,'2020_03_02_000000_create_processes_table',3),(19,'2020_03_02_000000_create_subprocesses_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
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
INSERT INTO `model_has_roles` VALUES (1,'App\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parameters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameters`
--

LOCK TABLES `parameters` WRITE;
/*!40000 ALTER TABLE `parameters` DISABLE KEYS */;
/*!40000 ALTER TABLE `parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'CR_users','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(2,'CRUD_users','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(3,'CR_projects','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(4,'CRUD_projects','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(5,'CRUD_parameters','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(6,'CRUD_macroprocess','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(7,'CRUD_tasks','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(8,'CRUD_catalogs','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(9,'R_reports','web','2020-03-02 06:49:15','2020-03-02 06:49:15'),(10,'simple_user','web','2020-03-02 06:49:15','2020-03-02 06:49:15');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processes`
--

DROP TABLE IF EXISTS `processes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subprocessProduct` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resultProduct` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phva` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subclassification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processes`
--

LOCK TABLES `processes` WRITE;
/*!40000 ALTER TABLE `processes` DISABLE KEYS */;
INSERT INTO `processes` VALUES (1,'manual','entrada 1','proveedor 1','a','a','proceso','a','a','riesgo 1','phva 1','a','Indicador 1',0,'2020-03-03 01:44:05','2020-03-03 01:44:05'),(2,'manual','entrada 1','proveedor 1','rrr','gtgtg','proceso','7777','ghghgh','riesgo 1','phva 1','ghghgh','Indicador 1',0,'2020-03-31 22:27:36','2020-03-31 22:27:36'),(3,'macroproceso 2 - p1','entrada 2','proveedor 2','jijju','njnjn','proceso','njnjnj','njnjnj','riesgo 1','phva 1','njnnjn','Indicador 1',0,'2020-03-31 22:54:50','2020-03-31 22:54:50'),(4,'macroproceso 2 - p1','[\"entrada 1\",\"ss\"]','[\"sss\"]','sss','sss','proceso','sss','sss','[\"riesgo 1\",\"sss\"]','[\"phva 1\",\"sss\"]','ssss','[\"Indicador 1\",\"ssss\"]',0,'2020-04-01 02:46:41','2020-04-01 02:46:41'),(5,'macroproceso 2 - pp','[\"entrada 1\"]','[\"proveedor 1\"]','kk','kkk','producto','pppp','oooo','[]','[\"phva 1\"]','ooo','[\"Indicador 1\"]',0,'2020-04-01 07:47:08','2020-04-01 07:47:08');
/*!40000 ALTER TABLE `processes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_structures`
--

DROP TABLE IF EXISTS `project_structures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_structures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `levels` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_structures`
--

LOCK TABLES `project_structures` WRITE;
/*!40000 ALTER TABLE `project_structures` DISABLE KEYS */;
INSERT INTO `project_structures` VALUES (2,0,'\"{\\\"name\\\":\\\"Estructura de niveles\\\",\\\"level\\\":0,\\\"numGoals\\\":1,\\\"goals\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"Estrat\'egico 1\\\",\\\"pos\\\":1,\\\"objectCode\\\":\\\" fe44vl7uhbmdz5vao5ygnnolkj2ijovqw8ryden89qb7o9yq1nb2tj1h\\\"}],\\\"isOpen\\\":true,\\\"featherNode\\\":false,\\\"children\\\":[{\\\"name\\\":\\\"RRHH\\\",\\\"level\\\":1,\\\"numGoals\\\":1,\\\"featherNode\\\":false,\\\"goals\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"OBJ RRRH !\\\",\\\"pos\\\":1,\\\"objectCode\\\":\\\" 5bflasazengbl25fgvse82qd6vwp1nzx461zduxi4wcnyx21tvza3f2v\\\"}],\\\"inheritedGoals\\\":[],\\\"macroprocess\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"M1\\\",\\\"goals\\\":[1]},{\\\"code\\\":\\\"25\\\",\\\"name\\\":\\\"RRHH 4\\\",\\\"goals\\\":[1]}],\\\"isOpen\\\":true,\\\"children\\\":[{\\\"name\\\":\\\"RECLUTAMIENTO\\\",\\\"level\\\":2,\\\"numGoals\\\":1,\\\"featherNode\\\":true,\\\"goals\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"obj 1\\\",\\\"pos\\\":1,\\\"objectCode\\\":\\\" mhyjwc3li12pljbja72gdyeobo9z5mdczezo5j2646qcxqzx3ncxuueo\\\"}],\\\"inheritedGoals\\\":[],\\\"macroprocess\\\":[{\\\"code\\\":\\\"macro 1\\\",\\\"name\\\":\\\"1\\\",\\\"goals\\\":[1]},{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"Macro 1\\\",\\\"goals\\\":[1]}]}]},{\\\"name\\\":\\\"FINANCIERO\\\",\\\"level\\\":1,\\\"numGoals\\\":1,\\\"featherNode\\\":false,\\\"goals\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"Financiero 1\\\",\\\"pos\\\":1,\\\"objectCode\\\":\\\" jfvpukravwfdnomra4rlpew8t9gfczg2ekt5haxd1iox6vjgpvmeaz38\\\"}],\\\"inheritedGoals\\\":[],\\\"macroprocess\\\":[],\\\"isOpen\\\":true,\\\"children\\\":[{\\\"name\\\":\\\"PAGOS\\\",\\\"level\\\":2,\\\"numGoals\\\":1,\\\"featherNode\\\":true,\\\"goals\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"obj pagos 1\\\",\\\"pos\\\":1,\\\"objectCode\\\":\\\" tw5qkl37nwwtplge4kv5zby3scdek98t83ejgmec17smm1a2u7iah3kx\\\"}],\\\"inheritedGoals\\\":[],\\\"macroprocess\\\":[{\\\"code\\\":\\\"1\\\",\\\"name\\\":\\\"macro 1 pagos\\\",\\\"goals\\\":[1]}]}]}]}\"','2020-03-10 02:36:04','2020-03-28 22:23:01');
/*!40000 ALTER TABLE `project_structures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_project` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_sponsor` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_auxiliar` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (0,'PRUEBA','default.png','default.png','default.png','Proyecto carga de trabajo para PRUEBA','2020-03-10 02:36:04','2020-03-10 02:36:04');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','web','2020-03-02 06:49:15','2020-03-02 06:49:15');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subparameters`
--

DROP TABLE IF EXISTS `subparameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subparameters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subparameters`
--

LOCK TABLES `subparameters` WRITE;
/*!40000 ALTER TABLE `subparameters` DISABLE KEYS */;
/*!40000 ALTER TABLE `subparameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subprocesses`
--

DROP TABLE IF EXISTS `subprocesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subprocesses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `process` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phva` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subprocesses`
--

LOCK TABLES `subprocesses` WRITE;
/*!40000 ALTER TABLE `subprocesses` DISABLE KEYS */;
INSERT INTO `subprocesses` VALUES (1,'manual','entrada 1','proveedor 1','a','a','a','a','riesgo 1','phva 1','Indicador 1',0,'2020-03-03 03:03:19','2020-03-03 03:03:19'),(2,'macroproceso 2 - p1 - proceso','[\"entrada 1\"]','[\"dd\"]','dd','dd','ddd','ddd','[\"ddd\"]','[\"phva 1\"]','[\"Indicador 1\"]',0,'2020-04-01 07:15:20','2020-04-01 07:15:20');
/*!40000 ALTER TABLE `subprocesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `related_to` json NOT NULL,
  `id_project` bigint(20) NOT NULL,
  `id_process` bigint(20) NOT NULL,
  `frecuency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `std_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stencil` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workingsince` date NOT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workday` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ethnic` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127001','John Doe','N/A','1900-01-01','N/A','1900-01-01','N/A','super@admin.com',NULL,'N/A','N/A','0','N/A','N/A','$2y$10$PIqnyr/FPFDwPqHcnUn8A.dsLfv2IHOasd/5euZfV/MpGznFIxP9a','N/A','default.png',NULL,'2020-03-02 06:49:15','2020-03-02 06:49:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variables`
--

DROP TABLE IF EXISTS `variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subparameter_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identificator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variables`
--

LOCK TABLES `variables` WRITE;
/*!40000 ALTER TABLE `variables` DISABLE KEYS */;
/*!40000 ALTER TABLE `variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websockets_statistics_entries`
--

DROP TABLE IF EXISTS `websockets_statistics_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websockets_statistics_entries`
--

LOCK TABLES `websockets_statistics_entries` WRITE;
/*!40000 ALTER TABLE `websockets_statistics_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `websockets_statistics_entries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-01  7:55:26
