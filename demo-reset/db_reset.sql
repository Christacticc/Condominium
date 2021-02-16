--
-- SQL de réinitialisation du jeu de données de démo
-- Extrait par PHPMYADMIN
-- Actions sur la table s_postal_code suppprimées car l'utilisateur ne modifie pas ces données.
-- ------------------------------------------------------






-- MariaDB dump 10.17  Distrib 10.5.1-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 172.17.0.7    Database: tacticcc0nd0
-- ------------------------------------------------------
-- Server version	5.6.50-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `s_address`
--

DROP TABLE IF EXISTS `s_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_address` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_part_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ad_part_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ad_fk_postal_code_id` int(11) NOT NULL,
  PRIMARY KEY (`ad_id`),
  KEY `ad_FK_postal_code` (`ad_fk_postal_code_id`),
  CONSTRAINT `ad_FK_postal_code` FOREIGN KEY (`ad_fk_postal_code_id`) REFERENCES `s_postal_code` (`pc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_address`
--

LOCK TABLES `s_address` WRITE;
/*!40000 ALTER TABLE `s_address` DISABLE KEYS */;
INSERT INTO `s_address` VALUES (3,'12, place Maréchal Lyautey','',30039),(4,'102, rue Dugesclin','',30039),(39,'1 quai de Madrid','',30034),(40,'Chemin de la Forêt','',18068),(41,'25, rue Jean Moulin','',12505),(42,'64, avenue d\'Hundertwasser','',3902),(43,'37, rue Thurins','',29782),(44,'Rue des Suspensions','',37579),(45,'Parc Alexandre Dumas','',19379),(46,'102, rue des Vendanges','',30039);
/*!40000 ALTER TABLE `s_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_category`
--

DROP TABLE IF EXISTS `s_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_category` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT,
  `ca_name` varchar(70) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `ca_position` int(11) NOT NULL,
  PRIMARY KEY (`ca_id`),
  UNIQUE KEY `ca_position` (`ca_position`),
  UNIQUE KEY `ca_name` (`ca_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_category`
--

LOCK TABLES `s_category` WRITE;
/*!40000 ALTER TABLE `s_category` DISABLE KEYS */;
INSERT INTO `s_category` VALUES (1,'juridique',4),(4,'technique',1),(5,'comptable',2),(6,'assemblée générale',3),(7,'to confirm',0);
/*!40000 ALTER TABLE `s_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_condominium`
--

DROP TABLE IF EXISTS `s_condominium`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_condominium` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT,
  `co_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `co_fk_address_id` int(11) NOT NULL,
  `co_internal_reference` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `co_message` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `co_password` char(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`co_id`),
  KEY `co_FK_address` (`co_fk_address_id`),
  CONSTRAINT `co_FK_address` FOREIGN KEY (`co_fk_address_id`) REFERENCES `s_address` (`ad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_condominium`
--

LOCK TABLES `s_condominium` WRITE;
/*!40000 ALTER TABLE `s_condominium` DISABLE KEYS */;
INSERT INTO `s_condominium` VALUES (53,'Quai des Géants',39,'000001','','0000'),(54,'Le Village',40,'000002','','0000'),(55,'Résidence du Vaisseau',41,'000003','','0000'),(56,'Un Chateau en Allemagne',42,'000004','','0000'),(57,'Les Braillards',43,'000005','','0000'),(58,'Résidence Saint Paul',44,'000006','','0000'),(59,'L\'Allée des Peintres',45,'000007','Ascenseur indisponible le mardi 16 février 2021 de 10h à 16h pour intervention technique.','0000');
/*!40000 ALTER TABLE `s_condominium` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_document`
--

DROP TABLE IF EXISTS `s_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_document` (
  `do_id` int(11) NOT NULL AUTO_INCREMENT,
  `do_name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `do_file_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `do_fk_category_id` int(11) NOT NULL,
  `do_fk_condominium_id` int(11) NOT NULL,
  `do_creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `do_modification_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `do_sort_number` int(11) DEFAULT NULL,
  `do_fk_type_id` int(11) NOT NULL,
  `do_available` tinyint(1) NOT NULL DEFAULT '1',
  `do_tracked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`do_id`),
  KEY `do_FK_condominium` (`do_fk_condominium_id`) USING BTREE,
  KEY `do_FK_category` (`do_fk_category_id`),
  KEY `do_FK_type` (`do_fk_type_id`),
  CONSTRAINT `do_FK_category` FOREIGN KEY (`do_fk_category_id`) REFERENCES `s_category` (`ca_id`),
  CONSTRAINT `do_FK_condominium` FOREIGN KEY (`do_fk_condominium_id`) REFERENCES `s_condominium` (`co_id`),
  CONSTRAINT `do_FK_type` FOREIGN KEY (`do_fk_type_id`) REFERENCES `s_type` (`ty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=410 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_document`
--

LOCK TABLES `s_document` WRITE;
/*!40000 ALTER TABLE `s_document` DISABLE KEYS */;
INSERT INTO `s_document` VALUES (398,'Attestation d’immatriculation','1page-1605711056.pdf',1,59,'2020-11-18 15:50:56','2020-11-18 15:54:18',5,2,1,0),(399,'Carnet d’Entretien','3pages-1605711058.pdf',4,59,'2020-11-18 15:50:58','2020-11-18 15:54:16',1,2,1,0),(400,'Procès verbal de l’AG du 27/06/2019','7pages-1605711060.pdf',1,59,'2020-11-18 15:51:00','2020-11-18 15:53:02',2,2,1,0),(401,'Procès verbal de l’AG du 24/06/2020','1page-1605711062.pdf',1,59,'2020-11-18 15:51:02','2020-11-18 15:53:01',1,2,1,0),(402,'Etat des dépenses 2017','3pages-1605711064.pdf',5,59,'2020-11-18 15:51:04','2020-11-18 15:54:55',3,2,1,0),(403,'Etat des dépenses 2018','7pages-1605711066.pdf',5,59,'2020-11-18 15:51:06','2020-11-18 15:54:54',2,2,1,0),(404,'Etat des dépenses 2019','1page-1605711068.pdf',5,59,'2020-11-18 15:51:08','2020-11-18 15:54:53',1,2,1,0),(405,'Fiche synthétique','3pages-1605711070.pdf',1,59,'2020-11-18 15:51:10','2020-11-18 15:54:17',4,1,1,1),(406,'Procès verbal de l’AG du 19/06/2018','7pages-1605711072.pdf',1,59,'2020-11-18 15:51:12','2020-11-18 15:53:03',3,2,1,1),(407,'1page-1605711797.pdf','1page-1605711797.pdf',7,54,'2020-11-18 16:03:17','2020-11-18 16:03:17',NULL,13,0,0),(408,'3pages-1605711799.pdf','3pages-1605711799.pdf',7,54,'2020-11-18 16:03:19','2020-11-18 16:03:19',NULL,13,0,0),(409,'7pages-1605711801.pdf','7pages-1605711801.pdf',7,54,'2020-11-18 16:03:21','2020-11-18 16:03:21',NULL,13,0,0);
/*!40000 ALTER TABLE `s_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_download`
--

DROP TABLE IF EXISTS `s_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_download` (
  `dl_id` int(11) NOT NULL AUTO_INCREMENT,
  `dl_fk_document_id` int(11) NOT NULL,
  `dl_e_mail_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dl_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dl_id`),
  KEY `dl_FK_document` (`dl_fk_document_id`),
  CONSTRAINT `dl_FK_document` FOREIGN KEY (`dl_fk_document_id`) REFERENCES `s_document` (`do_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_download`
--

LOCK TABLES `s_download` WRITE;
/*!40000 ALTER TABLE `s_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_general_assembly`
--

DROP TABLE IF EXISTS `s_general_assembly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_general_assembly` (
  `ga_id` int(11) NOT NULL AUTO_INCREMENT,
  `ga_fk_condominium_id` int(11) NOT NULL,
  `ga_webinar_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ga_room` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ga_time` datetime NOT NULL,
  `ga_fk_address_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ga_id`),
  KEY `ga_FK_condominium` (`ga_fk_condominium_id`) USING BTREE,
  KEY `ga_FK_address` (`ga_fk_address_id`) USING BTREE,
  CONSTRAINT `ga_FK_condominium` FOREIGN KEY (`ga_fk_condominium_id`) REFERENCES `s_condominium` (`co_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_general_assembly`
--

LOCK TABLES `s_general_assembly` WRITE;
/*!40000 ALTER TABLE `s_general_assembly` DISABLE KEYS */;
INSERT INTO `s_general_assembly` VALUES (6,59,'https://us04web.zoom.us/j/','6e étage droite','2021-01-10 15:30:00',46);
/*!40000 ALTER TABLE `s_general_assembly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_photo`
--

DROP TABLE IF EXISTS `s_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_photo` (
  `ph_id` int(11) NOT NULL AUTO_INCREMENT,
  `ph_file_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `ph_caption` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ph_position` tinyint(1) NOT NULL,
  `ph_fk_condominium` int(11) NOT NULL,
  PRIMARY KEY (`ph_id`),
  KEY `ph_FK_condominium` (`ph_fk_condominium`) USING BTREE,
  CONSTRAINT `ph_FK_condominium` FOREIGN KEY (`ph_fk_condominium`) REFERENCES `s_condominium` (`co_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_photo`
--

LOCK TABLES `s_photo` WRITE;
/*!40000 ALTER TABLE `s_photo` DISABLE KEYS */;
INSERT INTO `s_photo` VALUES (39,'CC0021cologne-1605688461.jpeg',NULL,2,53),(40,'CC0022cologne-1605688480.jpeg',NULL,1,53),(41,'CC0041VythiriVillage-1605705988.jpeg',NULL,1,54),(42,'CCBY30042VythiriVillage-EntranceViewOfBanasura-Airin010-1605706002.jpg',NULL,2,54),(43,'CC0071dusseldorf-1605706337.jpeg',NULL,1,55),(44,'CC0072dusseldorf-1605706348.jpeg',NULL,2,55),(45,'CCBY201Waldspirale-Jean-PierreDalbera-1605706676.jpg',NULL,1,56),(46,'CCBY202Waldspirale-Jean-PierreDalbera-1605706687.jpg',NULL,2,56),(48,'CCBYSA092ImmeubleDHabitationBraillard-FranckSchneider-1605706860.jpg',NULL,2,57),(49,'CCBYSA091ImmeubleDHabitationBraillard-FranckSchneider-1605707289.jpg',NULL,1,57),(50,'CCBYSA121Stockholm-ArildVagen-1605707505.jpg',NULL,1,58),(51,'CCBYSA122Stockholm-ArildVagen-1605707517.jpg',NULL,2,58),(52,'CCBYSA271ShellHaus-JorgZagel-1605707675.jpg',NULL,1,59),(53,'CCBYSA272ShellHaus-JustravelingCom-1605707684.jpg',NULL,2,59);
/*!40000 ALTER TABLE `s_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Aucune action sur la table `s_postal_code` puisque ses données ne sont pas modifiable par l'utilisateur
--

--
-- Table structure for table `s_type`
--

DROP TABLE IF EXISTS `s_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_type` (
  `ty_id` int(11) NOT NULL AUTO_INCREMENT,
  `ty_name` varchar(70) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ty_id`),
  UNIQUE KEY `ty_name` (`ty_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_type`
--

LOCK TABLES `s_type` WRITE;
/*!40000 ALTER TABLE `s_type` DISABLE KEYS */;
INSERT INTO `s_type` VALUES (2,'courant'),(1,'fiche synthétique'),(4,'standard'),(13,'to confirm');
/*!40000 ALTER TABLE `s_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_user`
--

DROP TABLE IF EXISTS `s_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_user` (
  `us_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `us_name` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `us_password` varchar(255) CHARACTER SET utf32 COLLATE utf32_bin NOT NULL,
  PRIMARY KEY (`us_id`),
  UNIQUE KEY `us_name` (`us_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_user`
--

LOCK TABLES `s_user` WRITE;
/*!40000 ALTER TABLE `s_user` DISABLE KEYS */;
INSERT INTO `s_user` VALUES (1,'admin','0000'),(2,'user','0000');
/*!40000 ALTER TABLE `s_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'tacticcc0nd0'
--

--
-- Dumping routines for database 'tacticcc0nd0'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-18 15:33:29
