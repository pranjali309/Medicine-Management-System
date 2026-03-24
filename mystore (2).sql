-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 03, 2025 at 02:27 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mystore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$iZTmlvNcJDwyaY3xi.zeJuCGgL5X1dUD3eAAWtJEIOs0jc.oBUpWq');

-- --------------------------------------------------------

--
-- Table structure for table `billing_history`
--

DROP TABLE IF EXISTS `billing_history`;
CREATE TABLE IF NOT EXISTS `billing_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Paid','Failed','Pending') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(33, 4, 1, 2),
(61, 6, 25, 1),
(103, 15, 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category_description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`, `category_description`, `created_at`) VALUES
(13, 'Pain Relievers (Analgesics)', NULL, '2025-02-28 12:11:42'),
(14, 'Antibiotics', NULL, '2025-02-28 12:12:27'),
(15, ' Antipyretics (Fever Reducers)', NULL, '2025-02-28 12:12:38'),
(16, ' Antacids & Acid Reducers', NULL, '2025-02-28 12:12:55'),
(17, 'Antihistamines (Allergy Medicines)', NULL, '2025-02-28 12:13:06'),
(18, 'Cough & Cold Medicines', NULL, '2025-02-28 12:13:18'),
(19, 'Antidiabetic Medicines', NULL, '2025-02-28 12:13:27'),
(20, 'Cardiovascular Medicines (Heart & Blood Pressure)', NULL, '2025-02-28 12:13:41'),
(21, 'Vitamins & Supplements', NULL, '2025-02-28 12:13:51'),
(22, 'Neurological & Psychiatric Medicines', NULL, '2025-02-28 12:14:00'),
(23, ' Antifungal & Antiviral Medicines', NULL, '2025-02-28 12:14:09'),
(24, 'Skin & Dermatology Medicines', NULL, '2025-02-28 12:14:19'),
(25, 'Eye & Ear Drops', NULL, '2025-02-28 12:14:28'),
(26, 'Hormonal Medicines', NULL, '2025-02-28 12:14:37'),
(27, ' Gastrointestinal Medicines', NULL, '2025-02-28 12:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reply` text COLLATE utf8mb4_general_ci,
  `status` enum('unread','read') COLLATE utf8mb4_general_ci DEFAULT 'unread',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `phone`, `address`, `message`, `ip_address`, `created_at`, `reply`, `status`) VALUES
(13, 'Tanuja Sharad More', '09518590430', 'at waknwadi post kikali taluka wai dist satara', 'asdfghjklkmnbvc', '::1', '2025-02-11 19:27:15', NULL, 'unread'),
(14, 'pooja', '09518590430', 'at waknwadi post kikali taluka wai dist satara', 'hello i am pooja', '::1', '2025-02-12 06:58:34', NULL, 'unread'),
(15, 'pooja', '09518590430', 'at waknwadi post kikali taluka wai dist satara', 'hello i am pooja', '::1', '2025-02-12 06:58:55', NULL, 'unread'),
(16, 'vaidehee', '09518590430', 'at waknwadi post kikali taluka wai dist satara', 'hello pooja', '::1', '2025-02-12 07:01:20', NULL, 'unread'),
(17, 'vaidehee', '09518590430', 'at waknwadi post kikali taluka wai dist satara', 'hello pooja', '::1', '2025-02-12 07:05:33', NULL, 'unread'),
(18, 'vaidehee', '09518590430', 'at waknwadi post kikali taluka wai dist satara', 'tanuja hello i am tanu', '::1', '2025-02-12 07:06:55', NULL, 'unread'),
(19, 'Tanuja Sharad More', '09518590430', 'at wakhandwadi post kikali taluka wai dist satara', 'i am tanuja sharad more', '::1', '2025-02-12 07:11:53', NULL, 'unread'),
(20, 'Tanuja Sharad More', '09518590430', 'at wakhandwadi post kikali taluka wai dist satara', 'i am tanuja sharad more', '::1', '2025-02-12 07:13:15', NULL, 'unread'),
(21, 'Tanuja Sharad More', '09518590430', 'at wakhandwadi post kikali taluka wai dist satara', 'i am tanuja sharad more', '::1', '2025-02-12 07:15:48', NULL, 'unread'),
(22, 'Tanuja Sharad More', '09518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'i am tanuja', '::1', '2025-02-12 07:16:03', NULL, 'unread'),
(23, 'dfghjkl', '', 'asdfghjk', 'hygtrfeds hgdfg uuyt', '::1', '2025-02-12 07:16:34', NULL, 'unread'),
(24, 'dfghjkl', '', 'asdfghjk', 'hygtrfeds hgdfg uuyt', '::1', '2025-02-12 07:17:47', NULL, 'unread'),
(25, 'dfghjkl', '', 'asdfghjk', 'hygtrfeds hgdfg uuyt', '::1', '2025-02-12 07:17:53', NULL, 'unread'),
(26, 'Tanuja Sharad More', '09518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'qwer tyyuuui aasdf hjkl zxcv bnnm', '::1', '2025-02-12 07:18:23', NULL, 'unread'),
(27, 'Tanuja Sharad More', '09518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'hello medico', '::1', '2025-02-23 05:38:40', NULL, 'unread'),
(28, 'anuja Sharad More', '9653427819', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'heyyy medico', '::1', '2025-02-24 16:00:11', NULL, 'unread'),
(29, 'chaitu more', '9561787848', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'heyyy my name is chaitu', '::1', '2025-02-24 16:00:49', NULL, 'unread'),
(30, 'ishwari Sharad More', '9834625927', 'At /Post kikali Taluka wai Dist satara', 'heyy no no no', '::1', '2025-02-24 16:01:41', NULL, 'unread'),
(31, 'ishwari Sharad More', '9834625927', 'At /Post kikali Taluka wai Dist satara', 'heyy no no no', '::1', '2025-02-24 16:01:47', NULL, 'unread'),
(32, 'Tanuja Sharad More', '09518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'hejk ghejhjjjkkf', '::1', '2025-02-27 04:45:25', NULL, 'unread'),
(33, 'Tanuja Sharad More', '9518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'heyyy  hello tanu', '::1', '2025-02-27 12:38:14', NULL, 'unread'),
(34, 'Tanuja Sharad More', '9518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'sdfghjklkjhgnbvcxzsdfghjkl', '::1', '2025-02-27 12:45:41', 'HELLO', 'unread'),
(35, 'Tanuja Sharad More', '0518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'aaaaaaaasdfghjnbvcxzxcdfgtyuij', '::1', '2025-02-27 12:47:15', NULL, 'unread'),
(36, 'Tanuja Sharad More', '9518590430', 'At wakhandwadi Post kikali Taluka wai Dist satara', 'qwertyuiopokjhgfdsaAXCVBNM,MNBV', '::1', '2025-02-27 12:47:52', 'heyy', 'unread'),
(37, 'bhumi kale', '09403661099', 'pune', 'helloooo Sagar Medico', '::1', '2025-03-18 12:09:55', NULL, 'unread'),
(38, 'bhumi kale', '9403661099', 'pune', 'hi i am bhumi', '::1', '2025-03-18 12:21:25', 'hello bhumi', 'unread'),
(39, 'madhvi bhosale', '07709676530', 'baramati', 'hello sagar medico i want some help', '::1', '2025-03-18 20:40:54', NULL, 'unread'),
(40, 'pooja nikam', '9403661024', 'satara', 'hello  sagar medico', '::1', '2025-03-19 07:28:34', 'hello pooja', 'unread'),
(41, 'Nikam Pranjali Jalindar', '9403661024', 'satara', 'hiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii', '::1', '2025-03-19 09:44:47', NULL, 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `status`, `created_at`) VALUES
(1, 'New order placed by User ID: 7 (Order ID: )', 'read', '2025-03-18 11:47:23'),
(2, '🛒 New order placed by User ID: 7 (Order ID: 8)', 'read', '2025-03-18 11:49:32'),
(3, '🛒 New order placed by User ID: 7 (Order ID: 9)', 'read', '2025-03-18 11:53:36'),
(4, '🛒 New order placed by User ID: 7 (Order ID: 10)', 'read', '2025-03-18 11:57:13'),
(5, '🛒 New order placed by User ID: 7 (Order ID: 11)', 'read', '2025-03-18 11:58:02'),
(6, '🛒 New order placed by User ID: 7 (Order ID: 12)', 'read', '2025-03-18 11:58:32'),
(7, '🛒 New order placed by User ID: 7 (Order ID: 13)', 'read', '2025-03-18 11:59:23'),
(8, '🛒 New order placed by User ID: 7 (Order ID: 14)', 'read', '2025-03-18 11:59:48'),
(9, '📩 New message from bhumi kale (09403661099)', 'read', '2025-03-18 12:09:55'),
(10, '📩 New message from bhumi kale (9403661099)', 'read', '2025-03-18 12:21:25'),
(11, '🛒 New order placed by User ID: 7 (Order ID: 15)', 'read', '2025-03-18 12:22:48'),
(12, '🛒 New order placed by User ID: 7 (Order ID: 16)', 'read', '2025-03-18 12:23:36'),
(13, '🛒 New order placed by User ID: 9 (Order ID: 17)', 'read', '2025-03-18 14:54:06'),
(14, '🛒 New order placed by User ID: 10 (Order ID: 18)', 'read', '2025-03-18 17:16:48'),
(15, '🛒 New order placed by User ID: 10 (Order ID: 19)', 'read', '2025-03-18 17:17:19'),
(16, '🛒 New order placed by User ID: 10 (Order ID: 20)', 'read', '2025-03-18 17:17:56'),
(17, '🛒 New order placed by User ID: 10 (Order ID: 21)', 'read', '2025-03-18 17:18:29'),
(18, '🛒 New order placed by User ID: 11 (Order ID: 22)', 'read', '2025-03-18 17:21:20'),
(19, '🛒 New order placed by User ID: 11 (Order ID: 23)', 'read', '2025-03-18 18:06:31'),
(20, '🛒 New order placed by User ID: 11 (Order ID: 24)', 'read', '2025-03-18 18:07:00'),
(21, '🛒 New order placed by User ID: 12 (Order ID: 25)', 'read', '2025-03-18 20:26:39'),
(22, '🛒 New order placed by User ID: 13 (Order ID: 26)', 'read', '2025-03-18 20:31:21'),
(23, '🛒 New order placed by User ID: 13 (Order ID: 27)', 'read', '2025-03-18 20:32:20'),
(24, '📩 New message from madhvi bhosale (07709676530)', 'read', '2025-03-18 20:40:54'),
(25, '📩 New message from pooja nikam (9403661024)', 'unread', '2025-03-19 07:28:34'),
(26, '🛒 New order placed by User ID: 12 (Order ID: 28)', 'unread', '2025-03-19 07:29:02'),
(27, '📩 New message from Nikam Pranjali Jalindar (9403661024)', 'unread', '2025-03-19 09:44:47'),
(28, '🛒 New order placed by User ID: 12 (Order ID: 29)', 'read', '2025-03-19 09:45:32'),
(29, '🛒 New order placed by User ID: 12 (Order ID: 30)', 'unread', '2025-03-20 07:41:42'),
(30, '🛒 New order placed by User ID: 12 (Order ID: 31)', 'unread', '2025-03-21 11:03:48'),
(31, '🛒 New order placed by User ID: 12 (Order ID: 32)', 'unread', '2025-03-21 11:10:49'),
(32, '🛒 New order placed by User ID: 14 (Order ID: 33)', 'unread', '2025-04-03 10:49:53'),
(33, '🛒 New order placed by User ID: 14 (Order ID: 34)', 'unread', '2025-04-03 10:50:37'),
(34, '🛒 New order placed by User ID: 14 (Order ID: 35)', 'unread', '2025-04-03 10:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` enum('cod','paypal','stripe','razorpay') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `order_status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_general_ci NOT NULL,
  `payment_id` int DEFAULT NULL,
  `expense_amount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`order_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `full_name`, `email`, `phone`, `address`, `total_price`, `payment_method`, `payment_status`, `order_date`, `order_status`, `payment_id`, `expense_amount`) VALUES
(1, 1, 'Sakshi Bhosale', 'sakshi19@gmail.com', '7709767260', 'satara', 120.00, 'cod', 'paid', '2025-01-17 10:27:45', 'delivered', NULL, 0.00),
(2, 1, 'Sakshi Bhosale', 'sakshi19@gmail.com', '7709767260', 'satara', 130.00, 'stripe', 'paid', '2025-03-17 10:31:48', 'processing', NULL, 0.00),
(3, 1, 'Sakshi Bhosale', 'sakshi19@gmail.com', '7709767260', 'satara', 160.00, 'stripe', 'paid', '2025-01-17 10:38:07', 'processing', NULL, 0.00),
(4, 1, 'Sakshi Bhosale', 'sakshi19@gmail.com', '7709767260', 'satara', 130.00, 'stripe', 'paid', '2025-03-17 10:49:54', 'processing', NULL, 0.00),
(5, 3, 'Tanuja More', 'tanuja17@gmail.com', '9518590430', 'satara', 240.00, 'cod', 'pending', '2025-03-17 17:45:19', 'processing', NULL, 0.00),
(6, 3, 'Tanuja More', 'tanuja17@gmail.com', '9518590430', 'satara', 320.00, 'stripe', 'failed', '2025-01-11 17:46:04', 'pending', NULL, 0.00),
(7, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 250.00, 'cod', 'pending', '2025-03-18 11:47:23', 'pending', NULL, 0.00),
(8, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 120.00, 'cod', 'pending', '2025-03-18 11:49:32', 'processing', NULL, 0.00),
(9, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 100.00, 'cod', 'paid', '2025-01-14 11:53:36', 'delivered', NULL, 0.00),
(10, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 100.00, 'cod', 'pending', '2025-03-18 11:57:13', '', NULL, 0.00),
(11, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 350.00, 'cod', 'pending', '2025-01-18 11:58:02', 'pending', NULL, 0.00),
(12, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 100.00, 'stripe', 'failed', '2025-03-18 11:58:32', 'pending', NULL, 0.00),
(13, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 50.00, 'cod', 'pending', '2025-01-18 11:59:23', '', NULL, 0.00),
(14, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 100.00, 'stripe', 'paid', '2025-03-18 11:59:48', 'shipped', NULL, 0.00),
(15, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 100.00, 'stripe', 'failed', '2025-03-18 12:22:48', 'cancelled', NULL, 0.00),
(16, 7, 'bhumi kale', 'bhumi2@gmail.com', '9403661099', 'pune', 80.00, 'cod', 'pending', '2025-03-18 12:23:36', '', NULL, 0.00),
(17, 9, 'Ankita Bhosale', 'bhosaleankita449@gmail.com', '9373277468', 'nandval,Satara', 120.00, 'cod', 'pending', '2025-03-18 14:54:06', 'processing', NULL, 0.00),
(18, 10, 'Anuja more', 'anu27@gmail.com', '9373277468', 'pune', 900.00, 'cod', 'pending', '2025-03-18 17:16:48', 'processing', NULL, 0.00),
(19, 10, 'Anuja more', 'anu27@gmail.com', '9373277468', 'pune', 750.00, 'cod', 'pending', '2025-03-18 17:17:19', 'processing', NULL, 0.00),
(20, 10, 'Anuja more', 'anu27@gmail.com', '9373277468', 'pune', 220.00, 'cod', 'pending', '2025-03-18 17:17:56', 'processing', NULL, 0.00),
(21, 10, 'Anuja more', 'anu27@gmail.com', '9373277468', 'pune', 260.00, 'stripe', 'paid', '2025-03-18 17:18:29', 'processing', NULL, 0.00),
(22, 11, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 300.00, 'cod', 'pending', '2025-03-18 17:21:20', 'processing', NULL, 0.00),
(23, 11, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 260.00, 'cod', 'pending', '2025-03-18 18:06:31', 'processing', NULL, 0.00),
(24, 11, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 120.00, 'stripe', 'paid', '2025-03-18 18:07:00', 'processing', NULL, 0.00),
(25, 12, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 130.00, 'cod', 'pending', '2025-03-18 20:26:39', 'cancelled', NULL, 0.00),
(26, 13, 'madhvi bhosale', 'madhvi12@gmail.com', '7709676530', 'baramati', 130.00, 'cod', 'pending', '2025-03-18 20:31:21', 'processing', NULL, 0.00),
(27, 13, 'madhvi bhosale', 'madhvi12@gmail.com', '7709676530', 'baramati', 130.00, 'stripe', 'paid', '2025-03-18 20:32:20', 'processing', NULL, 0.00),
(28, 12, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 240.00, 'cod', 'pending', '2025-03-19 07:29:02', 'processing', NULL, 0.00),
(29, 12, 'Nikam Pranjali Jalindar', 'nikampranjali2@gmail.com', '9403661024', 'satara', 130.00, 'cod', 'pending', '2025-03-19 09:45:32', 'processing', NULL, 0.00),
(30, 12, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 120.00, 'cod', 'pending', '2025-03-20 07:41:42', 'pending', NULL, 0.00),
(31, 12, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 100.00, 'cod', 'pending', '2025-03-21 11:03:48', 'processing', NULL, 0.00),
(32, 12, 'pooja nikam', 'pooja29@gmail.com', '9403661024', 'satara', 240.00, 'stripe', 'paid', '2025-03-21 11:10:49', 'processing', NULL, 0.00),
(33, 14, 'pooja nikam', 'nikampranjali2@gmail.com', '9403661024', 'satara', 130.00, 'cod', 'pending', '2025-04-03 10:49:53', 'processing', NULL, 0.00),
(34, 14, 'pooja nikam', 'nikampranjali2@gmail.com', '9403661024', 'satara', 120.00, 'stripe', 'paid', '2025-04-03 10:50:37', 'processing', NULL, 0.00),
(35, 14, 'pooja nikam', 'aartinikam663@gmail.com', '9403661024', 'satara', 120.00, 'stripe', 'paid', '2025-04-03 10:53:08', 'processing', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 29, 1, 120.00),
(2, 2, 43, 1, 130.00),
(3, 3, 40, 1, 160.00),
(4, 4, 43, 1, 130.00),
(5, 5, 29, 2, 120.00),
(6, 6, 7, 4, 80.00),
(7, 7, 43, 1, 130.00),
(8, 7, 29, 1, 120.00),
(9, 8, 29, 1, 120.00),
(10, 9, 17, 1, 100.00),
(11, 10, 42, 1, 100.00),
(12, 11, 13, 1, 350.00),
(13, 12, 31, 1, 100.00),
(14, 13, 6, 1, 50.00),
(15, 14, 20, 1, 100.00),
(16, 15, 31, 1, 100.00),
(17, 16, 7, 1, 80.00),
(18, 17, 35, 1, 120.00),
(19, 18, 30, 3, 300.00),
(20, 19, 19, 5, 150.00),
(21, 20, 34, 2, 110.00),
(22, 21, 32, 2, 130.00),
(23, 22, 26, 2, 150.00),
(24, 23, 43, 2, 130.00),
(25, 24, 29, 1, 120.00),
(26, 25, 43, 1, 130.00),
(27, 26, 43, 1, 130.00),
(28, 27, 43, 1, 130.00),
(29, 28, 29, 2, 120.00),
(30, 29, 43, 1, 130.00),
(31, 30, 29, 1, 120.00),
(32, 31, 37, 1, 100.00),
(33, 32, 29, 2, 120.00),
(34, 33, 43, 1, 130.00),
(35, 34, 29, 1, 120.00),
(36, 35, 29, 1, 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `payment_method` enum('cod','paypal','stripe','razorpay') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'paid',
  `transaction_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `user_id`, `payment_method`, `payment_status`, `transaction_id`, `payment_amount`, `payment_date`) VALUES
(1, 4, 1, 'stripe', 'paid', NULL, 130.00, '2025-03-17 16:25:01'),
(2, 6, 3, 'stripe', 'paid', NULL, 320.00, '2025-03-17 23:16:48'),
(3, 12, 7, 'stripe', 'paid', NULL, 100.00, '2025-03-18 17:29:00'),
(4, 14, 7, 'stripe', 'paid', NULL, 100.00, '2025-03-18 17:30:13'),
(5, 15, 7, 'stripe', 'paid', NULL, 100.00, '2025-03-18 17:53:12'),
(6, 21, 10, 'stripe', 'paid', NULL, 260.00, '2025-03-18 22:49:02'),
(7, 24, 11, 'stripe', 'paid', NULL, 120.00, '2025-03-18 23:37:25'),
(8, 27, 13, 'stripe', 'paid', NULL, 130.00, '2025-03-19 02:03:48'),
(9, 32, 12, 'stripe', 'paid', NULL, 240.00, '2025-03-21 16:41:25'),
(10, 34, 14, 'stripe', 'paid', NULL, 120.00, '2025-04-03 16:21:24'),
(11, 35, 14, 'stripe', 'paid', NULL, 120.00, '2025-04-03 16:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_description` text COLLATE utf8mb4_general_ci,
  `category_id` int NOT NULL,
  `medicine_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dosage_info` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prescription_required` enum('Yes','No') COLLATE utf8mb4_general_ci NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `storage_instructions` text COLLATE utf8mb4_general_ci NOT NULL,
  `side_effects` text COLLATE utf8mb4_general_ci,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `stock_quantity` int NOT NULL,
  `product_image1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_keywords` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `category_id`, `medicine_type`, `dosage_info`, `prescription_required`, `manufacturer`, `storage_instructions`, `side_effects`, `discount_price`, `expiry_date`, `stock_quantity`, `product_image1`, `created_at`, `product_name`, `description`, `product_keywords`, `price`) VALUES
(6, 'Paracetamol 500mg', 'Used for pain relief and fever reduction', 1, 'Tablet', 'Take 1 tablet every 6 hours', 'No', 'ABC Pharmaceuticals', 'Store in a cool, dry place', 'Nausea, liver damage (if overdosed)', 40.00, '2027-12-31', 500, 'paracetamol.jpg', '2025-02-28 12:25:49', 'Paracetamol', 'Pain relief, fever', 'pain, fever, headache', 50.00),
(7, 'Ibuprofen 400mg', 'Used for pain relief, inflammation, and fever', 1, 'Tablet', 'Take 1 tablet every 8 hours with food', 'No', 'XYZ Pharma', 'Store below 30°C, away from moisture', 'Stomach upset, dizziness', 70.00, '2026-08-15', 400, 'Ibuprofen 400mg.webp', '2025-02-28 12:25:49', 'Ibuprofen', 'Pain relief, anti-inflammatory', 'pain, inflammation, fever', 80.00),
(8, 'Aspirin 325mg', 'Used for pain relief and blood thinning', 1, 'Tablet', 'Take 1 tablet every 6 hours', 'No', 'MediCorp Ltd.', 'Keep in a dry, dark place', 'Heartburn, nausea, risk of bleeding', 50.00, '2025-11-20', 300, 'aspirin.jpg', '2025-02-28 12:25:49', 'Aspirin', 'Pain relief, blood thinner', 'pain, heart, fever', 60.00),
(9, 'Diclofenac Sodium 50mg', 'Used for pain relief and inflammation', 1, 'Tablet', 'Take 1 tablet every 12 hours', 'Yes', 'HealWell Pharma', 'Store in a cool, dry place', 'Stomach pain, dizziness', 90.00, '2028-07-10', 200, 'Diclofenac Sodium 50mg.webp', '2025-02-28 12:25:49', 'Diclofenac', 'Pain relief, anti-inflammatory', 'pain, muscle, arthritis', 100.00),
(11, NULL, NULL, 14, 'Capsule', 'Take 1 capsule every 8 hours for 7 days', 'Yes', 'ABC Pharmaceuticals', 'Store in a cool, dry place', 'Nausea, diarrhea, allergic reactions', 200.00, '2027-12-31', 500, 'Amoxicillin 500mg.webp', '2025-02-28 12:34:29', 'Amoxicillin 500mg', 'Broad-spectrum antibiotic used to treat bacterial infections.', NULL, 250.00),
(12, NULL, NULL, 14, 'Tablet', 'Take 1 tablet daily for 3 days', 'Yes', 'XYZ Pharmaceuticals', 'Store at room temperature', 'Nausea, stomach upset, dizziness', 270.00, '2028-06-15', 300, 'Azithromycin 250mg.webp', '2025-02-28 12:34:29', 'Azithromycin 250mg', 'Used to treat respiratory and skin infections.', NULL, 300.00),
(13, NULL, NULL, 14, 'Tablet', 'Take 1 tablet every 12 hours for 7 days', 'Yes', 'MediCare Ltd.', 'Keep in a dry place, away from sunlight', 'Diarrhea, nausea, headache', 320.00, '2027-09-20', 400, 'Ciprofloxacin 500mg.webp', '2025-02-28 12:34:29', 'Ciprofloxacin 500mg', 'Effective against urinary tract and respiratory infections.', NULL, 350.00),
(17, NULL, NULL, 0, 'Tablet', 'Take 1 tablet every 6 hours as needed', 'No', 'HealthCare Pharma', 'Store in a cool, dry place', 'Nausea, liver damage (if overdosed)', 90.00, '2026-11-30', 600, 'Paracetamol 500mg.webp', '2025-02-28 12:40:45', 'Paracetamol 500mg', 'Common fever reducer and pain reliever.', NULL, 100.00),
(18, NULL, NULL, 0, 'Tablet', 'Take 1 tablet every 8 hours with food', 'No', 'MediRelief Ltd.', 'Keep in a dry place, away from sunlight', 'Stomach pain, dizziness, nausea', 110.00, '2027-05-25', 500, 'Ibuprofen 400mg.webp', '2025-02-28 12:40:45', 'Ibuprofen 400mg', 'Used for reducing fever and inflammation.', NULL, 120.00),
(19, NULL, NULL, 0, 'Tablet', 'Take 1 tablet every 4-6 hours with water', 'No', 'PharmaWell Inc.', 'Store at room temperature', 'Heartburn, nausea, risk of bleeding (high doses)', 130.00, '2028-03-10', 450, 'Aspirin 325mg.webp', '2025-02-28 12:40:45', 'Aspirin 325mg', 'Fever reducer and blood thinner.', NULL, 150.00),
(20, 'Omeprazole 20mg', 'Used for acid reflux and GERD.', 4, 'Capsule', 'Once daily before breakfast', 'No', 'ABC Pharma', 'Store in a cool, dry place', 'Headache, nausea', 80.00, '2027-05-01', 500, 'Omeprazole 20mg.webp', '2025-02-28 12:59:36', 'Omeprazole', 'Treats acid reflux', 'Acid Reflux, GERD, Stomach', 100.00),
(21, 'Pantoprazole 40mg', 'Reduces stomach acid and treats ulcers.', 4, 'Tablet', 'Once daily before meals', 'No', 'XYZ Meds', 'Store in a dry place', 'Dizziness, stomach pain', 90.00, '2026-08-01', 400, 'Pantoprazole 40mg.webp', '2025-02-28 12:59:36', 'Pantoprazole', 'For gastritis', 'Stomach, Ulcers, Acid', 120.00),
(22, 'Ranitidine 150mg', 'Used for heartburn and acid indigestion.', 4, 'Tablet', 'Twice daily before meals', 'No', 'MedLife Corp.', 'Keep in a dry place', 'Mild diarrhea, headache', 70.00, '2025-12-01', 300, 'Ranitidine 150mg.webp', '2025-02-28 12:59:36', 'Ranitidine', 'Reduces stomach acid', 'Acidity, Heartburn', 90.00),
(23, 'Cetirizine 10mg', 'Used for allergies and hay fever.', 5, 'Tablet', 'Once daily', 'No', 'ABC Pharma', 'Store in a cool, dry place', 'Drowsiness, dry mouth', 50.00, '2027-03-15', 600, 'Cetirizine 10mg.webp', '2025-02-28 13:06:13', 'Cetirizine', 'Treats allergies', 'Allergy, Hay Fever, Itching', 110.00),
(24, 'Loratadine 10mg', 'For runny nose and sneezing relief.', 5, 'Tablet', 'Once daily', 'No', 'XYZ Meds', 'Store in a dry place', 'Drowsiness, headache', 55.00, '2026-11-20', 450, 'Loratadine 10mg.webp', '2025-02-28 13:06:13', 'Loratadine', 'For sneezing relief', 'Cold, Allergy, Runny Nose', 130.00),
(25, 'Diphenhydramine 25mg', 'Used for sleep aid and allergic reactions.', 5, 'Capsule', 'One capsule at bedtime', 'No', 'MedLife Corp.', 'Keep in a dry place', 'Drowsiness, dizziness', 60.00, '2025-09-30', 350, 'Diphenhydramine 25mg.webp', '2025-02-28 13:06:13', 'Diphenhydramine', 'For sleep aid', 'Insomnia, Allergy, Sleep', 90.00),
(26, 'Dextromethorphan Syrup', 'Used for dry cough relief.', 6, 'Syrup', '10ml every 6 hours', 'No', 'ABC Pharma', 'Store at room temperature', 'Drowsiness, nausea', 40.00, '2027-07-15', 700, 'Dextromethorphan Syrup.webp', '2025-02-28 13:10:08', 'Dextromethorphan', 'Cough suppressant', 'Dry Cough, Cold, Throat', 150.00),
(27, 'Guaifenesin 200mg', 'Helps with mucus removal.', 6, 'Tablet', 'One tablet every 8 hours', 'No', 'XYZ Meds', 'Store in a dry place', 'Dizziness, nausea', 45.00, '2026-12-20', 550, 'Guaifenesin 200mg.webp', '2025-02-28 13:10:08', 'Guaifenesin', 'Mucus relief', 'Cold, Cough, Mucus', 140.00),
(28, 'Bromhexine Syrup', 'For chest congestion relief.', 6, 'Syrup', '10ml twice daily', 'No', 'MedLife Corp.', 'Keep in a dry place', 'Mild dizziness, nausea', 50.00, '2025-10-30', 400, 'Bromhexine.webp', '2025-02-28 13:10:08', 'Bromhexine', 'For chest congestion', 'Cough, Cold, Congestion', 130.00),
(29, 'Metformin 500mg', 'Used for blood sugar control in diabetes.', 7, 'Tablet', 'Twice daily with meals', 'No', 'ABC Pharma', 'Store in a cool, dry place', 'Nausea, diarrhea', 60.00, '2027-08-15', 600, 'Metformin.webp', '2025-02-28 13:16:54', 'Metformin', 'Blood sugar control', 'Diabetes, Sugar, Insulin', 120.00),
(30, 'Insulin Injection', 'For Type 1 diabetes treatment.', 7, 'Injection', 'As prescribed by doctor', 'Yes', 'XYZ Meds', 'Refrigerate at 2-8°C', 'Low blood sugar, weight gain', 150.00, '2026-06-10', 400, 'insulin.webp', '2025-02-28 13:16:54', 'Insulin', 'For diabetes control', 'Diabetes, Insulin, Sugar Control', 300.00),
(31, 'Glibenclamide 5mg', 'Used for Type 2 diabetes.', 7, 'Tablet', 'Once daily before breakfast', 'No', 'MedLife Corp.', 'Keep in a dry place', 'Low blood sugar, nausea', 50.00, '2025-09-30', 450, 'Glibenclamide.webp', '2025-02-28 13:16:54', 'Glibenclamide', 'For Type 2 diabetes', 'Diabetes, Sugar Control', 100.00),
(32, 'Fluconazole 150mg', 'Used for fungal infections.', 11, 'Tablet', 'Once daily for 7 days', 'No', 'ABC Pharma', 'Store in a cool, dry place', 'Nausea, headache', 55.00, '2027-06-10', 500, 'Fluconazole.webp', '2025-02-28 13:16:54', 'Fluconazole', 'For fungal infections', 'Fungal, Infection, Skin', 130.00),
(33, 'Acyclovir 400mg', 'Used for viral infections like herpes.', 11, 'Tablet', 'Twice daily', 'Yes', 'XYZ Meds', 'Keep in a dry place', 'Nausea, dizziness', 60.00, '2026-09-15', 400, 'Acyclovir.webp', '2025-02-28 13:16:54', 'Acyclovir', 'For viral infections', 'Virus, Infection, Herpes', 140.00),
(34, 'Terbinafine Cream', 'For skin fungus treatment.', 11, 'Cream', 'Apply twice daily', 'No', 'MedLife Corp.', 'Keep at room temperature', 'Mild irritation, redness', 45.00, '2025-11-30', 350, 'Terbinafine.webp', '2025-02-28 13:16:54', 'Terbinafine', 'For skin fungus', 'Skin, Fungus, Treatment', 110.00),
(35, 'Ciprofloxacin Eye Drops', 'For bacterial eye infections.', 13, 'Eye Drops', '1 drop every 4 hours', 'Yes', 'ABC Pharma', 'Store in a cool place', 'Mild irritation, redness', 50.00, '2027-08-25', 600, 'Ciprofloxacin.webp', '2025-02-28 13:16:54', 'Ciprofloxacin', 'For bacterial eye infections', 'Eye, Infection, Bacterial', 120.00),
(36, 'Ofloxacin Ear Drops', 'For ear infections.', 13, 'Ear Drops', 'Twice daily', 'Yes', 'XYZ Meds', 'Keep in a dry place', 'Dizziness, irritation', 55.00, '2026-07-10', 500, 'Ofloxacin.webp', '2025-02-28 13:16:54', 'Ofloxacin', 'For ear infections', 'Ear, Infection, Bacterial', 130.00),
(37, 'Artificial Tears', 'For dry eyes and irritation.', 13, 'Eye Drops', 'As needed', 'No', 'MedLife Corp.', 'Store at room temperature', 'Mild stinging', 40.00, '2025-12-30', 700, 'Artificial Tears.webp', '2025-02-28 13:16:54', 'Artificial Tears', 'For dry eyes', 'Eye, Dryness, Relief', 100.00),
(38, 'Thyroxine 50mcg', 'For hypothyroidism treatment.', 14, 'Tablet', 'Once daily before breakfast', 'Yes', 'ABC Pharma', 'Store in a cool, dry place', 'Palpitations, sweating', 60.00, '2027-05-20', 550, 'Thyroxine.webp', '2025-02-28 13:16:54', 'Thyroxine', 'For thyroid health', 'Thyroid, Hormones, Metabolism', 140.00),
(39, 'Estrogen Tablets', 'For hormonal therapy.', 14, 'Tablet', 'Once daily', 'Yes', 'XYZ Meds', 'Keep in a dry place', 'Headache, nausea', 70.00, '2026-10-15', 400, 'Estrogen.webp', '2025-02-28 13:16:54', 'Estrogen', 'For hormone balance', 'Hormones, Therapy, Balance', 150.00),
(40, 'Progesterone Capsules', 'For pregnancy support.', 14, 'Capsule', 'As prescribed by doctor', 'Yes', 'MedLife Corp.', 'Store at room temperature', 'Drowsiness, dizziness', 80.00, '2025-09-10', 350, 'Progesterone.webp', '2025-02-28 13:16:54', 'Progesterone', 'For pregnancy support', 'Pregnancy, Hormones, Support', 160.00),
(41, 'Loperamide 2mg', 'For diarrhea control.', 15, 'Tablet', 'Take after each loose stool', 'No', 'ABC Pharma', 'Store in a dry place', 'Constipation, bloating', 30.00, '2027-04-05', 600, 'Loperamide.webp', '2025-02-28 13:16:54', 'Loperamide', 'For diarrhea relief', 'Diarrhea, Digestion, Stomach', 90.00),
(42, 'Domperidone 10mg', 'For nausea and vomiting.', 15, 'Tablet', 'One tablet before meals', 'No', 'XYZ Meds', 'Keep in a dry place', 'Dizziness, dry mouth', 40.00, '2026-06-30', 500, 'Domperidone.webp', '2025-02-28 13:16:54', 'Domperidone', 'For nausea relief', 'Nausea, Vomiting, Stomach', 100.00),
(43, 'Ondansetron 4mg', 'For chemotherapy-induced nausea.', 15, 'Tablet', 'One tablet before chemotherapy', 'Yes', 'MedLife Corp.', 'Store in a cool place', 'Headache, fatigue', 50.00, '2025-08-20', 400, 'Ondansetron.webp', '2025-02-28 13:16:54', 'Ondansetron', 'For nausea control', 'Chemotherapy, Nausea, Relief', 130.00);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `units_sold` int NOT NULL,
  `revenue` decimal(10,2) NOT NULL,
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
CREATE TABLE IF NOT EXISTS `support_tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `issue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Resolved','Closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_notifications` tinyint(1) DEFAULT '1',
  `sms_notifications` tinyint(1) DEFAULT '1',
  `dark_mode` tinyint(1) DEFAULT '0',
  `two_factor_auth` tinyint(1) DEFAULT '0',
  `account_status` enum('active','inactive') COLLATE utf8mb4_general_ci DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `privacy_setting` enum('everyone','only_me','friends') COLLATE utf8mb4_general_ci DEFAULT 'everyone',
  `reset_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `city_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Unknown',
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `address`, `profile_photo`, `created_at`, `email_notifications`, `sms_notifications`, `dark_mode`, `two_factor_auth`, `account_status`, `last_login`, `privacy_setting`, `reset_token`, `reset_token_expiry`, `city_name`, `latitude`, `longitude`) VALUES
(1, 'Sakshi Bhosale', 'sakshi19@gmail.com', '$2y$10$RfaDV5LZxXiGSmG4wwvQouVJVC1woGYZkHv3aXQIaTuywJ8KgOjx2', '7709767260', 'satara', 'uploads/1742206950_sakshiiii.jpg', '2025-03-17 10:22:30', 1, 1, 0, 0, 'active', '2025-03-17 22:02:55', 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(2, 'Rutika Sonawane', 'rutika09@gmail.com', '$2y$10$RtVSCQp9lJ3Njs/5tcxXOuJv324cStWkqMiowCEZZq5OOugRR6Ztm', '8805297810', 'satara', 'uploads/1742288629_rurikaa.jpg', '2025-03-17 17:27:43', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(3, 'Tanuja More', 'tanuja17@gmail.com', '$2y$10$7Bk3wpCfABdqvVlGnA5ZQuOwuT/FEcuQhd6pQ3LxNxNR9rrYmdPoC', '9518590430', 'satara', 'uploads/1740053651_WhatsApp Image 2024-04-19 at 12.36.21_49472bea.jpg', '2025-03-17 17:44:45', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(4, 'Aaradhya Nikam', 'aaradhya17@gmail.com', '$2y$10$93WAoyZFSHJ0SesNp8SL/ecIG4n2ivM32VoukeY.Bsxi7Agw2mtUy', '9638262788', 'baramati', 'uploads/1740053851_WhatsApp Image 2024-04-19 at 12.22.31_2993f8e2.jpg', '2025-03-18 09:03:49', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(5, 'Sameer shinde', 'sam17@gmail.com', '$2y$10$vpYxNcyaFDrUvYZmoCFihuqhzQgcvlgPox.EfUJSiGwp0TBwK1dxu', '7883366782', 'pune', 'uploads/1742289683_360_F_681323692_f9ksxWaOnozhuhiWTEtqewl6LTmGemjG.jpg', '2025-03-18 09:21:23', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(6, 'anvi bhosale', 'anvi19@gmail.com', '$2y$10$VsiD64LVOpS3IteDV3XNT.et90EdI4w19nwv4zdEds6nX68BF8Kme', '9403661024', 'baramati', 'uploads/1742293019_download.jpg', '2025-03-18 10:16:59', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(7, 'bhumi kale', 'bhumi9@gmail.com', '$2y$10$nz.SnjegQLfK3LnQWr9Xs.gs04gJ0AXVr8kEOo5spi8.7SPcq9xUW', '9403961099', 'pune', 'uploads/1740207542_WhatsApp Image 2024-04-19 at 12.36.21_49472bea.jpg', '2025-03-18 10:53:46', 1, 1, 0, 0, 'active', '2025-03-18 19:50:16', 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(8, 'pranjali nikam', 'pranjali29@gmail.com', '$2y$10$Ei4IZ09RZHqKNShUZQ2/YeaCd48tnZQXUh6OXdtLCO7h8fdIUC8nG', '9403661024', 'Satara', 'uploads/1742070852_WhatsApp Image 2024-07-29 at 10.06.53_d815d07b.jpg', '2025-03-18 14:52:53', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(9, 'Ankita Bhosale', 'ankita29@gmail.com', '$2y$10$gY6FlksaQXfVglIQvVTPQOflVzJdZXAs1LLC3nCa.a8k1z8.S5/nm', '9373277468', 'nandval,Satara', 'uploads/1741601617_WhatsApp Image 2025-03-10 at 15.40.13_33cc3f38.jpg', '2025-03-18 14:53:37', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(10, 'Anuja more', 'anu27@gmail.com', '$2y$10$JSn1OqXgSbRuLZ6Hf9V53utsUgIrkDm0vRERi9Oo/tRDl61dGTsVO', '9373277468', 'pune', 'uploads/1742318169_1741625556_Anuja.jpg', '2025-03-18 17:16:09', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(11, 'pooja nikam', 'pooja29@gmail.com', '$2y$10$ve95vmIj732LwjQdpClS3u4hII.nAMq.mWZ6agZ9.QyM3FVhVFgoS', '9403661024', 'satara', 'uploads/1742318441_1742031228_fev1.jpg', '2025-03-18 17:20:41', 1, 1, 0, 0, 'active', '2025-03-18 23:32:43', 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(12, 'Nikam Pranjali Jalindar', 'pooja19@gmail.com', '$2y$10$443mCeXsj8B4hJMPFkKN9e.KSmmD9/jMDh7/B8vYXayulwQG4No1.', '09403661024', 'baramati', 'uploads/1742329237_1740253837_WhatsApp Image 2024-07-29 at 10.06.53_d815d07b.jpg', '2025-03-18 20:20:37', 1, 1, 0, 0, 'active', '2025-04-03 13:14:24', 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(13, 'madhvi', 'madhvi12@gmail.com', '$2y$10$y4CIquMjSNZc3eS3NnKBYOA4hwDCg1f8roUK4QVZBn7AOajXVy9Ku', '12345', 'baramati', 'uploads/1742329733_1742289683_360_F_681323692_f9ksxWaOnozhuhiWTEtqewl6LTmGemjG.jpg', '2025-03-18 20:28:53', 1, 1, 0, 0, 'active', '2025-03-19 01:59:24', 'everyone', NULL, NULL, 'Unknown', NULL, NULL),
(14, 'pooja nikam', 'nikampranjali288@gmail.com', '$2y$10$z49vFyIoNhBlEaMEMMdA3.GS0ERoo5LBXgbmQHow56N1lo2ZTTvsW', '9403661024', 'satara', 'uploads/1743677101_WhatsApp Image 2024-07-29 at 10.06.53_d815d07b.jpg', '2025-04-03 10:45:02', 1, 1, 0, 0, 'active', NULL, 'everyone', NULL, NULL, 'Unknown', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 40, '2025-02-26 11:16:48'),
(2, 2, 1, '2025-02-26 21:50:54'),
(3, 3, 2, '2025-02-27 18:41:49'),
(4, 5, 4, '2025-02-28 10:41:36'),
(5, 6, 29, '2025-03-01 06:30:36'),
(6, 6, 41, '2025-03-01 06:30:40'),
(7, 7, 43, '2025-03-01 13:28:26'),
(8, 7, 29, '2025-03-01 13:28:30'),
(9, 18, 43, '2025-03-16 17:15:34'),
(10, 18, 29, '2025-03-16 17:15:38'),
(11, 12, 43, '2025-03-18 20:25:47');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
