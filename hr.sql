-- MySQL dump 10.13  Distrib 8.0.18, for Linux (x86_64)
--
-- Host: localhost    Database: hr
-- ------------------------------------------------------
-- Server version	8.0.18-0ubuntu0.19.10.1

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
-- Table structure for table `account_services`
--

DROP TABLE IF EXISTS `account_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_services_title_id_foreign` (`title_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_services`
--

LOCK TABLES `account_services` WRITE;
/*!40000 ALTER TABLE `account_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_type_services`
--

DROP TABLE IF EXISTS `account_type_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_type_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_type_services_service_id_foreign` (`service_id`),
  KEY `account_type_services_type_id_foreign` (`type_id`),
  CONSTRAINT `account_type_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `account_services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `account_type_services_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `account_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_type_services`
--

LOCK TABLES `account_type_services` WRITE;
/*!40000 ALTER TABLE `account_type_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_type_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  `default_provider` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_types_title_id_foreign` (`title_id`),
  CONSTRAINT `account_types_title_id_foreign` FOREIGN KEY (`title_id`) REFERENCES `texts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_types`
--

LOCK TABLES `account_types` WRITE;
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider` bigint(20) unsigned DEFAULT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` bigint(20) unsigned NOT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attachments_file_id_foreign` (`file_id`),
  CONSTRAINT `attachments_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availabilities`
--

DROP TABLE IF EXISTS `availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `min` double(8,2) DEFAULT NULL,
  `max` double(8,2) DEFAULT NULL,
  `places` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availabilities`
--

LOCK TABLES `availabilities` WRITE;
/*!40000 ALTER TABLE `availabilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `availabilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability_places`
--

DROP TABLE IF EXISTS `availability_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `availability_places` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `places` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability_places`
--

LOCK TABLES `availability_places` WRITE;
/*!40000 ALTER TABLE `availability_places` DISABLE KEYS */;
/*!40000 ALTER TABLE `availability_places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability_types`
--

DROP TABLE IF EXISTS `availability_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `availability_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability_types`
--

LOCK TABLES `availability_types` WRITE;
/*!40000 ALTER TABLE `availability_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `availability_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `benefit_availabilities`
--

DROP TABLE IF EXISTS `benefit_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `benefit_availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benefit_availabilities`
--

LOCK TABLES `benefit_availabilities` WRITE;
/*!40000 ALTER TABLE `benefit_availabilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `benefit_availabilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `benefit_types`
--

DROP TABLE IF EXISTS `benefit_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `benefit_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benefit_types`
--

LOCK TABLES `benefit_types` WRITE;
/*!40000 ALTER TABLE `benefit_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `benefit_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `benefits`
--

DROP TABLE IF EXISTS `benefits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `benefits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` bigint(20) unsigned NOT NULL,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `benefits_type_foreign` (`type`),
  CONSTRAINT `benefits_type_foreign` FOREIGN KEY (`type`) REFERENCES `benefit_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benefits`
--

LOCK TABLES `benefits` WRITE;
/*!40000 ALTER TABLE `benefits` DISABLE KEYS */;
/*!40000 ALTER TABLE `benefits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certification_allowed_categories`
--

DROP TABLE IF EXISTS `certification_allowed_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certification_allowed_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` bigint(20) unsigned NOT NULL,
  `category` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certification_allowed_categories`
--

LOCK TABLES `certification_allowed_categories` WRITE;
/*!40000 ALTER TABLE `certification_allowed_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `certification_allowed_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certification_categories`
--

DROP TABLE IF EXISTS `certification_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certification_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certification_categories`
--

LOCK TABLES `certification_categories` WRITE;
/*!40000 ALTER TABLE `certification_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `certification_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certification_category_list`
--

DROP TABLE IF EXISTS `certification_category_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certification_category_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `certification_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `certification_category_list_certification_id_foreign` (`certification_id`),
  KEY `certification_category_list_category_id_foreign` (`category_id`),
  CONSTRAINT `certification_category_list_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `certification_categories` (`id`),
  CONSTRAINT `certification_category_list_certification_id_foreign` FOREIGN KEY (`certification_id`) REFERENCES `certifications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certification_category_list`
--

LOCK TABLES `certification_category_list` WRITE;
/*!40000 ALTER TABLE `certification_category_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `certification_category_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certification_types`
--

DROP TABLE IF EXISTS `certification_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certification_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certification_types`
--

LOCK TABLES `certification_types` WRITE;
/*!40000 ALTER TABLE `certification_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `certification_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certifications`
--

DROP TABLE IF EXISTS `certifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` bigint(20) unsigned DEFAULT NULL,
  `attachments` bigint(20) unsigned NOT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certifications_category_foreign` (`category`),
  CONSTRAINT `certifications_category_foreign` FOREIGN KEY (`category`) REFERENCES `certification_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certifications`
--

LOCK TABLES `certifications` WRITE;
/*!40000 ALTER TABLE `certifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `certifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries_currencies`
--

DROP TABLE IF EXISTS `countries_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries_currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) unsigned NOT NULL,
  `currency_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `countries_currencies_country_id_foreign` (`country_id`),
  KEY `countries_currencies_currency_id_foreign` (`currency_id`),
  CONSTRAINT `countries_currencies_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `countries_currencies_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries_currencies`
--

LOCK TABLES `countries_currencies` WRITE;
/*!40000 ALTER TABLE `countries_currencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  `symbol` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duties`
--

DROP TABLE IF EXISTS `duties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `duties` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duties`
--

LOCK TABLES `duties` WRITE;
/*!40000 ALTER TABLE `duties` DISABLE KEYS */;
/*!40000 ALTER TABLE `duties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_availabilities`
--

DROP TABLE IF EXISTS `evaluation_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` bigint(20) unsigned NOT NULL,
  `type` bigint(20) unsigned NOT NULL,
  `min` double(8,2) DEFAULT NULL,
  `max` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_availabilities_evaluation_id_foreign` (`evaluation_id`),
  CONSTRAINT `evaluation_availabilities_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_availabilities`
--

LOCK TABLES `evaluation_availabilities` WRITE;
/*!40000 ALTER TABLE `evaluation_availabilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_availabilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_job_suitability`
--

DROP TABLE IF EXISTS `evaluation_job_suitability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_job_suitability` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` bigint(20) unsigned NOT NULL,
  `job_title_id` bigint(20) unsigned DEFAULT NULL,
  `years_exp` double(8,2) DEFAULT NULL,
  `hour_salary` double(8,2) DEFAULT NULL,
  `currency` bigint(20) unsigned DEFAULT NULL,
  `ability` int(11) NOT NULL DEFAULT '0',
  `potential_ability` int(11) NOT NULL DEFAULT '0',
  `confidence` int(11) NOT NULL DEFAULT '0',
  `interest` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `evaluation_job_suitability_evaluation_id_foreign` (`evaluation_id`),
  KEY `evaluation_job_suitability_job_title_id_foreign` (`job_title_id`),
  CONSTRAINT `evaluation_job_suitability_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluation_job_suitability_job_title_id_foreign` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_job_suitability`
--

LOCK TABLES `evaluation_job_suitability` WRITE;
/*!40000 ALTER TABLE `evaluation_job_suitability` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_job_suitability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_mbti`
--

DROP TABLE IF EXISTS `evaluation_mbti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_mbti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` bigint(20) unsigned NOT NULL,
  `mbti_type` bigint(20) unsigned NOT NULL,
  `possibility` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `evaluation_mbti_evaluation_id_foreign` (`evaluation_id`),
  CONSTRAINT `evaluation_mbti_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_mbti`
--

LOCK TABLES `evaluation_mbti` WRITE;
/*!40000 ALTER TABLE `evaluation_mbti` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_mbti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_methods`
--

DROP TABLE IF EXISTS `evaluation_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_methods`
--

LOCK TABLES `evaluation_methods` WRITE;
/*!40000 ALTER TABLE `evaluation_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_physicals`
--

DROP TABLE IF EXISTS `evaluation_physicals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_physicals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `measurement` bigint(20) unsigned NOT NULL,
  `evaluation_id` bigint(20) unsigned NOT NULL,
  `amount` double(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_physicals_evaluation_id_foreign` (`evaluation_id`),
  CONSTRAINT `evaluation_physicals_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_physicals`
--

LOCK TABLES `evaluation_physicals` WRITE;
/*!40000 ALTER TABLE `evaluation_physicals` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_physicals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_salaries`
--

DROP TABLE IF EXISTS `evaluation_salaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_salaries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `last_currency` bigint(20) unsigned DEFAULT NULL,
  `new_currency` bigint(20) unsigned DEFAULT NULL,
  `perspective` int(11) DEFAULT NULL,
  `last_hours` int(11) DEFAULT NULL,
  `last_salary` decimal(6,2) DEFAULT NULL,
  `last_extras` decimal(6,2) DEFAULT NULL,
  `new_salary` decimal(6,2) DEFAULT NULL,
  `new_extras` decimal(6,2) DEFAULT NULL,
  `new_hours` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_salaries`
--

LOCK TABLES `evaluation_salaries` WRITE;
/*!40000 ALTER TABLE `evaluation_salaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_salaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_skills`
--

DROP TABLE IF EXISTS `evaluation_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` bigint(20) unsigned NOT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_skills_evaluation_id_foreign` (`evaluation_id`),
  KEY `evaluation_skills_skill_id_foreign` (`skill_id`),
  CONSTRAINT `evaluation_skills_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `evaluation_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_skills`
--

LOCK TABLES `evaluation_skills` WRITE;
/*!40000 ALTER TABLE `evaluation_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moment` date DEFAULT NULL,
  `evaluator` bigint(20) unsigned DEFAULT NULL,
  `method` bigint(20) unsigned DEFAULT NULL,
  `person` bigint(20) unsigned NOT NULL,
  `public_notes` text COLLATE utf8_unicode_ci,
  `private_notes` text COLLATE utf8_unicode_ci,
  `attachments` bigint(20) unsigned DEFAULT NULL,
  `salary` bigint(20) unsigned DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluations_evaluator_foreign` (`evaluator`),
  CONSTRAINT `evaluations_evaluator_foreign` FOREIGN KEY (`evaluator`) REFERENCES `persons` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluations`
--

LOCK TABLES `evaluations` WRITE;
/*!40000 ALTER TABLE `evaluations` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `src` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_types`
--

DROP TABLE IF EXISTS `group_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_types`
--

LOCK TABLES `group_types` WRITE;
/*!40000 ALTER TABLE `group_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `short_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` bigint(20) unsigned DEFAULT NULL,
  `vat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reg_number` int(11) DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_country_foreign` (`country`),
  CONSTRAINT `groups_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_availabilities`
--

DROP TABLE IF EXISTS `jd_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jd_id` bigint(20) unsigned NOT NULL,
  `type` bigint(20) unsigned DEFAULT NULL,
  `min` double(8,2) NOT NULL DEFAULT '0.00',
  `max` double(8,2) NOT NULL DEFAULT '0.00',
  `importance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `jd_availabilities_jd_id_foreign` (`jd_id`),
  KEY `jd_availabilities_type_foreign` (`type`),
  CONSTRAINT `jd_availabilities_jd_id_foreign` FOREIGN KEY (`jd_id`) REFERENCES `jds` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jd_availabilities_type_foreign` FOREIGN KEY (`type`) REFERENCES `availability_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_availabilities`
--

LOCK TABLES `jd_availabilities` WRITE;
/*!40000 ALTER TABLE `jd_availabilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_availabilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_benefits`
--

DROP TABLE IF EXISTS `jd_benefits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_benefits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jd_id` bigint(20) unsigned NOT NULL,
  `week_days` int(11) DEFAULT NULL,
  `benefit` bigint(20) unsigned NOT NULL,
  `frequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `availability` bigint(20) unsigned DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `jd_benefits_jd_id_foreign` (`jd_id`),
  KEY `jd_benefits_benefit_foreign` (`benefit`),
  KEY `jd_benefits_availability_foreign` (`availability`),
  CONSTRAINT `jd_benefits_availability_foreign` FOREIGN KEY (`availability`) REFERENCES `benefit_availabilities` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jd_benefits_benefit_foreign` FOREIGN KEY (`benefit`) REFERENCES `benefits` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jd_benefits_jd_id_foreign` FOREIGN KEY (`jd_id`) REFERENCES `jds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_benefits`
--

LOCK TABLES `jd_benefits` WRITE;
/*!40000 ALTER TABLE `jd_benefits` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_benefits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_duties`
--

DROP TABLE IF EXISTS `jd_duties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_duties` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jd_id` bigint(20) unsigned NOT NULL,
  `duty_id` bigint(20) unsigned NOT NULL,
  `importance` int(11) NOT NULL DEFAULT '0',
  `worktime` int(11) DEFAULT NULL,
  `frequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `jd_duties_jd_id_foreign` (`jd_id`),
  KEY `jd_duties_duty_id_foreign` (`duty_id`),
  CONSTRAINT `jd_duties_duty_id_foreign` FOREIGN KEY (`duty_id`) REFERENCES `duties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jd_duties_jd_id_foreign` FOREIGN KEY (`jd_id`) REFERENCES `jds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_duties`
--

LOCK TABLES `jd_duties` WRITE;
/*!40000 ALTER TABLE `jd_duties` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_duties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_mbti`
--

DROP TABLE IF EXISTS `jd_mbti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_mbti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jd_id` bigint(20) unsigned NOT NULL,
  `mbti_type` bigint(20) unsigned NOT NULL,
  `possibility` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `jd_mbti_jd_id_foreign` (`jd_id`),
  CONSTRAINT `jd_mbti_jd_id_foreign` FOREIGN KEY (`jd_id`) REFERENCES `jds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_mbti`
--

LOCK TABLES `jd_mbti` WRITE;
/*!40000 ALTER TABLE `jd_mbti` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_mbti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_physical`
--

DROP TABLE IF EXISTS `jd_physical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_physical` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jd_id` bigint(20) unsigned NOT NULL,
  `requirement` int(11) NOT NULL DEFAULT '0',
  `physical_type` bigint(20) unsigned NOT NULL,
  `min` double(8,2) DEFAULT NULL,
  `max` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jd_physical_jd_id_foreign` (`jd_id`),
  CONSTRAINT `jd_physical_jd_id_foreign` FOREIGN KEY (`jd_id`) REFERENCES `jds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_physical`
--

LOCK TABLES `jd_physical` WRITE;
/*!40000 ALTER TABLE `jd_physical` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_physical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_skills`
--

DROP TABLE IF EXISTS `jd_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jd_id` bigint(20) unsigned NOT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  `importance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `jd_skills_jd_id_foreign` (`jd_id`),
  KEY `jd_skills_skill_id_foreign` (`skill_id`),
  CONSTRAINT `jd_skills_jd_id_foreign` FOREIGN KEY (`jd_id`) REFERENCES `jds` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jd_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_skills`
--

LOCK TABLES `jd_skills` WRITE;
/*!40000 ALTER TABLE `jd_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jd_statuses`
--

DROP TABLE IF EXISTS `jd_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jd_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jd_statuses`
--

LOCK TABLES `jd_statuses` WRITE;
/*!40000 ALTER TABLE `jd_statuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `jd_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jds`
--

DROP TABLE IF EXISTS `jds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_title_id` bigint(20) unsigned DEFAULT NULL,
  `text_id` bigint(20) unsigned DEFAULT NULL,
  `title_id` bigint(20) unsigned DEFAULT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jds_job_title_id_foreign` (`job_title_id`),
  KEY `jds_text_id_foreign` (`text_id`),
  CONSTRAINT `jds_job_title_id_foreign` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jds_text_id_foreign` FOREIGN KEY (`text_id`) REFERENCES `texts` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jds`
--

LOCK TABLES `jds` WRITE;
/*!40000 ALTER TABLE `jds` DISABLE KEYS */;
/*!40000 ALTER TABLE `jds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_descriptions`
--

DROP TABLE IF EXISTS `job_descriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_descriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_descriptions`
--

LOCK TABLES `job_descriptions` WRITE;
/*!40000 ALTER TABLE `job_descriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_descriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_history`
--

DROP TABLE IF EXISTS `job_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `department` bigint(20) unsigned DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` bigint(20) unsigned DEFAULT NULL,
  `job_title_id` bigint(20) unsigned DEFAULT NULL,
  `job_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `job_history_job_title_id_foreign` (`job_title_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_history`
--

LOCK TABLES `job_history` WRITE;
/*!40000 ALTER TABLE `job_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_titles`
--

DROP TABLE IF EXISTS `job_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_titles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_titles`
--

LOCK TABLES `job_titles` WRITE;
/*!40000 ALTER TABLE `job_titles` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mbti_types`
--

DROP TABLE IF EXISTS `mbti_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mbti_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `verb_id` bigint(20) unsigned NOT NULL,
  `seasonal_clock` bigint(20) unsigned NOT NULL,
  `elemental` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mbti_types`
--

LOCK TABLES `mbti_types` WRITE;
/*!40000 ALTER TABLE `mbti_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `mbti_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurements`
--

DROP TABLE IF EXISTS `measurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `measurements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurements`
--

LOCK TABLES `measurements` WRITE;
/*!40000 ALTER TABLE `measurements` DISABLE KEYS */;
/*!40000 ALTER TABLE `measurements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
INSERT INTO `migrations` VALUES ('2019_12_02_132221_create_texts_table',1),('2019_12_02_132222_create_persons_table',1),('2019_12_02_132917_create_translates_table',1),('2019_12_02_132923_create_languages_table',1),('2019_12_02_132934_create_accounts_table',1),('2019_12_02_132944_create_shared_accounts_table',1),('2019_12_02_132953_create_account_types_table',1),('2019_12_02_132954_create_account_services_table',1),('2019_12_02_133001_create_supported_services_table',1),('2019_12_02_133009_create_account_type_services_table',1),('2019_12_02_133024_create_files_table',1),('2019_12_02_133025_create_attachments_table',1),('2019_12_02_133035_create_countries_table',1),('2019_12_02_133036_create_currencies_table',1),('2019_12_02_133050_create_countries_currencies_table',1),('2019_12_02_133057_create_groups_table',1),('2019_12_02_133101_create_group_types_table',1),('2019_12_02_133109_create_skill_types_table',1),('2019_12_02_133110_create_job_descriptions_table',1),('2019_12_02_133111_create_job_titles_table',1),('2019_12_02_133112_create_job_history_table',1),('2019_12_02_133113_create_evaluations_table',1),('2019_12_02_133114_create_skills_table',1),('2019_12_02_133128_create_evaluation_methods_table',1),('2019_12_02_133134_create_evaluation_skills_table',1),('2019_12_02_133143_create_evaluation_mbti_table',1),('2019_12_02_133149_create_evaluation_physicals_table',1),('2019_12_02_133158_create_evaluation_salaries_table',1),('2019_12_02_133207_create_evaluation_job_suitability_table',1),('2019_12_02_133222_create_jds_table',1),('2019_12_02_133226_create_jd_skills_table',1),('2019_12_02_133229_create_jd_statuses_table',1),('2019_12_02_133234_create_duties_table',1),('2019_12_02_133235_create_jd_duties_table',1),('2019_12_02_133241_create_jd_physical_table',1),('2019_12_02_133246_create_jd_mbti_table',1),('2019_12_02_133250_create_benefit_availabilities_table',1),('2019_12_02_133250_create_benefit_types_table',1),('2019_12_02_133251_create_benefits_table',1),('2019_12_02_133252_create_jd_benefits_table',1),('2019_12_02_133257_create_availability_types_table',1),('2019_12_02_133258_create_jd_availabilities_table',1),('2019_12_02_133309_create_jd_availability_places_table',1),('2019_12_02_133333_create_evaluation_availabilities_table',1),('2019_12_02_133334_create_evaluation_availability_places_table',1),('2019_12_02_133444_create_measurements_table',1),('2019_12_02_133617_create_mbti_types_table',1),('2019_12_02_133633_create_certification_types_table',1),('2019_12_02_133634_create_certifications_table',1),('2019_12_02_133645_create_certification_categories_table',1),('2019_12_02_133646_create_certification_category_list_table',1),('2019_12_02_133711_create_certification_allowed_categories_table',1),('2019_12_05_092603_add_constraint_translates_table',1),('2019_12_05_103318_create_user_accounts_table',1),('2019_12_05_103703_drop_shared_accounts_table',1),('2019_12_11_134142_remove_constraint_account_services_table',1),('2019_12_11_153948_change_moment_field_evaluations_table',1),('2019_12_11_155146_add_timestamps_attachments_table',1),('2019_12_12_091859_add_timestamps_files_table',1),('2019_12_12_091920_remove_timestamps_attachments_table',1),('2019_12_17_102539_remove_jd_availability_places_table',1),('2019_12_17_102551_remove_evaluation_availability_places_table',1),('2019_12_17_102610_create_availability_places_table',1),('2019_12_17_141536_change_notes_fields_evaluations_table',1),('2019_12_23_101409_create_availabilities_table',1),('2019_12_23_101624_change_availability_places_table',1),('2019_12_24_105757_change_attachments_table',1),('2019_12_24_111851_change_certifications_table',1),('2019_12_26_152046_change_job_history_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` int(11) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hometown` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `face_pic` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persons`
--

LOCK TABLES `persons` WRITE;
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill_types`
--

DROP TABLE IF EXISTS `skill_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skill_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill_types`
--

LOCK TABLES `skill_types` WRITE;
/*!40000 ALTER TABLE `skill_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `skill_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `skill_type` bigint(20) unsigned NOT NULL,
  `years_exp` double(8,2) DEFAULT NULL,
  `hours_exp` double(8,2) DEFAULT NULL,
  `ability` int(11) NOT NULL DEFAULT '0',
  `potential_ability` int(11) DEFAULT NULL,
  `confidence` int(11) DEFAULT NULL,
  `interest` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skills_skill_type_foreign` (`skill_type`),
  CONSTRAINT `skills_skill_type_foreign` FOREIGN KEY (`skill_type`) REFERENCES `skill_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supported_services`
--

DROP TABLE IF EXISTS `supported_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supported_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) unsigned NOT NULL,
  `account_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `supported_services_account_id_foreign` (`account_id`),
  CONSTRAINT `supported_services_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supported_services`
--

LOCK TABLES `supported_services` WRITE;
/*!40000 ALTER TABLE `supported_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `supported_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `texts`
--

DROP TABLE IF EXISTS `texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `texts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `texts`
--

LOCK TABLES `texts` WRITE;
/*!40000 ALTER TABLE `texts` DISABLE KEYS */;
/*!40000 ALTER TABLE `texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translates`
--

DROP TABLE IF EXISTS `translates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `language` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `translate_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `translates_translate_id_foreign` (`translate_id`),
  CONSTRAINT `translates_translate_id_foreign` FOREIGN KEY (`translate_id`) REFERENCES `texts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translates`
--

LOCK TABLES `translates` WRITE;
/*!40000 ALTER TABLE `translates` DISABLE KEYS */;
/*!40000 ALTER TABLE `translates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_accounts_account_id_foreign` (`account_id`),
  CONSTRAINT `user_accounts_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_accounts`
--

LOCK TABLES `user_accounts` WRITE;
/*!40000 ALTER TABLE `user_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_accounts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-10 15:45:47
