DROP TABLE IF EXISTS `#__virtuemart_payeddownload_downloads`;
CREATE TABLE `#__virtuemart_payeddownload_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `#__virtuemart_payeddownload_orderfilepasswords`;
CREATE TABLE `#__virtuemart_payeddownload_orderfilepasswords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `#__virtuemart_payeddownload_productfiles`;
CREATE TABLE `#__virtuemart_payeddownload_productfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `virtuemart_product_id` varchar(45) DEFAULT NULL,
  `file_blob` mediumblob,
  `file_size` varchar(45) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `file_type` varchar(45) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `#__virtuemart_payeddownload_visits`;
CREATE TABLE `#__virtuemart_payeddownload_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `browser` varchar(45) DEFAULT NULL,
  `platform` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



