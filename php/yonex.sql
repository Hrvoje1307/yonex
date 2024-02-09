-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2024 at 07:33 AM
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
-- Table structure for table `bags`
--

CREATE TABLE `bags` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL,
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
  `image_url` varchar(500) NOT NULL,
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
(106062, 'Prigušivač vibracija AC165, 2 kom, bijeli', 0, 8.95, 7.34, './images/product-images/tennis/vibrationDampers/106061.webp', 'vibrationDamper', 'Gumeni vibracijski umetak Yonex Vibration Stopper s troslojnom strukturom maksimalno suzbija neželjene vibracije.- 2 komada u paketu');

-- --------------------------------------------------------

--
-- Table structure for table `cloathing`
--

CREATE TABLE `cloathing` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL,
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
  `image_url` varchar(500) NOT NULL,
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
  `image_url` varchar(500) NOT NULL,
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
  `image_url` varchar(500) NOT NULL,
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
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `number`, `password`, `is_admin`, `created_at`) VALUES
(11, 'Dean', 'Vidovic', 'vidovicdean@gmail.com', '0992959503', '$2y$10$pJtMRfopk1qCuipYDfzDIOxYY72i8Yrpmhi63mjoaJYIip5S6hVQm', 0, '2024-01-05'),
(12, 'Dejo', 'Nevolja', 'dejonevolja@gmail.com', '0912959503', '$2y$10$QBj9Gr0sF2sUe07SeWCzjeE8uKUq0EGQ1UKGHet1RxooEJuLwVUWq', 0, '2024-01-05'),
(15, 'aklsdajd', 'alksdjakld', 'alkjsdakld@alsdkjald.com', '890808', '$2y$10$g8rTWgxoeUtMDMJyg4IoXumyIUB0Cq0Xx7Zv4kKjPkEP1SW2XbHqO', 0, '2024-01-05'),
(16, 'Hrvoje', 'Cuckovic', 'cuckovichrvoje@gmail.com', '123456789', '$2y$10$TmWuedbToHWWC3uPlYOhPORFAkFxoTp5LthCK8n5dFUFDGZSH4Jjy', 0, '2024-01-05'),
(17, 'Jonah', 'Bijvank', 'jonahbijvank@gmail.com', '0985289234', '$2y$10$i6aAejA8eNquoY5blMLYguty3h./ZWqr5fjYrpHk3oPuNmy0dQrtS', 0, '2024-01-16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classicfilters`
--
ALTER TABLE `classicfilters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
