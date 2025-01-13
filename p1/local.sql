-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 13, 2025 at 09:54 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `local`
--

-- --------------------------------------------------------

--
-- Table structure for table `charging_stations`
--

CREATE TABLE `charging_stations` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `availability` enum('Available','Unavailable') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `charging_stations`
--

INSERT INTO `charging_stations` (`id`, `location`, `capacity`, `availability`, `created_at`) VALUES
(1, 'bashundhara', 500, 'Available', '2025-01-13 21:49:23'),
(2, 'banani', 400, 'Available', '2025-01-13 21:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `charging_station_logs`
--

CREATE TABLE `charging_station_logs` (
  `id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `charging_station_logs`
--

INSERT INTO `charging_station_logs` (`id`, `station_id`, `action`, `timestamp`) VALUES
(1, 1, 'active', '2025-01-13 21:50:29'),
(2, 1, 'active', '2025-01-13 21:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `energy_reports`
--

CREATE TABLE `energy_reports` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `usage` decimal(10,2) NOT NULL,
  `revenue` decimal(10,2) NOT NULL,
  `performance` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `energy_reports`
--

INSERT INTO `energy_reports` (`id`, `date`, `usage`, `revenue`, `performance`, `created_at`) VALUES
(1, '2025-01-14', '300.00', '20000.00', '34.00', '2025-01-13 21:51:24'),
(2, '2025-01-13', '500.00', '10000.00', '30.00', '2025-01-13 21:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_rules`
--

CREATE TABLE `pricing_rules` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pricing_rules`
--

INSERT INTO `pricing_rules` (`id`, `model`, `value`) VALUES
(1, 'p1', '300.00'),
(2, 'p2', '500.00');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `user_id`, `action`, `timestamp`) VALUES
(1, 3, 'ok', '2025-01-13 21:53:00'),
(2, 1, 'ok', '2025-01-13 21:53:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `status`) VALUES
(1, 'riad', 'riad@riad', 'riad', 'riad', 'active'),
(3, 'riad al hasan', 'riad@gmail.com', 'riadalhasan', 'riadalhasan', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charging_stations`
--
ALTER TABLE `charging_stations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charging_station_logs`
--
ALTER TABLE `charging_station_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station_id` (`station_id`);

--
-- Indexes for table `energy_reports`
--
ALTER TABLE `energy_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charging_stations`
--
ALTER TABLE `charging_stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `charging_station_logs`
--
ALTER TABLE `charging_station_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `energy_reports`
--
ALTER TABLE `energy_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charging_station_logs`
--
ALTER TABLE `charging_station_logs`
  ADD CONSTRAINT `charging_station_logs_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `charging_stations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
