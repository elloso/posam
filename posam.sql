-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 05 juin 2024 à 15:04
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `posam`
--

-- --------------------------------------------------------

--
-- Structure de la table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `area`
--

INSERT INTO `area` (`area_id`, `area_name`, `active`) VALUES
(1, 'Lucena City', 1),
(5, 'Bondoc Peninsula', 1),
(8, 'Silangan', 1),
(9, 'Metro Manila', 1),
(12, 'South', 1),
(14, 'Quezon', 1),
(15, 'Laguna', 1),
(16, 'Cavite', 1),
(23, 'Pampanga', 1),
(24, 'Batangas City', 1),
(25, 'Lipa City', 1),
(26, 'WALK-IN', 1),
(27, 'Pick-up', 1);

-- --------------------------------------------------------

--
-- Structure de la table `asset`
--

DROP TABLE IF EXISTS `asset`;
CREATE TABLE IF NOT EXISTS `asset` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_type_fk` int(11) DEFAULT NULL,
  `availability_fk` int(11) DEFAULT NULL,
  `location_fk` int(11) DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `asset_code` varchar(100) DEFAULT NULL,
  `asset_name` varchar(150) NOT NULL,
  `asset_quantity` int(11) DEFAULT NULL,
  `asset_value` decimal(12,2) NOT NULL,
  `brand` varchar(150) DEFAULT NULL,
  `description` text,
  `expiration_date` date DEFAULT NULL,
  `remark` text,
  `serial_number` varchar(150) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`asset_id`),
  KEY `asset_name` (`asset_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `asset`
--

INSERT INTO `asset` (`asset_id`, `asset_type_fk`, `availability_fk`, `location_fk`, `acquisition_date`, `asset_code`, `asset_name`, `asset_quantity`, `asset_value`, `brand`, `description`, `expiration_date`, `remark`, `serial_number`, `updated_by`, `updated_date`) VALUES
(12, 1, 1, 3, '2023-11-30', 'A001', 'Computer Samsung', 1, '2000.00', 'Samsung', 'For encoding of orders', NULL, NULL, '726538903789', 2, '2024-03-01 21:30:44'),
(13, 6, 1, 4, '2020-11-06', 'A002', 'Packaging Machine', 1, '500000.00', NULL, NULL, NULL, NULL, '47262198783298749', 2, '2024-03-01 21:32:31');

-- --------------------------------------------------------

--
-- Structure de la table `asset_type`
--

DROP TABLE IF EXISTS `asset_type`;
CREATE TABLE IF NOT EXISTS `asset_type` (
  `asset_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_type_code` varchar(10) NOT NULL,
  `asset_type_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`asset_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `asset_type`
--

INSERT INTO `asset_type` (`asset_type_id`, `asset_type_code`, `asset_type_name`, `active`) VALUES
(1, 'AMF006', 'Samsung PC-1', 1),
(2, 'AFM001', 'Marshall Middleby', 1),
(3, 'AFM002', 'Packaging Solution', 1),
(4, 'AFM005', 'Mettler Toledo', 1),
(5, 'AFM004', 'OTEX Weighing Scale', 1),
(6, 'AFM003', 'Automatic Vertical Packaging Machine', 1),
(7, 'AFM007', 'Samsung PC-2', 1),
(8, 'AFM008', 'Samsung PC-3', 1),
(9, 'AFM009', 'Samsung PC-4', 1),
(10, 'AFM010', 'LG PC-1', 1),
(11, 'AFM011', 'EPSON L310', 1),
(12, 'AFM012', 'EPSON L310', 1),
(13, 'AFM013', 'EPSON L360', 1),
(14, 'AFM014', 'HP Laserdisk GT5820', 1);

-- --------------------------------------------------------

--
-- Structure de la table `availability`
--

DROP TABLE IF EXISTS `availability`;
CREATE TABLE IF NOT EXISTS `availability` (
  `availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `availability_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `availability`
--

INSERT INTO `availability` (`availability_id`, `availability_name`, `active`) VALUES
(1, 'Available', 1),
(2, 'In other building', 1),
(3, 'Non Available', 1),
(4, 'Out for repair', 1);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `category_remark` text,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_remark`, `active`) VALUES
(2, 'Fresh Noodles', NULL, 1),
(3, 'Vinegar  & Sauces', NULL, 1),
(10, 'Pastry', NULL, 1),
(11, 'Baked Noodles', NULL, 1),
(13, 'Fried Noodles', NULL, 1),
(14, 'Outsource', NULL, 1),
(15, 'Plastic Packaging', NULL, 1),
(16, 'Raw Materials', NULL, 1),
(17, 'Corrugated Box', NULL, 1),
(18, 'Packaging Label', NULL, 1),
(19, 'Glass Bottles', NULL, 1),
(20, 'PET Bottle', NULL, 1),
(21, 'Packaging  Tape', NULL, 1),
(22, 'Plastic Twine', NULL, 1),
(23, 'Packaging Materials', NULL, 1),
(24, 'Container Packaging', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_fk` int(11) DEFAULT NULL,
  `customer_type_fk` int(11) DEFAULT NULL,
  `municipality_fk` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1' COMMENT '1=Active 2=Inactive',
  `address` varchar(250) DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL,
  `customer_code` varchar(10) DEFAULT NULL,
  `customer_name` varchar(150) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `remark` text,
  `tin` varchar(50) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  KEY `customer_name` (`customer_name`)
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`customer_id`, `area_fk`, `customer_type_fk`, `municipality_fk`, `active`, `address`, `balance`, `customer_code`, `customer_name`, `email`, `phone`, `remark`, `tin`, `updated_by`, `updated_date`) VALUES
(373, 24, 12, 1, 1, NULL, '6100.00', 'CUS001', 'Megastore', 'customer1@gmail.com', '12345', NULL, 'TIN111', 2, '2024-03-01 17:41:11'),
(374, 24, 4, 5, 1, NULL, '500.00', 'CUS002', 'Restaurant association', 'customer2@gmail.com', '12345', NULL, 'TIn222', 2, '2024-03-01 17:42:37');

-- --------------------------------------------------------

--
-- Structure de la table `customer_type`
--

DROP TABLE IF EXISTS `customer_type`;
CREATE TABLE IF NOT EXISTS `customer_type` (
  `customer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type_code` varchar(10) NOT NULL,
  `customer_type_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `customer_type`
--

INSERT INTO `customer_type` (`customer_type_id`, `customer_type_code`, `customer_type_name`, `active`) VALUES
(1, 'WMKT', 'Wet Market', 1),
(3, 'SMKT', 'Supermarket', 1),
(4, 'XCON', 'Exporter/Consolidator', 1),
(5, 'RSDC', 'Restaurant/Diner/Cafe', 1),
(6, 'PCTR', 'Pasalubong Center', 1),
(7, 'FPSD', 'Fresh Produce Supplier/ Distributor', 1),
(8, 'GMM', 'Grocery / Minimart', 1),
(10, 'ISWI', 'In-Store / Walk-In', 1),
(11, 'SC001', 'Sales Coordinator', 1),
(12, 'DIST', 'Distributor / Dealer', 1);

-- --------------------------------------------------------

--
-- Structure de la table `delivery`
--

DROP TABLE IF EXISTS `delivery`;
CREATE TABLE IF NOT EXISTS `delivery` (
  `delivery_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_fk` int(11) DEFAULT NULL,
  `batch_no` varchar(50) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_no` varchar(50) NOT NULL,
  `disposition` text,
  `expiry_date` date DEFAULT NULL,
  `lot_no` varchar(50) NOT NULL,
  `production_date` date DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`delivery_id`),
  KEY `supplier_fk` (`supplier_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `supplier_fk`, `batch_no`, `delivery_date`, `delivery_no`, `disposition`, `expiry_date`, `lot_no`, `production_date`, `reference_no`, `remark`, `updated_by`, `updated_date`) VALUES
(5, 24, 'Batch231', '2024-03-02', 'D24-1', NULL, '2024-03-23', 'Lot41', '2023-10-06', 'R3546565', '', 2, '2024-03-01 22:49:27'),
(6, 25, '234', '2024-03-02', 'D24-2', NULL, '2024-08-16', '666', '2023-11-10', '454353452', '', 2, '2024-03-01 23:00:25');

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_fk` int(11) DEFAULT NULL,
  `customer_fk` int(11) DEFAULT NULL,
  `employee_fk` int(11) DEFAULT NULL,
  `supplier_fk` int(11) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL,
  `doc_size` int(10) DEFAULT '0',
  `doc_type` varchar(30) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`document_id`, `asset_fk`, `customer_fk`, `employee_fk`, `supplier_fk`, `doc_name`, `doc_size`, `doc_type`, `updated_date`, `updated_by`) VALUES
(27, NULL, 373, NULL, NULL, '01-pinssm.gif', 1211, 'image/gif', '2024-03-01 17:41:57', 2),
(28, NULL, NULL, 50, NULL, 'entrepreneur-2275739_1280.jpg', 122, 'image/jpeg', '2024-03-01 21:25:11', 2),
(29, 12, NULL, NULL, NULL, 'screenrec.png', 13, 'image/png', '2024-03-01 21:30:57', 2),
(30, NULL, NULL, NULL, 24, 'video.jpg', 57, 'image/jpeg', '2024-03-02 00:04:19', 2);

-- --------------------------------------------------------

--
-- Structure de la table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_fk` int(11) DEFAULT NULL,
  `employee_status_fk` int(11) DEFAULT NULL,
  `employee_type_fk` int(11) DEFAULT NULL,
  `municipality_fk` int(11) DEFAULT NULL,
  `position_fk` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1' COMMENT '1=Active 2=Inactive',
  `address` varchar(250) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `employee_code` varchar(10) DEFAULT NULL,
  `employment_date` date DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL COMMENT 'M=Male  F=Female  O=Other',
  `last_name` varchar(50) DEFAULT NULL,
  `pag_ibig` varchar(50) DEFAULT NULL,
  `phil_health` varchar(50) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `remark` text,
  `sss` varchar(50) DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `employee`
--

INSERT INTO `employee` (`employee_id`, `area_fk`, `employee_status_fk`, `employee_type_fk`, `municipality_fk`, `position_fk`, `active`, `address`, `birthday`, `email`, `employee_code`, `employment_date`, `first_name`, `gender`, `last_name`, `pag_ibig`, `phil_health`, `phone`, `remark`, `sss`, `tin`, `updated_by`, `updated_date`) VALUES
(50, 24, 2, 1, 6, 1, 1, NULL, '1998-01-01', 'forceslea@gmail.com', 'EMP001', '2022-02-02', 'Lea', 'F', 'Forces', '44444', '333333', '123456789', NULL, '1111111', '22222', 2, '2024-03-01 21:24:43'),
(51, 24, 1, 1, 6, 8, 1, NULL, '1999-02-19', 'mcconnorp@gmail.com', 'EMP002', '2023-04-06', 'Phillip', 'M', 'McConnor', '444', '333', '23456789999', NULL, '111', '222', 2, '2024-03-01 21:26:38');

-- --------------------------------------------------------

--
-- Structure de la table `employee_status`
--

DROP TABLE IF EXISTS `employee_status`;
CREATE TABLE IF NOT EXISTS `employee_status` (
  `employee_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_status_code` varchar(10) NOT NULL,
  `employee_status_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `employee_status`
--

INSERT INTO `employee_status` (`employee_status_id`, `employee_status_code`, `employee_status_name`, `active`) VALUES
(1, '1', 'Single', 1),
(2, '2', 'Married', 1),
(9, '3', 'Widow', 1),
(10, '4', 'Separated', 1);

-- --------------------------------------------------------

--
-- Structure de la table `employee_type`
--

DROP TABLE IF EXISTS `employee_type`;
CREATE TABLE IF NOT EXISTS `employee_type` (
  `employee_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_type_code` varchar(10) NOT NULL,
  `employee_type_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`employee_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `employee_type`
--

INSERT INTO `employee_type` (`employee_type_id`, `employee_type_code`, `employee_type_name`, `active`) VALUES
(1, 'REG', 'Regular', 1),
(4, 'CW', 'Contingent Worker', 1),
(8, 'SS', 'Seasonal', 1),
(9, 'OA', 'Outsource /Agency', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  `formula` int(11) DEFAULT NULL,
  `formula_unit` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`ingredient_id`, `ingredient_name`, `active`, `formula`, `formula_unit`) VALUES
(1, 'Hard and Soft Flour ( MED)', 1, 44, ''),
(2, 'Hard Flour (Mami)', 1, 44, ''),
(3, 'Special Flour (REG ) X 20', 1, 120, 'packs'),
(5, 'Hard Flour (PLuc Steamed)', 1, 32, 'Kgs'),
(6, 'Hard Flour (LRE PCanton )', 1, 28, 'kgs'),
(9, 'Special Flour ( X- Large ) X 20', 1, 78, 'packs'),
(10, 'Special Flour (Whole)  X 50', 1, 61, 'pcks'),
(11, 'Special Flour (Whole )  X 40', 1, 65, 'pcks'),
(12, 'Hard Flour ( Baked Noodles )', 1, 23, ' kgs'),
(15, 'Hard and Soft Flour (BIG)', 1, 44, ''),
(16, 'Hard and Soft Flour (SML)', 1, 44, '');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_fk` int(11) DEFAULT NULL,
  `supplier_fk` int(11) DEFAULT NULL,
  `unit_fk` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active 2=inactive',
  `brand` varchar(25) DEFAULT NULL,
  `description` text,
  `inventory` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=Inventory 2=No Inventory',
  `item_code` varchar(25) DEFAULT NULL,
  `item_name` varchar(150) NOT NULL,
  `item_price` decimal(12,2) NOT NULL,
  `ordering_point` decimal(12,2) DEFAULT NULL,
  `price_date` date DEFAULT NULL,
  `remark` text,
  `safety_stock` decimal(12,2) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`item_id`, `category_fk`, `supplier_fk`, `unit_fk`, `active`, `brand`, `description`, `inventory`, `item_code`, `item_name`, `item_price`, `ordering_point`, `price_date`, `remark`, `safety_stock`, `updated_by`, `updated_date`) VALUES
(118, 13, 24, 10, 1, NULL, NULL, 1, 'ITE001', 'Miki Noodle', '100.00', '10.00', '2024-03-02', NULL, '15.00', 2, '2024-03-01 17:43:31'),
(119, 3, 25, 25, 1, 'La Reina Elena', NULL, 1, 'VIN001', 'Vinegar', '50.00', '5.00', '2024-03-02', NULL, '10.00', 2, '2024-03-01 17:48:04'),
(120, 2, 24, 9, 1, 'La Reina Elena', NULL, 2, 'NOO001', 'Fresh Noodles', '50.00', '10.00', '2024-03-02', NULL, '20.00', 2, '2024-03-01 17:50:19'),
(121, 18, 24, 13, 1, NULL, NULL, 1, 'DM023', 'Packaging material', '10.00', '600.00', '2024-03-02', NULL, '800.00', 2, '2024-03-01 23:01:50');

-- --------------------------------------------------------

--
-- Structure de la table `item_ingredient`
--

DROP TABLE IF EXISTS `item_ingredient`;
CREATE TABLE IF NOT EXISTS `item_ingredient` (
  `item_ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_fk` int(11) NOT NULL,
  `ingredient_fk` int(11) NOT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_ingredient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_ingredient`
--

INSERT INTO `item_ingredient` (`item_ingredient_id`, `item_fk`, `ingredient_fk`, `remark`, `updated_date`) VALUES
(32, 118, 15, 'Only fresh', '2024-03-01 22:58:19'),
(33, 120, 6, NULL, '2024-03-01 23:04:42'),
(34, 120, 2, NULL, '2024-03-04 23:22:37');

-- --------------------------------------------------------

--
-- Structure de la table `item_location`
--

DROP TABLE IF EXISTS `item_location`;
CREATE TABLE IF NOT EXISTS `item_location` (
  `item_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_fk` int(11) NOT NULL,
  `location_fk` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_location_id`),
  KEY `Item` (`item_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_location`
--

INSERT INTO `item_location` (`item_location_id`, `item_fk`, `location_fk`, `quantity`, `remark`, `updated_date`) VALUES
(314, 119, 3, '-6.00', NULL, '2024-03-01 17:48:53'),
(315, 118, 4, '180.00', NULL, '2024-03-01 17:49:27'),
(316, 120, 8, '-105.00', NULL, '2024-03-01 17:50:32'),
(317, 121, 7, '4900.00', NULL, '2024-03-01 23:02:03'),
(318, 118, 10, '110.00', NULL, '2024-03-01 23:47:22'),
(319, 119, 7, '100.00', NULL, '2024-03-02 01:17:41');

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(10) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`location_id`, `location_code`, `location_name`, `active`) VALUES
(3, 'AOF', 'Administration Office', 1),
(4, 'PROD B', 'Production B - Baked Products Area', 1),
(5, 'PROD C', 'Production C - Pastry', 1),
(6, 'PROD A', 'Production A - Fresh Products Area', 1),
(7, 'SPO', 'Supply and Property Office', 1),
(8, 'DPA', 'Finish products  Dispatching Area', 1),
(9, 'PMR', 'Packaging Materials Area', 1),
(10, 'test', 'Warehouse', 1);

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(9) NOT NULL AUTO_INCREMENT,
  `asset_fk` int(11) DEFAULT NULL,
  `customer_fk` int(11) DEFAULT NULL,
  `delivery_fk` int(11) DEFAULT NULL,
  `item_fk` int(11) DEFAULT NULL,
  `order_fk` int(11) DEFAULT NULL,
  `requisition_fk` int(11) DEFAULT NULL,
  `employee_fk` int(11) DEFAULT NULL,
  `subject_fk` int(11) DEFAULT NULL,
  `supplier_fk` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `attributes` longtext NOT NULL,
  `module` varchar(100) NOT NULL,
  `remark` text,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53085 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `log`
--

INSERT INTO `log` (`log_id`, `asset_fk`, `customer_fk`, `delivery_fk`, `item_fk`, `order_fk`, `requisition_fk`, `employee_fk`, `subject_fk`, `supplier_fk`, `action`, `attributes`, `module`, `remark`, `updated_by`, `updated_date`) VALUES
(53052, NULL, 373, NULL, NULL, NULL, NULL, NULL, 373, NULL, 'Create', 'a:13:{s:6:\"active\";s:1:\"1\";s:7:\"balance\";s:3:\"100\";s:7:\"area_fk\";s:2:\"24\";s:16:\"customer_type_fk\";s:2:\"12\";s:15:\"municipality_fk\";s:1:\"1\";s:7:\"address\";N;s:13:\"customer_code\";s:6:\"CUS001\";s:5:\"phone\";s:5:\"12345\";s:5:\"email\";s:19:\"customer1@gmail.com\";s:13:\"customer_name\";s:10:\"Customer 1\";s:6:\"remark\";N;s:3:\"tin\";s:6:\"TIN111\";s:10:\"updated_by\";s:1:\"2\";}', 'Customer', 'Create Customer 373', 2, '2024-03-01 17:41:11'),
(53053, NULL, 374, NULL, NULL, NULL, NULL, NULL, 374, NULL, 'Create', 'a:13:{s:6:\"active\";s:1:\"1\";s:7:\"balance\";s:0:\"\";s:7:\"area_fk\";s:2:\"24\";s:16:\"customer_type_fk\";s:1:\"4\";s:15:\"municipality_fk\";s:1:\"5\";s:7:\"address\";N;s:13:\"customer_code\";s:6:\"CUS002\";s:5:\"phone\";s:5:\"12345\";s:5:\"email\";s:19:\"customer2@gmail.com\";s:13:\"customer_name\";s:10:\"Customer 2\";s:6:\"remark\";N;s:3:\"tin\";s:6:\"TIn222\";s:10:\"updated_by\";s:1:\"2\";}', 'Customer', 'Create Customer 374', 2, '2024-03-01 17:42:37'),
(53054, NULL, NULL, NULL, 118, NULL, NULL, NULL, 118, NULL, 'Create', 'a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";N;s:9:\"item_code\";s:6:\"ITE001\";s:5:\"brand\";N;s:14:\"ordering_point\";s:2:\"10\";s:12:\"safety_stock\";s:2:\"15\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:3:\"100\";s:7:\"unit_fk\";s:2:\"10\";s:9:\"item_name\";s:6:\"Item 1\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}', 'Item', 'Create Item 118', 2, '2024-03-01 17:43:31'),
(53055, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24, 24, 'Create', 'a:10:{s:13:\"supplier_name\";s:10:\"Supplier 1\";s:7:\"address\";s:11:\"2150 Street\";s:7:\"contact\";s:8:\"M. Untel\";s:5:\"phone\";s:11:\"44655338945\";s:5:\"email\";s:19:\"supplier1@gmail.com\";s:6:\"mobile\";s:9:\"787565656\";s:3:\"tin\";s:6:\"IN1111\";s:7:\"website\";s:13:\"supplier1.com\";s:6:\"remark\";s:9:\"Very good\";s:6:\"active\";s:1:\"1\";}', 'Supplier', 'Create Supplier 24', 2, '2024-03-01 17:44:27'),
(53056, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 25, 'Create', 'a:10:{s:13:\"supplier_name\";s:10:\"Supplier 2\";s:7:\"address\";s:28:\"5746 Street around the store\";s:7:\"contact\";s:6:\"M. Two\";s:5:\"phone\";s:8:\"45566666\";s:5:\"email\";s:18:\"supplier2@gmai.com\";s:6:\"mobile\";s:10:\"7788999999\";s:3:\"tin\";s:9:\"TIN222334\";s:7:\"website\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:6:\"active\";s:1:\"1\";}', 'Supplier', 'Create Supplier 25', 2, '2024-03-01 17:45:15'),
(53057, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 25, 'Update', 'a:2:{s:3:\"old\";a:11:{s:11:\"supplier_id\";s:2:\"25\";s:6:\"active\";s:1:\"1\";s:7:\"address\";s:28:\"5746 Street around the store\";s:7:\"contact\";s:6:\"M. Two\";s:5:\"email\";s:18:\"supplier2@gmai.com\";s:6:\"mobile\";s:10:\"7788999999\";s:5:\"phone\";s:8:\"45566666\";s:6:\"remark\";s:0:\"\";s:13:\"supplier_name\";s:10:\"Supplier 2\";s:3:\"tin\";s:9:\"TIN222334\";s:7:\"website\";s:0:\"\";}s:3:\"new\";a:10:{s:13:\"supplier_name\";s:17:\"The best supplier\";s:7:\"address\";s:28:\"5746 Street around the store\";s:7:\"contact\";s:6:\"M. Two\";s:5:\"phone\";s:8:\"45566666\";s:5:\"email\";s:18:\"supplier2@gmai.com\";s:6:\"mobile\";s:10:\"7788999999\";s:3:\"tin\";s:9:\"TIN222334\";s:7:\"website\";s:0:\"\";s:6:\"remark\";s:0:\"\";s:6:\"active\";s:1:\"1\";}}', 'Supplier', 'Update Supplier 25', 2, '2024-03-01 17:45:48'),
(53058, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24, 24, 'Update', 'a:2:{s:3:\"old\";a:11:{s:11:\"supplier_id\";s:2:\"24\";s:6:\"active\";s:1:\"1\";s:7:\"address\";s:11:\"2150 Street\";s:7:\"contact\";s:8:\"M. Untel\";s:5:\"email\";s:19:\"supplier1@gmail.com\";s:6:\"mobile\";s:9:\"787565656\";s:5:\"phone\";s:11:\"44655338945\";s:6:\"remark\";s:9:\"Very good\";s:13:\"supplier_name\";s:10:\"Supplier 1\";s:3:\"tin\";s:6:\"IN1111\";s:7:\"website\";s:13:\"supplier1.com\";}s:3:\"new\";a:10:{s:13:\"supplier_name\";s:20:\"My favorite supplier\";s:7:\"address\";s:11:\"2150 Street\";s:7:\"contact\";s:8:\"M. Untel\";s:5:\"phone\";s:11:\"44655338945\";s:5:\"email\";s:19:\"supplier1@gmail.com\";s:6:\"mobile\";s:9:\"787565656\";s:3:\"tin\";s:6:\"IN1111\";s:7:\"website\";s:13:\"supplier1.com\";s:6:\"remark\";s:9:\"Very good\";s:6:\"active\";s:1:\"1\";}}', 'Supplier', 'Update Supplier 24', 2, '2024-03-01 17:46:06'),
(53059, NULL, 373, NULL, NULL, NULL, NULL, NULL, 373, NULL, 'Update', 'a:2:{s:3:\"old\";a:18:{s:11:\"customer_id\";s:3:\"373\";s:7:\"area_fk\";s:2:\"24\";s:16:\"customer_type_fk\";s:2:\"12\";s:15:\"municipality_fk\";s:1:\"1\";s:6:\"active\";s:1:\"1\";s:7:\"address\";N;s:7:\"balance\";s:6:\"100.00\";s:13:\"customer_code\";s:6:\"CUS001\";s:13:\"customer_name\";s:10:\"Customer 1\";s:5:\"email\";s:19:\"customer1@gmail.com\";s:5:\"phone\";s:5:\"12345\";s:6:\"remark\";N;s:3:\"tin\";s:6:\"TIN111\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:41:11\";s:9:\"area_name\";s:13:\"Batangas City\";s:17:\"municipality_name\";s:6:\"Lucena\";s:18:\"customer_type_name\";s:20:\"Distributor / Dealer\";}s:3:\"new\";a:13:{s:6:\"active\";s:1:\"1\";s:7:\"balance\";s:6:\"100.00\";s:7:\"area_fk\";s:2:\"24\";s:16:\"customer_type_fk\";s:2:\"12\";s:15:\"municipality_fk\";s:1:\"1\";s:7:\"address\";N;s:13:\"customer_code\";s:6:\"CUS001\";s:5:\"phone\";s:5:\"12345\";s:5:\"email\";s:19:\"customer1@gmail.com\";s:13:\"customer_name\";s:9:\"Megastore\";s:6:\"remark\";N;s:3:\"tin\";s:6:\"TIN111\";s:10:\"updated_by\";s:1:\"2\";}}', 'Customer', 'Update Customer 373', 2, '2024-03-01 17:46:31'),
(53060, NULL, 374, NULL, NULL, NULL, NULL, NULL, 374, NULL, 'Update', 'a:2:{s:3:\"old\";a:18:{s:11:\"customer_id\";s:3:\"374\";s:7:\"area_fk\";s:2:\"24\";s:16:\"customer_type_fk\";s:1:\"4\";s:15:\"municipality_fk\";s:1:\"5\";s:6:\"active\";s:1:\"1\";s:7:\"address\";N;s:7:\"balance\";s:4:\"0.00\";s:13:\"customer_code\";s:6:\"CUS002\";s:13:\"customer_name\";s:10:\"Customer 2\";s:5:\"email\";s:19:\"customer2@gmail.com\";s:5:\"phone\";s:5:\"12345\";s:6:\"remark\";N;s:3:\"tin\";s:6:\"TIn222\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:42:37\";s:9:\"area_name\";s:13:\"Batangas City\";s:17:\"municipality_name\";s:5:\"South\";s:18:\"customer_type_name\";s:21:\"Exporter/Consolidator\";}s:3:\"new\";a:13:{s:6:\"active\";s:1:\"1\";s:7:\"balance\";s:4:\"0.00\";s:7:\"area_fk\";s:2:\"24\";s:16:\"customer_type_fk\";s:1:\"4\";s:15:\"municipality_fk\";s:1:\"5\";s:7:\"address\";N;s:13:\"customer_code\";s:6:\"CUS002\";s:5:\"phone\";s:5:\"12345\";s:5:\"email\";s:19:\"customer2@gmail.com\";s:13:\"customer_name\";s:22:\"Restaurant association\";s:6:\"remark\";N;s:3:\"tin\";s:6:\"TIn222\";s:10:\"updated_by\";s:1:\"2\";}}', 'Customer', 'Update Customer 374', 2, '2024-03-01 17:46:57'),
(53061, NULL, NULL, NULL, 118, NULL, NULL, NULL, 118, NULL, 'Update', 'a:2:{s:3:\"old\";a:20:{s:7:\"item_id\";s:3:\"118\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";N;s:7:\"unit_fk\";s:2:\"10\";s:6:\"active\";s:1:\"1\";s:5:\"brand\";N;s:11:\"description\";N;s:9:\"inventory\";s:1:\"1\";s:9:\"item_code\";s:6:\"ITE001\";s:9:\"item_name\";s:6:\"Item 1\";s:10:\"item_price\";s:6:\"100.00\";s:14:\"ordering_point\";s:5:\"10.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:6:\"remark\";N;s:12:\"safety_stock\";s:5:\"15.00\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:43:31\";s:9:\"unit_name\";s:3:\"BOX\";s:13:\"category_name\";s:13:\"Fresh Noodles\";s:8:\"quantity\";N;}s:3:\"new\";a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:9:\"item_code\";s:6:\"ITE001\";s:5:\"brand\";N;s:14:\"ordering_point\";s:5:\"10.00\";s:12:\"safety_stock\";s:5:\"15.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:6:\"100.00\";s:7:\"unit_fk\";s:2:\"10\";s:9:\"item_name\";s:11:\"Miki Noodle\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Item', 'Update Item 118', 2, '2024-03-01 17:47:19'),
(53062, NULL, NULL, NULL, 119, NULL, NULL, NULL, 119, NULL, 'Create', 'a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:1:\"3\";s:11:\"supplier_fk\";s:2:\"25\";s:9:\"item_code\";N;s:5:\"brand\";N;s:14:\"ordering_point\";s:1:\"5\";s:12:\"safety_stock\";s:2:\"10\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:2:\"50\";s:7:\"unit_fk\";s:2:\"25\";s:9:\"item_name\";s:7:\"Vinegar\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}', 'Item', 'Create Item 119', 2, '2024-03-01 17:48:04'),
(53063, NULL, NULL, NULL, 119, NULL, NULL, NULL, 119, NULL, 'Update', 'a:2:{s:3:\"old\";a:20:{s:7:\"item_id\";s:3:\"119\";s:11:\"category_fk\";s:1:\"3\";s:11:\"supplier_fk\";s:2:\"25\";s:7:\"unit_fk\";s:2:\"25\";s:6:\"active\";s:1:\"1\";s:5:\"brand\";N;s:11:\"description\";N;s:9:\"inventory\";s:1:\"1\";s:9:\"item_code\";N;s:9:\"item_name\";s:7:\"Vinegar\";s:10:\"item_price\";s:5:\"50.00\";s:14:\"ordering_point\";s:4:\"5.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:6:\"remark\";N;s:12:\"safety_stock\";s:5:\"10.00\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:48:04\";s:9:\"unit_name\";s:3:\"BTL\";s:13:\"category_name\";s:17:\"Vinegar  & Sauces\";s:8:\"quantity\";N;}s:3:\"new\";a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:1:\"3\";s:11:\"supplier_fk\";s:2:\"25\";s:9:\"item_code\";s:6:\"VIN001\";s:5:\"brand\";s:14:\"La Reina Elena\";s:14:\"ordering_point\";s:4:\"5.00\";s:12:\"safety_stock\";s:5:\"10.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:5:\"50.00\";s:7:\"unit_fk\";s:2:\"25\";s:9:\"item_name\";s:7:\"Vinegar\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Item', 'Update Item 119', 2, '2024-03-01 17:48:41'),
(53064, NULL, NULL, NULL, 120, NULL, NULL, NULL, 120, NULL, 'Create', 'a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"2\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:9:\"item_code\";s:6:\"NOO001\";s:5:\"brand\";s:14:\"La Reina Elena\";s:14:\"ordering_point\";s:2:\"10\";s:12:\"safety_stock\";s:2:\"20\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:2:\"50\";s:7:\"unit_fk\";s:1:\"9\";s:9:\"item_name\";s:13:\"Fresh Noodles\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}', 'Item', 'Create Item 120', 2, '2024-03-01 17:50:19'),
(53065, NULL, NULL, NULL, NULL, NULL, NULL, 50, 50, NULL, 'Create', 'a:21:{s:6:\"active\";s:1:\"1\";s:7:\"area_fk\";s:2:\"24\";s:16:\"employee_type_fk\";s:1:\"1\";s:18:\"employee_status_fk\";s:1:\"2\";s:15:\"municipality_fk\";s:1:\"6\";s:11:\"position_fk\";s:1:\"1\";s:7:\"address\";N;s:8:\"birthday\";s:10:\"1998-01-01\";s:5:\"email\";s:19:\"forceslea@gmail.com\";s:10:\"first_name\";s:3:\"Lea\";s:9:\"last_name\";s:6:\"Forces\";s:13:\"employee_code\";s:6:\"EMP001\";s:15:\"employment_date\";s:10:\"2022-02-02\";s:6:\"gender\";s:1:\"F\";s:8:\"pag_ibig\";s:5:\"44444\";s:11:\"phil_health\";s:6:\"333333\";s:5:\"phone\";s:9:\"123456789\";s:6:\"remark\";N;s:3:\"sss\";s:7:\"1111111\";s:3:\"tin\";s:5:\"22222\";s:10:\"updated_by\";s:1:\"2\";}', 'Employee', 'Create Employee 50', 2, '2024-03-01 21:24:43'),
(53066, NULL, NULL, NULL, NULL, NULL, NULL, 51, 51, NULL, 'Create', 'a:21:{s:6:\"active\";s:1:\"1\";s:7:\"area_fk\";s:2:\"24\";s:16:\"employee_type_fk\";s:1:\"1\";s:18:\"employee_status_fk\";s:1:\"1\";s:15:\"municipality_fk\";s:1:\"6\";s:11:\"position_fk\";s:1:\"8\";s:7:\"address\";N;s:8:\"birthday\";s:10:\"1999-02-19\";s:5:\"email\";s:19:\"mcconnorp@gmail.com\";s:10:\"first_name\";s:7:\"Phillip\";s:9:\"last_name\";s:8:\"McConnor\";s:13:\"employee_code\";s:6:\"EMP002\";s:15:\"employment_date\";s:10:\"2023-04-06\";s:6:\"gender\";s:1:\"M\";s:8:\"pag_ibig\";s:3:\"444\";s:11:\"phil_health\";s:3:\"333\";s:5:\"phone\";s:11:\"23456789999\";s:6:\"remark\";N;s:3:\"sss\";s:3:\"111\";s:3:\"tin\";s:3:\"222\";s:10:\"updated_by\";s:1:\"2\";}', 'Employee', 'Create Employee 51', 2, '2024-03-01 21:26:38'),
(53067, 12, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'Create', 'a:14:{s:15:\"availability_fk\";N;s:11:\"location_fk\";s:1:\"3\";s:13:\"asset_type_fk\";s:1:\"1\";s:16:\"acquisition_date\";s:10:\"2023-11-30\";s:5:\"brand\";s:7:\"Samsung\";s:11:\"description\";N;s:11:\"asset_value\";s:4:\"2000\";s:15:\"expiration_date\";N;s:10:\"asset_code\";N;s:13:\"serial_number\";s:12:\"726538903789\";s:10:\"asset_name\";s:16:\"Computer Samsung\";s:6:\"remark\";N;s:14:\"asset_quantity\";s:1:\"1\";s:10:\"updated_by\";s:1:\"2\";}', 'Asset', 'Create Asset 12', 2, '2024-03-01 21:30:44'),
(53068, 13, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, 'Create', 'a:14:{s:15:\"availability_fk\";s:1:\"1\";s:11:\"location_fk\";s:1:\"4\";s:13:\"asset_type_fk\";s:1:\"6\";s:16:\"acquisition_date\";s:10:\"2020-11-06\";s:5:\"brand\";N;s:11:\"description\";N;s:11:\"asset_value\";s:6:\"500000\";s:15:\"expiration_date\";N;s:10:\"asset_code\";s:4:\"A002\";s:13:\"serial_number\";s:17:\"47262198783298749\";s:10:\"asset_name\";s:17:\"Packaging Machine\";s:6:\"remark\";N;s:14:\"asset_quantity\";s:1:\"1\";s:10:\"updated_by\";s:1:\"2\";}', 'Asset', 'Create Asset 13', 2, '2024-03-01 21:32:31'),
(53069, 12, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'Update', 'a:2:{s:3:\"old\";a:16:{s:8:\"asset_id\";s:2:\"12\";s:13:\"asset_type_fk\";s:1:\"1\";s:15:\"availability_fk\";N;s:11:\"location_fk\";s:1:\"3\";s:16:\"acquisition_date\";s:10:\"2023-11-30\";s:10:\"asset_code\";N;s:10:\"asset_name\";s:16:\"Computer Samsung\";s:14:\"asset_quantity\";s:1:\"1\";s:11:\"asset_value\";s:7:\"2000.00\";s:5:\"brand\";s:7:\"Samsung\";s:11:\"description\";N;s:15:\"expiration_date\";N;s:6:\"remark\";N;s:13:\"serial_number\";s:12:\"726538903789\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 16:30:44\";}s:3:\"new\";a:14:{s:15:\"availability_fk\";s:1:\"1\";s:11:\"location_fk\";s:1:\"3\";s:13:\"asset_type_fk\";s:1:\"1\";s:10:\"asset_code\";s:4:\"A001\";s:16:\"acquisition_date\";s:10:\"2023-11-30\";s:5:\"brand\";s:7:\"Samsung\";s:11:\"description\";N;s:11:\"asset_value\";s:7:\"2000.00\";s:13:\"serial_number\";s:12:\"726538903789\";s:15:\"expiration_date\";N;s:14:\"asset_quantity\";s:1:\"1\";s:10:\"asset_name\";s:16:\"Computer Samsung\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Asset', 'Update Asset 12', 2, '2024-03-01 21:32:43'),
(53070, 12, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'Update', 'a:2:{s:3:\"old\";a:16:{s:8:\"asset_id\";s:2:\"12\";s:13:\"asset_type_fk\";s:1:\"1\";s:15:\"availability_fk\";s:1:\"1\";s:11:\"location_fk\";s:1:\"3\";s:16:\"acquisition_date\";s:10:\"2023-11-30\";s:10:\"asset_code\";s:4:\"A001\";s:10:\"asset_name\";s:16:\"Computer Samsung\";s:14:\"asset_quantity\";s:1:\"1\";s:11:\"asset_value\";s:7:\"2000.00\";s:5:\"brand\";s:7:\"Samsung\";s:11:\"description\";N;s:15:\"expiration_date\";N;s:6:\"remark\";N;s:13:\"serial_number\";s:12:\"726538903789\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 16:30:44\";}s:3:\"new\";a:14:{s:15:\"availability_fk\";s:1:\"1\";s:11:\"location_fk\";s:1:\"3\";s:13:\"asset_type_fk\";s:1:\"1\";s:10:\"asset_code\";s:4:\"A001\";s:16:\"acquisition_date\";s:10:\"2023-11-30\";s:5:\"brand\";s:7:\"Samsung\";s:11:\"description\";s:22:\"For encoding of orders\";s:11:\"asset_value\";s:7:\"2000.00\";s:13:\"serial_number\";s:12:\"726538903789\";s:15:\"expiration_date\";N;s:14:\"asset_quantity\";s:1:\"1\";s:10:\"asset_name\";s:16:\"Computer Samsung\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Asset', 'Update Asset 12', 2, '2024-03-01 21:33:50'),
(53071, NULL, NULL, 5, NULL, NULL, NULL, NULL, 5, NULL, 'Create', 'a:9:{s:11:\"delivery_no\";s:5:\"D24-1\";s:11:\"supplier_fk\";s:2:\"24\";s:13:\"delivery_date\";s:10:\"2024-03-02\";s:15:\"production_date\";s:10:\"2023-10-06\";s:11:\"expiry_date\";s:10:\"2024-03-23\";s:8:\"batch_no\";s:8:\"Batch231\";s:6:\"lot_no\";s:5:\"Lot41\";s:12:\"reference_no\";s:8:\"R3546565\";s:10:\"updated_by\";s:1:\"2\";}', 'Delivery', 'Create Delivery 5', 2, '2024-03-01 22:49:27'),
(53072, NULL, NULL, 6, NULL, NULL, NULL, NULL, 6, NULL, 'Create', 'a:9:{s:11:\"delivery_no\";s:5:\"D24-2\";s:11:\"supplier_fk\";s:2:\"25\";s:13:\"delivery_date\";s:10:\"2024-03-02\";s:15:\"production_date\";s:10:\"2023-11-10\";s:11:\"expiry_date\";s:10:\"2024-08-16\";s:8:\"batch_no\";s:3:\"234\";s:6:\"lot_no\";s:3:\"666\";s:12:\"reference_no\";s:9:\"454353452\";s:10:\"updated_by\";s:1:\"2\";}', 'Delivery', 'Create Delivery 6', 2, '2024-03-01 23:00:25'),
(53073, NULL, NULL, NULL, 121, NULL, NULL, NULL, 121, NULL, 'Create', 'a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:2:\"18\";s:11:\"supplier_fk\";s:2:\"24\";s:9:\"item_code\";s:5:\"DM023\";s:5:\"brand\";N;s:14:\"ordering_point\";s:3:\"600\";s:12:\"safety_stock\";s:3:\"800\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:2:\"10\";s:7:\"unit_fk\";s:2:\"13\";s:9:\"item_name\";s:18:\"Packaging material\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}', 'Item', 'Create Item 121', 2, '2024-03-01 23:01:50'),
(53074, NULL, NULL, NULL, NULL, NULL, 24, NULL, 24, NULL, 'Create', 'a:5:{s:14:\"requisition_no\";s:5:\"R24-1\";s:21:\"employee_requested_fk\";s:2:\"50\";s:20:\"employee_approved_fk\";s:2:\"51\";s:16:\"requisition_date\";s:10:\"2024-03-02\";s:10:\"updated_by\";s:1:\"2\";}', 'Requisition', 'Create Requisition 24', 2, '2024-03-01 23:02:19'),
(53075, NULL, NULL, NULL, NULL, NULL, 24, NULL, 24, NULL, 'Update', 'a:2:{s:3:\"old\";a:9:{s:14:\"requisition_id\";s:2:\"24\";s:20:\"employee_approved_fk\";s:2:\"51\";s:21:\"employee_requested_fk\";s:2:\"50\";s:16:\"requisition_date\";s:10:\"2024-03-02\";s:14:\"requisition_no\";s:5:\"R24-1\";s:6:\"remark\";s:0:\"\";s:10:\"updated_by\";s:13:\"Carmen Gagnon\";s:12:\"updated_date\";s:10:\"2024-03-01\";s:23:\"employee_requested_name\";s:10:\"Forces Lea\";}s:3:\"new\";a:4:{s:16:\"requisition_date\";s:10:\"2024-03-02\";s:21:\"employee_requested_fk\";s:2:\"50\";s:20:\"employee_approved_fk\";s:2:\"51\";s:10:\"updated_by\";s:1:\"2\";}}', 'Requisition', 'Update Requisition 24', 2, '2024-03-01 23:02:34'),
(53076, NULL, NULL, NULL, NULL, 36093, NULL, NULL, 36093, NULL, 'Create', 'a:10:{s:8:\"order_no\";s:7:\"2400001\";s:11:\"customer_fk\";s:3:\"373\";s:11:\"employee_fk\";s:2:\"50\";s:13:\"delivery_date\";s:10:\"2024-03-03\";s:10:\"order_date\";s:10:\"2024-03-02\";s:11:\"order_total\";s:7:\"1600.00\";s:16:\"sales_invoice_no\";s:4:\"2352\";s:19:\"delivery_receipt_no\";s:5:\"66666\";s:17:\"purchase_order_no\";s:4:\"9999\";s:10:\"updated_by\";s:1:\"2\";}', 'Order', 'Create Order 36093', 2, '2024-03-01 23:03:34'),
(53077, NULL, NULL, NULL, 120, NULL, NULL, NULL, 120, NULL, 'Update', 'a:2:{s:3:\"old\";a:20:{s:7:\"item_id\";s:3:\"120\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:7:\"unit_fk\";s:1:\"9\";s:6:\"active\";s:1:\"1\";s:5:\"brand\";s:14:\"La Reina Elena\";s:11:\"description\";N;s:9:\"inventory\";s:1:\"2\";s:9:\"item_code\";s:6:\"NOO001\";s:9:\"item_name\";s:13:\"Fresh Noodles\";s:10:\"item_price\";s:5:\"50.00\";s:14:\"ordering_point\";s:5:\"10.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:6:\"remark\";N;s:12:\"safety_stock\";s:5:\"20.00\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:50:19\";s:9:\"unit_name\";s:2:\"KG\";s:13:\"category_name\";s:13:\"Fresh Noodles\";s:8:\"quantity\";s:5:\"-5.00\";}s:3:\"new\";a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:9:\"item_code\";s:6:\"NOO001\";s:5:\"brand\";s:14:\"La Reina Elena\";s:14:\"ordering_point\";s:5:\"10.00\";s:12:\"safety_stock\";s:5:\"20.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:5:\"50.00\";s:7:\"unit_fk\";s:1:\"9\";s:9:\"item_name\";s:13:\"Fresh Noodles\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Item', 'Update Item 120', 2, '2024-03-01 23:04:09'),
(53078, NULL, NULL, NULL, 120, NULL, NULL, NULL, 120, NULL, 'Update', 'a:2:{s:3:\"old\";a:20:{s:7:\"item_id\";s:3:\"120\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:7:\"unit_fk\";s:1:\"9\";s:6:\"active\";s:1:\"1\";s:5:\"brand\";s:14:\"La Reina Elena\";s:11:\"description\";N;s:9:\"inventory\";s:1:\"1\";s:9:\"item_code\";s:6:\"NOO001\";s:9:\"item_name\";s:13:\"Fresh Noodles\";s:10:\"item_price\";s:5:\"50.00\";s:14:\"ordering_point\";s:5:\"10.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:6:\"remark\";N;s:12:\"safety_stock\";s:5:\"20.00\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:50:19\";s:9:\"unit_name\";s:2:\"KG\";s:13:\"category_name\";s:13:\"Fresh Noodles\";s:8:\"quantity\";s:5:\"-5.00\";}s:3:\"new\";a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"2\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:9:\"item_code\";s:6:\"NOO001\";s:5:\"brand\";s:14:\"La Reina Elena\";s:14:\"ordering_point\";s:5:\"10.00\";s:12:\"safety_stock\";s:5:\"20.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:5:\"50.00\";s:7:\"unit_fk\";s:1:\"9\";s:9:\"item_name\";s:13:\"Fresh Noodles\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Item', 'Update Item 120', 2, '2024-03-01 23:04:28'),
(53079, NULL, NULL, NULL, NULL, 36094, NULL, NULL, 36094, NULL, 'Create', 'a:10:{s:8:\"order_no\";s:7:\"2400002\";s:11:\"customer_fk\";s:3:\"374\";s:11:\"employee_fk\";s:2:\"50\";s:13:\"delivery_date\";s:10:\"2024-03-03\";s:10:\"order_date\";s:10:\"2024-03-02\";s:11:\"order_total\";s:6:\"500.00\";s:16:\"sales_invoice_no\";s:0:\"\";s:19:\"delivery_receipt_no\";s:0:\"\";s:17:\"purchase_order_no\";s:0:\"\";s:10:\"updated_by\";s:1:\"2\";}', 'Order', 'Create Order 36094', 2, '2024-03-01 23:05:04'),
(53080, NULL, NULL, NULL, 118, NULL, NULL, NULL, 118, NULL, 'Update', 'a:2:{s:3:\"old\";a:20:{s:7:\"item_id\";s:3:\"118\";s:11:\"category_fk\";s:1:\"2\";s:11:\"supplier_fk\";s:2:\"24\";s:7:\"unit_fk\";s:2:\"10\";s:6:\"active\";s:1:\"1\";s:5:\"brand\";N;s:11:\"description\";N;s:9:\"inventory\";s:1:\"1\";s:9:\"item_code\";s:6:\"ITE001\";s:9:\"item_name\";s:11:\"Miki Noodle\";s:10:\"item_price\";s:6:\"100.00\";s:14:\"ordering_point\";s:5:\"10.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:6:\"remark\";N;s:12:\"safety_stock\";s:5:\"15.00\";s:10:\"updated_by\";s:1:\"2\";s:12:\"updated_date\";s:19:\"2024-03-01 12:43:31\";s:9:\"unit_name\";s:3:\"BOX\";s:13:\"category_name\";s:13:\"Fresh Noodles\";s:8:\"quantity\";s:6:\"190.00\";}s:3:\"new\";a:15:{s:6:\"active\";s:1:\"1\";s:9:\"inventory\";s:1:\"1\";s:11:\"category_fk\";s:2:\"13\";s:11:\"supplier_fk\";s:2:\"24\";s:9:\"item_code\";s:6:\"ITE001\";s:5:\"brand\";N;s:14:\"ordering_point\";s:5:\"10.00\";s:12:\"safety_stock\";s:5:\"15.00\";s:10:\"price_date\";s:10:\"2024-03-02\";s:11:\"description\";N;s:10:\"item_price\";s:6:\"100.00\";s:7:\"unit_fk\";s:2:\"10\";s:9:\"item_name\";s:11:\"Miki Noodle\";s:6:\"remark\";N;s:10:\"updated_by\";s:1:\"2\";}}', 'Item', 'Update Item 118', 2, '2024-03-01 23:47:05'),
(53081, NULL, NULL, 6, NULL, NULL, NULL, NULL, 6, NULL, 'Update', 'a:2:{s:3:\"old\";a:13:{s:11:\"delivery_id\";s:1:\"6\";s:11:\"supplier_fk\";s:2:\"25\";s:8:\"batch_no\";s:3:\"234\";s:13:\"delivery_date\";s:10:\"2024-03-02\";s:11:\"delivery_no\";s:5:\"D24-2\";s:11:\"expiry_date\";s:10:\"2024-08-16\";s:6:\"lot_no\";s:3:\"666\";s:15:\"production_date\";s:10:\"2023-11-10\";s:12:\"reference_no\";s:9:\"454353452\";s:6:\"remark\";s:0:\"\";s:10:\"updated_by\";s:13:\"Carmen Gagnon\";s:12:\"updated_date\";s:19:\"2024-03-01 18:00:25\";s:13:\"supplier_name\";s:17:\"The best supplier\";}s:3:\"new\";a:8:{s:11:\"supplier_fk\";s:2:\"25\";s:13:\"delivery_date\";s:10:\"2024-03-02\";s:15:\"production_date\";s:10:\"2023-11-10\";s:11:\"expiry_date\";s:10:\"2024-08-16\";s:8:\"batch_no\";s:3:\"234\";s:6:\"lot_no\";s:3:\"666\";s:12:\"reference_no\";s:9:\"454353452\";s:10:\"updated_by\";s:1:\"2\";}}', 'Delivery', 'Update Delivery 6', 2, '2024-03-02 16:40:24'),
(53082, NULL, NULL, NULL, NULL, 36095, NULL, NULL, 36095, NULL, 'Create', 'a:10:{s:8:\"order_no\";s:7:\"2400003\";s:11:\"customer_fk\";s:3:\"373\";s:11:\"employee_fk\";s:2:\"51\";s:13:\"delivery_date\";s:10:\"2024-03-12\";s:10:\"order_date\";s:10:\"2024-03-11\";s:11:\"order_total\";s:7:\"1000.00\";s:16:\"sales_invoice_no\";s:0:\"\";s:19:\"delivery_receipt_no\";s:0:\"\";s:17:\"purchase_order_no\";s:0:\"\";s:10:\"updated_by\";s:2:\"29\";}', 'Order', 'Create Order 36095', 29, '2024-03-11 15:33:02'),
(53083, NULL, NULL, NULL, NULL, 36096, NULL, NULL, 36096, NULL, 'Create', 'a:10:{s:8:\"order_no\";s:7:\"2400004\";s:11:\"customer_fk\";s:3:\"373\";s:11:\"employee_fk\";s:2:\"50\";s:13:\"delivery_date\";s:10:\"2024-05-28\";s:10:\"order_date\";s:10:\"2024-05-27\";s:11:\"order_total\";s:5:\"50.00\";s:16:\"sales_invoice_no\";s:5:\"12345\";s:19:\"delivery_receipt_no\";s:4:\"6789\";s:17:\"purchase_order_no\";s:4:\"5555\";s:10:\"updated_by\";s:2:\"29\";}', 'Order', 'Create Order 36096', 29, '2024-05-27 11:48:11'),
(53084, NULL, NULL, NULL, NULL, 36096, NULL, NULL, 36096, NULL, 'Update', 'a:2:{s:3:\"old\";a:19:{s:8:\"order_id\";s:5:\"36096\";s:11:\"customer_fk\";s:3:\"373\";s:11:\"employee_fk\";s:2:\"50\";s:13:\"delivery_date\";s:10:\"2024-05-28\";s:19:\"delivery_receipt_no\";s:4:\"6789\";s:10:\"order_date\";s:10:\"2024-05-27\";s:8:\"order_no\";s:7:\"2400004\";s:11:\"order_total\";s:5:\"50.00\";s:17:\"purchase_order_no\";s:4:\"5555\";s:6:\"remark\";s:0:\"\";s:16:\"sales_invoice_no\";s:5:\"12345\";s:10:\"updated_by\";s:14:\"Catalyste User\";s:12:\"updated_date\";s:10:\"2024-05-27\";s:13:\"customer_name\";s:9:\"Megastore\";s:9:\"area_name\";s:13:\"Batangas City\";s:17:\"municipality_name\";s:6:\"Lucena\";s:5:\"phone\";s:5:\"12345\";s:7:\"balance\";s:7:\"1150.00\";s:16:\"previous_balance\";s:7:\"1100.00\";}s:3:\"new\";a:8:{s:10:\"order_date\";s:10:\"2024-05-27\";s:11:\"employee_fk\";s:2:\"50\";s:16:\"sales_invoice_no\";s:5:\"12345\";s:19:\"delivery_receipt_no\";s:4:\"6789\";s:17:\"purchase_order_no\";s:4:\"5555\";s:13:\"delivery_date\";s:10:\"2024-05-28\";s:11:\"order_total\";s:7:\"5000.00\";s:10:\"updated_by\";s:2:\"29\";}}', 'Order', 'Update Order 36096', 29, '2024-05-27 11:48:20');

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE IF NOT EXISTS `maintenance` (
  `maintenance_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_fk` int(11) NOT NULL,
  `maintenance_type_fk` int(11) NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `description` text,
  `maintenance_date` date DEFAULT NULL,
  `maintenance_name` varchar(150) NOT NULL,
  `remark` text,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`maintenance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`maintenance_id`, `asset_fk`, `maintenance_type_fk`, `cost`, `description`, `maintenance_date`, `maintenance_name`, `remark`, `updated_by`, `updated_date`) VALUES
(14, 12, 7, '500.00', 'Printer installed', '2024-03-02', 'Problem with the printer', NULL, 2, '2024-03-01 21:31:34');

-- --------------------------------------------------------

--
-- Structure de la table `maintenance_type`
--

DROP TABLE IF EXISTS `maintenance_type`;
CREATE TABLE IF NOT EXISTS `maintenance_type` (
  `maintenance_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `maintenance_type_code` varchar(10) NOT NULL,
  `maintenance_type_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`maintenance_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `maintenance_type`
--

INSERT INTO `maintenance_type` (`maintenance_type_id`, `maintenance_type_code`, `maintenance_type_name`, `active`) VALUES
(6, 'MAINTAIN', 'Maintenance annual', 1),
(7, 'REPAIR', 'Repair the asset', 1),
(8, 'CHANGE', 'Change for a new asset', 1),
(9, 'RENEWAL', 'Renewal', 1);

-- --------------------------------------------------------

--
-- Structure de la table `movement`
--

DROP TABLE IF EXISTS `movement`;
CREATE TABLE IF NOT EXISTS `movement` (
  `movement_id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_fk` int(11) DEFAULT NULL,
  `item_location_fk` int(11) DEFAULT NULL,
  `order_fk` int(11) DEFAULT NULL,
  `requisition_fk` int(11) DEFAULT NULL,
  `date_movement` date NOT NULL,
  `order_amount` decimal(12,2) DEFAULT NULL,
  `rate` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `type_movement` tinyint(1) DEFAULT NULL COMMENT '1=In  2=Out',
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`movement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98455 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movement`
--

INSERT INTO `movement` (`movement_id`, `delivery_fk`, `item_location_fk`, `order_fk`, `requisition_fk`, `date_movement`, `order_amount`, `rate`, `quantity`, `remark`, `type_movement`, `updated_by`, `updated_date`) VALUES
(98442, 5, 315, NULL, NULL, '2024-03-02', NULL, '100.00', '100.00', 'Delivery ', 1, 2, '2024-03-01 22:49:27'),
(98445, NULL, 317, NULL, 24, '2024-03-02', NULL, NULL, '100.00', 'Requisition ', 2, 2, '2024-03-01 23:02:34'),
(98446, NULL, 314, NULL, 24, '2024-03-02', NULL, NULL, '10.00', 'Requisition ', 2, 2, '2024-03-01 23:02:34'),
(98447, NULL, 316, 36093, NULL, '2024-03-02', '600.00', '40.00', '15.00', 'Order ', 2, 2, '2024-03-01 23:03:34'),
(98448, NULL, 315, 36093, NULL, '2024-03-02', '1000.00', '100.00', '10.00', 'Order ', 2, 2, '2024-03-01 23:03:34'),
(98449, NULL, 314, 36094, NULL, '2024-03-02', '500.00', '50.00', '10.00', 'Order ', 2, 2, '2024-03-01 23:05:04'),
(98450, 6, 314, NULL, NULL, '2024-03-03', NULL, '60.00', '10.00', 'Delivery ', 1, 2, '2024-03-02 16:40:24'),
(98451, 6, 318, NULL, NULL, '2024-03-03', NULL, '100.00', '10.00', 'Delivery ', 1, 2, '2024-03-02 16:40:24'),
(98452, NULL, 315, 36095, NULL, '2024-03-11', '1000.00', '100.00', '10.00', 'Order ', 2, 29, '2024-03-11 15:33:02'),
(98454, NULL, 316, 36096, NULL, '2024-05-27', '5000.00', '50.00', '100.00', 'Order ', 2, 29, '2024-05-27 11:48:20');

-- --------------------------------------------------------

--
-- Structure de la table `municipality`
--

DROP TABLE IF EXISTS `municipality`;
CREATE TABLE IF NOT EXISTS `municipality` (
  `municipality_id` int(11) NOT NULL AUTO_INCREMENT,
  `municipality_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`municipality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `municipality`
--

INSERT INTO `municipality` (`municipality_id`, `municipality_name`, `active`) VALUES
(1, 'Lucena', 1),
(5, 'South', 1),
(6, 'Candelaria', 1),
(8, 'Catanauan', 1),
(10, 'Gen. Luna', 1),
(11, 'Macalelon', 1),
(12, 'Unisan', 1),
(13, 'Agdangan', 1),
(14, 'Burgos', 1),
(15, 'Pagbilao', 1),
(16, 'Gumaca', 1),
(17, 'Lopez', 1),
(18, 'Guinyangan', 1),
(19, 'Calauag', 1),
(20, 'Siain', 1),
(21, 'Atimonan', 1),
(22, 'Macalelon', 1),
(23, 'Unisan', 1),
(24, 'Sariaya', 1),
(25, 'Candelaria', 1),
(26, 'Carmona', 1),
(27, 'San Juan', 1),
(28, 'Pasay', 1),
(29, 'Balintawak', 1),
(30, 'Manila', 1),
(31, 'Pasig', 1),
(32, 'Del Monte Bulacan', 1),
(33, 'Calamba', 1),
(34, 'Tayabas', 1),
(35, 'Molino', 1),
(36, 'Cuban', 1),
(37, 'Cubao', 1),
(38, 'Taguig', 1),
(39, 'Quezon City', 1),
(40, 'Plaridel', 1),
(41, 'Sampaloc', 1),
(42, 'San Fernando', 1),
(43, 'Taguig City', 1),
(44, 'Mandaluyong', 1),
(45, 'Makati', 1),
(46, 'San Pablo City', 1),
(47, 'Sto Tomas', 1),
(48, 'Tiaong', 1),
(49, 'Tagaytay City', 1),
(50, 'LIPA CITY', 1),
(51, 'WALK-IN', 1),
(52, 'Tagkawayan', 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_fk` int(11) DEFAULT NULL,
  `employee_fk` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_receipt_no` varchar(50) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `order_total` decimal(12,2) NOT NULL,
  `purchase_order_no` varchar(50) DEFAULT NULL,
  `remark` varchar(255) NOT NULL,
  `sales_invoice_no` varchar(100) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `customer_fk` (`customer_fk`),
  KEY `order_date` (`order_date`)
) ENGINE=InnoDB AUTO_INCREMENT=36097 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_fk`, `employee_fk`, `delivery_date`, `delivery_receipt_no`, `order_date`, `order_no`, `order_total`, `purchase_order_no`, `remark`, `sales_invoice_no`, `updated_by`, `updated_date`) VALUES
(36093, 373, 50, '2024-03-03', '66666', '2024-03-02', '2400001', '1600.00', '9999', '', '2352', 2, '2024-03-01 23:03:34'),
(36094, 374, 50, '2024-03-03', '', '2024-03-02', '2400002', '500.00', '', '', '', 2, '2024-03-01 23:05:04'),
(36095, 373, 51, '2024-03-12', '', '2024-03-11', '2400003', '1000.00', '', '', '', 29, '2024-03-11 15:33:02'),
(36096, 373, 50, '2024-05-28', '6789', '2024-05-27', '2400004', '5000.00', '5555', '', '12345', 29, '2024-05-27 11:48:11');

-- --------------------------------------------------------

--
-- Structure de la table `organization`
--

DROP TABLE IF EXISTS `organization`;
CREATE TABLE IF NOT EXISTS `organization` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `currency` char(3) NOT NULL,
  `logo_visible` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=Visible 2=Non Visible',
  `message` text NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  PRIMARY KEY (`organization_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `organization`
--

INSERT INTO `organization` (`organization_id`, `address`, `country`, `currency`, `logo_visible`, `message`, `organization_name`, `phone`) VALUES
(1, 'KM 133 Diversion Road Silangan Mayao Lucena City', 'Philippines', 'PHP', 2, 'hello everyone one.&nbsp;', 'Amstature Foods', '7956247');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_fk` int(11) NOT NULL,
  `order_fk` int(11) DEFAULT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_remark` text,
  `payment_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Payment  2=Credi',
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `Customer` (`customer_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=34353 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_fk`, `order_fk`, `amount_paid`, `payment_date`, `payment_remark`, `payment_type`, `updated_by`, `updated_date`) VALUES
(34352, 373, 36093, '1600.00', '2024-03-02', NULL, 1, 2, '2024-03-01 23:39:59');

-- --------------------------------------------------------

--
-- Structure de la table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `position_code` varchar(10) NOT NULL,
  `position_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `position`
--

INSERT INTO `position` (`position_id`, `position_code`, `position_name`, `active`) VALUES
(1, 'ADO', 'Administrative   Officer', 1),
(2, 'DLC', 'Delivery Crew', 1),
(4, 'PDC', 'Production Crew', 1),
(5, 'UTC', 'Utility Crew', 1),
(6, 'HSO', 'Health & Safety Officer', 1),
(7, 'ADA', 'Administrative  Assistant', 1),
(8, 'GMR', 'General Manager', 1),
(9, 'OPM', 'Operation Manager', 1),
(10, 'ADC', 'Administrative  Clerk', 1),
(11, 'STC', 'Store Clerk', 1);

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(100) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profile`
--

INSERT INTO `profile` (`profile_id`, `profile_name`, `permission`) VALUES
(1, 'Administrator', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:11:\"createStore\";i:17;s:11:\"updateStore\";i:18;s:9:\"viewStore\";i:19;s:11:\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s:11:\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s:11:\"createOrder\";i:29;s:11:\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s:11:\"deleteOrder\";i:32;s:11:\"viewReports\";i:33;s:13:\"updateCompany\";i:34;s:11:\"viewProfile\";i:35;s:13:\"updateSetting\";}'),
(7, 'reader', 'a:19:{i:0;s:8:\"viewItem\";i:1;s:9:\"viewOrder\";i:2;s:12:\"viewCustomer\";i:3;s:8:\"viewArea\";i:4;s:16:\"viewMunicipality\";i:5;s:9:\"viewAsset\";i:6;s:16:\"viewAvailability\";i:7;s:12:\"viewDocument\";i:8;s:15:\"viewMaintenance\";i:9;s:19:\"viewMaintenanceType\";i:10;s:12:\"viewCategory\";i:11;s:12:\"viewLocation\";i:12;s:8:\"viewUnit\";i:13;s:12:\"viewMovement\";i:14;s:13:\"viewDashboard\";i:15;s:10:\"viewReport\";i:16;s:11:\"viewProfile\";i:17;s:8:\"viewUser\";i:18;s:16:\"viewOrganization\";}'),
(12, 'admin', 'a:122:{i:0;s:10:\"createItem\";i:1;s:10:\"updateItem\";i:2;s:8:\"viewItem\";i:3;s:10:\"deleteItem\";i:4;s:14:\"createMovement\";i:5;s:14:\"updateMovement\";i:6;s:12:\"viewMovement\";i:7;s:14:\"deleteMovement\";i:8;s:14:\"createCategory\";i:9;s:14:\"updateCategory\";i:10;s:12:\"viewCategory\";i:11;s:14:\"deleteCategory\";i:12;s:10:\"createUnit\";i:13;s:10:\"updateUnit\";i:14;s:8:\"viewUnit\";i:15;s:10:\"deleteUnit\";i:16;s:16:\"createIngredient\";i:17;s:16:\"updateIngredient\";i:18;s:14:\"viewIngredient\";i:19;s:16:\"deleteIngredient\";i:20;s:16:\"createProduction\";i:21;s:16:\"updateProduction\";i:22;s:14:\"viewProduction\";i:23;s:16:\"deleteProduction\";i:24;s:14:\"createSupplier\";i:25;s:14:\"updateSupplier\";i:26;s:12:\"viewSupplier\";i:27;s:14:\"deleteSupplier\";i:28;s:14:\"createDelivery\";i:29;s:14:\"updateDelivery\";i:30;s:12:\"viewDelivery\";i:31;s:14:\"deleteDelivery\";i:32;s:11:\"createOrder\";i:33;s:11:\"updateOrder\";i:34;s:9:\"viewOrder\";i:35;s:11:\"deleteOrder\";i:36;s:14:\"createCustomer\";i:37;s:14:\"updateCustomer\";i:38;s:12:\"viewCustomer\";i:39;s:14:\"deleteCustomer\";i:40;s:18:\"createCustomerType\";i:41;s:18:\"updateCustomerType\";i:42;s:16:\"viewCustomerType\";i:43;s:18:\"deleteCustomerType\";i:44;s:13:\"createPayment\";i:45;s:13:\"updatePayment\";i:46;s:11:\"viewPayment\";i:47;s:13:\"deletePayment\";i:48;s:21:\"updateBalanceCustomer\";i:49;s:11:\"createAsset\";i:50;s:11:\"updateAsset\";i:51;s:9:\"viewAsset\";i:52;s:11:\"deleteAsset\";i:53;s:15:\"createAssetType\";i:54;s:15:\"updateAssetType\";i:55;s:13:\"viewAssetType\";i:56;s:15:\"deleteAssetType\";i:57;s:18:\"createAvailability\";i:58;s:18:\"updateAvailability\";i:59;s:16:\"viewAvailability\";i:60;s:18:\"deleteAvailability\";i:61;s:17:\"createMaintenance\";i:62;s:17:\"updateMaintenance\";i:63;s:15:\"viewMaintenance\";i:64;s:17:\"deleteMaintenance\";i:65;s:21:\"createMaintenanceType\";i:66;s:21:\"updateMaintenanceType\";i:67;s:19:\"viewMaintenanceType\";i:68;s:21:\"deleteMaintenanceType\";i:69;s:14:\"createEmployee\";i:70;s:14:\"updateEmployee\";i:71;s:12:\"viewEmployee\";i:72;s:14:\"deleteEmployee\";i:73;s:18:\"createEmployeeType\";i:74;s:18:\"updateEmployeeType\";i:75;s:16:\"viewEmployeeType\";i:76;s:18:\"deleteEmployeeType\";i:77;s:20:\"createEmployeeStatus\";i:78;s:20:\"updateEmployeeStatus\";i:79;s:18:\"viewEmployeeStatus\";i:80;s:20:\"deleteEmployeeStatus\";i:81;s:14:\"createPosition\";i:82;s:14:\"updatePosition\";i:83;s:12:\"viewPosition\";i:84;s:14:\"deletePosition\";i:85;s:17:\"createRequisition\";i:86;s:17:\"updateRequisition\";i:87;s:15:\"viewRequisition\";i:88;s:17:\"deleteRequisition\";i:89;s:14:\"createLocation\";i:90;s:14:\"updateLocation\";i:91;s:12:\"viewLocation\";i:92;s:14:\"deleteLocation\";i:93;s:10:\"createArea\";i:94;s:10:\"updateArea\";i:95;s:8:\"viewArea\";i:96;s:10:\"deleteArea\";i:97;s:18:\"createMunicipality\";i:98;s:18:\"updateMunicipality\";i:99;s:16:\"viewMunicipality\";i:100;s:18:\"deleteMunicipality\";i:101;s:14:\"createDocument\";i:102;s:14:\"updateDocument\";i:103;s:12:\"viewDocument\";i:104;s:14:\"deleteDocument\";i:105;s:18:\"createOrganization\";i:106;s:18:\"updateOrganization\";i:107;s:16:\"viewOrganization\";i:108;s:18:\"deleteOrganization\";i:109;s:13:\"createProfile\";i:110;s:13:\"updateProfile\";i:111;s:11:\"viewProfile\";i:112;s:13:\"deleteProfile\";i:113;s:10:\"createUser\";i:114;s:10:\"updateUser\";i:115;s:8:\"viewUser\";i:116;s:10:\"deleteUser\";i:117;s:12:\"updateSystem\";i:118;s:13:\"updateSetting\";i:119;s:13:\"viewDashboard\";i:120;s:12:\"updateReport\";i:121;s:10:\"viewReport\";}'),
(13, 'Office Staff', 'a:30:{i:0;s:10:\"updateItem\";i:1;s:8:\"viewItem\";i:2;s:10:\"deleteItem\";i:3;s:14:\"updateCategory\";i:4;s:12:\"viewCategory\";i:5;s:14:\"deleteCategory\";i:6;s:10:\"updateUnit\";i:7;s:8:\"viewUnit\";i:8;s:10:\"deleteUnit\";i:9;s:15:\"updateComponent\";i:10;s:13:\"viewComponent\";i:11;s:15:\"deleteComponent\";i:12;s:11:\"createOrder\";i:13;s:11:\"updateOrder\";i:14;s:9:\"viewOrder\";i:15;s:11:\"deleteOrder\";i:16;s:14:\"createCustomer\";i:17;s:14:\"updateCustomer\";i:18;s:12:\"viewCustomer\";i:19;s:14:\"deleteCustomer\";i:20;s:13:\"createPayment\";i:21;s:13:\"updatePayment\";i:22;s:11:\"viewPayment\";i:23;s:13:\"deletePayment\";i:24;s:21:\"updateBalanceCustomer\";i:25;s:14:\"updateLocation\";i:26;s:12:\"viewLocation\";i:27;s:14:\"deleteLocation\";i:28;s:13:\"viewDashboard\";i:29;s:10:\"viewReport\";}'),
(15, 'Staff', 'a:34:{i:0;s:10:\"updateItem\";i:1;s:8:\"viewItem\";i:2;s:10:\"deleteItem\";i:3;s:14:\"updateCategory\";i:4;s:12:\"viewCategory\";i:5;s:14:\"deleteCategory\";i:6;s:10:\"updateUnit\";i:7;s:8:\"viewUnit\";i:8;s:10:\"deleteUnit\";i:9;s:14:\"updateMovement\";i:10;s:12:\"viewMovement\";i:11;s:14:\"deleteMovement\";i:12;s:16:\"createProduction\";i:13;s:16:\"updateProduction\";i:14;s:14:\"viewProduction\";i:15;s:16:\"deleteProduction\";i:16;s:11:\"createOrder\";i:17;s:11:\"updateOrder\";i:18;s:9:\"viewOrder\";i:19;s:11:\"deleteOrder\";i:20;s:14:\"createCustomer\";i:21;s:14:\"updateCustomer\";i:22;s:12:\"viewCustomer\";i:23;s:14:\"deleteCustomer\";i:24;s:13:\"createPayment\";i:25;s:13:\"updatePayment\";i:26;s:11:\"viewPayment\";i:27;s:13:\"deletePayment\";i:28;s:21:\"updateBalanceCustomer\";i:29;s:14:\"updateLocation\";i:30;s:12:\"viewLocation\";i:31;s:14:\"deleteLocation\";i:32;s:13:\"viewDashboard\";i:33;s:10:\"viewReport\";}');

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

DROP TABLE IF EXISTS `report`;
CREATE TABLE IF NOT EXISTS `report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_code` char(5) NOT NULL,
  `report_desc` varchar(200) DEFAULT NULL,
  `report_form` varchar(100) NOT NULL,
  `report_title` varchar(100) NOT NULL,
  `report_for` varchar(15) NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `report`
--

INSERT INTO `report` (`report_id`, `report_code`, `report_desc`, `report_form`, `report_title`, `report_for`) VALUES
(1, 'REP01', 'List of items', '/application/controllers/Repor01.php', 'List of items', 'report'),
(2, 'REP02', 'List of Assets', '/application/controllers/report02.php', 'List of Assets', 'report'),
(5, 'REP81', 'Print a specific item', '/application/controllers/report_item.php', 'item', 'none'),
(7, 'REP83', 'Print a specific order', '/application/controllers/report_order.php', 'Order', 'none'),
(8, 'REP84', 'Print a specific asset', '/application/controllers/report_asset.php', 'Asset', 'none'),
(9, 'REP85', 'Print a specific setting', '/application/controllers/report_setting.php', 'Setting', 'none'),
(10, 'REP03', 'List of Orders', '/application/controllers/report03.php', 'List of Orders', 'report'),
(11, 'REP86', 'Print a specific customer', '/application/controllers/report_customer.php', 'Customer', 'none'),
(12, 'REP87', 'Print a specific employee', '/application/controllers/report_employee.php', 'Employee', 'none'),
(13, 'REP04', 'List of Customers', '/application/controllers/report04.php', 'List of customers', 'report'),
(14, 'REP05', 'List of Employees', '/application/controllers/report05.php', 'List of Employees', 'report'),
(15, 'REP88', 'Print the Order Slip', '/application/controllers/report_order_slip.php', 'Order Slip', 'none'),
(16, 'REP07', 'Summary of Deliveries', '/application/controllers/report07.php', 'Summary of Deliveries', 'report'),
(18, 'REP06', 'Summary of Orders', '/application/controllers/report06.php', 'Summary of Orders', 'report'),
(19, 'REP08', 'Order Slip', '/application/controllers/report08.php', 'Order Slip', 'report'),
(20, 'REP09', 'Summary of Payments', '/application/controllers/report09.php', 'Summary of Payments', 'report'),
(21, 'REP10', 'Statement of Account', '/application/controllers/report10.php', 'Statement of Account', 'report'),
(22, 'REP11', 'Inventory Control', '/application/controllers/report11.php', 'Inventory Control', 'report'),
(23, 'REP82', 'Print the Requisition', '/application/controllers/report_requisition.php', 'Requisition Form', 'none'),
(24, 'REP12', 'List of Requisitions', '/application/controllers/report12.php', 'List of Requisitions', 'report'),
(25, 'REP13', 'Orders per Day', '/application/controllers/report13.php', 'Orders per Day', 'report'),
(26, 'REP89', 'Print the supplier', '/application/controllers/report_supplier.php', 'Supplier', 'none'),
(27, 'REP90', 'Print the delivery', '/application/controllers/report_delivery.php', 'Delivery', 'none'),
(28, 'REP14', 'List of Suppliers', '/application/controllers/report14.php', 'List of Suppliers', 'report'),
(29, 'REP15', 'List of Deliveries', '/application/controllers/report15.php', 'List of Deliveries', 'report');

-- --------------------------------------------------------

--
-- Structure de la table `requisition`
--

DROP TABLE IF EXISTS `requisition`;
CREATE TABLE IF NOT EXISTS `requisition` (
  `requisition_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_approved_fk` int(11) DEFAULT NULL,
  `employee_requested_fk` int(11) DEFAULT NULL,
  `requisition_date` date DEFAULT NULL,
  `requisition_no` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`requisition_id`),
  KEY `employee_requested_fk` (`employee_requested_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `requisition`
--

INSERT INTO `requisition` (`requisition_id`, `employee_approved_fk`, `employee_requested_fk`, `requisition_date`, `requisition_no`, `remark`, `updated_by`, `updated_date`) VALUES
(24, 51, 50, '2024-03-02', 'R24-1', '', 2, '2024-03-01 23:02:19');

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  `address` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `phone` varchar(75) DEFAULT NULL,
  `remark` text,
  `supplier_name` varchar(100) NOT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `active`, `address`, `contact`, `email`, `mobile`, `phone`, `remark`, `supplier_name`, `tin`, `website`) VALUES
(24, 1, '2150 Street', 'M. Untel', 'supplier1@gmail.com', '787565656', '44655338945', 'Very good', 'My favorite supplier', 'IN1111', 'supplier1.com'),
(25, 1, '5746 Street around the store', 'M. Two', 'supplier2@gmai.com', '7788999999', '45566666', '', 'The best supplier', 'TIN222334', '');

-- --------------------------------------------------------

--
-- Structure de la table `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active  2=inactive',
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`, `active`) VALUES
(9, 'KG', 1),
(10, 'BOX', 1),
(11, 'BDL', 1),
(12, 'LTR', 1),
(13, 'SCK', 1),
(23, 'GAL', 1),
(24, 'PCS', 1),
(25, 'BTL', 1),
(26, 'PCK', 1),
(27, 'GMS', 1),
(28, 'CBY', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_fk` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `remark` text,
  `phone` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL COMMENT '1=active  2=inactive',
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `profile_fk`, `employee_id`, `username`, `password`, `email`, `user_name`, `remark`, `phone`, `active`, `updated_by`, `updated_date`) VALUES
(2, 12, 7, 'voyagine', '$2y$10$bQqR.jmqPDZNTfp3I7woBeUBcGHHAWdMRwnXgkxaqteIamdgN0vgW', 'voyagine@hotmail.com', 'Carmen Gagnon', NULL, '5149836594', 0, 18, '2019-09-17 17:37:09'),
(29, 12, NULL, 'posam', '$2y$10$dJXuozeyBlFZgn142.FZKeAvQen6tnuNtNmkc9xZzfxPQHLotKwp.', 'catalyste@gmail.com', 'Catalyste User', NULL, '12345', 1, 2, '2024-03-01 23:17:03'),
(30, 12, NULL, 'superadmin', '$2y$10$8aP2ejkPHvZd4HcS11sNYuvvmNIDOMWlCOlbRxz/jvUnsFyAj86iK', 'superadmin@gmail.com', 'Super Admin', NULL, '', 1, 29, '2024-06-05 19:45:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
