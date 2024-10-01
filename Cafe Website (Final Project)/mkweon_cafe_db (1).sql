-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2024 at 03:55 PM
-- Server version: 8.0.37
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mkweon_cafe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE `cafes` (
  `cafe_id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `location_id` int DEFAULT NULL,
  `cafe_type_id` int DEFAULT NULL,
  `hours` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `price_id` int DEFAULT NULL,
  `yelp_rating` decimal(3,1) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `upside` varchar(1000) DEFAULT NULL,
  `downside` varchar(1000) DEFAULT NULL,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`cafe_id`, `name`, `location_id`, `cafe_type_id`, `hours`, `price_id`, `yelp_rating`, `rating`, `upside`, `downside`, `image_url`) VALUES
(1, 'Community Goods', 1, 4, '7:00 AM - 4:00 PM', 2, 4.3, NULL, NULL, NULL, 'https://s3-media0.fl.yelpcdn.com/bphoto/p84KDbfS0eqFuAZBSmv0Dw/348s.jpg'),
(2, 'Harucake', 2, 4, '12:00 PM - 6:00 PM', 2, 4.1, 3.0, 'Unique drinks and super cute cakes', 'Long lines and pricey', 'https://res.cloudinary.com/the-infatuation/image/upload/c_fill,w_1200,ar_4:3,g_center,f_auto/Harucake'),
(3, 'Verve Coffee Roasters', 3, 2, '7:00 AM - 6:00 PM', 1, 4.0, 4.2, 'Such a pretty cafe with lots of seats and good food', 'There are no outlets', 'https://sprudge.com/wp-content/uploads/2023/05/Verve-1-1536x1024.jpg'),
(4, 'DAMO', 2, 4, '8:00 AM - 7:00 PM', 2, 4.6, NULL, NULL, NULL, 'https://s3-media0.fl.yelpcdn.com/bphoto/HdeX_2A3oTR7fSf4ubzjig/348s.jpg'),
(5, 'Maru Coffee', 3, 2, '7:30 AM - 5:00 PM', 2, 4.4, NULL, NULL, NULL, 'https://images.squarespace-cdn.com/content/v1/57011ac64d088e778102bd66/1569546753938-Z8RG986AIBWBTVPXHK9D/coffee-shop-open-plan.jpg'),
(6, 'Pantry by Madhappy', 6, 2, '8:00 AM - 4:00 PM', 2, 4.1, NULL, NULL, NULL, 'https://www.madhappy.com/cdn/shop/files/seandavidson_madhappy_la_21_copy.jpg?v=1703198811&width=2400'),
(7, 'Steroscope', 4, 2, '6:00 AM - 7:00 PM', 1, 4.6, NULL, NULL, NULL, 'https://scontent-lax3-1.xx.fbcdn.net/v/t39.30808-6/242714854_2343231355806740_4679270380401691191_n.jpg?stp=dst-jpg_s1080x2048&_nc_cat=104&ccb=1-7&_nc_sid=5f2048&_nc_ohc=WgZOxcGqrzoQ7kNvgGDimT8&_nc_ht=scontent-lax3-1.xx&oh=00_AfDwIjQjSPTMNV1VD1PoN8hSM-ALZs2wBNS3zpT1pUuI-Q&oe=663CFB33'),
(8, 'Spot Coffee & More', 2, 3, '12:00 PM - 2:00 AM', 2, 4.0, NULL, NULL, NULL, 'https://static.wixstatic.com/media/a875c0_fb5e00c4200f467586242268c42d2fd0~mv2.jpg/v1/fill/w_560,h_374,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/%EA%B0%80%EB%A1%9C%202.jpg'),
(9, 'La La Kind Cafe', 5, 2, '7:00 AM - 9:00 PM', 1, 3.8, NULL, NULL, NULL, 'https://img.cdn4dd.com/cdn-cgi/image/fit=cover,width=600,height=400,format=auto,quality=80/https://doordash-static.s3.amazonaws.com/media/store/header/7512a4e7-2db8-46c0-b8ab-3a94a579a7fb.jpg'),
(10, 'Canyon Coffee', 4, 2, '7:00 AM - 5:00 PM', 1, 4.2, NULL, NULL, NULL, 'https://canyoncoffee.co/cdn/shop/files/EchoPark7_1600x.jpg?v=1661353937');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_type`
--

CREATE TABLE `cafe_type` (
  `cafe_type_id` int NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cafe_type`
--

INSERT INTO `cafe_type` (`cafe_type_id`, `name`) VALUES
(1, 'Study'),
(2, 'Aesthetic'),
(3, 'Late Night'),
(4, 'Food & Drinks'),
(5, 'Social');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `name`) VALUES
(1, 'Beverly Grove'),
(2, 'Koreatown'),
(3, 'Downtown'),
(4, 'Echo Park'),
(5, 'Fairfax'),
(6, 'West Hollywood');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `price_id` int NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`price_id`, `name`) VALUES
(1, '$'),
(2, '$$'),
(3, '$$$');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cafes`
--
ALTER TABLE `cafes`
  ADD PRIMARY KEY (`cafe_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `cafe_type_id` (`cafe_type_id`),
  ADD KEY `price_id` (`price_id`);

--
-- Indexes for table `cafe_type`
--
ALTER TABLE `cafe_type`
  ADD PRIMARY KEY (`cafe_type_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`price_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `cafe_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cafe_type`
--
ALTER TABLE `cafe_type`
  MODIFY `cafe_type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `price_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cafes`
--
ALTER TABLE `cafes`
  ADD CONSTRAINT `cafes_ibfk_1` FOREIGN KEY (`cafe_type_id`) REFERENCES `cafe_type` (`cafe_type_id`),
  ADD CONSTRAINT `cafes_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`),
  ADD CONSTRAINT `cafes_ibfk_3` FOREIGN KEY (`price_id`) REFERENCES `price` (`price_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
