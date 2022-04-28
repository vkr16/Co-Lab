-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2022 at 10:39 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `co-lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `capacity` int(5) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `thumbnail` varchar(60) NOT NULL DEFAULT 'default_thumbnail.jpg',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `studentid` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `validity` enum('valid','invalid') NOT NULL DEFAULT 'invalid',
  `uniqueid` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `studentid`, `username`, `email`, `password`, `role`, `validity`, `uniqueid`) VALUES
(1, 'Developer', '000000000000000', 'dev', 'developer.colab@gmail.com', '$2y$10$mtu5SsgHySR33ZJeXKn4Cu7ilPWFthgA6GRFCLW0RySj4/mPD.wom', 'admin', 'valid', '6dcedc503404eb42b126888395b1dc4bec90ca4a'),
(2, 'Administrator', '000000000000001', 'admin', 'fikri.droid16@gmail.com', '$2y$10$a2yx4CSx.VRdN4LXaORhk.kw.pwJh.Jp2.kQ3xflAR2/OmWEyGYSu', 'admin', 'valid', 'faaee5e5281ee9448af3a38136b5e612125a6788'),
(3, 'Fikri Miftah Akmaludin', '185150301111043', 'vkr16', 'pisangbenyek0@gmail.com', '$2y$10$enXMrKuv1aYT.oBFhtjlJusHIUV7PbmCVQQSyr3W6ZG85agVR/SQW', 'user', 'valid', 'e56004eec5308ab94b634b375192b75832c2bc98');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
