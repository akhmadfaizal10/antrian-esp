-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 04:55 PM
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
-- Database: `antrian`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `created_at`) VALUES
(1, '1', '2025-01-13 11:17:59'),
(2, '2', '2025-01-13 11:18:19'),
(3, '3', '2025-01-13 11:18:19'),
(4, '', '2025-01-13 15:22:18'),
(5, '', '2025-01-13 15:26:50'),
(6, '', '2025-01-13 15:26:55'),
(7, '', '2025-01-13 15:27:01'),
(8, '', '2025-01-13 15:30:08'),
(9, '0', '2025-01-13 15:37:42'),
(10, '1', '2025-01-13 15:37:44'),
(11, '0', '2025-01-13 15:37:45'),
(12, '0', '2025-01-13 15:37:45'),
(13, '0', '2025-01-13 15:37:46'),
(14, '0', '2025-01-13 15:37:46'),
(15, '0', '2025-01-13 15:37:47'),
(16, '0', '2025-01-13 15:37:47'),
(17, '0', '2025-01-13 15:37:48'),
(18, '0', '2025-01-13 15:37:48'),
(19, '0', '2025-01-13 15:37:49'),
(20, '0', '2025-01-13 15:37:55'),
(21, '1', '2025-01-13 15:38:10'),
(22, '', '2025-01-13 15:43:31'),
(23, '', '2025-01-13 15:43:37'),
(24, '', '2025-01-13 15:43:48'),
(25, '', '2025-01-13 15:43:54'),
(26, '', '2025-01-13 15:44:30'),
(27, '', '2025-01-13 15:45:49'),
(28, '', '2025-01-13 15:45:54'),
(29, '', '2025-01-13 15:45:57'),
(30, '', '2025-01-13 15:46:01'),
(31, '', '2025-01-13 15:46:28'),
(32, '', '2025-01-13 15:46:32'),
(33, '', '2025-01-13 15:47:16'),
(34, '', '2025-01-13 15:47:33'),
(35, '0', '2025-01-13 15:51:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
