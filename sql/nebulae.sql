
--
-- Table structure for table `nebulae`
--

DROP TABLE IF EXISTS `nebulae`;

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


--
-- Dumping data for table `nebulae`
--

LOCK TABLES `nebulae` WRITE;

INSERT INTO `nebulae` VALUES (1,'Orion','https://www.nasa.gov/sites/default/files/thumbnails/image/orion-nebula-xlarge_web.jpg','Orion',1344,12.0, 'raymond'),
                             (2,'Horsehead','https://upload.wikimedia.org/wikipedia/commons/6/68/Barnard_33.jpg','Orion',1500,3.5, 'martine'),
                             (3,'Crab','http://cdn.eso.org/images/screen/eso9948f.jpg','Taurus',6523,5.5, 'martine'),
                             (4,'Helix','http://cdn.spacetelescope.org/archives/images/screen/opo0432d.jpg','Aquarius',695,2.87, 'raymond'),
                             (5,'Butterfly','https://www.nasa.gov/sites/default/files/images/754349main_butterfly_nebula_full_full.jpg','Scorpius',3392,1.5, 'testeur');

UNLOCK TABLES;

