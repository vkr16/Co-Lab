-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2022 at 08:34 AM
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

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `location`, `capacity`, `description`, `thumbnail`, `status`) VALUES
(1, 'Laboratorium Fisika 4 (Ruang Meeting Bersama)', 'Lantai 2 Ruang A2.4', 20, 'Laboratorium ini di lengkapi dengan fasilitas-fasilitas pendukung seperti berikut: <br><br>- Alat-alat Praktik<br>- Komponen2 Elektronika dasar <br>- dll', '9cd259383781c0f13756.jpg', 'active'),
(2, 'Laboratorium Komputer', 'Lantai 3 Ruang A3.15', 31, 'Laboratorium Komputer ini di lengkapi dengan fasilitas pendukung berupa :<br><br>- Komputer desktop x30<br>- Proyektor x2 <br>- AC x2<br>- dll<br><br>', '116a65be879b253b786f.jpg', 'active'),
(3, 'Ruang Meeting Bersama 2 ', 'Lantai 3 Ruang A3.22', 27, 'Berikut adalah contoh deskripsi untuk ruang meeting<br><br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 27x<br>- Meja Besar <br>- Proyektor 2x<br>- AC 1x<br>- dll<br>', '5005c850e804963b7d5f.jpeg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `room_id` int(10) NOT NULL,
  `time_start` datetime DEFAULT NULL,
  `time_end` datetime DEFAULT NULL,
  `notes` varchar(255) NOT NULL
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
(2, 'Administrator', '000000000000001', 'admin', 'fikri.droid16@gmail.com', '$2y$10$a2yx4CSx.VRdN4LXaORhk.kw.pwJh.Jp2.kQ3xflAR2/OmWEyGYSu', 'admin', 'valid', 'faaee5e5281ee9448af3a38136b5e612125a6788'),
(3, 'Fikri Miftah Akmaludin', '185150301111043', 'user', 'contact.fikmif16@gmail.com', '$2y$10$hsjcI.B1fccsviGcvoCqLuwAOVyieEqvR2RC3rqSRTGh2ChOhSidW', 'user', 'valid', 'c7f25df5d1e769249d9c8daa24ffce593be88866'),
(6, 'Developer ', '000000000000000', 'dev', 'developer.colab@gmail.com', '$2y$10$wYZYLCdtyvqBpGKujTRz5OZJW/DqM5Vb0/eHyGYys0a2la.Bsusl.', 'admin', 'valid', '8b4e9e243325f9fdd17eb24c83ea3b1a5c8062fd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
