-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2019 at 09:36 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `screenName` varchar(40) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `profileCover` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `validationCode` text NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `screenName`, `profileImage`, `profileCover`, `bio`, `validationCode`, `active`) VALUES
(9, 'kulfon@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'kredka', 'images/image9medusakredki.jpg', 'images/image9kot.jpg', 'Siema jestem kredka\r\nhihihihihi\r\nwbijaj na mojego google LOLOL: http://www.google.com', '0', 1),
(10, 'czaja@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'KrysCzajkowski', 'images/image10krolMacius1.jpg', 'images/image10delfinek.jpg', 'Elo mordo wbijaj na moje social media \r\nInst: krys.czajkowski\r\nSnap: nie_majuznazw\r\nFb: https://www.facebook.com/profile.php?id=100008701864345\r\nInstagramek: https://www.instagram.com/krys.czajkowski/', '0', 1),
(14, 'krystian@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'krystian', 'images/image14brzydkiKOt.jpg', 'images/image14bmw.jpg', 'Siema jestem KRYSTIAN!', '0', 1),
(16, 'kicikici@gmai.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'kicikici', 'images/defaultProfileImage.png', 'images/defaultCoverImage.png', '', '0', 1),
(24, 'zdzichu@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'zdzichu', 'images/defaultProfileImage.png', 'images/defaultCoverImage.png', '', 'bd60ccd4653cec34e26de1e47da54a4b', 0),
(25, 'wujek@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'wujek', 'images/defaultProfileImage.png', 'images/defaultCoverImage.png', '', '0', 1),
(26, 'asdfasdff@gmail.com', '3fc0a7acf087f549ac2b266baf94b8b1', 'asdfasdf', 'images/defaultProfileImage.png', 'images/defaultCoverImage.png', '', '7c580605d38ed1a3e99a312ae37ce43a', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
