-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status`varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;


--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;

INSERT INTO `accounts` VALUES (1,'Toto Dupont','toto','$2y$10$vecze/V//nVxqjpk2VqMOuk46PoPs/ol.xdB4.0OTtj1Z.ee0W4a.','admin'), 
                              (2,'Jean-Michel Testeur','testeur','$2y$10$Lj0O5fP9xARQvYuo5/dd7.PLAVm9mPo5zwPEohMogU3XwIGN6ZY2C','user'), 
                              (3, 'Martine Dubois', 'martine', '$2y$10$yZ6Wvlp1ylaRK6IwjY0CzuJ.eSQJyao/iMWbHT1SMDKkJ6WEBCnr6', 'user'),
                              (4, 'Raymond Martin', 'raymond', '$2y$10$X1HrGzMVPYiOeV6UibjGnuDd/MoGnm0.hwhiwWDmyzjjHlfZpsOlm', 'user');
UNLOCK TABLES;

