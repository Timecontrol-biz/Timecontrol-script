-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2015 at 06:55 PM
-- Server version: 5.5.41-cll-lve
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `voron249_timecontrol-demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  `data` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `ip_address`, `user_agent`, `last_activity`, `user_data`, `data`, `timestamp`) VALUES
('4541999d832f5fee94be212794749c7c264c6df8', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1433158318;', '0000-00-00 00:00:00'),
('5948ddd26a31fc29f67a510b148184edb138edce', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1433154865;', '0000-00-00 00:00:00'),
('aae8f7d06447653843a5c570890cd01d4ff61836', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1433168497;', '0000-00-00 00:00:00'),
('cd9fc6d551529d42e04ce98811324c449f2fe1e3', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1433157148;', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE IF NOT EXISTS `timetable` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user` int(50) NOT NULL,
  `date` date NOT NULL,
  `checkin` time NOT NULL,
  `checkout` time NOT NULL,
  `lunch_start` time NOT NULL,
  `lunch_stop` time NOT NULL,
  `reason_morning` text NOT NULL,
  `reason_evening` text NOT NULL,
  `summary` int(10) NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`) VALUES
(1, 'Name', 'Surname');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
