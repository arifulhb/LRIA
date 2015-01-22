# Dump of table tblCustomer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblCustomer`;

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



# Dump of table tblPartner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblPartner`;

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

LOCK TABLES `tblPartner` WRITE;
/*!40000 ALTER TABLE `tblPartner` DISABLE KEYS */;

INSERT INTO `tblPartner` (`psn`, `partner_email`, `partner_password`, `app_id`, `company_id`, `login_type`, `api_endpoint`)
VALUES
	(1,'','','myapp1','',0,'http://dev.posios.com:8080/PosServer/JSON-RPC'),
	(2,'','','muapp1','',1,'http://sg1.posios.com:8080/PosServer/JSON-RPC');

/*!40000 ALTER TABLE `tblPartner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblReservation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblReservation`;

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



# Dump of table tblusers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblusers`;

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

LOCK TABLES `tblusers` WRITE;
/*!40000 ALTER TABLE `tblusers` DISABLE KEYS */;

INSERT INTO `tblusers` (`user_sn`, `user_name`, `user_email`, `user_password`, `user_status`)
VALUES
	(1,'admin','lria@example.com','202cb962ac59075b964b07152d234b70',1);

/*!40000 ALTER TABLE `tblusers` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
