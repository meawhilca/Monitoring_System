-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 02:52 AM
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
-- Database: `expense_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Bills'),
(4, 'Education'),
(7, 'Entertainment'),
(1, 'Food'),
(5, 'Health'),
(8, 'Others'),
(6, 'Personal Care'),
(2, 'Transportation');

-- --------------------------------------------------------

--
-- Table structure for table `categories_budget`
--

CREATE TABLE `categories_budget` (
  `category_name` varchar(100) NOT NULL,
  `budget_limit` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_budget`
--

INSERT INTO `categories_budget` (`category_name`, `budget_limit`, `created_at`) VALUES
('Bills', 500.00, '2026-04-14 02:13:53'),
('Education', 200.00, '2026-04-16 00:51:28'),
('Entertainment', 300.00, '2026-04-14 02:13:53'),
('Food', 200.00, '2026-04-14 02:13:53'),
('Health', 0.00, '2026-04-14 02:13:53'),
('Others', 0.00, '2026-04-14 02:13:53'),
('Savings', 0.00, '2026-04-14 02:13:53'),
('School', 0.00, '2026-04-14 02:13:53'),
('Shopping', 0.00, '2026-04-14 02:13:53'),
('Transportation', 0.00, '2026-04-14 02:13:53'),
('Utilities', 0.00, '2026-04-14 02:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `amount`, `category`, `payment_method`, `date`, `description`) VALUES
(2, 50.00, 'foods', 'cash', '2026-04-14', 'ga snack ko'),
(3, 50.00, 'foods', 'cash', '2026-04-14', 'ga snack ko'),
(4, 55.00, 'foods', 'cash', '2026-04-14', 'for lunch'),
(7, 500.50, 'Bills', 'Cash', '2026-04-16', 'electricity'),
(8, NULL, 'Unknown', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_budget`
--

CREATE TABLE `monthly_budget` (
  `id` int(11) NOT NULL,
  `month` varchar(7) NOT NULL,
  `budget_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthly_budget`
--

INSERT INTO `monthly_budget` (`id`, `month`, `budget_amount`, `created_at`) VALUES
(1, '', 7000.00, '2026-04-21 02:31:46'),
(2, '2026-04', 7000.00, '2026-04-21 02:33:12'),
(6, '2026-05', 10000.00, '2026-05-12 00:25:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `categories_budget`
--
ALTER TABLE `categories_budget`
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_budget`
--
ALTER TABLE `monthly_budget`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `month` (`month`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `monthly_budget`
--
ALTER TABLE `monthly_budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
