-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2017 at 05:34 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `excelexport_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `excelexport`
--

CREATE TABLE IF NOT EXISTS `excelexport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ItemName` varchar(150) NOT NULL,
  `ItemCode` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `excelexport`
--

INSERT INTO `excelexport` (`id`, `ItemName`, `ItemCode`, `Date`, `Price`, `Quantity`) VALUES
(1, 'car audio (CA)', 'NM-8010', '2017-11-10', 8544, 41),
(2, 'car navigation (CN)', 'NM-8011', '2017-11-10', 4514, 14),
(3, 'copy machine (CM)', 'NM-8012', '2017-11-10', 5756, 100),
(4, 'computer (CP)', 'NM-8013', '2017-11-10', 4413, 54),
(5, 'digital camera (DC)', 'NM-8014', '2017-11-11', 4597, 90),
(6, 'display device (DD)', 'NM-8015', '2017-11-11', 7456, 50),
(7, 'digital video camera (DVC)', 'NM-8016', '2017-11-11', 4121, 45),
(8, 'digital video player (DVP)', 'NM-8017', '2017-11-11', 7458, 40),
(9, 'digital video recorder (DVR)', 'NM-8018', '2017-11-11', 4756, 500),
(10, 'fax (FAX)', 'NM-8019', '2017-11-11', 2584, 120),
(11, 'global positioning system (GPS)', 'NM-8020', '2017-11-12', 3695, 350),
(12, 'hard disk drive (HDD)', 'NM-8021', '2017-11-12', 4522, 740),
(13, 'multifunction printer (MFP)', 'NM-8022', '2017-11-12', 4521, 280),
(14, 'mechatronics (MN)', 'NM-8023', '2017-11-12', 9685, 580),
(15, 'mobile phone (MP)', 'NM-8024', '2017-11-13', 8657, 685),
(16, 'network device (NW)', 'NM-8026', '2017-11-13', 8574, 385),
(17, 'personal computer (PC)', 'NM-8027', '2017-11-13', 2574, 452),
(18, 'portable media player (PMP)', 'NM-8028', '2017-11-13', 9685, 274),
(19, 'printer (PR)', 'NM-8029', '2017-11-13', 7451, 200),
(20, 'semiconductor (SC)', 'NM-8030', '2017-11-13', 3585, 500);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
