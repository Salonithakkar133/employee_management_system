-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 08:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `status`, `assigned_to`, `created_by`, `created_at`) VALUES
(4, 'project', 'this is your project', 'in_progress', NULL, 7, '2025-06-19 10:03:19'),
(6, 'project', 'project', 'in_progress', 27, 7, '2025-06-19 12:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pending','employee','team_leader','admin') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `profile_image`, `is_deleted`) VALUES
(7, 'admin', 'admin@gmail.com', '$2y$10$r582WAIss8rcO/SnfL9Ylekd.0jAESGfyYOWgbD8rUGbK0ma.0TJu', 'admin', '2025-06-18 12:14:57', '1750610424_diet flyer.png', 0),
(27, 'saloni', 'saloni@gmail.com', '$2y$10$xJ.zE/yCK1yK74pvWvRXa.z/SCoHHOa3uVjFI3lqdRt9Ki4wXYtcq', 'employee', '2025-06-19 12:32:40', NULL, 0),
(28, 'part', 'parth@gmail.com', '$2y$10$iWi7sNCeFWC.OGyMcyIpuO2elMmgxMD/gZDjG6iOSXRmuBXSy..M2', 'team_leader', '2025-06-20 05:41:20', NULL, 0),
(48, 'abc', 'a@gmail.com', '$2y$10$nRdt1lC3.g0jZqzpaSaPcO.PQc3a78J0cKQipQHppG1n6793TQvUC', 'pending', '2025-06-20 11:03:30', NULL, 0),
(49, 's', 's@gmail.com', '$2y$10$zFa2BPL.laDHmhRj179LRO/3ckcrusSKOQX78QrZtJ6vV1pJdW4H6', 'pending', '2025-06-20 11:24:53', NULL, 0),
(53, 'pragati', 'p@gmail', '$2y$10$CStbCpcqf090DhGlsKk5uO647RHTe7yRvvNveEE.c9ZCExrZScZ46', 'employee', '2025-06-20 12:28:04', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
