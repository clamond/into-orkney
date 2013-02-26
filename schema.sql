-- MySQL dump 10.13  Distrib 5.5.25
--
-- Host: localhost    Database: intoOrkney
-- ------------------------------------------------------
-- Server version	5.5.25

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
-- Table structure for table `place`
--

DROP TABLE IF EXISTS `place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `place` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `place_name` varchar(500) NOT NULL,
  `loc_lat` varchar(45) DEFAULT NULL,
  `loc_long` varchar(45) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flickr_search` varchar(500) DEFAULT NULL,
  `twitter_search` varchar(500) DEFAULT NULL,
  `soundcloud_search` varchar(500) DEFAULT NULL,
  `youtube_search` varchar(500) DEFAULT NULL,
  `freetext` varchar(50000) DEFAULT NULL,
  PRIMARY KEY (`place_id`),
  UNIQUE KEY `place_id_UNIQUE` (`place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25906 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `place_name`
--

DROP TABLE IF EXISTS `place_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `place_name` (
  `place_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) NOT NULL,
  `place_description` varchar(50000) DEFAULT NULL,
  `name_source` varchar(5000) DEFAULT NULL,
  `name_type` varchar(500) DEFAULT NULL,
  `original_grid_ref` varchar(45) DEFAULT NULL,
  `original_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`place_name_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8599 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rcahms`
--

DROP TABLE IF EXISTS `rcahms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rcahms` (
  `rcahms_id` varchar(500) NOT NULL,
  `place_id` int(11) NOT NULL,
  `archaeological_notes` varchar(10000) DEFAULT NULL,
  `architectural_notes` varchar(10000) DEFAULT NULL,
  `site_type` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`rcahms_id`),
  UNIQUE KEY `place_id_UNIQUE` (`place_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rcahms_image`
--

DROP TABLE IF EXISTS `rcahms_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rcahms_image` (
  `rcahms_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `rcahms_id` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `copyright` varchar(500) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`rcahms_image_id`),
  UNIQUE KEY `rcahms_image_id_UNIQUE` (`rcahms_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43005 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trail`
--

DROP TABLE IF EXISTS `trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trail` (
  `trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `trail_name` varchar(500) NOT NULL,
  `trail_desc` varchar(50000) DEFAULT NULL,
  PRIMARY KEY (`trail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trail_place`
--

DROP TABLE IF EXISTS `trail_place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trail_place` (
  `trail_place_id` int(11) NOT NULL AUTO_INCREMENT,
  `trail_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `trail_order` int(11) NOT NULL,
  PRIMARY KEY (`trail_place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-26 19:03:59
