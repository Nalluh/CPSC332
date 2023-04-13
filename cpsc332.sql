-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2023 at 02:24 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpsc332`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `FName`, `LName`, `email`, `PhoneNumber`, `date`) VALUES
(70, 'Nalla1', 'Qwerty123.', 'Alla', 'C', 'a@a.com', '123', '2023-04-11 20:06:19'),
(71, 'Nalla', 'Qwerty123.', 'Allan', 'Cortes', 'allan.cor98@gmail.com', '5624056559', '2023-04-11 20:06:39'),
(72, 'yoyoyo29', 'yYoYo6809.', 'Yolando', 'Yoling', 'yoyo29@gmail.com', '9492398678', '2023-04-11 20:22:20'),
(73, 'ALcor', 'ALCOr4321!', 'AL', 'alcor@gmail.com', 'Cor', '6267718945', '2023-04-11 22:04:29'),
(74, 'Nalla4', 'Qwerty1234.', 'Ben', '4@gmail.com', 'BEN', '9192345432', '2023-04-11 22:48:37'),
(75, 'TBHIDK', 'TBHIDk1212!', 'TBHIDK', 'tbhidk@gmail.com', 'TBHIDK', '1231231234', '2023-04-12 00:13:12'),
(76, 'test', 'Test1234!', 'test', 'testing', 'test@test.com', '5456366336', '2023-04-12 00:15:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
