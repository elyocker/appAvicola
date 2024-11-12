-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.24-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para avicola
CREATE DATABASE IF NOT EXISTS `avicola` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `avicola`;

-- Volcando estructura para tabla avicola.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `cli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_nombre` varchar(200) DEFAULT NULL,
  `cli_cedula` varchar(200) DEFAULT NULL,
  `cli_telefono` varchar(200) DEFAULT NULL,
  `cli_email` varchar(200) DEFAULT NULL,
  `cli_depart` varchar(200) DEFAULT NULL,
  `cli_ciudad` varchar(200) DEFAULT NULL,
  `cli_direccion` varchar(200) DEFAULT NULL,
  `cli_barrio` varchar(200) DEFAULT NULL,
  `cli_estado` varchar(1) DEFAULT NULL,
  `cli_fechac` date DEFAULT NULL,
  `cli_horac` time DEFAULT NULL,
  `cli_usuac` varchar(50) DEFAULT NULL,
  `cli_usuam` varchar(50) DEFAULT NULL,
  `cli_fecham` date DEFAULT NULL,
  `cli_horam` time DEFAULT NULL,
  PRIMARY KEY (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla avicola.cliente: ~0 rows (aproximadamente)

-- Volcando estructura para tabla avicola.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `men_id` int(11) NOT NULL AUTO_INCREMENT,
  `men_menu` varchar(100) DEFAULT NULL,
  `men_submen` varchar(999) DEFAULT NULL,
  `men_menurl` varchar(100) DEFAULT NULL,
  `men_suburl` varchar(999) DEFAULT NULL,
  `men_estado` int(1) DEFAULT NULL,
  PRIMARY KEY (`men_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla avicola.menu: ~4 rows (aproximadamente)
INSERT IGNORE INTO `menu` (`men_id`, `men_menu`, `men_submen`, `men_menurl`, `men_suburl`, `men_estado`) VALUES
	(6, 'Inicio', NULL, 'inicio', NULL, 1),
	(7, 'Modulos', 'usuarios,clientes,roles,productos,control,inventario,proveedores', NULL, 'usuarios,clientes,roles,productos,control,inventario,proveedores', 1),
	(8, NULL, NULL, 'salir', NULL, 1),
	(9, 'Informes', 'ventas', NULL, 'ventas', 1);

-- Volcando estructura para tabla avicola.municipios
CREATE TABLE IF NOT EXISTS `municipios` (
  `id_municipio` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `municipio` varchar(255) NOT NULL DEFAULT '',
  `estado` int(1) unsigned NOT NULL,
  `departamento_id` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `departamento_id` (`departamento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1101 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla avicola.municipios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla avicola.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(50) DEFAULT NULL,
  `rol_fechac` date DEFAULT NULL,
  `rol_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla avicola.roles: ~5 rows (aproximadamente)
INSERT IGNORE INTO `roles` (`rol_id`, `rol_nombre`, `rol_fechac`, `rol_estado`) VALUES
	(1, 'admin', '2022-06-09', 1),
	(11, 'dibujante', '2022-06-09', 1),
	(12, 'servicios generales', NULL, 1),
	(13, 'Contador', NULL, 1),
	(14, 'cafeteria', NULL, 1);

-- Volcando estructura para tabla avicola.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `usu_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usu_cuenta` varchar(1000) DEFAULT NULL,
  `usu_pass` varchar(1000) DEFAULT NULL,
  `usu_nombre` varchar(1000) DEFAULT NULL,
  `usu_apellido` varchar(1000) DEFAULT NULL,
  `usu_telefono` varchar(50) DEFAULT NULL,
  `usu_email` varchar(1000) DEFAULT NULL,
  `usu_foto` varchar(1000) DEFAULT NULL,
  `usu_rol` int(11) DEFAULT NULL,
  `usu_estado` varchar(1) DEFAULT NULL,
  `usu_fechac` date DEFAULT NULL,
  `usu_ultmlog` datetime DEFAULT NULL,
  `usu_horac` time DEFAULT NULL,
  `usu_fecham` date DEFAULT NULL,
  `usu_horam` time DEFAULT NULL,
  `usu_ipcone` varchar(200) DEFAULT NULL,
  `usu_paiscone` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`usu_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla avicola.usuario: ~1 rows (aproximadamente)
INSERT IGNORE INTO `usuario` (`usu_codigo`, `usu_cuenta`, `usu_pass`, `usu_nombre`, `usu_apellido`, `usu_telefono`, `usu_email`, `usu_foto`, `usu_rol`, `usu_estado`, `usu_fechac`, `usu_ultmlog`, `usu_horac`, `usu_fecham`, `usu_horam`, `usu_ipcone`, `usu_paiscone`) VALUES
	(35, 'admin', '$2y$10$kw3qNlu/WEi.Q6Mr/TjK8OaqG8DtNkeKP0D.VSmJwm9vVebehmPEW', 'administrador', '', '74587999', 'admin@gmail.com', 'img/usuarios/admin/admin.png', 1, '1', '2022-07-31', '2024-11-12 17:29:04', '14:47:37', NULL, NULL, NULL, NULL),
	(36, 'prueba', '$2y$10$qkiM7eJ9nJbdEZmQT6h1GO2tKjyoMmI.AR.kHCXG7PKHjIFy0AN0O', 'PRUEBA1', 'PRUEBA', '3187401935', 'juanpavale99@gmail.com', 'img/usuarios/prueba/prueba.jpg', 1, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
