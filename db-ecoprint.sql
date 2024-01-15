-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 11:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-ecoprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
(4, 'IWckDc3xbB7BtzfnW8cU', 2, 150000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `qty` varchar(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'in progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`) VALUES
('bNw8x8qzBL8CbmgPd2q3', 'op2LBIyhPTz0XEJ3kh2L', 'rani', '09999', 'ref3@gmail.com', 'lala\\, lalala, kooo, aadad - 12222', 'home', 'cash on delivery', 'EklrzqrZJxGJ1nzfFzQx', '100000', '1', '2024-01-13', 'in progress'),
('qKhdQWuid9gNJnRD9sA4', 'IWckDc3xbB7BtzfnW8cU', 'Refi Junitasari', '5714171826', 'refijunita3@gmail.com', 'KAB. TEGAL, JALAN DR. SOETOMO RT 006 RW 003,KALISAPU, SLAWI, K - 52416', 'home', 'cash on delivery', '2', '150000', '1', '2024-01-14', 'in progress'),
('dAh7upOYMtLcAgG3vr7s', 'IWckDc3xbB7BtzfnW8cU', 'Refi Junitasari', '5714171826', 'refijunita3@gmail.com', 'KAB. TEGAL, JALAN DR. SOETOMO RT 006 RW 003,KALISAPU, SLAWI, K - 52416', 'home', 'cash on delivery', '3', '180000', '1', '2024-01-14', 'in progress'),
('gcflOxT57i4OUYAx6rnc', 'IWckDc3xbB7BtzfnW8cU', 'Refi Junitasari', '5714171826', 'refijunita3@gmail.com', 'KAB. TEGAL, JALAN DR. SOETOMO RT 006 RW 003,KALISAPU, SLAWI, K - 52416', 'home', 'cash on delivery', '1', '80000', '1', '2024-01-14', 'in progress'),
('do4mvpuC7AcHBJH68XWz', 'IWckDc3xbB7BtzfnW8cU', 'Refi Junitasari', '5714171826', 'refijunita3@gmail.com', 'KAB. TEGAL, JALAN DR. SOETOMO RT 006 RW 003,KALISAPU, SLAWI, K - 52416', 'home', 'cash on delivery', '4', '170000', '1', '2024-01-14', 'in progress');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `category`, `name`, `description`, `detail`, `price`, `image`) VALUES
(1, 'Tas', 'Kalico Pouch', 'Kaliko Textiles', 'Kaliko Pouch Ecoprint: aksen gaya ramah lingkungan. Dengan teknik Ecoprint, pouch ini menampilkan motif alam yang unik. Terbuat dari bahan ramah lingkungan, menyediakan opsi fungsional dan modis dengan kesadaran lingkungan. Ideal untuk menyimpan kebutuhan', 70000, 'Rectangle 31.png'),
(3, 'Lainnya', 'Floral Scraft', 'Nature Shop', 'Floral Scarf Ecoprint adalah aksesori yang memikat dengan sentuhan alam yang eksklusif. Dicetak dengan teknik Ecoprint yang ramah lingkungan, selendang ini mempersembahkan motif bunga yang memikat dan unik. Terbuat dari bahan berkualitas tinggi yang mendu', 180000, 'Rectangle 31 (2).png'),
(4, 'Wanita', 'Seleeveless Blouse', 'Keyla Wear', 'Ecoprin Sleeveless Blouse menghadirkan perpaduan elegan antara desain modern dan keberlanjutan lingkungan. Dibuat dengan teknik Ecoprint yang ramah lingkungan, blouse ini memberikan opsi busana yang stylish dan mendukung keberlanjutan. Dengan desain sleev', 170000, 'Rectangle 31 (3).png'),
(8, 'Alas Kaki', 'Eco Leather Sandals', 'Footprint Shop', 'Eco Leather Sandals: Keanggunan dan keberlanjutan dalam satu langkah. Dicetak dengan teknik Ecoprint, sandal ini menghadirkan motif alam pada kulit ramah lingkungan. Memberikan kenyamanan dan gaya, Eco Leather Sandals adalah pilihan modis yang mendukung k', 250000, 'Rectangle 31 (5).png'),
(10, 'Alas Kaki', 'Kaos Kaki Floral', 'Footprint Shop', 'Kaos Kaki Floral Ecoprint: Keindahan alam dalam setiap langkah. Dicetak dengan teknik Ecoprint, kaos kaki ini menghadirkan motif bunga yang memikat. Terbuat dari bahan ramah lingkungan, memberikan kenyamanan dan gaya yang mendukung keberlanjutan.', 30000, 'DdJk5WWJEKPBwCzlGtkL.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_lengkap`, `email`, `password`) VALUES
(1, 'Refi Junitasari', 'refijunita3@gmail.com', '7ff59266311b752bb0930798f8bbc75d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
