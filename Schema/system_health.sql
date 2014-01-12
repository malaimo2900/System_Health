-- MySQL dump 10.13  Distrib 5.5.33, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: system_health
-- ------------------------------------------------------
-- Server version	5.5.33-0+wheezy1

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
-- Current Database: `system_health`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `system_health` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `system_health`;

--
-- Table structure for table `my_status`
--

DROP TABLE IF EXISTS `my_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_status` (
  `id` tinyint(255) NOT NULL AUTO_INCREMENT,
  `status` bit(1) NOT NULL,
  `status_type_id` tinyint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_my_status_1` (`status_type_id`),
  CONSTRAINT `fk_my_status_1` FOREIGN KEY (`status_type_id`) REFERENCES `status_types` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_status`
--

LOCK TABLES `my_status` WRITE;
/*!40000 ALTER TABLE `my_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `snmp_mib_info`
--

DROP TABLE IF EXISTS `snmp_mib_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_mib_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mib_type` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `mib_pref` char(250) COLLATE utf8_unicode_ci NOT NULL,
  `data_type` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mib_type` (`mib_type`,`mib_pref`),
  KEY `mib_pref` (`mib_pref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `snmp_mib_info`
--

LOCK TABLES `snmp_mib_info` WRITE;
/*!40000 ALTER TABLE `snmp_mib_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `snmp_mib_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `snmp_mibs`
--

DROP TABLE IF EXISTS `snmp_mibs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_mibs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `snmp_mib_info_id` int(10) NOT NULL,
  `mib_id` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `snmp_mib_info_id` (`snmp_mib_info_id`,`mib_id`(255)),
  KEY `snmp_mib_info_id_2` (`snmp_mib_info_id`),
  KEY `fk_snmp_mibs_1` (`snmp_mib_info_id`),
  CONSTRAINT `fk_snmp_mibs_1` FOREIGN KEY (`snmp_mib_info_id`) REFERENCES `snmp_mib_info` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `snmp_mibs`
--

LOCK TABLES `snmp_mibs` WRITE;
/*!40000 ALTER TABLE `snmp_mibs` DISABLE KEYS */;
/*!40000 ALTER TABLE `snmp_mibs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_types`
--

DROP TABLE IF EXISTS `status_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_types` (
  `id` tinyint(255) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_types`
--

LOCK TABLES `status_types` WRITE;
/*!40000 ALTER TABLE `status_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `status_types` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-12 18:41:37
