-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2020 at 06:25 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myloan`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_audit_trail`
--

CREATE TABLE `ci_audit_trail` (
  `id` int(11) NOT NULL,
  `sql_str` text CHARACTER SET utf8 DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `function` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `comment` text CHARACTER SET utf8 DEFAULT NULL,
  `ip_address` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `insert_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_details`
--

CREATE TABLE `loan_details` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `loan_status` enum('approve','disapprove','pending') NOT NULL,
  `total_amount_loan` double(10,2) NOT NULL,
  `total_paid_by_weeks` double(10,2) NOT NULL,
  `total_paid_forlast` double(10,2) NOT NULL,
  `total_paid` double(10,2) NOT NULL,
  `total_balance` double(10,2) NOT NULL,
  `total_weeks` int(11) NOT NULL,
  `current_no_weeks` int(11) NOT NULL,
  `currency` varchar(300) NOT NULL,
  `currency_desc` varchar(300) NOT NULL,
  `loan_terms` int(11) NOT NULL,
  `loan_terms_types` enum('years','months','weeks') NOT NULL,
  `start_date_loan` date NOT NULL,
  `end_date_loan` date NOT NULL,
  `applied_date` datetime NOT NULL,
  `applied_by` int(11) NOT NULL,
  `review_date` datetime NOT NULL,
  `review_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loan_payment_details`
--

CREATE TABLE `loan_payment_details` (
  `id` int(11) NOT NULL,
  `loanid` int(11) NOT NULL,
  `date_payment` datetime NOT NULL,
  `payment_amount` double(10,2) NOT NULL,
  `payment_week` int(11) NOT NULL,
  `payment_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myloan_sessions`
--

CREATE TABLE `myloan_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myloan_user`
--

CREATE TABLE `myloan_user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `usertype` enum('superadmin','user') NOT NULL,
  `password` varchar(300) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `myloan_user`
--

INSERT INTO `myloan_user` (`id`, `fullname`, `username`, `usertype`, `password`, `created_date`, `updated_date`, `updated_by`) VALUES
(1, 'Admin Myloan', 'admin', 'superadmin', '0192023a7bbd73250516f069df18b500', '2020-09-03 00:10:26', '0000-00-00 00:00:00', ''),
(2, 'Haiqal halim', 'thekapitan', 'user', '5445bd81bcc908c271b5c6f0368c7942', '2020-09-02 18:52:32', '0000-00-00 00:00:00', ''),
(3, 'tester user 1', 'tester1', 'user', '3bb18e2a9895656f7318fa9540313a82', '2020-09-04 18:23:37', '0000-00-00 00:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_audit_trail`
--
ALTER TABLE `ci_audit_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_details`
--
ALTER TABLE `loan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_payment_details`
--
ALTER TABLE `loan_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myloan_sessions`
--
ALTER TABLE `myloan_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `myloan_user`
--
ALTER TABLE `myloan_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_audit_trail`
--
ALTER TABLE `ci_audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_details`
--
ALTER TABLE `loan_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_payment_details`
--
ALTER TABLE `loan_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `myloan_user`
--
ALTER TABLE `myloan_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
