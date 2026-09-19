-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2026 at 03:16 PM
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
-- Database: `web_trai_cay`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `batch_code` varchar(30) NOT NULL,
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `harvest_date` datetime DEFAULT NULL,
  `initial_weight` decimal(10,2) NOT NULL,
  `current_weight` decimal(10,2) NOT NULL,
  `status` varchar(30) DEFAULT 'Lưu kho'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `origin` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_code`, `name`, `phone`, `origin`) VALUES
(1, 'NCC01', 'Vùng Trồng Tiền Giang', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `max_storage_days` int(11) DEFAULT NULL,
  `storage_temp` decimal(4,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_code`, `name`, `description`, `max_storage_days`, `storage_temp`) VALUES
(1, 'LTC01', 'Trái cây tươi', NULL, NULL, NULL),
(2, 'LTC02', 'Trái cây Nhiệt Đới', 'Các loại trái cây tươi mát nhiệt đới', NULL, NULL),
(3, 'LTC03', 'Trái cây Giải Nhiệt', 'Trái cây mọng nước giải nhiệt mùa hè', NULL, NULL),
(4, 'LTC04', 'Trái cây Vùng Miền', 'Đặc sản trái cây các vùng miền', NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `don_hang`
-- (See below for the actual view)
--
CREATE TABLE `don_hang` (
`ma_don_hang` int(11)
,`id` int(11)
,`order_code` varchar(30)
,`ma_nguoi_dung` int(11)
,`user_id` int(11)
,`ho_ten` varchar(100)
,`ho_ten_khach` varchar(100)
,`customer_name` varchar(100)
,`so_dien_thoai` varchar(15)
,`sdt` varchar(15)
,`phone` varchar(15)
,`dia_chi_giao` varchar(255)
,`dia_chi_giao_hang` varchar(255)
,`dia_chi` varchar(255)
,`address` varchar(255)
,`subtotal` decimal(18,2)
,`voucher_id` int(11)
,`discount_amount` decimal(12,2)
,`tong_tien` decimal(18,2)
,`total_amount` decimal(18,2)
,`payment_method` varchar(30)
,`trang_thai` varchar(30)
,`status` varchar(30)
,`ngay_dat` datetime
,`created_at` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nguoi_dung`
-- (See below for the actual view)
--
CREATE TABLE `nguoi_dung` (
`ma_nguoi_dung` int(11)
,`id` int(11)
,`username` varchar(50)
,`password` varchar(100)
,`ho_va_ten` varchar(100)
,`ho_ten` varchar(100)
,`fullname` varchar(100)
,`email` varchar(100)
,`so_dien_thoai` varchar(15)
,`phone` varchar(15)
,`dia_chi` varchar(255)
,`address` varchar(255)
,`vai_tro` varchar(30)
,`role` varchar(30)
,`trang_thai` varchar(20)
,`status` varchar(20)
,`ngay_tao` datetime
,`created_at` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `discount_amount` decimal(12,2) DEFAULT 0.00,
  `final_amount` decimal(18,2) NOT NULL,
  `payment_method` varchar(30) DEFAULT 'COD',
  `order_status` varchar(30) DEFAULT 'Chờ xử lý',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `customer_name`, `customer_phone`, `shipping_address`, `subtotal`, `voucher_id`, `discount_amount`, `final_amount`, `payment_method`, `order_status`, `created_at`) VALUES
(2, 'ORD-20260917090021-760', 2, 'Đỗ Quang Huy', '12345', '123hcm', 65000.00, 1, 20000.00, 45000.00, 'COD', 'Chờ xử lý', '2026-09-17 14:00:21'),
(3, 'ORD-20260917091521-388', 2, 'Đỗ Quang Huy', '12323', 'ư12', 325000.00, 1, 20000.00, 305000.00, 'COD', 'Đang giao', '2026-09-17 14:15:21'),
(4, 'ORD-20260917151947-207', 3, 'Đỗ Quang Huy1', '12222', '1dsd', 390000.00, 1, 20000.00, 370000.00, 'COD', 'Đã giao', '2026-09-17 20:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `total_price`) VALUES
(1, 2, 1, 'Xoài Cát Hòa Lộc', 65000.00, 1, 65000.00),
(2, 3, 1, 'Xoài Cát Hòa Lộc', 65000.00, 5, 325000.00),
(3, 4, 1, 'Xoài Cát Hòa Lộc', 65000.00, 6, 390000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `sale_price` decimal(18,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `unit` varchar(20) DEFAULT 'Kg',
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Đang bán',
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `price`, `sale_price`, `stock_quantity`, `unit`, `image`, `description`, `status`, `expiry_date`) VALUES
(1, 1, NULL, 'Xoài Cát Hòa Lộc', 65000.00, NULL, 38, 'Kg', 'Xoài Cát Hòa Lộc.jpg', 'Xoài Cát Hòa Lộc thơm ngọt, đặc sản miền Tây', 'Đang bán', NULL),
(2, 1, NULL, 'Bưởi Da Xanh', 80000.00, NULL, 40, 'Kg', 'Bưởi Da Xanh.webp', 'Bưởi Da Xanh mọng nước, vị ngọt thanh', 'Đang bán', NULL),
(3, 2, NULL, 'Măng Cụt', 120000.00, NULL, 30, 'Kg', 'Măng Cụt.webp', 'Măng Cụt ngọt thanh, thơm ngon', 'Đang bán', NULL),
(4, 1, NULL, 'Chôm Chôm', 60000.00, NULL, 45, 'Kg', 'Chôm Chôm.jpg', 'Chôm Chôm tươi, mọng nước, vị ngọt', 'Đang bán', NULL),
(5, 2, NULL, 'Sầu Riêng Ri6', 180000.00, NULL, 25, 'Kg', 'Sầu Riêng Ri6.jpg', 'Sầu Riêng Ri6 cơm vàng, béo thơm', 'Đang bán', NULL),
(6, 1, NULL, 'Dừa Xiêm', 25000.00, NULL, 60, 'Trái', 'Dừa Xiêm.jpg', 'Dừa Xiêm nước ngọt, thanh mát', 'Đang bán', NULL),
(7, 2, NULL, 'Thanh Long Ruột Đỏ', 45000.00, NULL, 50, 'Kg', 'Thanh Long Ruột Đỏ.jpg', 'Thanh Long Ruột Đỏ ngọt, màu sắc đẹp', 'Đang bán', NULL),
(8, 4, NULL, 'Vú Sữa Lò Rèn', 90000.00, NULL, 35, 'Kg', 'Vú Sữa Lò Rèn.jpg', 'Vú Sữa Lò Rèn ngọt béo, đặc sản Tiền Giang', 'Đang bán', NULL),
(9, 1, NULL, 'Nhãn Xuồng Cơm Vàng', 75000.00, NULL, 40, 'Kg', 'Nhãn Xuồng Cơm Vàng.jpg', 'Nhãn xuồng cơm vàng ngọt thơm, thịt dày', 'Đang bán', NULL),
(12, 1, NULL, 'Ổi Lê', 35000.00, NULL, 50, 'Kg', 'Ổi Lê.jpg', 'Ổi lê giòn, vị ngọt thanh và tươi ngon', 'Đang bán', NULL),
(13, 2, NULL, 'Mít Thái', 55000.00, NULL, 45, 'Kg', 'Mít Thái.jpg', 'Mít Thái múi vàng, thơm và ngọt ', 'Đang bán', NULL),
(14, 2, NULL, 'Chanh Không Hạt', 40000.00, NULL, 35, 'Kg', 'Chanh Không Hạt.jpg', 'Chanh tươi mọng nước, vị chua tự nhiên', 'Đang bán', NULL),
(15, 3, NULL, 'Dưa Hấu Không Hạt', 30000.00, NULL, 60, 'Kg', 'Dưa Hấu Không Hạt.webp', 'Dưa hấu không hạt nhiều nước, vị ngọt mát', 'Đang bán', NULL),
(16, 3, NULL, 'Sapoche', 65000.00, NULL, 30, 'Kg', 'Sapoche.jpg', 'Sapoche chín tự nhiên, thịt mềm và ngọt', 'Đang bán', NULL),
(17, 4, NULL, 'Cóc Thái', 45000.00, NULL, 40, 'Kg', 'Cóc Thái.jpg', 'Cóc Thái giòn, vị chua ngọt hấp dẫn', 'Đang bán', NULL),
(18, 4, NULL, 'Me Thái', 70000.00, NULL, 30, 'Kg', 'Me Thái.jpg', 'Me Thái thịt dày, vị chua ngọt đặc trưng', 'Đang bán', NULL),
(19, 1, NULL, 'Nhãn Tiêu Da Bò', 70000.00, NULL, 40, 'Kg', 'Nhãn Tiêu Da Bò.jpg', 'Nhãn Tiêu Da Bò thơm ngọt, thịt dày và mọng nước', 'Đang bán', NULL),
(20, 2, NULL, 'Chôm Chôm Java', 55000.00, NULL, 40, 'Kg', 'Chôm Chôm Java.jpg', 'Chôm Chôm Java tươi, vị ngọt thanh và mọng nước', 'Đang bán', NULL),
(21, 3, NULL, 'Dâu Tây', 150000.00, NULL, 25, 'Kg', 'Dâu Tây.jpg', 'Dâu Tây tươi ngon, màu đỏ đẹp và vị chua ngọt', 'Đang bán', NULL),
(22, 4, NULL, 'Bòn Bon Thái', 85000.00, NULL, 35, 'Kg', 'Bòn Bon Thái.jpg', 'Bòn Bon Thái mọng nước, vị ngọt thanh và thơm', 'Đang bán', NULL),
(23, 1, NULL, 'Hồng Xiêm', 60000.00, NULL, 35, 'Kg', 'Hồng Xiêm.jpg', 'Hồng Xiêm chín tự nhiên, vị ngọt đậm và thơm', 'Đang bán', NULL),
(24, 1, NULL, 'Cam Sành', 45000.00, NULL, 40, 'Kg', 'Cam Sành.jpg', 'Cam Sành mọng nước, vị chua ngọt tự nhiên', 'Đang bán', NULL),
(25, 1, NULL, 'Quýt Hồng', 55000.00, NULL, 45, 'Kg', 'Quýt Hồng.jpg', 'Quýt Hồng thơm ngon, vỏ mỏng và nhiều nước', 'Đang bán', NULL),
(26, 4, NULL, 'Cam Cao Phong', 60000.00, NULL, 47, 'Kg', 'Cam Cao Phong.jpg', 'Cam Cao Phong mọng nước, vị ngọt và thơm tự nhiên', 'Đang bán', NULL),
(27, 4, NULL, 'Dưa Hấu Hoàng Kim', 45000.00, NULL, 40, 'Kg', 'Dưa Hấu Hoàng Kim.jpg', 'Dưa Hấu Hoàng Kim giòn ngọt, mọng nước và tươi mát', 'Đang bán', '2026-09-30'),
(28, 4, NULL, 'Mãng Cầu Bà Đen', 80000.00, NULL, 95, 'Kg', 'Mãng Cầu Bà Đen.jpg', 'Mãng Cầu Bà Đen thơm ngon, thịt mềm và vị chua ngọt', 'Đang bán', '2026-10-16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `san_pham`
-- (See below for the actual view)
--
CREATE TABLE `san_pham` (
`ma_san_pham` int(11)
,`id` int(11)
,`ten_san_pham` varchar(150)
,`gia` decimal(18,2)
,`so_luong` int(11)
,`han_su_dung` date
,`hinh_anh` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT 'Khách hàng',
  `status` varchar(20) DEFAULT 'Hoạt động',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `phone`, `address`, `role`, `status`, `created_at`) VALUES
(2, 'huy123@gmail.com', '$2y$10$qV9HiDUuqgCGx67hYiw1S.acD.njke6o2aRj3Q2BcYWb7IxiUXCIm', 'Đỗ Quang Huy', 'huy123@gmail.com', '12345678', '123hcm', 'admin', 'Hoạt động', '2026-09-17 13:59:27'),
(3, 'huy1@gmail.com', '$2y$10$8JBjuLVCUQuT4Tlb0q68..6Mdk8JMICnS3.a0F.OlYMFp/cC2OmMS', 'Đỗ Quang Huy1', 'huy1@gmail.com', '123', '1hcm', 'Khách hàng', 'Hoạt động', '2026-09-17 16:43:49'),
(4, 'huy12345@gmail.com', '$2y$10$1BQl06I9Kop9zI2v9IS2Guzr.7Sn/X/YnWUI65s4FhuH/AZjBG3GO', 'Đỗ Quang Huy2', 'huy12345@gmail.com', '1234', '', 'Khách hàng', 'Hoạt động', '2026-09-19 09:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` varchar(20) NOT NULL,
  `discount_value` decimal(12,2) NOT NULL,
  `min_order_amount` decimal(12,2) DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT 100,
  `used_count` int(11) DEFAULT 0,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(20) DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `usage_limit`, `used_count`, `start_date`, `end_date`, `status`) VALUES
(1, 'TRAICAY20K', 'fixed', 20000.00, 50000.00, 100, 3, '2024-01-01 00:00:00', '2030-12-31 23:59:59', 'Hoạt động'),
(2, 'GIAM10PCT', 'percent', 10.00, 100000.00, 100, 0, '2024-01-01 00:00:00', '2030-12-31 23:59:59', 'Hoạt động'),
(3, 'GIAM10P1', '', 10000.00, 1000000.00, 100, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Hoạt động');

-- --------------------------------------------------------

--
-- Structure for view `don_hang`
--
DROP TABLE IF EXISTS `don_hang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `don_hang`  AS SELECT `orders`.`id` AS `ma_don_hang`, `orders`.`id` AS `id`, `orders`.`order_code` AS `order_code`, `orders`.`user_id` AS `ma_nguoi_dung`, `orders`.`user_id` AS `user_id`, `orders`.`customer_name` AS `ho_ten`, `orders`.`customer_name` AS `ho_ten_khach`, `orders`.`customer_name` AS `customer_name`, `orders`.`customer_phone` AS `so_dien_thoai`, `orders`.`customer_phone` AS `sdt`, `orders`.`customer_phone` AS `phone`, `orders`.`shipping_address` AS `dia_chi_giao`, `orders`.`shipping_address` AS `dia_chi_giao_hang`, `orders`.`shipping_address` AS `dia_chi`, `orders`.`shipping_address` AS `address`, `orders`.`subtotal` AS `subtotal`, `orders`.`voucher_id` AS `voucher_id`, `orders`.`discount_amount` AS `discount_amount`, `orders`.`final_amount` AS `tong_tien`, `orders`.`final_amount` AS `total_amount`, `orders`.`payment_method` AS `payment_method`, `orders`.`order_status` AS `trang_thai`, `orders`.`order_status` AS `status`, `orders`.`created_at` AS `ngay_dat`, `orders`.`created_at` AS `created_at` FROM `orders` ;

-- --------------------------------------------------------

--
-- Structure for view `nguoi_dung`
--
DROP TABLE IF EXISTS `nguoi_dung`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nguoi_dung`  AS SELECT `users`.`id` AS `ma_nguoi_dung`, `users`.`id` AS `id`, `users`.`username` AS `username`, `users`.`password` AS `password`, `users`.`fullname` AS `ho_va_ten`, `users`.`fullname` AS `ho_ten`, `users`.`fullname` AS `fullname`, `users`.`email` AS `email`, `users`.`phone` AS `so_dien_thoai`, `users`.`phone` AS `phone`, `users`.`address` AS `dia_chi`, `users`.`address` AS `address`, `users`.`role` AS `vai_tro`, `users`.`role` AS `role`, `users`.`status` AS `trang_thai`, `users`.`status` AS `status`, `users`.`created_at` AS `ngay_tao`, `users`.`created_at` AS `created_at` FROM `users` ;

-- --------------------------------------------------------

--
-- Structure for view `san_pham`
--
DROP TABLE IF EXISTS `san_pham`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `san_pham`  AS SELECT `products`.`id` AS `ma_san_pham`, `products`.`id` AS `id`, `products`.`name` AS `ten_san_pham`, `products`.`price` AS `gia`, `products`.`stock_quantity` AS `so_luong`, `products`.`expiry_date` AS `han_su_dung`, `products`.`image` AS `hinh_anh` FROM `products` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batch_code` (`batch_code`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_code` (`brand_code`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_code` (`category_code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `batches_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
