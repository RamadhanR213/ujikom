-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 03:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oss_ujikom`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Diagnostik'),
(2, 'Bedah'),
(3, 'Peralatan Laboratorium'),
(4, 'Perawatan Luka');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `contact` varchar(30) DEFAULT NULL,
  `paypal` varchar(50) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `username`, `password`, `email`, `dateofbirth`, `gender`, `address`, `city`, `contact`, `paypal`, `role`) VALUES
(1, 'Admin', '$2y$10$tZnuQTDiFkrJhveu5oZYSOGrBObO3UHRnpeDjynhczKLRYJSbQlWW', 'raditya@gmail.com', '2024-10-01', 'Male', 'Rungkut', 'Surabaya', '0812667267', '10101010101010', 'admin'),
(21, 'Tes Member', '$2y$10$OVGByUmA8kxDR3AGw8j6u.F7WjMs1yY9BQ7B1G.99qo9dpgA.g7Hu', 'a@gmail.com', '2024-10-15', 'Female', 'Rungkut', 'Surabaya', '5115151', '1556555555', 'member'),
(22, 'devi', '$2y$10$mmlY45iTyKydXCV.O7v1ueKRnbmgEPlY9aqUPVoil4qvPGJuQrznm', 'a@gmail.com', '2024-09-03', 'Female', 'Rungkut', 'Surabaya', '5115151', '1556555555', 'member'),
(23, 'Raditya', '$2y$10$8TQDM8dyuqdNTMYYSgYZ1eDnWbyJIRp7z.A58gqZswt.RnO8zBHXy', 'raditya@gmail.com', '2024-09-01', 'Male', 'Rungkut', 'Surabaya', '2147483647', '1200004848', 'member'),
(24, 'Dimas', '$2y$10$meWVQEsvcNMJqYAdFN0hJ.bfxm94SpiaKIYNKnebeeki9o/CP3UYi', 'tesemail@gmail.com', '2003-10-12', 'Male', 'medokan asri', 'Surabaya', '2147483647', '121111113131', 'member'),
(25, 'testing', '$2y$10$/5QF.7Wyi584ct9TtV6FLuQGCkMYVzs6idu8ctsNHP5tE3r.RyZey', 'testing@gmail.com', '2003-10-12', 'Male', 'sini', 'Surabaya', '08166627836', '123131312312', 'member'),
(26, 'rdt', '$2y$10$QKHZDY5VwKKHjvJJDx3Ny.ramo.oGTGadCT1rJMepbeOwNrGXYYyC', 'jaydenturneridp@gmail.com', '2024-10-01', 'Male', 'rungkut', 'Surabaya', '081231231311', '312313131313', 'member'),
(27, 'dimas', '$2y$10$6CeJm1d3q.By09hIkMn6h.p4yFX4MIQ8U8a51gvQZA3S6apuir0NO', 'radityadvz@gmail.com', '2003-10-12', 'Male', 'medokan', 'Surabaya', '081225823604', '11123131313131', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `tanggal` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('Belum disetujui','Disetujui','Ditolak') NOT NULL DEFAULT 'Belum disetujui',
  `pembayaran` enum('Transfer','COD') NOT NULL DEFAULT 'Transfer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pengguna`, `tanggal`, `total`, `status`, `pembayaran`) VALUES
(8, 1, '07-10-2024', 63000, 'Disetujui', 'Transfer'),
(9, 1, '07-10-2024', 208950, 'Belum disetujui', 'Transfer'),
(10, 1, '07-10-2024', 546000, 'Belum disetujui', 'Transfer'),
(11, 1, '07-10-2024', 21000, 'Belum disetujui', 'Transfer'),
(12, 1, '07-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(13, 1, '07-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(14, 1, '07-10-2024', 304500, 'Belum disetujui', 'Transfer'),
(15, 1, '07-10-2024', 304500, 'Belum disetujui', 'Transfer'),
(16, 23, '07-10-2024', 63000, 'Belum disetujui', 'Transfer'),
(17, 1, '07-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(18, 1, '07-10-2024', 283500, 'Belum disetujui', 'COD'),
(19, 23, '07-10-2024', 229950, 'Belum disetujui', 'COD'),
(20, 23, '07-10-2024', 229950, 'Belum disetujui', 'Transfer'),
(21, 23, '07-10-2024', 208950, 'Belum disetujui', 'Transfer'),
(22, 23, '07-10-2024', 208950, 'Belum disetujui', 'Transfer'),
(23, 1, '07-10-2024', 492450, 'Belum disetujui', 'COD'),
(24, 1, '07-10-2024', 492450, 'Belum disetujui', 'Transfer'),
(25, 1, '07-10-2024', 21000, 'Belum disetujui', 'Transfer'),
(26, 26, '08-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(27, 26, '08-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(28, 26, '08-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(29, 26, '08-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(30, 26, '08-10-2024', 250950, 'Belum disetujui', 'COD'),
(31, 26, '08-10-2024', 250950, 'Belum disetujui', 'Transfer'),
(32, 26, '08-10-2024', 250950, 'Belum disetujui', 'Transfer'),
(33, 26, '08-10-2024', 250950, 'Belum disetujui', 'Transfer'),
(34, 26, '08-10-2024', 229950, 'Belum disetujui', 'Transfer'),
(35, 26, '08-10-2024', 229950, 'Belum disetujui', 'Transfer'),
(36, 26, '08-10-2024', 21000, 'Belum disetujui', 'Transfer'),
(37, 26, '08-10-2024', 21000, 'Belum disetujui', 'Transfer'),
(38, 26, '08-10-2024', 42000, 'Belum disetujui', 'Transfer'),
(39, 26, '08-10-2024', 84000, 'Belum disetujui', 'Transfer'),
(40, 23, '08-10-2024', 808500, 'Belum disetujui', 'Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` double NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `stok` enum('tersedia','habis') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_kategori`, `nama`, `harga`, `foto`, `detail`, `stok`) VALUES
(34, 4, 'Kursi Roda', 250000, 'TXLhXL00NrusddknOy3K.png', 'Kursi Roda Premium kami dirancang untuk memberikan kenyamanan dan kemudahan bagi penggunanya, ideal untuk mobilitas sehari-hari baik di dalam maupun luar ruangan. Dengan desain ergonomis, roda tahan lama, dan rangka aluminium ringan, kursi roda ini mudah dipindahkan dan dapat menampung berat hingga 120 kg.', 'tersedia'),
(35, 2, 'Sanitizer', 20000, 'eSYlllmnlePFh7VzyWMz.jpeg', 'Dibuat dengan kandungan alkohol yang cukup tinggi, produk ini mampu membunuh hingga 99.9% kuman dalam hitungan detik, menjadikannya pilihan praktis untuk menjaga kebersihan di mana saja dan kapan saja.', 'tersedia'),
(36, 1, 'Termometer', 199000, 'TvNr3gKxbAw3IAgnJZVj.jpg', 'Dirancang untuk memberikan pengukuran suhu yang cepat dan akurat, ideal untuk penggunaan di rumah, kantor, atau fasilitas kesehatan.', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `produk_pesanan`
--

CREATE TABLE `produk_pesanan` (
  `id_produk_pesanan` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_pesanan`
--

INSERT INTO `produk_pesanan` (`id_produk_pesanan`, `id_pesanan`, `id_produk`, `jumlah`) VALUES
(4, 8, 35, 3),
(5, 9, 36, 1),
(6, 10, 34, 2),
(7, 10, 35, 1),
(8, 11, 35, 1),
(9, 12, 35, 2),
(10, 13, 35, 2),
(11, 14, 35, 2),
(12, 14, 34, 1),
(13, 15, 35, 2),
(14, 15, 34, 1),
(15, 16, 35, 3),
(16, 17, 35, 2),
(17, 18, 35, 1),
(18, 18, 34, 1),
(19, 19, 35, 1),
(20, 19, 36, 1),
(21, 20, 35, 1),
(22, 20, 36, 1),
(23, 21, 36, 1),
(24, 22, 36, 1),
(25, 23, 35, 1),
(26, 23, 36, 1),
(27, 23, 34, 1),
(28, 24, 35, 1),
(29, 24, 36, 1),
(30, 24, 34, 1),
(31, 25, 35, 1),
(32, 26, 35, 2),
(33, 27, 35, 2),
(34, 28, 35, 2),
(35, 29, 35, 2),
(36, 30, 35, 2),
(37, 30, 36, 1),
(38, 31, 35, 2),
(39, 31, 36, 1),
(40, 32, 35, 2),
(41, 32, 36, 1),
(42, 33, 35, 2),
(43, 33, 36, 1),
(44, 34, 35, 1),
(45, 34, 36, 1),
(46, 35, 35, 1),
(47, 35, 36, 1),
(48, 36, 35, 1),
(49, 37, 35, 1),
(50, 38, 35, 2),
(51, 39, 35, 4),
(52, 40, 34, 3),
(53, 40, 35, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pendaftar` (`id_pengguna`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`),
  ADD KEY `kategori_produk` (`id_kategori`);

--
-- Indexes for table `produk_pesanan`
--
ALTER TABLE `produk_pesanan`
  ADD PRIMARY KEY (`id_produk_pesanan`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `produk_pesanan`
--
ALTER TABLE `produk_pesanan`
  MODIFY `id_produk_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pendaftar` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `kategori_produk` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `produk_pesanan`
--
ALTER TABLE `produk_pesanan`
  ADD CONSTRAINT `produk_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `produk_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `outlet` (
  `id_outlet` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_outlet` VARCHAR(255) NOT NULL,
  `alamat` TEXT NOT NULL,
  `gambar` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_outlet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `outlet` (`nama_outlet`, `alamat`, `gambar`) VALUES
('Surabaya', 'Jl. Raya Darmo No. 123', 'surabaya.jpg'),
('Kediri', 'Jl. Dhoho No. 45', 'kediri.jpg'),
('Sidoarjo', 'Jl. Gajah Mada No. 67', 'sidoarjo.jpg'),
('Jombang', 'Jl. Wahid Hasyim No. 89', 'jombang.jpg'),
('Mojokerto', 'Jl. Mojopahit No. 101', 'mojokerto.jpg'),
('Gresik', 'Jl. Veteran No. 12', 'gresik.jpg');