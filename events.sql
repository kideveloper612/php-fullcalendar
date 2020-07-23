-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 23, 2020 at 09:14 AM
-- Server version: 5.7.30-0ubuntu0.16.04.1
-- PHP Version: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_ipioss`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `is_paid_standby` int(11) DEFAULT NULL COMMENT '1 = staff member is paid the usual £200/week oncall standby rate',
  `is_paid_overtime` int(11) DEFAULT NULL COMMENT '1 = is paid the 1.5 x / 2 x overtime rate during this period on standby',
  `extra_parameters` text COLLATE utf8mb4_unicode_ci COMMENT 'Any extra parameters required for the event',
  `resource_id` int(11) DEFAULT NULL COMMENT 'The Autotask resource ID of the person on call',
  `created_by_resource_id` int(11) DEFAULT NULL COMMENT 'The Autotask resource ID of the person who created the entry',
  `resourceId` int(11) DEFAULT NULL COMMENT 'This is actually the resource in Fullcalendar',
  `comments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `is_paid_standby`, `is_paid_overtime`, `extra_parameters`, `resource_id`, `created_by_resource_id`, `resourceId`, `comments`, `created_at`, `updated_at`) VALUES
(1, 'Darren Round', '2020-07-03 17:30:00', '2020-07-10 08:30:00', 1, 1, NULL, 1, NULL, 1, NULL, NULL, NULL),
(2, 'Mick Lee', '2020-07-10 17:30:00', '2020-07-17 08:30:00', 1, 1, NULL, 1, NULL, 1, NULL, NULL, NULL),
(30, 'Paul Hrynkiw', '2020-07-03 17:30:00', '2020-07-10 08:30:00', NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL),
(31, 'Umed Ali', '2020-07-03 17:30:00', '2020-07-10 08:30:00', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
(32, 'Paul Hrynkiw', '2020-07-10 17:30:00', '2020-07-17 08:30:00', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
(33, 'Paul Hrynkiw', '2020-07-03 17:30:00', '2020-07-10 08:30:00', NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL),
(34, 'Darren Round', '2020-07-03 17:30:00', '2020-07-10 08:30:00', NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL),
(35, 'Nic Atkins', '2020-07-10 17:30:00', '2020-07-17 08:30:00', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL),
(36, 'Jimmy George', '2020-07-10 17:30:00', '2020-07-17 08:30:00', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
(37, 'Nic Atkins', '2020-07-11 17:30:00', '2020-07-18 08:30:00', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(38, 'Nic Atkins', '2020-07-19 17:30:00', '2020-07-26 08:30:00', NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_is_paid_standby_index` (`is_paid_standby`),
  ADD KEY `events_is_paid_overtime_index` (`is_paid_overtime`),
  ADD KEY `events_resource_id_index` (`resource_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
