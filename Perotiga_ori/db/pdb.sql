-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2024 at 12:15 PM
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
-- Database: `pdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `car_age` int(11) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `car_image_path` varchar(255) DEFAULT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `car_age`, `availability`, `car_image_path`, `price_per_day`, `transmission`, `fuel_type`, `created_at`, `updated_at`) VALUES
(1, 'Perodua', 'Myvi', 7, 1, 'uploads/myvi2.jpg', 55.00, 'Automatic', 'Petrol', '2024-06-30 09:24:15', '2024-06-30 09:24:22'),
(2, 'Proton', 'X50', 3, 1, 'uploads/X50.jpg', 70.00, 'Automatic', 'Petrol', '2024-06-30 09:24:46', '2024-06-30 09:24:46'),
(3, 'Proton', 'X70', 2, 1, 'uploads/X70.png', 100.00, 'Automatic', 'Petrol', '2024-06-30 09:27:54', '2024-06-30 09:27:54'),
(4, 'Proton', 'Satria Theo', 1, 1, 'uploads/satria.jpg', 150.00, 'Automatic', 'Petrol', '2024-06-30 09:31:31', '2024-06-30 09:33:50'),
(5, 'Proton', 'Suprima', 6, 1, 'uploads/suprima.jpg', 80.00, 'Automatic', 'Petrol', '2024-06-30 09:32:08', '2024-06-30 09:32:08'),
(6, 'Toyota', 'Vellfire', 4, 1, 'uploads/vellfire.jpg', 170.00, 'Automatic', 'Petrol', '2024-06-30 09:32:41', '2024-06-30 09:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `car_id`, `payment_date`, `amount`, `payment_status`, `created_at`) VALUES
(1, 4, '0000-00-00', 0.00, 'Paid', '2024-06-30 09:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `ic` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` varchar(10) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`id`, `user_id`, `car_id`, `ic`, `address`, `status`, `created_at`, `updated_at`, `name`) VALUES
(1, 3, 4, '020715100515', 'Bandar Baru, Kuala Selangor', 'Approved', '2024-06-30 09:34:55', '2024-06-30 09:36:35', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) DEFAULT 'No address provided',
  `password` varchar(30) NOT NULL,
  `user_role` int(11) NOT NULL,
  `phone_num` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `address`, `password`, `user_role`, `phone_num`, `created_at`, `updated_at`) VALUES
(1, 'technician', 'Technician User', 'technician@gmail.com', 'No address provided', 'technician', 3, '012-3456789', '2024-06-29 22:29:36', '2024-06-29 22:29:36'),
(2, 'admin', 'Admin Userr', 'admin@gmail.com', 'No address providedd', 'admin', 2, '019-87654323', '2024-06-29 22:29:36', '2024-06-29 22:29:50'),
(3, 'user', 'Regular User', 'user@gmail.com', 'No address provided', 'user', 1, '011-23456789', '2024-06-29 22:29:36', '2024-06-29 22:29:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
