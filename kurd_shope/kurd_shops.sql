-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 08:35 PM
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
-- Database: `kurd_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `items` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `total` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productNameEn` varchar(255) NOT NULL,
  `productDescription` text DEFAULT NULL,
  `productPrice` int(10) NOT NULL,
  `productOriginalPrice` int(10) DEFAULT NULL,
  `productImage` varchar(255) NOT NULL,
  `productCategory` varchar(100) NOT NULL,
  `productBrand` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productName`, `productNameEn`, `productDescription`, `productPrice`, `productOriginalPrice`, `productImage`, `productCategory`, `productBrand`, `created_at`) VALUES
(3, 'شامپۆی گوڵاو', 'Rose Shampoo', 'شامپۆیەکی ئەسڵی بە گوڵاو بۆ قژی نەرم', 37000, 40000, 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=300', 'haircare', 'هەرێمی جوانی', '2025-07-15 13:46:30'),
(4, 'پەرفیومی شەو', 'Night Perfume', 'پەرفیومێکی خۆش بۆ شەوان', 65000, NULL, 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=300', 'fragrance', 'کوردستان فریگرانس', '2025-07-15 13:46:30'),
(5, 'بڕشی میکیاج', 'Makeup Brush Set', 'کۆمەڵە بڕشی میکیاج بە کوالیتی بەرز', 55000, 65000, 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=300', 'tools', 'پرۆ میکیاج', '2025-07-15 13:46:30'),
(6, 'ماسکی چاودێری پێست', 'Skincare Mask', 'ماسکێکی تایبەت بۆ چاودێری پێست', 30000, 20000, 'https://images.unsplash.com/photo-1570554886111-e80fcca6a029?w=300', 'skincare', 'نەچەرال کیر', '2025-07-15 13:46:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
