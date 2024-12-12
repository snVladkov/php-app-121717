-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 02:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laptops`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products_users`
--

CREATE TABLE `favorite_products_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL COMMENT 'Първичен ключ',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `image`, `price`) VALUES
(1, 'Dell XPS 13', 'https://ardes.bg/uploads/original/dell-xps-13-plus-9320-393691.jpg', '999.99'),
(2, 'Apple MacBook Air', 'https://cdncloudcart.com/25880/products/images/28368/apple-macbook-air-m1-8gb-ddr4x-256gb-ssd-13-3-wqxga-gold-image_61a8cf36e50dc_600x600.jpeg?1638782461', '1199.99'),
(3, 'HP Spectre x360', 'https://img-cdn.tnwcdn.com/image?fit=1200%2C900&height=900&url=https%3A%2F%2Fcdn0.tnwcdn.com%2Fwp-content%2Fblogs.dir%2F1%2Ffiles%2F2021%2F08%2FHP-Spectre-x360-14-1-of-7.jpg&signature=0d2f21c8c102f0b5f8f935cee9d98ef6', '1099.99'),
(4, 'Lenovo ThinkPad X1 Carbon', 'https://cdn.izotcomputers.com/8270-large_default/laptop-vtora-upotreba-lenovo-thinkpad-x1-carbon-gen-9.jpg', '1299.99'),
(5, 'Asus ZenBook 13', 'https://laptop.bg/system/images/300015/normal/asus_zenbook_13_oled_ux325eaoledwb503r.jpg', '899.99'),
(6, 'Microsoft Surface Laptop 4', 'https://gfx3.senetic.com/akeneo-catalog/7/1/b/9/71b955b8b0f63a78a44c1a6a845adbf09e281afc_1684023_LDH_00031_image1.jpg', '999.99'),
(7, 'Acer Swift 3', 'https://ardes.bg/uploads/p/acer-swift-3-sf314-43-432825.jpg', '699.99'),
(8, 'Razor Blade 15', 'https://ardes.bg/uploads/original/razer-blade-15-rz09-0421-428703.jpg', '1599.99');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `names`, `email`, `password`) VALUES
(6, 'Симеон', 'simeon@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$QndnNTB3b0RmdUhTV2VVZQ$QfKHIMfaObI+KUoAMDhyxVKnxTQ3QvMBD+YYvy3Niks'),
(7, 'Simeon2', 'simeon2@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$VmF4OGYzQjNWb0pOSU43bw$YUvVoKEoa5ibI9p0BG90ZYIWo38E26MewdZ3t8owjJM'),
(9, 'Simeon3', 'simeon3@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$bDd4OXhQYllwR085L204OA$2jJL+jR/qQAqinPW3qOtXTsOdalEteR/vY76u3IrRrc'),
(10, '<script>alert(\"HACKED!!\");</script>', 'simeon123@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$Mk9TZElRV1NQY2ZSVTROUg$Q6voVoJX4KkpwYl5zUjxbwK4UL4NLhJUOfqGWLoRT9s');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorite_products_users`
--
ALTER TABLE `favorite_products_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorite_products_users`
--
ALTER TABLE `favorite_products_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
