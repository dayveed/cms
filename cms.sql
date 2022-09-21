-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 21, 2022 at 07:17 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `email`, `username`, `hashed_password`) VALUES
(2, 'David', 'Landesman', 'dlandesman@gmail.com', 'dlandesman', '$2y$10$hSpDGw6Pn15CQ8VE2lY.F.ZL1wsEtLyMmpZZvA2Fl.sZd/7bXpVHu');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `blurb` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `employee_id`, `name`, `blurb`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'David Landesman', 'David isn\'t really a writer but he pretends to be in order to pay the bills', NULL, '2022-09-19 20:10:25', '2022-09-19 23:10:25'),
(2, 2, 'John Doe', 'John struggles mightily with getting his peers to take him seriously. \"Yes, it is my real name!\" is something you\'ll hear often if you hang around John.', NULL, '2022-09-19 20:10:25', '2022-09-19 23:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `name`, `position`, `visible`, `slug`) VALUES
(1, 'Articles', 1, 1, 'articles'),
(2, 'Blog posts', 2, 1, 'blog-posts'),
(3, 'Personal experiences', 3, 1, 'experiences'),
(5, 'Cost guides', 4, 1, 'cost-guides');

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

DROP TABLE IF EXISTS `contractors`;
CREATE TABLE IF NOT EXISTS `contractors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_service_id` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`id`, `name`, `service_id`) VALUES
(1, 'Andy Roddick', 1),
(2, 'Bob hope', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `content` text,
  `author_id` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index_content_type_id_slug` (`content_type_id`,`slug`),
  KEY `fk_content_type_id` (`content_type_id`) USING BTREE,
  KEY `fk_author_id` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `content_type_id`, `title`, `position`, `visible`, `content`, `author_id`, `slug`, `created_at`, `updated_at`) VALUES
(9, 3, 'Loans', 1, 1, '<div id=\"hero-image\">\r\n  <img src=\"images/page_assets/bizloans_539438468.png\" width=\"900\" height=\"200\" alt=\"\" />\r\n</div>\r\n\r\n<div id=\"content\">\r\n  <h1>Business Loans</h1>\r\n  <p>Businesses need upkeep to stay profitable in a competitive market. Whether you need to purchase new equipment, have plans for an expansion, or want to remodel your facility, Globe Bank can help you finance your vision.</p>\r\n  <ul>\r\n    <li><a href=\"#\">Compare our business term loans</a></li>\r\n    <li><a href=\"#\">Learn about SBA loan options</a></li>\r\n    <li><a href=\"#\">Estimate monthly payments</a></li>\r\n    <li><a href=\"#\">Check your application status</a></li>\r\n  </ul>\r\n\r\n</div>\r\n', 2, 'loans', '2022-09-19 19:41:45', '2022-09-21 00:10:16'),
(15, 2, 'test', 21, 1, 'dfgdfg', NULL, 'history', '2022-09-20 09:09:05', '2022-09-21 00:16:17'),
(16, 1, 'test slugs ', 11, 1, 'hey', 1, 'test-slugs', '2022-09-20 14:53:45', '2022-09-20 23:16:40'),
(17, 1, 'Test to see if slug Works', 10, 0, 'testing aghain', 1, 'test-to-see-if-slug-works', '2022-09-20 14:54:23', '2022-09-20 23:16:40'),
(18, 2, 'Test to see if slug Works', 3, 0, 'testing', 1, 'test-to-see-if-slug-works', '2022-09-20 16:26:34', '2022-09-21 00:16:17'),
(20, 1, 'test meta', 9, 1, 'yoyo', 1, 'test-meta', '2022-09-20 19:23:50', '2022-09-20 23:16:40'),
(21, 1, 'test meta2', 8, 0, 'yoyo', 1, 'test-meta2', '2022-09-20 19:26:25', '2022-09-20 23:16:40'),
(22, 1, 'test meta3', 7, 0, 'teeeeesttting', 1, 'test-meta3', '2022-09-20 19:35:01', '2022-09-20 23:16:40'),
(23, 1, 'test meta 4', 6, 0, 'teeeeesttting', 1, 'test-meta-4', '2022-09-20 19:36:10', '2022-09-20 23:16:40'),
(24, 1, 'test meta 5', 5, 0, 'teeeeesttting', 1, 'test-meta-5', '2022-09-20 19:37:06', '2022-09-20 23:16:40'),
(25, 1, 'test meta 6', 4, 0, 'teeeeesttting', 1, 'test-meta-6', '2022-09-20 19:38:17', '2022-09-20 23:16:40'),
(26, 1, 'test meta 7', 3, 0, 'teeeeesttting', 1, 'test-meta-7', '2022-09-20 19:39:28', '2022-09-20 23:16:40'),
(27, 1, 'test meta 8', 2, 0, 'teeeeestttin', 1, 'test-meta-8', '2022-09-20 19:40:18', '2022-09-20 23:16:40'),
(33, 1, 'test16', 1, 0, 'yo', 1, 'test16', '2022-09-20 20:16:40', '2022-09-20 23:16:40'),
(35, 2, 'test17', 2, 0, 'testing again', 1, 'test17', '2022-09-20 20:47:54', '2022-09-21 00:16:17'),
(37, 2, 'My roofing experience', 1, 1, 'I had a great time and didn\'t fall off', 1, 'my-roofing-experience', '2022-09-20 21:16:17', '2022-09-21 00:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `page_meta`
--

DROP TABLE IF EXISTS `page_meta`;
CREATE TABLE IF NOT EXISTS `page_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_meta`
--

INSERT INTO `page_meta` (`id`, `page_id`, `meta_key`, `meta_value`) VALUES
(4, 30, 'service_id', '4'),
(5, 30, 'contractor_id', '2'),
(6, 30, 'minimum_cost', '100'),
(7, 30, 'maximum_cost', '2'),
(8, 31, 'service_id', '4'),
(9, 31, 'contractor_id', '2'),
(10, 31, 'minimum_cost', '100'),
(11, 31, 'maximum_cost', '2'),
(16, 33, 'service_id', '3'),
(17, 33, 'contractor_id', '1'),
(18, 33, 'minimum_cost', '25'),
(19, 33, 'maximum_cost', '2'),
(24, 35, 'service_id', '4'),
(25, 35, 'contractor_id', ''),
(26, 35, 'minimum_cost', ''),
(27, 35, 'maximum_cost', ''),
(32, 37, 'service_id', '1'),
(33, 37, 'contractor_id', ''),
(34, 37, 'minimum_cost', ''),
(35, 37, 'maximum_cost', '');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`) VALUES
(1, 'roofing'),
(2, 'painting'),
(3, 'carpet cleaning'),
(4, 'chimney sweeping');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
