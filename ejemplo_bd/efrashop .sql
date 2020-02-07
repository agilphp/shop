-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 05, 2020 at 11:04 AM
-- Server version: 5.7.26
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efrashop`
--

-- --------------------------------------------------------

--
-- Table structure for table `sesiones`
--

DROP TABLE IF EXISTS `sesiones`;
CREATE TABLE IF NOT EXISTS `sesiones` (
  `id` char(128) COLLATE utf8_spanish2_ci NOT NULL,
  `set_time` char(10) COLLATE utf8_spanish2_ci NOT NULL,
  `data` text COLLATE utf8_spanish2_ci NOT NULL,
  `session_key` char(128) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `sesiones`
--

INSERT INTO `sesiones` (`id`, `set_time`, `data`, `session_key`) VALUES
('ffs4bo9kjnp1uq78tbdpr6knihmfe4jo9aa1qcdcs5juggkutlje88h1s0gtcohr9kjfdpaavni0dbviflhb7merd349rdiaapjmst3', '1580872503', 'qqqsH69DyGUa5sfNEE5isZV275wvCAskjJATLk0MCiPNWgw8pkmjtPS1mCtLBxWO/EI+XRJtu57Pk/zi2YmWCTZC69jb5MAjiM7iUS2lr9IoDTYVqUfv6lCESL0nQC2YLEtY31e0ZdvbMwEEALSkY9Ktix4Bh4E4E4QZKyMl7eN3BOd2DnO9UQqT1pf7jRWzdHftZy7sTEOSpvCf6SStGSKeROSfma6h/h5QNgNj2sQsLGpqpqINL8YA0usGyR6q1qWMOciFNS2zCFLdQ4aPbB1IEfK9ZKnkha0AKA/NrfwtB26nW2O+nlHs9EaMowwViMZ4xf5bnpPmIwxF3CbVaehJ5wumxPSBpUmm8EniFiYmK0BYrpZEut2F4p1MpqdnQLSxj7PGw+kpDAdWsoWtWEHuq5fz9kgy2koGXyJNpHXQtImZnXFyh3Rti4+3lghMGHtKcLM9FunjWYnwxQ+/FiAPJKsQWk6dXYttN36cFSCGMK1OcLi4ymapNMsvDALk07m7swZa4K7f+SMq5UUBbd/GVZu09L9yc8xux8R1pADYIbpUjuCGYYLJGA1Z/PGkegqcmQt9+9cbEMIAiRK7/CTCNT3DqAt8jNn3F8Ha9RYmoVaQXMDwT6oflPYEFaq3qUfjSwAPMQMG0KmaJqFjjsAprSSKDIXQ4iFeNXZX4FCIVS84OPe41pKA7aRYkIPqrUGl2aOweYe14f1Op0gp4nuCERcE5xogjpT5Agrxw0O0wcDFoGjKK4F+BA1rMCeN2Wf3DBmZK1tOMcTlB+b6HIj9NKPdxzE7qDJchX2v1tOO1rWYkuSsbjvIeGP5of9z5Bcu2Eefr1T9l7GIH0N1GdBx/LrqDUgfh6rYb3o4cZIrNY5UkX4fVD9vvQNow61pm1GVmxNLZkyU2VfDZmZOH7W3qMQOvFmnbUmsfEmk2cKhKCWJDTaKKFpb8sE5o1ULZOlMRxjWoJFPiEwBesard0kKuLS3RDXQ/DXVjkMSMqskHJH19gZ/xKdnrf9MhmU0/PKSGgkRMc31hx1i+REEkJ2LUWDUxap2qFGhittrbKNdWN1fvC8WT5D0/ciiwoWQUl9lJjhAk9Q3naT/XADLOw==', 'f5468e36d9cb860ff183ecbee46f7fa8e5c0cac54bf9a6d0f48a712604d1437ff55ebe0d12e4c76502c6a1352ef75ddc5d1ab8d749cb3aea00b7c0a95b0bff94');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategoria`
--

DROP TABLE IF EXISTS `tblcategoria`;
CREATE TABLE IF NOT EXISTS `tblcategoria` (
  `linea_Id` int(5) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci,
  PRIMARY KEY (`linea_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblcategoria`
--

INSERT INTO `tblcategoria` (`linea_Id`, `codigo`, `nombre`, `descripcion`) VALUES
(1, 'elet_001', 'Electronica para el hogar', 'Todo en electronica para los hogares y las personas');

-- --------------------------------------------------------

--
-- Table structure for table `tbldetalle_orden`
--

DROP TABLE IF EXISTS `tbldetalle_orden`;
CREATE TABLE IF NOT EXISTS `tbldetalle_orden` (
  `detalle_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tblorders_order_id` bigint(20) NOT NULL,
  `tblproductos_producto_Id` bigint(20) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `descuento` float DEFAULT NULL,
  PRIMARY KEY (`detalle_id`),
  KEY `fk_table1_tblorders1_idx` (`tblorders_order_id`),
  KEY `fk_table1_tblproductos1_idx` (`tblproductos_producto_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tbldetalle_orden`
--

INSERT INTO `tbldetalle_orden` (`detalle_id`, `tblorders_order_id`, `tblproductos_producto_Id`, `cantidad`, `precio`, `descuento`) VALUES
(1, 3, 3, 1, 250, NULL),
(2, 3, 4, 1, 120, NULL),
(3, 3, 5, 1, 800, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblestado_orden`
--

DROP TABLE IF EXISTS `tblestado_orden`;
CREATE TABLE IF NOT EXISTS `tblestado_orden` (
  `status_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`status_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Tabla para relacionar con las ordenes de compra';

--
-- Dumping data for table `tblestado_orden`
--

INSERT INTO `tblestado_orden` (`status_order_id`, `nombre`) VALUES
(1, 'CREATED'),
(2, 'PAYED'),
(3, 'REJECTED');

-- --------------------------------------------------------

--
-- Table structure for table `tblitems`
--

DROP TABLE IF EXISTS `tblitems`;
CREATE TABLE IF NOT EXISTS `tblitems` (
  `itemsid` int(11) NOT NULL AUTO_INCREMENT,
  `menuid` int(5) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `clase` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`itemsid`),
  KEY `menuid` (`menuid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblitems`
--

INSERT INTO `tblitems` (`itemsid`, `menuid`, `nombre`, `url`, `clase`) VALUES
(1, 2, 'Inicio', 'index', ''),
(2, 2, 'Carrito', 'carrito/listar', ''),
(3, 2, 'Mis Ordenes', 'tienda/listarOrdenes', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblmenu`
--

DROP TABLE IF EXISTS `tblmenu`;
CREATE TABLE IF NOT EXISTS `tblmenu` (
  `menuId` int(5) NOT NULL AUTO_INCREMENT,
  `menu` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `url` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` char(1) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`menuId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblmenu`
--

INSERT INTO `tblmenu` (`menuId`, `menu`, `url`, `estado`) VALUES
(1, 'admin', '', '1'),
(2, 'user', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblordenes`
--

DROP TABLE IF EXISTS `tblordenes`;
CREATE TABLE IF NOT EXISTS `tblordenes` (
  `order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tblstatusorder_status_order_id` int(11) NOT NULL,
  `tblusuarios_id_usuario` bigint(20) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_tblorders_tblstatusorder1_idx` (`tblstatusorder_status_order_id`),
  KEY `fk_tblorders_tblusuarios1_idx` (`tblusuarios_id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Tabla que guarda todas las ordenes creadas por los clientes';

--
-- Dumping data for table `tblordenes`
--

INSERT INTO `tblordenes` (`order_id`, `created_at`, `update_at`, `tblstatusorder_status_order_id`, `tblusuarios_id_usuario`) VALUES
(3, '2020-02-03 23:15:10', '2020-02-03 23:15:10', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tblproductos`
--

DROP TABLE IF EXISTS `tblproductos`;
CREATE TABLE IF NOT EXISTS `tblproductos` (
  `producto_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` float DEFAULT NULL,
  `detalle` text COLLATE utf8_spanish2_ci NOT NULL,
  `flag` char(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `clase` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `linea_Id` int(5) DEFAULT NULL,
  PRIMARY KEY (`producto_Id`),
  KEY `fk_tblproductos_tbllinea1_idx` (`linea_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblproductos`
--

INSERT INTO `tblproductos` (`producto_Id`, `codigo`, `nombre`, `imagen`, `precio`, `detalle`, `flag`, `clase`, `linea_Id`) VALUES
(3, 'htc_001', 'HTC ONE', 'promo-1.png', 250, 'Buy HTC Phones just for $250. Cheap. Dont miss this offer. Keep it checking for more.', '1', 'pbox rcolor', 1),
(4, 'BLACKBERRY_001', 'BLACKBERRY', 'promo-2.png\r\n', 120, 'Buy Blackberry phones just for $250. Dont miss this offer. Keep it checking for more.\r\n\r\n', '1', 'pbox bcolor', 1),
(5, 'lumia_001', 'NOKIA LUMIA', 'promo-3.png', 800, 'Buy Nokia Lumia Phones just for $200. Dont miss offer. Keep it checking for more.\r\n\r\n', '1', 'pbox gcolor', 1),
(6, 'HTC_One_V002', 'HTC One V', '2.png', 140, 'Something about the product goes here. Not More than 2 lines.', '0', '', 1),
(7, 'DellOneV001', 'Dell One V', '3.png', 185, 'Something about the product goes here. Not More than 2 lines.', '0', '', 1),
(8, 'CannonOneV001', 'Cannon One V', '4.png', 245, 'Something about the product goes here. Not More than 2 lines.', '0', '', 1),
(9, 'AppleOneV001', 'Apple One V', '5.png', 210, 'Something about the product goes here. Not More than 2 lines.\r\n\r\n', '0', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblrol`
--

DROP TABLE IF EXISTS `tblrol`;
CREATE TABLE IF NOT EXISTS `tblrol` (
  `rol_Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`rol_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblrol`
--

INSERT INTO `tblrol` (`rol_Id`, `nombre`, `estado`, `fecha`) VALUES
(1, 'admin', '1', '2020-02-01 00:00:00'),
(2, 'user', '1', '2020-02-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblrol_menu`
--

DROP TABLE IF EXISTS `tblrol_menu`;
CREATE TABLE IF NOT EXISTS `tblrol_menu` (
  `rol_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `tblmenu_menuId` int(5) NOT NULL,
  `tblrol_rol_Id` int(11) NOT NULL,
  PRIMARY KEY (`rol_menu_id`),
  KEY `fk_Tblrol?menu_tblmenu1_idx` (`tblmenu_menuId`),
  KEY `fk_Tblrol_menu_tblrol1_idx` (`tblrol_rol_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblrol_menu`
--

INSERT INTO `tblrol_menu` (`rol_menu_id`, `tblmenu_menuId`, `tblrol_rol_Id`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblusuarios`
--

DROP TABLE IF EXISTS `tblusuarios`;
CREATE TABLE IF NOT EXISTS `tblusuarios` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `customer_email` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `customer_mobile` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `rolId` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuarios_tblrol1_idx` (`rolId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tblusuarios`
--

INSERT INTO `tblusuarios` (`id_usuario`, `customer_name`, `customer_email`, `customer_mobile`, `clave`, `rolId`) VALUES
(2, 'Erika Garcia', 'erikagarcia1179@gmail.com', '3128409929', 'P0L1fe703d258c7ef5f50b71e06565a65aa07194907f', 1),
(8, 'Efrain2', 'EFRASOFT@GMAIL.COM', '3174208855', '94490217', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbldetalle_orden`
--
ALTER TABLE `tbldetalle_orden`
  ADD CONSTRAINT `fk_table1_tblorders1` FOREIGN KEY (`tblorders_order_id`) REFERENCES `tblordenes` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_table1_tblproductos1` FOREIGN KEY (`tblproductos_producto_Id`) REFERENCES `tblproductos` (`producto_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblitems`
--
ALTER TABLE `tblitems`
  ADD CONSTRAINT `tblitems_ibfk_1` FOREIGN KEY (`menuid`) REFERENCES `tblmenu` (`menuId`);

--
-- Constraints for table `tblordenes`
--
ALTER TABLE `tblordenes`
  ADD CONSTRAINT `fk_tblorders_tblstatusorder1` FOREIGN KEY (`tblstatusorder_status_order_id`) REFERENCES `tblestado_orden` (`status_order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tblorders_tblusuarios1` FOREIGN KEY (`tblusuarios_id_usuario`) REFERENCES `tblusuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblproductos`
--
ALTER TABLE `tblproductos`
  ADD CONSTRAINT `fk_tblproductos_tbllinea1` FOREIGN KEY (`linea_Id`) REFERENCES `tblcategoria` (`linea_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblrol_menu`
--
ALTER TABLE `tblrol_menu`
  ADD CONSTRAINT `fk_Tblrol?menu_tblmenu1` FOREIGN KEY (`tblmenu_menuId`) REFERENCES `tblmenu` (`menuId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Tblrol_menu_tblrol1` FOREIGN KEY (`tblrol_rol_Id`) REFERENCES `tblrol` (`rol_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblusuarios`
--
ALTER TABLE `tblusuarios`
  ADD CONSTRAINT `fk_usuarios_tblrol1` FOREIGN KEY (`rolId`) REFERENCES `tblrol` (`rol_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
