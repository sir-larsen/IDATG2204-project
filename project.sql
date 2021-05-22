-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22. Mai, 2021 22:37 PM
-- Tjener-versjon: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `employee`
--

CREATE TABLE `employee` (
  `nr` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `position` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `franchise`
--

CREATE TABLE `franchise` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `neg_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `grip_system`
--

CREATE TABLE `grip_system` (
  `grip_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `individual_store`
--

CREATE TABLE `individual_store` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `neg_price` float NOT NULL,
  `franchise` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `orders`
--

CREATE TABLE `orders` (
  `order_nr` int(11) NOT NULL,
  `ski_type` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `shipment_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_details`
--

CREATE TABLE `order_details` (
  `order_nr` int(11) NOT NULL,
  `model` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_history`
--

CREATE TABLE `order_history` (
  `history_id` int(11) NOT NULL,
  `order_nr` int(11) NOT NULL,
  `employee` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_state`
--

CREATE TABLE `order_state` (
  `id` int(11) NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `places_order`
--

CREATE TABLE `places_order` (
  `franchise_id` int(11) NOT NULL,
  `individual_store_id` int(11) NOT NULL,
  `team_skier_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `storekeeper_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_plan`
--

CREATE TABLE `production_plan` (
  `nr` int(11) NOT NULL,
  `num_skis_total` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `production_planner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipment`
--

CREATE TABLE `shipment` (
  `nr` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `pickup_date` date NOT NULL,
  `company_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `driver_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipment_state`
--

CREATE TABLE `shipment_state` (
  `id` int(11) NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipment_transporters`
--

CREATE TABLE `shipment_transporters` (
  `shipment_id` int(11) NOT NULL,
  `company_name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `size_class`
--

CREATE TABLE `size_class` (
  `id` int(11) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski`
--

CREATE TABLE `ski` (
  `product_no` int(11) NOT NULL,
  `url` varchar(400) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `msrpp` float DEFAULT NULL,
  `photo` varchar(400) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `historical` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `grip_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `temp_id` int(11) NOT NULL,
  `weight_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_model`
--

CREATE TABLE `ski_model` (
  `model_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_plan`
--

CREATE TABLE `ski_plan` (
  `plan_id` int(11) NOT NULL,
  `model` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_production_plan`
--

CREATE TABLE `ski_production_plan` (
  `plan_id` int(11) NOT NULL,
  `product_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_temperature`
--

CREATE TABLE `ski_temperature` (
  `temp_id` int(11) NOT NULL,
  `temperature` varchar(4) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_type`
--

CREATE TABLE `ski_type` (
  `type_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `team_skier`
--

CREATE TABLE `team_skier` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `dob` date NOT NULL,
  `club` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `num_skis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `transporters`
--

CREATE TABLE `transporters` (
  `company_name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `weight_class`
--

CREATE TABLE `weight_class` (
  `id` int(11) NOT NULL,
  `min_weight` int(11) NOT NULL,
  `max_weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`nr`);

--
-- Indexes for table `franchise`
--
ALTER TABLE `franchise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grip_system`
--
ALTER TABLE `grip_system`
  ADD PRIMARY KEY (`grip_id`);

--
-- Indexes for table `individual_store`
--
ALTER TABLE `individual_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_nr`),
  ADD KEY `orders_fk` (`parent_id`),
  ADD KEY `orders_fk2` (`shipment_id`),
  ADD KEY `orders_fk3` (`state_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_nr`,`model`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`order_nr`,`history_id`);

--
-- Indexes for table `order_state`
--
ALTER TABLE `order_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places_order`
--
ALTER TABLE `places_order`
  ADD PRIMARY KEY (`franchise_id`,`individual_store_id`,`team_skier_id`,`order_id`,`storekeeper_id`),
  ADD KEY `Places_order_fk2` (`individual_store_id`),
  ADD KEY `Places_order_fk3` (`team_skier_id`),
  ADD KEY `places_order_fk4` (`order_id`),
  ADD KEY `places_order_fk5` (`storekeeper_id`);

--
-- Indexes for table `production_plan`
--
ALTER TABLE `production_plan`
  ADD PRIMARY KEY (`nr`),
  ADD KEY `production_plan_fk` (`production_planner_id`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`nr`),
  ADD KEY `shipment_fk` (`state_id`);

--
-- Indexes for table `shipment_state`
--
ALTER TABLE `shipment_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_transporters`
--
ALTER TABLE `shipment_transporters`
  ADD PRIMARY KEY (`shipment_id`,`company_name`),
  ADD KEY `shipment_transporters_fk2` (`company_name`);

--
-- Indexes for table `size_class`
--
ALTER TABLE `size_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ski`
--
ALTER TABLE `ski`
  ADD PRIMARY KEY (`product_no`),
  ADD KEY `ski_fk` (`order_id`),
  ADD KEY `ski_fk2` (`model_id`),
  ADD KEY `ski_fk3` (`grip_id`),
  ADD KEY `ski_fk4` (`type_id`),
  ADD KEY `ski_fk5` (`temp_id`),
  ADD KEY `ski_fk6` (`weight_id`),
  ADD KEY `ski_fk7` (`size_id`);

--
-- Indexes for table `ski_model`
--
ALTER TABLE `ski_model`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `ski_plan`
--
ALTER TABLE `ski_plan`
  ADD PRIMARY KEY (`plan_id`,`model`);

--
-- Indexes for table `ski_production_plan`
--
ALTER TABLE `ski_production_plan`
  ADD PRIMARY KEY (`plan_id`,`product_no`),
  ADD KEY `ski_production_plan_fk2` (`product_no`);

--
-- Indexes for table `ski_temperature`
--
ALTER TABLE `ski_temperature`
  ADD PRIMARY KEY (`temp_id`);

--
-- Indexes for table `ski_type`
--
ALTER TABLE `ski_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `team_skier`
--
ALTER TABLE `team_skier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transporters`
--
ALTER TABLE `transporters`
  ADD PRIMARY KEY (`company_name`);

--
-- Indexes for table `weight_class`
--
ALTER TABLE `weight_class`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `franchise`
--
ALTER TABLE `franchise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grip_system`
--
ALTER TABLE `grip_system`
  MODIFY `grip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_store`
--
ALTER TABLE `individual_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_nr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_plan`
--
ALTER TABLE `production_plan`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment`
--
ALTER TABLE `shipment`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size_class`
--
ALTER TABLE `size_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ski`
--
ALTER TABLE `ski`
  MODIFY `product_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ski_model`
--
ALTER TABLE `ski_model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ski_temperature`
--
ALTER TABLE `ski_temperature`
  MODIFY `temp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ski_type`
--
ALTER TABLE `ski_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_skier`
--
ALTER TABLE `team_skier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weight_class`
--
ALTER TABLE `weight_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_fk` FOREIGN KEY (`parent_id`) REFERENCES `orders` (`order_nr`),
  ADD CONSTRAINT `orders_fk2` FOREIGN KEY (`shipment_id`) REFERENCES `shipment` (`nr`),
  ADD CONSTRAINT `orders_fk3` FOREIGN KEY (`state_id`) REFERENCES `order_state` (`id`);

--
-- Begrensninger for tabell `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_fk` FOREIGN KEY (`order_nr`) REFERENCES `orders` (`order_nr`);

--
-- Begrensninger for tabell `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_fk` FOREIGN KEY (`order_nr`) REFERENCES `orders` (`order_nr`);

--
-- Begrensninger for tabell `places_order`
--
ALTER TABLE `places_order`
  ADD CONSTRAINT `Places_order_fk` FOREIGN KEY (`franchise_id`) REFERENCES `franchise` (`id`),
  ADD CONSTRAINT `Places_order_fk2` FOREIGN KEY (`individual_store_id`) REFERENCES `individual_store` (`id`),
  ADD CONSTRAINT `Places_order_fk3` FOREIGN KEY (`team_skier_id`) REFERENCES `team_skier` (`id`),
  ADD CONSTRAINT `places_order_fk4` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_nr`),
  ADD CONSTRAINT `places_order_fk5` FOREIGN KEY (`storekeeper_id`) REFERENCES `employee` (`nr`);

--
-- Begrensninger for tabell `production_plan`
--
ALTER TABLE `production_plan`
  ADD CONSTRAINT `production_plan_fk` FOREIGN KEY (`production_planner_id`) REFERENCES `employee` (`nr`);

--
-- Begrensninger for tabell `shipment`
--
ALTER TABLE `shipment`
  ADD CONSTRAINT `shipment_fk` FOREIGN KEY (`state_id`) REFERENCES `shipment_state` (`id`);

--
-- Begrensninger for tabell `shipment_transporters`
--
ALTER TABLE `shipment_transporters`
  ADD CONSTRAINT `shipment_transporters_fk` FOREIGN KEY (`shipment_id`) REFERENCES `shipment` (`nr`),
  ADD CONSTRAINT `shipment_transporters_fk2` FOREIGN KEY (`company_name`) REFERENCES `transporters` (`company_name`);

--
-- Begrensninger for tabell `ski`
--
ALTER TABLE `ski`
  ADD CONSTRAINT `ski_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_nr`),
  ADD CONSTRAINT `ski_fk2` FOREIGN KEY (`model_id`) REFERENCES `ski_model` (`model_id`),
  ADD CONSTRAINT `ski_fk3` FOREIGN KEY (`grip_id`) REFERENCES `grip_system` (`grip_id`),
  ADD CONSTRAINT `ski_fk4` FOREIGN KEY (`type_id`) REFERENCES `ski_type` (`type_id`),
  ADD CONSTRAINT `ski_fk5` FOREIGN KEY (`temp_id`) REFERENCES `ski_temperature` (`temp_id`),
  ADD CONSTRAINT `ski_fk6` FOREIGN KEY (`weight_id`) REFERENCES `weight_class` (`id`),
  ADD CONSTRAINT `ski_fk7` FOREIGN KEY (`size_id`) REFERENCES `size_class` (`id`);

--
-- Begrensninger for tabell `ski_plan`
--
ALTER TABLE `ski_plan`
  ADD CONSTRAINT `ski_plan_fk` FOREIGN KEY (`plan_id`) REFERENCES `production_plan` (`nr`);

--
-- Begrensninger for tabell `ski_production_plan`
--
ALTER TABLE `ski_production_plan`
  ADD CONSTRAINT `ski_production_plan_fk` FOREIGN KEY (`plan_id`) REFERENCES `production_plan` (`nr`),
  ADD CONSTRAINT `ski_production_plan_fk2` FOREIGN KEY (`product_no`) REFERENCES `ski` (`product_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
