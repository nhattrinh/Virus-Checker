-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 02, 2017 at 11:23 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antivirusdb`
--
CREATE DATABASE IF NOT EXISTS `antivirusdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `antivirusdb`;

-- --------------------------------------------------------

--
-- Table structure for table `admintable`
--

DROP TABLE IF EXISTS `admintable`;
CREATE TABLE IF NOT EXISTS `admintable` (
  `usernamedb` varchar(20) NOT NULL,
  `passworddb` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admintable`
--

INSERT INTO `admintable` (`usernamedb`, `passworddb`) VALUES
('admin', '1c1674798e0ee57a5dbafeed10298ce8b10933939d27de542ef1fcc1ed416f5e979e63a9c5bd26a65ebaa9aa0320416b21f7f89268f5f6d03ac7f687d58441be');

-- --------------------------------------------------------

--
-- Table structure for table `antivirustable`
--

DROP TABLE IF EXISTS `antivirustable`;
CREATE TABLE IF NOT EXISTS `antivirustable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `filesignature` varchar(65494) NOT NULL,
  `threatdetect` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `antivirustable`
--

INSERT INTO `antivirustable` (`id`, `type`, `filesignature`, `threatdetect`) VALUES
(1, 'Trojan Horse', '504b341406080002102deaef2f721', 'Yes'),
(2, 'Worm', 'ffd8ffe00104a464946011104804800', 'Yes'),
(3, 'Adware', 'efbbbf3c3f786d6c2076657273696f6e3d22312e', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `contributorsputativefilestable`
--

DROP TABLE IF EXISTS `contributorsputativefilestable`;
CREATE TABLE IF NOT EXISTS `contributorsputativefilestable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `filesignature` varchar(65493) NOT NULL,
  `threatdetect` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contributorsputativefilestable`
--

INSERT INTO `contributorsputativefilestable` (`id`, `type`, `filesignature`, `threatdetect`) VALUES
(1, 'Ransomware?', '313020756e697473206f6620656c656374697665', 'Doublecheck');

-- --------------------------------------------------------

--
-- Table structure for table `contributorstable`
--

DROP TABLE IF EXISTS `contributorstable`;
CREATE TABLE IF NOT EXISTS `contributorstable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contributorstable`
--

INSERT INTO `contributorstable` (`id`, `username`, `email`, `password`) VALUES
(1, 'user1', 'user1@sjsu.edu', '9ec62c20118ff506dac139ec30a521d12b9883e55da92b7d9adeefe09ed4e0bd152e2a099339871424263784f8103391f83b781c432f45eccb03e18e28060d2f');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
