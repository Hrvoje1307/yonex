-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 12:42 PM
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
-- Database: `yonex`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `filter_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`id`, `filter_name`) VALUES
(1, 'Dostupno'),
(2, 'Nedostupno');

-- --------------------------------------------------------

--
-- Table structure for table `bags`
--

CREATE TABLE `bags` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `size` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balls`
--

CREATE TABLE `balls` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `type` varchar(50) NOT NULL,
  `speed` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classicfilters`
--

CREATE TABLE `classicfilters` (
  `id` int(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(7,2) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classicfilters`
--

INSERT INTO `classicfilters` (`id`, `name`, `quantity`, `price`, `priceNOTAX`, `img_url`, `category`, `description`) VALUES
(106061, 'Prigušivač vibracija AC165, 2 kom, bijeli', 5, 8.95, 7.34, './images/product-images/tennis/vibrationDampers/106061.webp', 'vibrationDamper', 'Gumeni vibracijski umetak Yonex Vibration Stopper s troslojnom strukturom maksimalno suzbija neželjene vibracije.- 2 komada u paketu'),
(106062, 'Prigušivač vibracija AC165, 2 kom, bijeli', 0, 50.00, 7.34, './images/product-images/tennis/vibrationDampers/106061.webp', 'vibrationDamper', 'Gumeni vibracijski umetak Yonex Vibration Stopper s troslojnom strukturom maksimalno suzbija neželjene vibracije.- 2 komada u paketu');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `size` varchar(5) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cords`
--

CREATE TABLE `cords` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `thicknesses` varchar(10) NOT NULL,
  `length` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rackets`
--

CREATE TABLE `rackets` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `type` varchar(100) NOT NULL,
  `racketWeigth` varchar(50) NOT NULL,
  `handlerSize` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `priceNOTAX` double(7,2) NOT NULL,
  `img_url` varchar(500) NOT NULL,
  `shoes_num` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `number`, `password`, `is_admin`, `created_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(18, 'Hrvoje', 'Cuckovic', 'cuckovichrvoje1307@gmail.com', '3099898415', '$2y$10$hTO1x7ImCdDe7bi5uIG1p.vD3m2ec3rBiV/F0zaTykBFkNo.9QfbK', 0, '2024-02-26', '6789e6366c23d9f2083b05802191a31a89690b33071d18c02d500984df999f19', '2024-03-11 03:07:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bags`
--
ALTER TABLE `bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balls`
--
ALTER TABLE `balls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classicfilters`
--
ALTER TABLE `classicfilters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cords`
--
ALTER TABLE `cords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rackets`
--
ALTER TABLE `rackets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
