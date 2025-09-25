-- Create a new database
CREATE DATABASE IF NOT EXISTS `admin_panel`;
USE `admin_panel`;
-- Drop existing tables to start fresh
DROP TABLE IF EXISTS `items`;
DROP TABLE IF EXISTS `carts`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `addresses`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `phone_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone_number`) VALUES
(1, 'John Doe', 'john.doe@example.com', 'hashed_password_1', 'admin', '555-1234'),
(2, 'Jane Smith', 'jane.smith@example.com', 'hashed_password_2', 'user', '555-5678'),
(3, 'Peter Jones', 'peter.jones@example.com', 'hashed_password_3', 'user', '555-9012'),
(4, 'R. Singh', 'r.singh@example.com', 'hashed_password_4', 'user', '555-1111'),
(5, 'A. Lopez', 'a.lopez@example.com', 'hashed_password_5', 'user', '555-2222'),
(6, 'J. Chen', 'j.chen@example.com', 'hashed_password_6', 'user', '555-3333'),
(7, 'M. Rossi', 'm.rossi@example.com', 'hashed_password_7', 'user', '555-4444');
--
-- Table structure for table `addresses`
--
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address_line` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `addresses`
--
INSERT INTO `addresses` (`id`, `user_id`, `address_line`, `city`, `state`, `postal_code`, `country`) VALUES
(1, 1, '123 Main St', 'Anytown', 'CA', '90210', 'USA'),
(2, 2, '456 Oak Ave', 'Sometown', 'NY', '10001', 'USA'),
(3, 1, '789 Pine Rd', 'Otherville', 'TX', '73301', 'USA');
--
-- Table structure for table `categories`
--
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `categories`
--
INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Men'),
(2, 'Women'),
(3, 'Kids'),
(4, 'Electronics');
--
-- Table structure for table `products`
--
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `products`
--
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `color`, `size`, `price`, `discount_price`) VALUES
(1, 1, 'T-Shirt', 'A comfortable cotton t-shirt.', 'black', 'M', 25.00, 20.00),
(2, 2, 'Jeans', 'Blue denim jeans.', 'blue', 'S', 50.00, 45.00),
(3, 1, 'Sneakers', 'Running shoes.', 'white', '10', 80.00, 70.00);
--
-- Table structure for table `carts`
--
CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `carts`
--
INSERT INTO `carts` (`id`, `user_id`) VALUES
(1, 4),
(2, 5);
--
-- Table structure for table `items`
--
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `items`
--
INSERT INTO `items` (`id`, `cart_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 3, 1),
(3, 2, 2, 1);
--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `orders`
--
INSERT INTO `orders` (`id`, `user_id`, `status`, `total`, `order_date`) VALUES
(1039, 7, 'Paid', 249.00, '2025-09-16'),
(1040, 6, 'Refunded', 59.00, '2025-09-17'),
(1041, 5, 'Pending', 89.50, '2025-09-18'),
(1042, 4, 'Paid', 129.00, '2025-09-18');
