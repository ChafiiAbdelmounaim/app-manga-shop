-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2022 at 07:15 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(3, 'admin', '523af537946b79c4f8369ed39ba78605');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(16, 47, 12, 'one piece v 100', 100, 5, 'op-100-1.jpg'),
(17, 47, 13, 'Dr stone v 22', 66, 4, 'dr-22-1.jpg'),
(26, 10, 17, 'jujutsu kaisen v 11', 96, 1, 'jk-11-1.jpg'),
(27, 47, 15, 'black clover v 27', 85, 4, 'bc-27-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(6, 0, 'abdou', 'zoro@op', '061234565674', 'whatever !!'),
(7, 0, 'akaio-7', 'akaio@gmail.com', '0645123698', 'great website ,easy shop i had the best user experience ❤🌹'),
(8, 0, 'mohamed', 'zoro@op', '98125114545', 'that payment process was pretty easy 💖💖');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(6, 9, 'abdou', '0612345678', 'moro15@gmail.com', 'paypal', 'flat no. 47, shari3 hamiiid, rabat, none, morocco - 23350', 'boruto v 14 (87 x 1) - Dr stone v 22 (66 x 1) - one piece v 102 (102 x 4) - ', 561, '2022-07-09', 'completed'),
(7, 10, 'adminAC', '065454648', 'luffy@op', 'paypal', 'flat no. 45, shari3 hamiiid, kasbat tadla, beni mellal-khenifra, morocco - 35465', 'one piece v 100 (100 x 1) - jujutsu kaisen v 16 (80 x 3) - demon slayer v 19 (69 x 2) - black clover v 30 (103 x 1) - ', 581, '2022-07-11', 'completed'),
(8, 11, 'zoro', '4506456551', 'zoro@gmail.com', 'cash on delivery', 'flat no. 47, shari3 hamiiid, rabat, none, morocco - 12546', 'one piece v 100 (100 x 1) - black clover v 27 (85 x 1) - jujutsu kaisen v 16 (80 x 1) - ', 265, '2022-07-12', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(8, 'one piece v 99', 'manga one piece v 99 english', 97, 'op-99-1.jpg', 'op-99-2.jpg', 'op-99-3.jpg'),
(9, 'boruto v 14', 'manga boruto v 14 english', 87, 'boruto-14-1.jpg', 'boruto-14-2.jpg', 'boruto-14-3.jpg'),
(10, 'one piece v 102', 'manga one piece v 102 english', 102, 'op-102-1.jpg', 'op-102-2.jpg', 'op-102-3.jpg'),
(11, 'boruto v 13', 'manga boruto v 13 english', 75, 'boruto-13-1.jpg', 'boruto-13-2.jpg', 'boruto-13-3.jpg'),
(12, 'one piece v 100', 'manga one piece v 100 english', 100, 'op-100-1.jpg', 'op-100-2.jpg', 'op-100-3.jpg'),
(13, 'Dr stone v 22', 'manga Dr stone v 22 english', 66, 'dr-22-1.jpg', 'dr-22-2.jpg', 'dr-22-3.jpg'),
(14, 'one piece v 101', 'one piece v 101 english', 106, 'op-101-1.jpg', 'op-101-2.jpg', 'op-101-3.jpg'),
(15, 'black clover v 27', 'black clover v 27 english', 85, 'bc-27-1.jpg', 'bc-27-2.jpg', 'bc-27-3.jpg'),
(16, 'demon slayer v 19', 'demon slayer v 19 english', 69, 'ds-19-1.jpg', 'ds-19-2.jpg', 'ds-19-3.jpg'),
(17, 'jujutsu kaisen v 11', 'jujutsu kaisen v 11 english', 96, 'jk-11-1.jpg', 'jk-11-2.jpg', 'jk-11-3.jpg'),
(18, 'jujutsu kaisen v 16', 'jujutsu kaisen v 16 english', 80, 'jk-16-1.jpg', 'jk-16-2.jpg', 'jk-16-3.jpg'),
(19, 'demon slayer v 23', 'demon slayer v 23 english', 98, 'ds-23-1.jpg', 'ds-23-2.jpg', 'ds-23-3.jpg'),
(20, 'undead unluck v 12', 'undead unluck v 12 english', 54, 'uu-12-1.jpg', 'uu-12-2.jpg', 'uu-12-3.jpg'),
(21, 'black clover v 30', 'black clover v 30 english', 103, 'bc-30-1.jpg', 'bc-30-2.jpg', 'bc-30-3.jpg'),
(22, 'boruto v 16', 'boruto v 16 english', 77, 'boruto-16-1.jpg', 'boruto-16-2.jpg', 'boruto-16-3.jpg'),
(23, 'jujutsu kaisen v 7', 'jujutsu kaisen v 7 arabic', 162, 'jk-7-1.jpg', 'jk-7-2.jpg', 'jk-7-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL /*UNIQUE*/,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(9, 'ronaldo', 'akaio7@gmail.com', '34ec78fcc91ffb1e54cd85e4a0924332'),
(10, 'abdou', 'luffy@op', '523af537946b79c4f8369ed39ba78605'),
(11, 'zoro', 'zoro@gmail.com', 'f970e2767d0cfe75876ea857f92e319b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
