-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2024 at 01:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
(13, 'Hrvoje', 'Cuckovic', 'hrvoje.cuckovic@gmail.com', '123456789', '$2y$10$jr1Ne.9UntfuDaJVFZpHpeXQtX4QtE7xiUxIV53XdobYuVG6c/1Tu', 0, '2024-01-05'),
(15, 'aklsdajd', 'alksdjakld', 'alkjsdakld@alsdkjald.com', '890808', '$2y$10$g8rTWgxoeUtMDMJyg4IoXumyIUB0Cq0Xx7Zv4kKjPkEP1SW2XbHqO', 0, '2024-01-05');

--
-- Indexes for dumped tables
--

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
