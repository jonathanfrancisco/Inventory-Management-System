-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 03, 2018 at 05:49 PM
-- Server version: 5.7.22-0ubuntu18.04.1
-- PHP Version: 7.2.5-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`) VALUES
(24, 'Asus'),
(25, 'Lenovo'),
(26, 'Intel'),
(27, 'AMD'),
(28, 'Apple'),
(37, 'Western Digital'),
(38, 'Seagate'),
(39, 'JBL'),
(40, 'Acer'),
(41, 'Kingston'),
(42, 'Sandisk'),
(43, 'NZXT'),
(44, 'DeepCool'),
(45, 'Creative'),
(46, 'A4Tech'),
(47, 'Cooler Master'),
(48, 'Nvidia'),
(49, 'ATI'),
(50, 'LG'),
(51, 'Samsung'),
(52, 'BenQ'),
(53, 'G.Skill'),
(54, 'Tecware'),
(55, 'Dell'),
(56, 'HP'),
(57, 'SeaSonic'),
(58, 'Corsair'),
(59, 'Edifier'),
(60, 'Logitech'),
(61, 'SteelSeries'),
(62, 'ViewSonic'),
(63, 'Oppo');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(126, 'Laptops'),
(127, 'Processors'),
(128, 'Video Cards'),
(130, 'Motherboards'),
(131, 'Memory Modules'),
(132, 'Storage Devices'),
(133, 'Chassis'),
(134, 'Monitors'),
(135, 'Accessories'),
(136, 'Power Sources'),
(137, 'Gadgets Accessories'),
(138, 'Multimedia Products'),
(139, 'Cooling Systems'),
(140, 'Desktop Packages'),
(141, 'Printers'),
(142, 'Projector'),
(143, 'Networking Materials'),
(144, 'Uncategorized'),
(145, 'Furnitures');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `inventory_action` varchar(255) NOT NULL,
  `inventory_quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `inventory_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `inventory_action`, `inventory_quantity`, `product_id`, `inventory_date`) VALUES
(109, 'NEW PRODUCT STOCK-IN', 100, 32, '2018-05-10 06:26:44'),
(110, 'NEW PRODUCT STOCK-IN', 100, 33, '2018-05-10 06:27:18'),
(111, 'STOCK-OUT', 2, 33, '2018-05-10 06:29:29'),
(112, 'STOCK-OUT', 2, 32, '2018-05-10 06:29:29'),
(113, 'NEW PRODUCT STOCK-IN', 50, 34, '2018-05-10 10:04:38'),
(114, 'STOCK-IN', 50, 34, '2018-05-10 10:05:22'),
(115, 'STOCK-OUT', 5, 32, '2018-05-10 10:06:55'),
(116, 'NEW PRODUCT STOCK-IN', 100, 35, '2018-05-10 10:26:50'),
(117, 'STOCK-IN', 1, 32, '2018-05-10 10:27:52'),
(118, 'STOCK-OUT', 120, 34, '2018-05-10 10:29:33'),
(119, 'STOCK-OUT', 100, 33, '2018-05-10 10:35:53'),
(120, 'NEW PRODUCT STOCK-IN', 120, 36, '2018-05-10 10:41:44'),
(121, 'STOCK-OUT', 100, 36, '2018-06-02 19:16:19'),
(122, 'STOCK-OUT', 20, 36, '2018-06-02 19:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_date`, `customer_name`, `customer_contact`, `customer_address`, `total_amount`, `amount_paid`) VALUES
(1, '2018-05-10 06:29:29', 'Mr. Eerol', '12369', 'DWCL', 410000, 410000),
(2, '2018-05-10 10:06:54', 'Dugay', '69696969', 'dwcl', 600000, 600000),
(3, '2018-05-10 10:29:33', 'Charles', '123', 'wer', 120000, 120000),
(4, '2018-05-10 10:35:53', 'fasdf', 'fdsf', 'fsdf', 8500000, 100000000),
(5, '2018-06-02 19:17:04', 'Charles', '312312321', 'dwcl', 1730200, 10000000);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_product`
--

CREATE TABLE `invoice_product` (
  `invoice_product_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_product`
--

INSERT INTO `invoice_product` (`invoice_product_id`, `invoice_id`, `product_id`, `quantity`) VALUES
(1, 1, 33, 2),
(2, 1, 32, 2),
(3, 2, 32, 5),
(4, 3, 34, 120),
(5, 4, 33, 100),
(6, 4, 36, 100),
(7, 5, 36, 20);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_barcode` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_barcode`, `product_name`, `product_price`, `product_stock`, `category_id`, `brand_id`) VALUES
(32, '123123123', 'Macbook Pro 15 inch i7', 120000, 94, 126, 28),
(35, '3127471', 'Samsung S8', 49500, 100, 144, 51),
(36, '123123', 'Lenovo Thinkpad X1 Carbon', 86510, 0, 126, 25);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `middle_name`, `last_name`, `username`, `password`) VALUES
(1, 'Jonats', NULL, 'Franc', 'admin', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD PRIMARY KEY (`invoice_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_barcode` (`product_barcode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `invoice_product`
--
ALTER TABLE `invoice_product`
  MODIFY `invoice_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
