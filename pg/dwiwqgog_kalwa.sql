-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2023 at 04:48 AM
-- Server version: 5.7.41
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dwiwqgog_kalwa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_gateway`
--

CREATE TABLE `tb_gateway` (
  `id` int(11) NOT NULL,
  `signup_fee` int(11) NOT NULL,
  `gateway_upiuid` varchar(255) NOT NULL,
  `gateway_secret` varchar(255) NOT NULL,
  `gateway_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gateway`
--

INSERT INTO `tb_gateway` (`id`, `signup_fee`, `gateway_upiuid`, `gateway_secret`, `gateway_key`) VALUES
(1, 1, 'paytmqr2810050501017lx70vimhxwu@paytm', 'UAeG8x0VT3', '829b95-a7f7e1-215cb1-525255-1ccbd5');

-- --------------------------------------------------------

--
-- Table structure for table `tb_partner`
--

CREATE TABLE `tb_partner` (
  `id` int(11) NOT NULL,
  `uid_token` varchar(50) NOT NULL,
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
  `device` longtext NOT NULL,
  `upis` longtext NOT NULL,
  `paytm_business` longtext NOT NULL,
  `paytm_active` int(11) NOT NULL DEFAULT '0',
  `settle_account` mediumtext NOT NULL,
  `upi_active` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `payid` varchar(255) DEFAULT NULL,
  `password_bckup` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_partner`
--

INSERT INTO `tb_partner` (`id`, `uid_token`, `type`, `login_id`, `login_pwd`, `login_otp`, `name`, `company_name`, `mobile`, `email`, `pan_no`, `uid_no`, `balance`, `token`, `secret`, `txn_status_webhook`, `slab`, `upi_id`, `device`, `upis`, `paytm_business`, `paytm_active`, `settle_account`, `upi_active`, `status`, `payid`, `password_bckup`) VALUES
(1, 'f1826e90ecb4236483fa8385923f508410e15e8d', 1, 'ADMIN', '$2y$10$pNho/32eNwxCy8yW.RYALexWM774DntRZvm216j9DE5stT8iY0xGa', '9VEwugLn', 'Santosh Kumar', 'pbsmm.store', '6207214857', 'infoteam@pbsmm.store', 'ERTPR3423C', '340370566145', '1008.775', '3ce20f-062089-3a3b4b-577799-134eac', 'OohbD3CGZJ', 'https://pbsmm.store/callback_fun', 4, '', 'VERSION.RELEASE : 10\nVERSION.INCREMENTAL : V12.0.4.0.QFKINXM\nVERSION.SDK.NUMBER : 29\nBOARD : raphaelin\nBOOTLOADER : unknown\nBRAND : Xiaomi\nCPU_ABI : arm64v8a\nCPU_ABI2 : \nDISPLAY : QKQ1.190825.002 testkeys\nFINGERPRINT : Xiaomi/raphaelin/raphaelin:10/QKQ1.190825.002/V12.0.4.0.QFKINXM:user/releasekeys\nHARDWARE : qcom\nHOST : c5miuiotabd00.bj\nID : QKQ1.190825.002\nMANUFACTURER : Xiaomi\nMODEL : Redmi K20 Pro\nPRODUCT : raphaelin\nSERIAL : unknown\nTAGS : releasekeys\nTIME : 1608501582000\nTYPE : user\nUNKNOWN : unknown\nUSER : builder', '{\"upi_id\":\"SahidMolla.eazypay@icici\",\"upi_name\":\"SM MULTI SERVICE TECHNOLOGY\",\"ifsc\":\"FINO0000001\"}', '{\"upi_data\":{\"pa\":\"paytmqr1jw2ihob26@paytm\",\"pn\":\"Paytm\"},\"upi_id\":\"paytmqr1jw2ihob26@paytm\",\"upi_name\":\"pbsmm\",\"mid\":\"qrSnNc24220567888966\"}', 1, '{\"account_no\":\"20127598439\",\"beneficiary_name\":\"Sahid Molla \",\"ifsc\":\"FINO0000001\"}', 1, 'active', NULL, NULL),
(260, '', 0, 'ERTPR4365C', '$2y$10$4DhF3fiMDFzNfu.vMZasp.i/QdYWg0zNSiosR0dU9cu5OlUW0ETEK', '2frfKRFs', 'Akash Kumar', 'Print', '1111111111', 'gamernkrb@gmail.com', 'ERTPR4365C', '111111111111', '900', '7aa54a-317290-dc3b08-db6333-c3c2a8', 'NHmG9WPcog', '', 4, '', '', '', '{\"upi_data\":{\"pa\":\"paytmqr1jw2ihob26@paytm\",\"pn\":\"Paytm\"},\"upi_id\":\"paytmqr1jw2ihob26@paytm\",\"upi_name\":\"Paytm\",\"mid\":\"qrSnNc24220567888966\"}', 1, '{\"account_no\":\"1111111111111111\",\"beneficiary_name\":\"dsewhg\",\"ifsc\":\"ipos0000001\"}', 1, 'active', '27551678344176', '33w1678344176');

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
  `app_logo` text NOT NULL,
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

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` (`id`, `socket`, `base_url`, `company_name`, `company_account`, `company_logo`, `app_logo`, `company_about`, `web_fav`, `web_tag`, `web_rights`, `support`, `slab_id`, `upi_prefix`, `upi_bank`, `hypto_token`, `authorization`, `smsapi`, `app_link`, `live_chat`, `notification`, `uid`, `status`) VALUES
(1, 'https://', 'demo.pbsmm.store', 'pbsmm UPI PAYMENT GATEWAY', '{\"account\":\"0000000000\",\"name\":\"pbsmm.store\",\"ifsc\":\"FINO0000001( UPI / IMPS / NEFT )\"}', 'https://pbsmm.store.in/images/all-logo.png', 'https://pbsmm.store.in/images/all-logo.png', ' ', 'https://pbsmm.store.in/images/favicon (1).ico', 'pbsmm.store.in', 'pbsmm.store.in', '{\"mobile\":\" \",\"mobile1\":\" \",\"email\":\" \"}', 4, 'multipe', 'RAJA.eazypay@icici', 'NA', 'NA', '{\"username\":\"https://partner.multipe.in/login.php?msgid=2\",\"password\":\"https://partner.multipe.in/login.php?msgid=2\",\"smsurl\":\"https://partner.multipe.in/login.php?msgid=2\"}', 'http://localhost/images/brand.png', '<script>\r\n (function () {\r\n var options = {\r\n whatsapp: \"916207214857\", // WhatsApp number\r\n call_to_action: \"WhtsApp Support\", // Call to action\r\n position: \"right\", // Position may be \'right\' or \'left\'\r\n };\r\n var proto = document.location.protocol, host = \"whatshelp.io\", url = proto + \"//static.\" + host;\r\n var s = document.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true; s.src = url + \'/widget-send-button/js/init.js\';\r\n s.onload = function () { WhWidgetSendButton.init(host, proto, options); };\r\n var x = document.getElementsByTagName(\'script\')[0]; x.parentNode.insertBefore(s, x);\r\n })();\r\n</script>', '<h2><span class=\"marker\"><strong>LifeTime Offer Plan Price: 999 Only</strong></span></h2>\r\n', 1, 1);

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

--
-- Dumping data for table `tb_slab`
--

INSERT INTO `tb_slab` (`id`, `name`, `upi`, `van`, `imps`, `neft`, `uid`, `status`) VALUES
(4, 'FREE UPI', '0.0', '0.00', '{\"slab1\":\"0.00\",\"slab2\":\"0.00\",\"slab3\":\"0.00\"}', '{\"slab1\":\"0.00\",\"slab2\":\"0.00\",\"slab3\":\"0.00\"}', 1, 1);

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

--
-- Dumping data for table `tb_transactions`
--

INSERT INTO `tb_transactions` (`id`, `token`, `user_uid`, `order_id`, `client_orderid`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `fees`, `settle_amount`, `closing_balance`, `txn_type`, `remark`, `status`) VALUES
(1, '', 1, 'o2kq85Aysy', '', '2023-02-02', '11:06:38 PM', 'Received - Admin', 'DCA', '20127598439', 'SMMULTISERVICE', '1675359398', '1000', '0', '1000', '1008.775', 'CREDIT', 'Admin', 'COMPLETED'),
(2, '', 260, 'mkCvqK3CD0', '', '2023-03-09', '12:25:58 PM', 'Transfer - Admin', 'DDA', '0000000000', 'ERTPR4365C', '1678344958', '100', '0', '100', '-100', 'DEBIT', 'Admin', 'COMPLETED'),
(3, '', 260, 'fsM9RPpUFx', '', '2023-03-09', '12:26:20 PM', 'Received - Admin', 'DCA', '0000000000', 'ERTPR4365C', '1678344980', '1000', '0', '1000', '900', 'CREDIT', 'Admin', 'COMPLETED');

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
  `bank_ref_num` varchar(50) NOT NULL,
  `results` longtext,
  `client_orderid` varchar(100) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `tb_settings`
--
ALTER TABLE `tb_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_slab`
--
ALTER TABLE `tb_slab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_upis`
--
ALTER TABLE `tb_upis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_virtualtxn`
--
ALTER TABLE `tb_virtualtxn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
