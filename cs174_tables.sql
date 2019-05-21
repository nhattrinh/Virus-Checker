DROP DATABASE IF EXISTS cs174;
CREATE DATABASE cs174;
USE cs174;






DROP TABLE IF EXISTS `virus`;
CREATE TABLE `virus` (
  `name` varchar(64) NOT NULL,
  `signature` mediumtext NOT NULL,
  `date` varchar(64) NOT NULL,
  `time` varchar(64) NOT NULL,
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `signature` (`signature`(20))
) ENGINE=MyISAM AUTO_INCREMENT=6969;






DROP TABLE IF EXISTS `salt`;
CREATE TABLE `salt` (
  `salt1` varchar(15) NOT NULL,
  `salt2` varchar(15) NOT NULL,
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2;

LOCK TABLES `salt` WRITE;
INSERT INTO `salt` VALUES ('7df89v7496d','fdajfkhvkxchvi',1);

UNLOCK TABLES;










DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2;
LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES ('First','User','student@sjsu.edu','5f4dcc3b5aa765d61d8327deb882cf99',1);

UNLOCK TABLES;






DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt1` varchar(15) NOT NULL,
  `salt2` varchar(15) NOT NULL,
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2;
LOCK TABLES `admin` WRITE;
INSERT INTO `admin` VALUES ('Ronald','Mcdonald','admin@sjsu.edu','e48472b2c08d4649299563e60884c032', 'build','wall',1);
UNLOCK TABLES;