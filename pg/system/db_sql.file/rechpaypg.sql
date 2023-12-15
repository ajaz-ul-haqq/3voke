-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 18, 2021 at 04:29 PM
-- Server version: 10.3.27-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rechpay1_pg`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_partner`
--

CREATE TABLE `tb_partner` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `login_id` varchar(20) NOT NULL,
  `login_pwd` varchar(200) NOT NULL,
  `login_otp` varchar(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pan_no` varchar(10) NOT NULL,
  `uid_no` varchar(12) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `txn_status_webhook` varchar(255) NOT NULL,
  `slab` int(11) NOT NULL,
  `upi_id` varchar(50) NOT NULL,
  `settle_account` mediumtext NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `id` int(11) NOT NULL,
  `socket` varchar(10) NOT NULL,
  `base_url` varchar(200) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_account` mediumtext NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `company_about` mediumtext NOT NULL,
  `web_fav` varchar(255) NOT NULL,
  `web_tag` text NOT NULL,
  `web_rights` varchar(200) NOT NULL,
  `support` mediumtext NOT NULL,
  `slab_id` int(11) NOT NULL,
  `upi_prefix` varchar(50) NOT NULL,
  `upi_bank` varchar(100) NOT NULL,
  `hypto_token` varchar(200) NOT NULL,
  `authorization` varchar(255) NOT NULL,
  `smsapi` longtext NOT NULL,
  `app_link` text NOT NULL,
  `live_chat` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notification` longtext NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_slab`
--

CREATE TABLE `tb_slab` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `upi` varchar(50) NOT NULL,
  `van` varchar(50) NOT NULL,
  `imps` varchar(100) NOT NULL,
  `neft` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transactions`
--

CREATE TABLE `tb_transactions` (
  `id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `user_uid` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `client_orderid` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `pay_upi` varchar(100) NOT NULL,
  `upi_id` varchar(100) NOT NULL,
  `rrn` varchar(100) NOT NULL,
  `txn_amount` varchar(100) NOT NULL,
  `fees` varchar(100) NOT NULL,
  `settle_amount` varchar(100) NOT NULL,
  `closing_balance` varchar(100) NOT NULL,
  `txn_type` varchar(20) NOT NULL,
  `remark` text NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_upis`
--

CREATE TABLE `tb_upis` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `upi_uid` int(11) NOT NULL,
  `upi_id` varchar(100) NOT NULL,
  `upi_name` varchar(200) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_virtualtxn`
--

CREATE TABLE `tb_virtualtxn` (
  `id` int(11) NOT NULL,
  `credited_at` varchar(100) NOT NULL,
  `bene_account_no` varchar(200) NOT NULL,
  `bene_account_ifsc` varchar(200) NOT NULL,
  `rmtr_full_name` varchar(200) NOT NULL,
  `rmtr_account_no` varchar(200) NOT NULL,
  `rmtr_account_ifsc` varchar(50) NOT NULL,
  `rmtr_to_bene_note` varchar(255) NOT NULL,
  `txn_id` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `charges_gst` varchar(200) NOT NULL,
  `settled_amount` varchar(200) NOT NULL,
  `txn_time` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `bank_ref_num` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_partner`
--
ALTER TABLE `tb_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_settings`
--
ALTER TABLE `tb_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_slab`
--
ALTER TABLE `tb_slab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_upis`
--
ALTER TABLE `tb_upis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_virtualtxn`
--
ALTER TABLE `tb_virtualtxn`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_partner`
--
ALTER TABLE `tb_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_settings`
--
ALTER TABLE `tb_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_slab`
--
ALTER TABLE `tb_slab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_upis`
--
ALTER TABLE `tb_upis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_virtualtxn`
--
ALTER TABLE `tb_virtualtxn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
