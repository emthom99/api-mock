-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2013 at 10:49 AM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `api_mock`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_api`
--

DROP TABLE IF EXISTS `tbl_api`;
CREATE TABLE `tbl_api` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `current_option` bigint(20) DEFAULT NULL,
  `validated` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `current_option` (`current_option`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history`
--

DROP TABLE IF EXISTS `tbl_history`;
CREATE TABLE `tbl_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `api_id` bigint(20) DEFAULT NULL,
  `url` varchar(255) DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `ip` varchar(255) DEFAULT '',
  `method` varchar(255) DEFAULT '',
  `resquest` longtext,
  `response` longtext,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `api_id` (`api_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_option`
--

DROP TABLE IF EXISTS `tbl_option`;
CREATE TABLE `tbl_option` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `api_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT '',
  `is_passthrough` tinyint(4) DEFAULT '0',
  `url_passthrough` varchar(255) DEFAULT '',
  `delay` int(11) DEFAULT '0',
  `http_code` int(11) DEFAULT '200',
  `is_json` tinyint(4) DEFAULT '0',
  `reponse_data` longtext,
  `order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `api_id` (`api_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_history`
--
ALTER TABLE `tbl_history`
  ADD CONSTRAINT `tbl_history_ibfk_1` FOREIGN KEY (`api_id`) REFERENCES `tbl_api` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_option`
--
ALTER TABLE `tbl_option`
  ADD CONSTRAINT `tbl_option_ibfk_1` FOREIGN KEY (`api_id`) REFERENCES `tbl_api` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `tbl_api` (`id`, `name`, `url`, `current_option`, `validated`) VALUES
(1, 'My Default Api', '', 56, 0);

INSERT INTO `tbl_option` (`id`, `api_id`, `name`, `is_passthrough`, `url_passthrough`, `delay`, `http_code`, `is_json`, `reponse_data`, `order`) VALUES
(1, 1, 'normal', 0, '', 0, 200, 0, 'not found api', 0),
(2, 1, 'error(404)', 0, '', 0, 404, 0, '', 0);
