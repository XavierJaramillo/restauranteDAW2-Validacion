-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2020 a las 18:59:45
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2021_jaramilloxavi`
--
CREATE DATABASE IF NOT EXISTS `2021_jaramilloxavi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `2021_jaramilloxavi`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camareros`
--

CREATE TABLE `camareros` (
  `id_camarero` int(11) NOT NULL,
  `nombre_camarero` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `pass_camarero` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `rol` enum('0','1','2') COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `estado` enum('0','1') COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `camareros`
--

INSERT INTO `camareros` (`id_camarero`, `nombre_camarero`, `pass_camarero`, `rol`, `estado`) VALUES
(1, 'Xavi', '81dc9bdb52d04dc20036dbd8313ed055', '0', '0'),
(2, 'Pepe', '81dc9bdb52d04dc20036dbd8313ed055', '2', '0'),
(3, 'Alberto', '81dc9bdb52d04dc20036dbd8313ed055', '0', '0'),
(4, 'Sergio', '81dc9bdb52d04dc20036dbd8313ed055', '0', '0'),
(5, 'Ronaldiño', '81dc9bdb52d04dc20036dbd8313ed055', '1', '1'),
(13, 'Admin', '21232f297a57a5a743894a0e4a801fc3', '2', '0'),
(14, 'David', '81dc9bdb52d04dc20036dbd8313ed055', '1', '0'),
(17, 'Carlos', '81dc9bdb52d04dc20036dbd8313ed055', '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacio`
--

CREATE TABLE `espacio` (
  `id_espacio` int(11) NOT NULL,
  `tipo_espacio` enum('Terraza','Comedor','VIPs') COLLATE utf8_spanish2_ci NOT NULL,
  `capacidad_mesas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `espacio`
--

INSERT INTO `espacio` (`id_espacio`, `tipo_espacio`, `capacidad_mesas`) VALUES
(1, 'VIPs', 3),
(2, 'Terraza', 11),
(3, 'Comedor', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `capacidad_max` decimal(1,0) NOT NULL,
  `disp_mesa` enum('Disponible','Reparacion') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'Disponible',
  `id_espacio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `capacidad_max`, `disp_mesa`, `id_espacio`) VALUES
(1, '8', 'Disponible', 1),
(2, '8', 'Reparacion', 1),
(3, '8', 'Disponible', 1),
(4, '4', 'Disponible', 2),
(5, '4', 'Reparacion', 2),
(6, '4', 'Disponible', 2),
(7, '4', 'Reparacion', 2),
(8, '4', 'Reparacion', 2),
(9, '4', 'Reparacion', 2),
(10, '4', 'Disponible', 2),
(11, '4', 'Disponible', 2),
(12, '4', 'Disponible', 2),
(13, '4', 'Disponible', 2),
(14, '4', 'Disponible', 2),
(15, '4', 'Reparacion', 3),
(16, '4', 'Reparacion', 3),
(17, '4', 'Disponible', 3),
(18, '4', 'Reparacion', 3),
(19, '4', 'Disponible', 3),
(20, '4', 'Reparacion', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `dia` date NOT NULL,
  `franja` enum('13:00h-14:00h','14:00h-15:00h','21:00h-22:00h','22:00h-23:00h') DEFAULT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `nombre_comensal` varchar(50) NOT NULL,
  `num_comensales` int(2) NOT NULL DEFAULT 0,
  `id_camarero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `dia`, `franja`, `id_mesa`, `nombre_comensal`, `num_comensales`, `id_camarero`) VALUES
(1, '2020-12-14', '13:00h-14:00h', 5, 'Alberto', 2, 1),
(2, '2020-12-14', '14:00h-15:00h', 5, 'Xavi', 2, 1),
(3, '2020-12-14', '13:00h-14:00h', 6, 'Ejemplo', 2, 1),
(4, '2020-12-14', '13:00h-14:00h', 4, 'Prueba', 3, 2),
(5, '2020-12-14', '14:00h-15:00h', 4, 'Prueba2', 2, 2),
(6, '2020-12-14', '21:00h-22:00h', 4, 'Prueba3', 1, 2),
(7, '2020-12-14', '22:00h-23:00h', 4, 'Prueba4', 1, 2),
(8, '2020-12-14', '22:00h-23:00h', 5, 'Vamos', 1, 2),
(16, '2020-12-15', '13:00h-14:00h', 6, 'Verjano', 1, 2),
(18, '2020-12-15', '14:00h-15:00h', 6, 'Carlos', 1, 2),
(19, '2020-12-15', '21:00h-22:00h', 6, 'David', 1, 2),
(20, '2020-12-15', '22:00h-23:00h', 6, 'Dani', 1, 2),
(21, '2020-12-15', '13:00h-14:00h', 10, 'PruebaD', 1, 2),
(26, '2020-12-17', '14:00h-15:00h', 10, 'Buendia', 2, 2),
(32, '2020-12-15', '22:00h-23:00h', 1, 'RealSquad', 4, 4),
(45, '2020-12-16', '13:00h-14:00h', 6, 'adsfasdf', 3, 4),
(46, '2020-12-16', '22:00h-23:00h', 6, 'Pruebaaaaaa', 2, 4),
(47, '2020-12-16', '21:00h-22:00h', 6, 'Prueba', 3, 4),
(49, '2020-12-18', '13:00h-14:00h', 6, 'Ejemplo', 3, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `camareros`
--
ALTER TABLE `camareros`
  ADD PRIMARY KEY (`id_camarero`),
  ADD UNIQUE KEY `nombre_camarero` (`nombre_camarero`);

--
-- Indices de la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD PRIMARY KEY (`id_espacio`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_espacio` (`id_espacio`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD UNIQUE KEY `dia` (`dia`,`franja`,`id_mesa`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_camarero` (`id_camarero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `camareros`
--
ALTER TABLE `camareros`
  MODIFY `id_camarero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_2` FOREIGN KEY (`id_espacio`) REFERENCES `espacio` (`id_espacio`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id_mesa`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`id_camarero`) REFERENCES `camareros` (`id_camarero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;