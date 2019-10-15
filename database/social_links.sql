-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2019 at 04:23 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `smedia` varchar(255) NOT NULL,
  `smedia_name` varchar(255) NOT NULL,
  `smedia_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `account_id`, `smedia`, `smedia_name`, `smedia_link`) VALUES
(1, 10, 'instagram', 'krystek', 'https://instagram.com/krys.czajkowski'),
(2, 10, 'tiktok', 'tiktokerpierwszaklasa', 'https://tiktok.com'),
(3, 10, 'twitter', 'twittermistrz', ''),
(4, 10, 'facebook', '', 'https://facebook.com'),
(6, 10, 'twitch', 'xdXD', ''),
(7, 10, 'youtube', 'DZIWKIDRAGILASERY', ''),
(8, 10, 'discord', 'a', ''),
(9, 10, 'snapchat', '', ''),
(10, 10, 'mail', 'czajkowski.krystian@gmail.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
