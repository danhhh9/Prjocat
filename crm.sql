-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2024 at 10:38 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `date_of_birth`, `created_at`, `updated_at`) VALUES
(1, 'first user.....', 'hawi@mailinator.com', '0512151515', 'new address street', '1993-07-31', '2024-12-01 22:07:50', '2024-12-05 10:49:05'),
(2, 'user name', 'fimu@mailinator.com', '0515121245', 'test new addresss', '1990-11-01', '2024-12-01 22:16:25', '2024-12-02 21:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `interactions`
--

CREATE TABLE `interactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interactions`
--

INSERT INTO `interactions` (`id`, `lead_id`, `type`, `date`, `details`, `created_at`, `updated_at`) VALUES
(1, 1, 'email', '2024-12-01 00:00:00', 'i was send an email for the client', '2024-12-01 23:40:49', '2024-12-01 23:40:49'),
(4, 2, 'whatsapp', '2024-12-01 23:45:00', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has ', '2024-12-01 23:45:45', '2024-12-01 23:45:45'),
(5, 1, 'sms', '2024-12-02 20:21:00', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has	\r\n', '2024-12-02 20:16:51', '2024-12-02 20:16:51'),
(6, 1, 'call', '2024-12-05 11:50:00', 'احمد وافق علي العرض', '2024-12-05 10:50:12', '2024-12-05 10:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `email`, `phone`, `source`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lead number 1', 'lead@gmail.com', '0512544554', 'facebook', 'new', '2024-12-01 22:33:44', '2024-12-01 22:33:54'),
(2, 'Lead number 2', 'lead@gmail.test', '0512112215', 'twitter', 'new', '2024-12-01 22:34:20', '2024-12-01 22:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `date`, `status`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-12-09 21:03:00', 'completed', 'test address', '2024-12-02 21:11:29', '2024-12-02 21:28:44'),
(2, 1, '2024-12-02 21:17:00', 'completed', 'address', '2024-12-02 21:15:01', '2024-12-02 21:23:08'),
(4, 2, '2024-12-02 21:32:00', 'pending', 'test', '2024-12-02 21:28:24', '2024-12-02 21:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`order_id`, `product_id`, `price`) VALUES
(1, 3, 120.00),
(1, 5, 110.00),
(1, 6, 130.00),
(2, 4, 100.00),
(2, 6, 130.00),
(4, 4, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Product #1', 'this is product description for test data this is product description for test data this is product description for test data this is product description for test data this is product description for test data this is product description for test data ', 150.00, '2024-12-01 22:49:18', '2024-12-01 22:50:09'),
(3, 'Product #2', 'this is product description for test data this is product description for test data ', 120.00, '2024-12-01 22:49:18', '2024-12-01 22:50:09'),
(4, 'Product #3', 'this is product description for test data this is product description for test data ', 100.00, '2024-12-01 22:49:18', '2024-12-01 22:50:09'),
(5, 'Product #4', 'this is product description for test data this is product description for test data ', 110.00, '2024-12-01 22:49:18', '2024-12-01 22:50:09'),
(6, 'Product #5', 'this is product description for test data this is product description for test data ', 130.00, '2024-12-01 22:49:18', '2024-12-01 22:50:09'),
(7, 'Product #6', 'this is product description for test data this is product description for test data ', 160.00, '2024-12-01 22:49:18', '2024-12-01 22:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'password', '2024-12-01 23:05:59', '2024-12-01 23:05:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
