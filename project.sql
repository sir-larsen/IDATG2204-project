-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25. Mai, 2021 20:56 PM
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
-- Tabellstruktur for tabell `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `address` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `address`
--

INSERT INTO `address` (`id`, `address`) VALUES
(1, 'Brugata 5 4027 Stavanger'),
(2, 'Fisegata 3 4026 Stavanger'),
(3, 'Rumpeveien 12 2815 Gjøvik'),
(4, 'Markus Zakarias Prompevei 7 5000 Bærum');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `auth_token`
--

CREATE TABLE `auth_token` (
  `id` int(11) NOT NULL,
  `token` varchar(400) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `auth_token`
--

INSERT INTO `auth_token` (`id`, `token`) VALUES
(1, '7f38212946ddbd7aadba90192887c5538328bb77bf3756504a1e538226fa8f51'),
(2, '4b36a056eebfab7e4bbb26a278309812f55623b9675d4b4e9345f3fbf89e71d3'),
(3, '9d34402491a7e00f0ed216ed2f6ac63b2848ce41ad17a65bde2fffd47f7445c2'),
(4, '544c4686e64cdcdaba07ec71b4940122b0e9cc844d803d6cbc7282e139b08960'),
(5, 'd8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `customer_rep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `customer`
--

INSERT INTO `customer` (`id`, `start_date`, `end_date`, `customer_rep`) VALUES
(1, '2020-01-01', '2021-01-01', 1),
(2, '2020-02-02', '2021-02-02', 1),
(3, '2019-01-01', '2020-01-01', 1),
(4, '2017-01-01', '2021-01-01', 1),
(5, '2018-04-27', '2021-02-14', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `employee`
--

CREATE TABLE `employee` (
  `nr` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `employee`
--

INSERT INTO `employee` (`nr`, `name`, `position`) VALUES
(1, 'Maximiliano Zakarias', 1),
(2, 'Rånny enkelmann', 2),
(3, 'Kåre Catalan', 3);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `employee_position`
--

CREATE TABLE `employee_position` (
  `id` int(11) NOT NULL,
  `position` varchar(30) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `employee_position`
--

INSERT INTO `employee_position` (`id`, `position`) VALUES
(1, 'customer_rep'),
(2, 'storekeeper'),
(3, 'production_planner');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `franchise`
--

CREATE TABLE `franchise` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `neg_price` float NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `franchise`
--

INSERT INTO `franchise` (`id`, `name`, `neg_price`, `address_id`) VALUES
(1, 'XXL', 1200, 1),
(2, 'Sport1', 1150, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `grip_system`
--

CREATE TABLE `grip_system` (
  `grip_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `grip_system`
--

INSERT INTO `grip_system` (`grip_id`, `name`) VALUES
(1, 'wax'),
(2, 'IntelliGrip');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `individual_store`
--

CREATE TABLE `individual_store` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `neg_price` float NOT NULL,
  `id_franchise` int(11) DEFAULT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `individual_store`
--

INSERT INTO `individual_store` (`id`, `name`, `neg_price`, `id_franchise`, `address_id`) VALUES
(3, 'XXL Stavanger', 1200, 1, 3),
(4, 'Birkelands Sport', 1000, NULL, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `orders`
--

CREATE TABLE `orders` (
  `order_nr` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_rep` int(11) DEFAULT NULL,
  `date_placed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `orders`
--

INSERT INTO `orders` (`order_nr`, `state_id`, `parent_id`, `total_price`, `customer_id`, `customer_rep`, `date_placed`) VALUES
(1, 4, NULL, NULL, 2, 1, '2021-03-15'),
(2, 1, NULL, NULL, 1, 1, '2021-05-10'),
(3, 1, NULL, NULL, 3, 1, '2021-05-24'),
(4, 1, NULL, NULL, 4, 1, '2021-04-11'),
(5, 1, 2, NULL, 4, 1, '2021-04-28');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_details`
--

CREATE TABLE `order_details` (
  `order_nr` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `order_details`
--

INSERT INTO `order_details` (`order_nr`, `model`, `quantity`) VALUES
(1, 2, 400),
(2, 1, 423),
(3, 2, 325),
(4, 3, 200),
(5, 4, 445);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_history`
--

CREATE TABLE `order_history` (
  `order_nr` int(11) NOT NULL,
  `employee` int(80) NOT NULL,
  `old_state` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `order_history`
--

INSERT INTO `order_history` (`order_nr`, `employee`, `old_state`) VALUES
(1, 1, 1),
(1, 1, 2),
(1, 1, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_state`
--

CREATE TABLE `order_state` (
  `id` int(11) NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `order_state`
--

INSERT INTO `order_state` (`id`, `state`) VALUES
(1, 'new'),
(2, 'open'),
(3, 'skis avaliable'),
(4, 'ready to be shipped');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_plan`
--

CREATE TABLE `production_plan` (
  `nr` int(11) NOT NULL,
  `production_planner_id` int(11) NOT NULL,
  `period` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `production_plan`
--

INSERT INTO `production_plan` (`nr`, `production_planner_id`, `period`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipment`
--

CREATE TABLE `shipment` (
  `nr` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `company_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `driver_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `shipment`
--

INSERT INTO `shipment` (`nr`, `pickup_date`, `company_name`, `driver_id`, `state_id`, `address_id`) VALUES
(1, '2021-04-05', 'postnord', 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipment_state`
--

CREATE TABLE `shipment_state` (
  `id` int(11) NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `shipment_state`
--

INSERT INTO `shipment_state` (`id`, `state`) VALUES
(1, 'ready'),
(2, 'picked up');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `size_class`
--

CREATE TABLE `size_class` (
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `size_class`
--

INSERT INTO `size_class` (`size`) VALUES
(135),
(140),
(145),
(150),
(155),
(160),
(165),
(170),
(175),
(180),
(185),
(190),
(195),
(200);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski`
--

CREATE TABLE `ski` (
  `product_no` int(11) NOT NULL,
  `url` varchar(400) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `msrpp` float DEFAULT NULL,
  `historical` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `grip_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `weight_id` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `temp` varchar(20) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `ski`
--

INSERT INTO `ski` (`product_no`, `url`, `msrpp`, `historical`, `model_id`, `grip_id`, `type_id`, `weight_id`, `size`, `temp`) VALUES
(1, NULL, 1700, 0, 3, 1, 1, 1, 135, 'cold'),
(2, NULL, 1700, 0, 5, 1, 1, 2, 140, 'cold'),
(3, NULL, 1700, 0, 2, 2, 1, 3, 150, 'cold');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_model`
--

CREATE TABLE `ski_model` (
  `model_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `ski_model`
--

INSERT INTO `ski_model` (`model_id`, `name`) VALUES
(1, 'Active'),
(2, 'Active Pro'),
(3, 'Endurance'),
(4, 'Intrasonic'),
(5, 'Race Pro'),
(6, 'Race Speed'),
(7, 'Redline');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_production_plan`
--

CREATE TABLE `ski_production_plan` (
  `plan_id` int(11) NOT NULL,
  `product_no` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `ski_production_plan`
--

INSERT INTO `ski_production_plan` (`plan_id`, `product_no`, `quantity`) VALUES
(1, 1, 200),
(1, 2, 55),
(1, 3, 125),
(2, 1, 800),
(2, 2, 500),
(3, 1, 100);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_temperature`
--

CREATE TABLE `ski_temperature` (
  `temperature` varchar(4) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `ski_temperature`
--

INSERT INTO `ski_temperature` (`temperature`) VALUES
('cold'),
('warm');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_type`
--

CREATE TABLE `ski_type` (
  `type_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `ski_type`
--

INSERT INTO `ski_type` (`type_id`, `name`) VALUES
(1, 'skate'),
(2, 'classic'),
(3, 'double pole');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `team_skier`
--

CREATE TABLE `team_skier` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `dob` date NOT NULL,
  `club` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL,
  `num_skis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `team_skier`
--

INSERT INTO `team_skier` (`id`, `name`, `dob`, `club`, `num_skis`) VALUES
(5, 'Prompkus Zakarias Keegjord', '1996-02-02', 'catalan il', 200);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `transporters`
--

CREATE TABLE `transporters` (
  `company_name` varchar(80) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `transporters`
--

INSERT INTO `transporters` (`company_name`) VALUES
('bring'),
('postnord'),
('zakariasens tungtransport og rollerburger');

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
-- Dataark for tabell `weight_class`
--

INSERT INTO `weight_class` (`id`, `min_weight`, `max_weight`) VALUES
(1, 20, 30),
(2, 30, 40),
(3, 40, 50),
(4, 50, 60),
(5, 60, 70),
(6, 70, 80),
(7, 80, 90),
(8, 90, 200);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_token`
--
ALTER TABLE `auth_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_customer_fk` (`customer_rep`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`nr`),
  ADD KEY `employee_employee_fk6` (`position`);

--
-- Indexes for table `employee_position`
--
ALTER TABLE `employee_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `franchise`
--
ALTER TABLE `franchise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `franchise_franchise_fkfkf1` (`address_id`);

--
-- Indexes for table `grip_system`
--
ALTER TABLE `grip_system`
  ADD PRIMARY KEY (`grip_id`);

--
-- Indexes for table `individual_store`
--
ALTER TABLE `individual_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_store_fk1` (`id_franchise`),
  ADD KEY `individual_store_individual_fkfk` (`address_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_nr`),
  ADD KEY `orders_fk3` (`state_id`),
  ADD KEY `orders_orders_fk5` (`parent_id`),
  ADD KEY `orders_orders_fkfk` (`customer_id`),
  ADD KEY `orders_orders_fkfk2` (`customer_rep`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_nr`,`model`),
  ADD KEY `order_details_fk2` (`model`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`order_nr`,`employee`,`old_state`),
  ADD KEY `order_history_fk2` (`employee`),
  ADD KEY `order_history_fkfk3` (`old_state`);

--
-- Indexes for table `order_state`
--
ALTER TABLE `order_state`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `shipment_fk` (`state_id`),
  ADD KEY `shipment_fk_shipment` (`address_id`);

--
-- Indexes for table `shipment_state`
--
ALTER TABLE `shipment_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size_class`
--
ALTER TABLE `size_class`
  ADD PRIMARY KEY (`size`);

--
-- Indexes for table `ski`
--
ALTER TABLE `ski`
  ADD PRIMARY KEY (`product_no`),
  ADD KEY `ski_fk2` (`model_id`),
  ADD KEY `ski_fk3` (`grip_id`),
  ADD KEY `ski_fk4` (`type_id`),
  ADD KEY `ski_fk6` (`weight_id`),
  ADD KEY `ski_ski_ski_ski_fk` (`size`),
  ADD KEY `ski_fk5` (`temp`);

--
-- Indexes for table `ski_model`
--
ALTER TABLE `ski_model`
  ADD PRIMARY KEY (`model_id`);

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
  ADD PRIMARY KEY (`temperature`);

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
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_position`
--
ALTER TABLE `employee_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grip_system`
--
ALTER TABLE `grip_system`
  MODIFY `grip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `production_plan`
--
ALTER TABLE `production_plan`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shipment`
--
ALTER TABLE `shipment`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ski`
--
ALTER TABLE `ski`
  MODIFY `product_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ski_model`
--
ALTER TABLE `ski_model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ski_type`
--
ALTER TABLE `ski_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `weight_class`
--
ALTER TABLE `weight_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_customer_fk` FOREIGN KEY (`customer_rep`) REFERENCES `employee` (`nr`);

--
-- Begrensninger for tabell `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_employee_fk6` FOREIGN KEY (`position`) REFERENCES `employee_position` (`id`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `franchise`
--
ALTER TABLE `franchise`
  ADD CONSTRAINT `franchise_franchise_fk6` FOREIGN KEY (`id`) REFERENCES `customer` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `franchise_franchise_fkfkf1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Begrensninger for tabell `individual_store`
--
ALTER TABLE `individual_store`
  ADD CONSTRAINT `individual_store_fk1` FOREIGN KEY (`id_franchise`) REFERENCES `franchise` (`id`),
  ADD CONSTRAINT `individual_store_fkfk1` FOREIGN KEY (`id`) REFERENCES `customer` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `individual_store_individual_fkfk` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_fk3` FOREIGN KEY (`state_id`) REFERENCES `order_state` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_orders_fk5` FOREIGN KEY (`parent_id`) REFERENCES `orders` (`order_nr`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_orders_fkfk` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `orders_orders_fkfk2` FOREIGN KEY (`customer_rep`) REFERENCES `employee` (`nr`);

--
-- Begrensninger for tabell `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_fk1` FOREIGN KEY (`order_nr`) REFERENCES `orders` (`order_nr`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_fk2` FOREIGN KEY (`model`) REFERENCES `ski_model` (`model_id`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_fk` FOREIGN KEY (`order_nr`) REFERENCES `orders` (`order_nr`),
  ADD CONSTRAINT `order_history_fk2` FOREIGN KEY (`employee`) REFERENCES `employee` (`nr`),
  ADD CONSTRAINT `order_history_fkfk3` FOREIGN KEY (`old_state`) REFERENCES `order_state` (`id`);

--
-- Begrensninger for tabell `production_plan`
--
ALTER TABLE `production_plan`
  ADD CONSTRAINT `production_plan_fk` FOREIGN KEY (`production_planner_id`) REFERENCES `employee` (`nr`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `shipment`
--
ALTER TABLE `shipment`
  ADD CONSTRAINT `shipment_fk` FOREIGN KEY (`state_id`) REFERENCES `shipment_state` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `shipment_fk_shipment` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `ski`
--
ALTER TABLE `ski`
  ADD CONSTRAINT `ski_fk2` FOREIGN KEY (`model_id`) REFERENCES `ski_model` (`model_id`),
  ADD CONSTRAINT `ski_fk3` FOREIGN KEY (`grip_id`) REFERENCES `grip_system` (`grip_id`),
  ADD CONSTRAINT `ski_fk4` FOREIGN KEY (`type_id`) REFERENCES `ski_type` (`type_id`),
  ADD CONSTRAINT `ski_fk5` FOREIGN KEY (`temp`) REFERENCES `ski_temperature` (`temperature`),
  ADD CONSTRAINT `ski_fk6` FOREIGN KEY (`weight_id`) REFERENCES `weight_class` (`id`),
  ADD CONSTRAINT `ski_ski_ski_ski_fk` FOREIGN KEY (`size`) REFERENCES `size_class` (`size`);

--
-- Begrensninger for tabell `ski_production_plan`
--
ALTER TABLE `ski_production_plan`
  ADD CONSTRAINT `ski_production_plan_fk` FOREIGN KEY (`plan_id`) REFERENCES `production_plan` (`nr`),
  ADD CONSTRAINT `ski_production_plan_fk2` FOREIGN KEY (`product_no`) REFERENCES `ski` (`product_no`);

--
-- Begrensninger for tabell `team_skier`
--
ALTER TABLE `team_skier`
  ADD CONSTRAINT `team_skier_skier_fk` FOREIGN KEY (`id`) REFERENCES `customer` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
