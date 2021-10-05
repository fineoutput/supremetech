-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2021 at 03:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `create_outdoor`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_sidebar`
--

CREATE TABLE `tbl_admin_sidebar` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `url` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_sidebar`
--

INSERT INTO `tbl_admin_sidebar` (`id`, `name`, `url`) VALUES
(1, 'Dashboard', 'home'),
(5, 'Slider Management', 'slider/view_slider'),
(8, 'Banner Images', 'banners/view_banners'),
(9, 'Contact Us Management', 'contactus/view_contactus'),
(10, 'Coupon Code Management', 'coupon/view_coupon');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_sidebar2`
--

CREATE TABLE `tbl_admin_sidebar2` (
  `id` int(11) NOT NULL,
  `main_id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `url` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_sidebar2`
--

INSERT INTO `tbl_admin_sidebar2` (`id`, `main_id`, `name`, `url`) VALUES
(1, 2, 'View Team', 'system/view_team'),
(2, 2, 'Add Team', 'system/add_team');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banners`
--

CREATE TABLE `tbl_banners` (
  `id` int(11) NOT NULL,
  `banner_image` text NOT NULL,
  `redirection_link` varchar(300) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_banners`
--

INSERT INTO `tbl_banners` (`id`, `banner_image`, `redirection_link`, `ip`, `date`, `is_active`, `added_by`) VALUES
(4, 'assets/uploads/banner/team20210906030928.jpg', 'http://localhost/tailer_codeigniter', '', '2021-09-04 16:21:54', 1, 19),
(5, 'assets/uploads/banner/team20210906030945.png', 'http://localhost/supremetech/customci3.1/dcadmin/banners/add_banners', '', '2021-09-06 19:19:45', 1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contactus`
--

CREATE TABLE `tbl_contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` varchar(300) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `id` int(11) NOT NULL,
  `promocode` varchar(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `min_cart_amount` float(10,2) NOT NULL,
  `discount_percent` varchar(100) NOT NULL,
  `maximum_discount` float(10,2) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`id`, `promocode`, `start_date`, `end_date`, `min_cart_amount`, `discount_percent`, `maximum_discount`, `ip`, `date`, `is_active`, `added_by`) VALUES
(4, 'holi90', '2021-09-16', '2021-09-22', 100.00, '2%', 50.00, '', '2021-09-04 16:22:50', 1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `slider_image` text NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `title`, `slider_image`, `ip`, `date`, `is_active`, `added_by`) VALUES
(10, 'Testing', 'assets/uploads/slider/slider20210906030943.jpeg', '', '2021-09-06 19:18:21', 1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(2000) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address` varchar(2000) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `power` int(11) NOT NULL,
  `services` varchar(1000) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_team`
--

INSERT INTO `tbl_team` (`id`, `name`, `email`, `password`, `phone`, `address`, `image`, `power`, `services`, `ip`, `date`, `added_by`, `is_active`) VALUES
(1, 'Anay Pareek', 'anaypareek@rocketmail.com', '9ffd3dfaf18c6c0dededaba5d7db9375', '9799655891', '19 kalyanpuri new sanganer road sodala', '', 1, '[\"999\"]', '1000000', '16-05-2018', 1, 1),
(19, 'Demo', 'demo@gmail.com', 'f702c1502be8e55f4208d69419f50d0a', '9999999999', 'jaipur', NULL, 1, '[\"999\"]', '::1', '2020-01-04 18:12:55', 1, 1),
(29, 'Animesh Sharma', 'animesh.skyline@gmail.com', '8bda6fe26dad2b31f9cb9180ec3823e8', '8441849182', 'pratap nagar sitapura jaipur', '', 2, '[\"999\"]', '::1', '2020-01-06 14:47:11', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin_sidebar`
--
ALTER TABLE `tbl_admin_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_sidebar2`
--
ALTER TABLE `tbl_admin_sidebar2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banners`
--
ALTER TABLE `tbl_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contactus`
--
ALTER TABLE `tbl_contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_team`
--
ALTER TABLE `tbl_team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin_sidebar`
--
ALTER TABLE `tbl_admin_sidebar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_admin_sidebar2`
--
ALTER TABLE `tbl_admin_sidebar2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_banners`
--
ALTER TABLE `tbl_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_contactus`
--
ALTER TABLE `tbl_contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
