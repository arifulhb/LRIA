CREATE DATABASE  IF NOT EXISTS `lira` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lira`;
-- MySQL dump 10.13  Distrib 5.6.17, for osx10.6 (i386)
--
-- Host: localhost    Database: lira
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `tblCustomer`
--

DROP TABLE IF EXISTS `tblCustomer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblCustomer` (
  `cust_sn` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cust_oid` varchar(10) DEFAULT NULL,
  `cust_firstname` varchar(50) DEFAULT NULL,
  `cust_lastname` varchar(50) DEFAULT NULL,
  `cust_phone_no` varchar(50) DEFAULT NULL,
  `cust_company_name` varchar(255) DEFAULT NULL,
  `cust_email` varchar(50) DEFAULT NULL,
  `cust_note` varchar(256) DEFAULT NULL,
  `cust_username` varchar(50) DEFAULT NULL,
  `cust_password` varchar(256) DEFAULT NULL,
  `create_by` smallint(6) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cust_sn`),
  UNIQUE KEY `cust_phone_no_UNIQUE` (`cust_phone_no`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblCustomer`
--

LOCK TABLES `tblCustomer` WRITE;
/*!40000 ALTER TABLE `tblCustomer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblCustomer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPartner`
--

DROP TABLE IF EXISTS `tblPartner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPartner` (
  `psn` smallint(6) NOT NULL AUTO_INCREMENT,
  `partner_email` varchar(45) DEFAULT NULL,
  `partner_password` varchar(45) DEFAULT NULL,
  `app_id` varchar(45) DEFAULT NULL,
  `company_id` varchar(10) DEFAULT NULL,
  `login_type` tinyint(4) DEFAULT NULL COMMENT '0=dev/test',
  `api_endpoint` varchar(256) DEFAULT NULL,
  UNIQUE KEY `psn_UNIQUE` (`psn`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPartner`
--

LOCK TABLES `tblPartner` WRITE;
/*!40000 ALTER TABLE `tblPartner` DISABLE KEYS */;
INSERT INTO `tblPartner` VALUES (1,'eric@thelaunchstars.com','launchstars','9','32',0,'http://dev.posios.com:8080/PosServer/JSON-RPC'),(2,'support@thelaunchstars.com','aidi9639','9','14013',1,'http://sg1.posios.com:8080/PosServer/JSON-RPC');
/*!40000 ALTER TABLE `tblPartner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblReservation`
--

DROP TABLE IF EXISTS `tblReservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblReservation` (
  `rsrv_sn` bigint(20) NOT NULL AUTO_INCREMENT,
  `cust_sn` int(11) DEFAULT NULL,
  `rsrv_date` datetime DEFAULT NULL,
  `rsrv_pax` smallint(6) DEFAULT NULL,
  `rsrv_note` varchar(256) DEFAULT NULL,
  `cust_is_repeat` tinyint(4) DEFAULT NULL COMMENT '0=repeated, 1=new',
  `customerId` varchar(10) DEFAULT NULL,
  `reservationId` varchar(10) DEFAULT NULL,
  `modificationTime` varchar(50) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `create_by` smallint(6) DEFAULT NULL COMMENT 'user_sn',
  PRIMARY KEY (`rsrv_sn`),
  UNIQUE KEY `rsrv_sn_UNIQUE` (`rsrv_sn`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblReservation`
--

LOCK TABLES `tblReservation` WRITE;
/*!40000 ALTER TABLE `tblReservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblReservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblusers` (
  `user_sn` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_password` varchar(256) DEFAULT NULL,
  `user_status` tinyint(4) DEFAULT NULL COMMENT '1=active 0 inactive',
  PRIMARY KEY (`user_sn`),
  UNIQUE KEY `user_sn_UNIQUE` (`user_sn`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusers`
--

LOCK TABLES `tblusers` WRITE;
/*!40000 ALTER TABLE `tblusers` DISABLE KEYS */;
INSERT INTO `tblusers` VALUES (1,'admin','lira@example.com','202cb962ac59075b964b07152d234b70',1);
/*!40000 ALTER TABLE `tblusers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-22 13:03:54
