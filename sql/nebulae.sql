-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: mysql.info.unicaen.fr    Database: niveau_dev
-- ------------------------------------------------------
-- Server version	5.5.47-0+deb7u1-log

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
-- Table structure for table `nebulae`
--

DROP TABLE IF EXISTS `nebulae`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nebulae` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `constellation` varchar(255) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `radius` float(11) DEFAULT NULL,
  `user` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nebulae`
--

LOCK TABLES `nebulae` WRITE;
/*!40000 ALTER TABLE `nebulae` DISABLE KEYS */;
INSERT INTO `nebulae` VALUES (1,'Orion','https://www.nasa.gov/sites/default/files/thumbnails/image/orion-nebula-xlarge_web.jpg','Orion',1344,12.0, 'raymond'),
                             (2,'Horsehead','https://upload.wikimedia.org/wikipedia/commons/6/68/Barnard_33.jpg','Orion',1500,3.5, 'martine'),
                             (3,'Crab','http://cdn.eso.org/images/screen/eso9948f.jpg','Taurus',6523,5.5, 'martine'),
                             (4,'Helix','http://cdn.spacetelescope.org/archives/images/screen/opo0432d.jpg','Aquarius',695,2.87, 'raymond'),
                             (5,'Butterfly','https://www.nasa.gov/sites/default/files/images/754349main_butterfly_nebula_full_full.jpg','Scorpius',3392,1.5, 'testeur');
/*!40000 ALTER TABLE `nebulae` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-16 18:30:36
