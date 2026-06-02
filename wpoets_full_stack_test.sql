-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 09:51 AM
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
-- Database: `wpoets_full_stack_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `badge_text` varchar(150) NOT NULL,
  `title` varchar(255) NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `tab_id`, `badge_text`, `title`, `button_text`, `button_link`, `image`, `sort_order`, `status`, `created_at`) VALUES
(1, 1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Usability enhancement and Training for Transaction Portal for Customers', 'Learn More', '#', 'assets/images/DL-Learning-1.jpg', 1, 1, '2026-05-31 20:25:54'),
(2, 1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Interactive LMS rollout for onboarding and field enablement', 'Learn More', '#', 'assets/images/DL-Learning-1.jpg', 2, 1, '2026-05-31 20:25:54'),
(3, 1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Training portal modernization with better engagement flows', 'Learn More', '#', 'assets/images/DL-Learning-1.jpg', 3, 1, '2026-05-31 20:25:54'),
(4, 2, 'CONNECTED TECHNOLOGY PLATFORM', 'Cloud-first architecture for resilient operations and growth', 'Discover', '#', 'assets/images/DL-Technology.jpg', 1, 1, '2026-05-31 20:25:54'),
(5, 2, 'CONNECTED TECHNOLOGY PLATFORM', 'Automation systems that reduce friction and speed up delivery', 'Discover', '#', 'assets/images/DL-Technology.jpg', 2, 1, '2026-05-31 20:25:54'),
(6, 2, 'CONNECTED TECHNOLOGY PLATFORM', 'Modern dashboards that keep every team aligned in real time', 'Discover', '#', 'assets/images/DL-Technology.jpg', 3, 1, '2026-05-31 20:25:54'),
(7, 3, 'SMART COMMUNICATION HUB', 'Unified communication that keeps customers informed at every step', 'Explore', '#', 'assets/images/DL-Communication.jpg', 1, 1, '2026-05-31 20:25:54'),
(8, 3, 'SMART COMMUNICATION HUB', 'Campaign messaging and alerts with a clear content hierarchy', 'Explore', '#', 'assets/images/DL-Communication.jpg', 2, 1, '2026-05-31 20:25:54'),
(9, 3, 'SMART COMMUNICATION HUB', 'Omnichannel communication experiences with measurable impact', 'Explore', '#', 'assets/images/DL-Communication.jpg', 3, 1, '2026-05-31 20:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `tabs`
--

CREATE TABLE `tabs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabs`
--

INSERT INTO `tabs` (`id`, `title`, `icon`, `sort_order`, `status`, `created_at`) VALUES
(1, 'Learning', 'assets/images/DL-learning.svg', 1, 1, '2026-05-31 20:25:54'),
(2, 'Technology', 'assets/images/DL-technology.svg', 2, 1, '2026-05-31 20:25:54'),
(3, 'Communication', 'assets/images/DL-communication.svg', 3, 1, '2026-05-31 20:25:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_slides_tabs` (`tab_id`);

--
-- Indexes for table `tabs`
--
ALTER TABLE `tabs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tabs`
--
ALTER TABLE `tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `slides`
--
ALTER TABLE `slides`
  ADD CONSTRAINT `fk_slides_tabs` FOREIGN KEY (`tab_id`) REFERENCES `tabs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
