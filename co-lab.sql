-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2022 at 05:50 PM
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
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL DEFAULT 'thumbnail_default.png',
  `layout` varchar(255) NOT NULL DEFAULT 'layout_default.png',
  `capacity` int(10) NOT NULL,
  `code` varchar(4) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Laboratorium Resurrection Farmasi', 'Gedung Fakultas Keperawatan Lantai 1 Ruang A1.13', 20, 'Laboratorium ini di lengkapi dengan fasilitas-fasilitas pendukung seperti berikut: <br><br>- Alat-alat Praktik<br>- Komponen2 dasar <br>- Bahan Kimia<br>- dll', '9cd259383781c0f13756.jpg', 'active'),
(2, 'Laboratorium Liners', 'Gedung Fakultas Vokasi Lantai 6 Ruang A6.9', 31, 'Laboratorium Komputer ini di lengkapi dengan fasilitas pendukung berupa :<br><br>- Komputer PC x31<br>- Proyektor x2 <br>- AC x2<br>- dll<br><br>', '116a65be879b253b786f.jpg', 'active'),
(3, 'Ruang The Sunshine ', 'Gedung Bersama Kampus Dieng Lantai 3 Ruang A3.22', 27, 'Berikut adalah contoh deskripsi untuk ruang meeting<br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 27x<br>- Meja Besar <br>- Proyektor 2x<br>- AC 1x<br>- dll<br>', '5005c850e804963b7d5f.jpeg', 'active'),
(5, 'Pro Lab', 'Gedung Fakultas Vokasi Lantai 2 Ruang A2.3', 30, 'Laboratorium Pro Lab merupakan salah satu Laboratorium yang dimiliki Universitas Brawijaya Kampus Dieng Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. <br>Fasilitas yang di miliki lab yaitu :<br>1. Personal Computer (PC) sebanyak 30<br>2. Software berlisensi resmi<br>3. Osciloscope, dll', '436655b3777ce4ce9064.jpg', 'active'),
(6, 'Super Komputer', 'Gedung Fakultas Vokasi Lantai 2 Ruang A2.6', 50, 'Laboratorium Super Komputer merupakan salah satu Laboratorium yang dimiliki Universitas Brawijaya Kampus Dieng Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. <br>Fasilitas yang di miliki lab yaitu :<br>1. Personal Computer (PC) sebanyak 50<br>2. Software berlisensi resmi<br>3. Osciloscope, dll', '2be3200b67966ea78a61.jpg', 'active'),
(7, 'Laboratorium Microprosesor', 'Gedung Fakultas Vokasi Lantai 5 Ruang A5.11', 25, 'Laboratorium Microprosesor merupakan salah satu Laboratorium yang dimiliki Universitas Brawijaya Kampus Dieng Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. <br>Fasilitas yang di miliki lab yaitu :<br>1. Personal Computer (PC) sebanyak 31 Unit ; Spesifikasi Intel Core I3 ; Ram 4.00 Gb<br>2. Software berlisensi resmi<br>3. Osciloscope, dll', '0a22f7cf05ac552aa903.jpg', 'active'),
(8, 'Laboratorium Mostly', 'Gedung Fakultas Vokasi Lantai 5 Ruang A5.7', 60, 'Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. Fasilitas tersebut sebagai sarana mahasiswa dan dosen untuk melakukan kegiatan antara lain: praktikum, perkuliahan, penelitian, dan pengabdian masyarakat. Adapun fasilitas & spesifikasi pada ruang laboratorium ini adalah sebagai berikut :<br>1. Personal Computer (PC) sebanyak 60 Unit<br>2. LCD Projektor, dll<br><br>', '2e2921d055fc48b98b50.jpg', 'active'),
(9, 'Laboratorium Intels', 'Gedung Fakultas Vokasi Lantai 7 Ruang A7.3', 20, 'Laboratorium Komputer ini di lengkapi dengan fasilitas pendukung berupa :<br><br>- Komputer desktop x20<br>- Proyektor x2 <br>- AC x2<br>- dll<br>', '7f56401eaa9839cc3dcb.jpg', 'active'),
(10, 'Laboratorium Endemic', 'Gedung Fakultas Keperawatan Lantai 3 Ruang A3.9', 30, 'Laboratorium Fakultas Keperawatan dimaksudkan untuk membantu proses pembelajaran di Program Studi Keperawatan. Di prodi ini terdapat sejumlah mata kuliah yang bersifat praktis yang wajib dikuasai oleh para calon Perawat atau Ners. Fasilitas yang ada di laboratorium ini adalah :<br>1. Peralatan Praktikum <br>2. Meja Bayi<br>3. Meja Praktikum<br>4. Matras<br>5. Sampiran<br>6. Mesin EKG<br>7. Dan Lain-Lain', 'c2a84d81fd4285b28d4c.jpg', 'active'),
(11, 'Laboratorium KMB', 'Gedung Fakultas Keperawatan Lantai 6 Ruang A6.5', 60, 'Laboratorium ini didesain khusus untuk menunjang pembelajaran mahasiswa program pasacasarjana Keperawatan Medikal Bedah dalam hal pemberian asuhan keperawatan lanjut (advanced) pada kasus keperawatan medikal bedah yang kompleks seperti pemeriksaan fisik sistem saraf lanjut, sistem perkemihan lanjut, dialisis, dll.<br>Oleh karena itu, Laboratorium ini memeiliki fasilitas seperti :<br>1. Pemeriksaan Fisik<br>2. Intervensi Intravena dan Subkutan<br>3. Model TB<br>', '890d6ca9f57f07148998.jpg', 'active'),
(12, 'Laboratorium Child', 'Gedung Fakultas Keperawatan Lantai 10 Ruang A10.8', 30, 'Laboratorium ini terbagi atas tiga ruangan yaitu ruangan laboratorium NICU/PICU, medical pediatric ward, dan surgical pediatric ward dengan kapasitas ruangan masing-masing yaitu 30 mahasiswa. Laboratorium ini biasa digunakan untuk kegiatan pemeriksaan tumbuh kembang anak, pemeriksaan fisik, pengambilan darah kapiler, perawatan dengan metode kanguru, perawatan pada kasus kegawatan yang dialami oleh bayi dan anak, dll.', '3cdac348966ad80d5253.jpg', 'active'),
(13, 'Ruangan Go Public', 'Gedung Bersama Kampus Dieng Lantai 6 Ruang A6.1', 25, 'Berikut adalah contoh deskripsi untuk ruang meeting yang biasanya digunakan untuk organisasi ataupun pihak kampus<br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 25x<br>- Meja Panjang <br>- Proyektor 2x<br>- AC 1x<br>- dll<br>', '209cc335dfa7bd69e084.png', 'active'),
(14, 'Ruang Knife', 'Gedung Bersama Kampus Dieng Lantai 6 Ruang A6.8', 20, 'Berikut adalah contoh deskripsi untuk ruang meeting yang biasanya digunakan untuk organisasi ataupun pihak kampus<br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 20x<br>- Meja Panjang <br>- Proyektor 1x<br>- AC 1x<br>- dll<br>', '83f891bd93ac6a1d1d95.jpg', 'active'),
(15, 'Ruang Will Done', 'Gedung Bersama Kampus Dieng Lantai 6 Ruang A6.6', 30, 'Berikut adalah contoh deskripsi untuk ruang meeting yang biasanya digunakan untuk organisasi ataupun pihak kampus<br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 30x<br>- Meja Panjang <br>- Proyektor 2x<br>- AC 2x<br>- dll', 'c585d91e0cce68e8c8e9.jpg', 'active'),
(16, 'Ruang Good Moon', 'Gedung Bersama Kampus Dieng Lantai 7 Ruang A7.21', 50, 'Berikut adalah contoh deskripsi untuk ruang meeting yang biasanya digunakan untuk organisasi ataupun pihak kampus<br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 50x<br>- Meja Panjang <br>- Proyektor 3x<br>- AC 2x<br>- dll', 'ccaf666e0f217f7d3dee.jpg', 'active'),
(17, 'Ruang The Tall', 'Gedung Bersama Kampus Dieng Lantai 6 Ruang A6.1', 60, 'Berikut adalah contoh deskripsi untuk ruang meeting yang biasanya digunakan untuk organisasi ataupun pihak kampus<br>Ruang meeting terdiri dari banyak kursi yang dijejer rapih<br><br>fasilitas yang tersedia antara lain:<br>- Kursi 60<br>- Meja 60 <br>- Proyektor 3x<br>- AC 2x<br>- dll', 'a798c9734f8de0b62038.jpg', 'active'),
(18, 'Laboratorium Sainsburry', 'Gedung Fakultas Keperawatan Lantai 7 Ruang A.12', 50, 'Laboratorium ini di lengkapi dengan fasilitas-fasilitas pendukung seperti berikut: <br><br>- Alat-Alat Praktik<br>- Komponen-Komponen Dasar <br>- Bahan Kimia<br>- dll', 'a6dd8accad4851806279.jpg', 'active'),
(19, 'Laboratorium Hands-On', 'Gedung Fakultas Keperawatan Lantai 1 Ruang A1.17', 21, 'Laboratorium ini di lengkapi dengan fasilitas-fasilitas pendukung seperti berikut: <br><br>- Alat-Alat Praktik<br>- Komponen-Komponen Dasar <br>- Bahan Kimia<br>- dll', 'd15b99771989b765cc40.jpg', 'active'),
(20, 'Laboratorium Treatroom', 'Gedung Fakultas Keperawatan Lantai 7 Ruang A7.3', 35, 'Laboratorium ini di lengkapi dengan fasilitas-fasilitas pendukung seperti berikut: <br><br>- Alat-Alat Praktik<br>- Komponen-Komponen Dasar <br>- Bahan Kimia<br>- dll', '3ae0707f5a13a87ac47e.jpg', 'active'),
(21, 'Laboratorium Inbeautiful', 'Gedung Fakultas Vokasi Lantai 6 Ruang A6.19', 25, 'Laboratorium Pro Lab merupakan salah satu Laboratorium yang dimiliki Universitas Brawijaya Kampus Dieng Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. <br>Fasilitas yang di miliki lab yaitu :<br>1. Personal Computer (PC) sebanyak 25<br>2. Software berlisensi resmi<br>3. Osciloscope, dll', '5055cd2f965511b95abc.jpg', 'active'),
(22, 'Laboratorium Lookingood', 'Gedung Fakultas Vokasi Lantai 3 Ruang A3.16', 27, 'Laboratorium Pro Lab merupakan salah satu Laboratorium yang dimiliki Universitas Brawijaya Kampus Dieng Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. <br>Fasilitas yang di miliki lab yaitu :<br>1. Personal Computer (PC) sebanyak 27<br>2. Software berlisensi resmi<br>3. Osciloscope, dll', '407c850fe4148ffdd5c6.jpg', 'active'),
(23, 'Laboratorium Furnichia', 'Gedung Fakultas Vokasi Lantai 5 Ruang A5.21', 35, 'Laboratorium Pro Lab merupakan salah satu Laboratorium yang dimiliki Universitas Brawijaya Kampus Dieng Laboratorium ini memiliki ruangan yang luas serta ditunjang dengan fasilitas pendukung yang lengkap dan memiliki perangkat utama komputer dengan spesifikasi cukup tinggi. <br>Fasilitas yang di miliki lab yaitu :<br>1. Personal Computer (PC) sebanyak 35<br>2. Software berlisensi resmi<br>3. Osciloscope, dll', '320a090fbbb23c6b37ec.jpg', 'active'),
(24, 'Laboratorium Komputer', 'Gedung Vokasi Lantai 5 A5.11', 15, 'Fasilitas untuk laboratorium komputer sebagai berikut :<br>1. Komputer<br>2. Meja<br>3. Ac', 'cd4afac96715c411d4a3.jpg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `spaces`
--

CREATE TABLE `spaces` (
  `id` int(10) NOT NULL,
  `area_id` int(10) NOT NULL,
  `space_no` int(10) NOT NULL,
  `color_code` varchar(7) NOT NULL DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `space_tickets`
--

CREATE TABLE `space_tickets` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `area_id` int(10) NOT NULL,
  `space_no` int(11) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_end` datetime NOT NULL,
  `status` enum('valid','invalid') NOT NULL DEFAULT 'valid',
  `invalidated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `notes` varchar(255) NOT NULL,
  `status` enum('valid','invalid') NOT NULL DEFAULT 'valid',
  `invalidated` datetime DEFAULT NULL
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
  `uniqueid` varchar(100) DEFAULT NULL,
  `photo` varchar(100) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `studentid`, `username`, `email`, `password`, `role`, `validity`, `uniqueid`, `photo`) VALUES
(2, 'Administrator', '000000000000001', 'admin', 'not.gamer16@gmail.com', '$2y$10$TnHNhl4EE.wHGPBtmyFxnOFG4XLvly0bdtbf9EbmQqfkZLyY8OI7W', 'admin', 'valid', 'faaee5e5281ee9448af3a38136b5e612125a6788', '2482b3210d4167ec1872.jfif'),
(9, 'Nur Amalia Asmi susanteo', '193140714111050', 'amiisteo_', 'namaliaamiisteo@gmail.com', '$2y$10$J9V4Gw05WnyD0CNOAQGK/.e7SWMJGOnuydK16ssnbKiI50uUKYi1W', 'user', 'valid', '3dc73702b0a3599419a873fa5b2670890eae6992', 'c9dad0fe660754e7c5cf.png'),
(10, 'Amalia Asmi', '193140714111051', 'amii_', 'nuramaliaasmisteo@icloud.com', '$2y$10$Ix/I79Y6DAWFGd.MoaaaeeXCMPX2iJYPhA6OsALBapVuh1ArpF3Yq', 'user', 'invalid', '4053f840a5c973f4d0788da1e839120401baddfb', 'default.png'),
(11, 'Fikri Miftah Akmaludin', '185150301111043', 'vkr16', 'fikri.droid16@gmail.com', '$2y$10$gY7p/8wXF5SSD8lYqndUOuGqvql7Re.uS.SlPZBaIJ8eEeRS1eHAa', 'user', 'valid', '6f3e50da82785e690cc252164bcbff841016f8ba', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spaces`
--
ALTER TABLE `spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `space_tickets`
--
ALTER TABLE `space_tickets`
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
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `spaces`
--
ALTER TABLE `spaces`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `space_tickets`
--
ALTER TABLE `space_tickets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
