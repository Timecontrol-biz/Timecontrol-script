-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2015 at 03:02 PM
-- Server version: 5.5.41-cll-lve
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `voron249_timetable`
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
('07f49993e6e1e560630c8c2885d322d954e2a516', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432824679;', '0000-00-00 00:00:00'),
('0e10c0b99e5e72b40bd85f475d4c9cf7d8cfdf6a', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432822695;', '0000-00-00 00:00:00'),
('2795197a00ef135ebabe5abc31c46471ee5bf6a1', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432823838;', '0000-00-00 00:00:00'),
('35be012d8066f3bc48d3f85d0c36765701208058', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432823324;', '0000-00-00 00:00:00'),
('3b9c1f115bb02a6bb50327dab71d46ddf54a6058', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432825043;', '0000-00-00 00:00:00'),
('520ce0154056ac21038a273c3c5ec9fd17e8fdba', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432825292;', '0000-00-00 00:00:00'),
('6432f1ac3c55be2fe31f21197e1cc76741d0f445', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432823015;', '0000-00-00 00:00:00'),
('6d51a5437eba3cfa345e53ce6e68fe672efd8c9b', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432824223;', '0000-00-00 00:00:00'),
('8fe18aaa31071fbaee56277bd511cf06debdccec', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432824989;', '0000-00-00 00:00:00'),
('98e397d669def9ee9e35f50c8f915c851db064a4', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432822044;', '0000-00-00 00:00:00'),
('a417ff5b83c23ddca8a4705e2fef02c38d6d4ae0', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432824321;', '0000-00-00 00:00:00'),
('e2ccefd4d342ef83a6447a168989831eb5790083', '194.44.254.94', '', 0, '', '__ci_last_regenerate|i:1432824633;', '0000-00-00 00:00:00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `user`, `date`, `checkin`, `checkout`, `lunch_start`, `lunch_stop`, `reason_morning`, `reason_evening`, `summary`, `ip`) VALUES
(1, 2, '2015-05-28', '09:30:00', '00:00:00', '14:00:00', '15:07:39', '', '', 0, '194.44.254.94'),
(2, 1, '2015-05-28', '09:10:00', '00:00:00', '12:53:22', '13:06:30', '', '', 0, '194.44.254.94'),
(3, 5, '2015-05-28', '09:10:09', '00:00:00', '00:00:00', '00:00:00', '', '', 0, '194.44.254.94');

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
(1, 'Sergey', 'Voronovich'),
(2, 'Anton', 'Minchuk'),
(3, 'Bohdan', 'Kholiavka'),
(4, 'Oleg', 'Bogdanovych'),
(5, 'Natali', 'Dedyk'),
(6, 'Nazar', 'Trokhanovskyy'),
(7, 'Svitlana', 'Nazar');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
