-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2025 at 07:46 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Gitar', 'Alat musik petik', '2025-07-17 10:23:07'),
(2, 'Drum', 'Alat musik pukul', '2025-07-17 10:23:07'),
(3, 'Piano', 'Alat musik tuts', '2025-07-17 10:23:07'),
(4, 'Biola', 'Alat musik gesek', '2025-07-17 10:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `subject`, `message`, `created_at`) VALUES
(1, 4, 'Admin', 'mantap', '2025-07-17 20:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `shipping_address_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `payment_proof`, `total`, `shipping_address_id`) VALUES
(13, 4, '2025-07-19 14:43:57', 'completed', NULL, 51618800.00, 1),
(14, 4, '2025-07-19 15:02:34', 'completed', NULL, 51618800.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(14, 13, 15, 1, 51618800.00),
(15, 14, 15, 1, 51618800.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `payment_date` datetime NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `proof` varchar(255) NOT NULL,
  `status` enum('pending','confirmed','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `price` decimal(12,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `created_by`, `created_at`) VALUES
(1, 1, 'Yamaha F310', 'Yamaha F310 adalah gitar akustik steel-string yang sempurna untuk pemula hingga musisi menengah yang menginginkan instrumen berkualitas dengan harga terjangkau. Dibuat oleh Yamaha—brand terpercaya di dunia musik—gitar ini menawarkan suara jernih, konstruksi kokoh, dan kenyamanan bermain yang ideal untuk latihan, performa kecil, atau sekadar bermain di rumah.', 1250000.00, 8, 'image-removebg-preview (2).png', NULL, '2025-07-17 10:23:07'),
(2, 2, 'Pearl Roadshow', 'Pearl Roadshow adalah solusi sempurna bagi drummer pemula hingga menengah yang menginginkan drum kit lengkap dengan harga terjangkau, tanpa mengorbankan kualitas suara dan ketahanan. Seri Roadshow menawarkan konfigurasi modular yang mudah disesuaikan, shell berkayu tebal, dan hardware kokoh untuk performa optimal baik di rumah, studio, atau panggung kecil.', 7000000.00, 3, 'image-removebg-preview (1).png', NULL, '2025-07-17 10:23:07'),
(3, 3, 'Yamaha P-45', 'Yamaha P-45 adalah digital piano portabel yang dirancang untuk pemula hingga pianis menengah yang menginginkan pengalaman bermain layaknya piano akustik dalam bentuk yang praktis. Dengan 88 tuts berbobot (Graded Hammer Standard/GHS) dan suara sampling dari Yamaha CFIIIS Concert Grand Piano, P-45 menawarkan kenyamanan dan kualitas suara terbaik di kelasnya.', 6500000.00, 5, 'image-removebg-preview.png', NULL, '2025-07-17 10:23:07'),
(4, 3, 'Yamaha GB1K-PE', 'Hadirkan keindahan suara dan keanggunan piano klasik ke rumah atau studio Anda dengan Yamaha GB1K-PE, grand piano akustik berukuran ringkas yang menawarkan kualitas suara luar biasa dan presisi bermain tingkat tinggi. Dengan panjang 151 cm, piano ini cocok untuk ruangan dengan space terbatas namun tetap mempertahankan karakteristik khas grand piano Yamaha.', 150860000.00, 2, 'image-removebg-preview (3).png', 3, '2025-07-18 03:26:27'),
(5, 3, 'Yamaha PSR-EW425', 'Tingkatkan kreativitas bermusik Anda dengan Yamaha PSR-EW425, keyboard portabel 76 tuts yang menggabungkan fleksibilitas tuts lebih panjang, suara premium Yamaha, dan fitur canggih untuk performa maupun produksi musik. Cocok untuk pemula yang ingin berkembang hingga musisi tingkat menengah, keyboard ini dilengkapi style arranger otomatis, fungsi rekaman, dan konektivitas modern untuk pengalaman bermain yang lebih interaktif.', 7932200.00, 6, 'image-removebg-preview (4).png', 3, '2025-07-18 05:06:41'),
(6, 3, 'Yamaha PSR-E273', 'Yamaha PSR-E273 adalah keyboard elektronik yang sempurna untuk pemula, siswa musik, atau siapa saja yang ingin belajar piano dengan cara yang menyenangkan dan terjangkau. Dengan 61 tuts ukuran standar yang responsif, suara berkualitas tinggi, dan fitur pembelajaran interaktif, keyboard ini membantu mengasah keterampilan musik dengan mudah.', 2700000.00, 8, 'image-removebg-preview (5).png', 3, '2025-07-18 05:10:37'),
(7, 2, 'Yamaha Drum Digital DTX 6K3-X', 'Hadirkan pengalaman bermain drum yang tak tertandingi dengan Yamaha DTX6K3-X, electronic drum set premium dari Yamaha yang dirancang untuk drummer profesional maupun pemula yang menginginkan kualitas terbaik. Dilengkapi dengan DTX-PAD silicone head yang memberikan respon alami layaknya drum akustik, serta teknologi sensor terbaru untuk deteksi ketukan yang akurat.', 18138400.00, 4, 'image-removebg-preview (6).png', 3, '2025-07-18 05:14:00'),
(8, 1, 'Cort Action DLX AS OPN', 'Cort Action DLX AS OPN adalah electric bass guitar yang dirancang untuk musisi tingkat pemula hingga menengah yang menginginkan instrumen berkualitas tinggi dengan harga terjangkau. Dengan kombinasi konstruksi solid, pickup bertenaga, dan neck yang nyaman, bass ini cocok untuk berbagai genre musik seperti rock, funk, jazz, dan pop.', 4690000.00, 7, 'image-removebg-preview (7).png', 3, '2025-07-18 07:52:13'),
(9, 1, 'Cort AD 880CE BK', 'Cort AD 880CE BK adalah elektro-akustik gitar yang menggabungkan keindahan suara akustik alami dengan teknologi modern untuk performa panggung atau rekaman. Dengan body cutaway, sistem pickup Fishman Sonicore, dan desain mewah hitam glossy, gitar ini cocok untuk musisi akustik yang menginginkan fleksibilitas bermain baik plugged-in maupun unplugged.', 3290000.00, 4, 'image-removebg-preview (8).png', 3, '2025-07-18 07:55:49'),
(10, 1, 'Cort CLASSIC TC', 'Cort Classic TC adalah gitar klasik berkualitas tinggi yang menggabungkan desain vintage tradisional dengan konstruksi modern untuk suara yang hangat dan nyaman dimainkan. Dibuat dengan material pilihan dan detail presisi, gitar ini cocok untuk pemula hingga musisi klasik yang mencari instrumen dengan tonalitas seimbang dan estetika timeless.', 3950000.00, 6, 'image-removebg-preview (9).png', 3, '2025-07-18 09:07:32'),
(11, 2, 'Alesis Sample Pad Pro', 'Alesis Sample Pad Pro adalah drum pad elektronik canggih yang dirancang untuk drummer live, produksi musik, atau studio rekaman. Dengan 8 pad sensitif, kemampuan sampling langsung, dan 100+ suara built-in, alat ini memungkinkan Anda mengontrol sample, loop, atau efek dengan dinamika penuh. Cocok untuk pertunjukan panggung, latihan, atau produksi elektronik!', 4850000.00, 12, 'image-removebg-preview (10).png', 3, '2025-07-18 09:10:57'),
(12, 2, 'Roland TD-27KV2', 'Roland TD-27KV2 adalah electronic drum kit flagship yang menghadirkan pengalaman bermain realistis layaknya akustik, diperkuat oleh teknologi mutakhir Digital Snare (PD-140DS) dan Digital Ride (CY-18DR). Dirancang untuk drummer profesional dan studio, kit ini menawarkan responsivitas tak tertandingi, suara sampel high-end, dan konstruksi premium untuk performa panggung atau rekaman.', 55950000.00, 3, 'image-removebg-preview (11).png', 3, '2025-07-18 09:16:17'),
(13, 4, 'Biola Cavaliers CV4 SW', 'Biola Cavaliers CV4 SW adalah biola akustik berkualitas tinggi yang dirancang untuk pemain tingkat menengah hingga profesional. Dibuat dengan kayu solid (spruce top, maple back & sides) dan finishing glossy sunburst, instrumen ini menawarkan suara yang kaya, proyeksi optimal, serta kenyamanan bermain yang unggul. Ideal untuk pertunjukan live, latihan, atau rekaman studio.', 1500000.00, 9, 'image-removebg-preview (12).png', 3, '2025-07-18 09:21:06'),
(14, 4, 'Biola Cavaliers CV1A WG', 'Biola Cavaliers CV1A WG adalah biola akustik yang dirancang khusus untuk pemula, menawarkan kualitas suara yang baik dan kemudahan bermain dengan harga terjangkau. Dibuat dengan top spruce dan maple back & sides, serta finishing glossy white gloss (WG), instrumen ini cocok untuk siswa musik atau pemain pemula yang ingin belajar dengan alat yang nyaman dan andal.', 950000.00, 14, 'image-removebg-preview (13).png', 3, '2025-07-18 09:23:26'),
(15, 3, 'Yamaha CLP865GP', 'Yamaha CLP-865GP adalah digital grand piano flagship dari seri Clavinova yang menghadirkan pengalaman bermain layaknya grand piano akustik, dilengkapi dengan teknologi terbaru Yamaha dan desain mewah. Dengan keyboard GrandTouch™ dan suara sampling CFX & Bösendorfer Imperial, piano ini cocok untuk pianis profesional, sekolah musik, atau penggemar piano yang menginginkan performa tertinggi dalam bentuk digital.', 51618800.00, 3, 'image-removebg-preview (14).png', 3, '2025-07-18 09:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 4, 1, 4, 'Mantap', '2025-07-17 22:21:57'),
(2, 4, 1, 5, 'mantap', '2025-07-18 10:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `recipient_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `recipient_name`, `phone`, `address`, `city`, `postal_code`, `province`, `created_at`) VALUES
(1, 4, 'wenka', '081256544092', 'JL. Pontianak 2', 'Bontang', '12345', 'Kalimantan Timur', '2025-07-18 13:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'Admin', 'admin@mail.com', '$2y$10$UHv3A.IwRrPvSRF6ipZmAOyFrt9D9dpks30Ug73qaVlzkF5hPaDPq', 'admin', '2025-07-17 10:43:41'),
(4, 'Wenka Salinding', 'wenkasalinding04@gmail.com', '$2y$10$1ndhKlFaOu36qBCD1KZ1KenLjYUAzeiSC388TmAPCOFQUizlQrzWS', 'customer', '2025-07-17 11:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(7, 4, 15, '2025-07-19 14:36:04');

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
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_order` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
