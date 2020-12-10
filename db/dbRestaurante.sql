-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2020 a las 17:21:58
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2021_jaramilloxavi`
--
CREATE DATABASE 2021_jaramilloxavi;
USE 2021_jaramilloxavi;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camareros`
--

CREATE TABLE `camareros` (
  `id_camarero` int(11) NOT NULL,
  `nombre_camarero` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `pass_camarero` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idMantenimiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `camareros`
--

INSERT INTO `camareros` (`id_camarero`, `nombre_camarero`, `pass_camarero`, `idMantenimiento`) VALUES
(1, 'Xavier', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(2, 'Sergio', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(3, 'Judit', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(4, 'Marc', '81dc9bdb52d04dc20036dbd8313ed055', 1),
(7, 'Pepe', '81dc9bdb52d04dc20036dbd8313ed055', 2);

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
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `hora_entrada` datetime NOT NULL,
  `hora_salida` datetime NOT NULL,
  `id_mesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `idMantenimiento` int(11) NOT NULL,
  `numMante` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`idMantenimiento`, `numMante`) VALUES
(1, '00001'),
(2, '00002');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `capacidad_mesa` decimal(1,0) DEFAULT NULL,
  `capacidad_max` decimal(1,0) NOT NULL,
  `disp_mesa` enum('Libre','Ocupada','Reparacion') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'Libre',
  `id_camarero` int(11) DEFAULT NULL,
  `id_espacio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `capacidad_mesa`, `capacidad_max`, `disp_mesa`, `id_camarero`, `id_espacio`) VALUES
(1, '0', '8', 'Libre', NULL, 1),
(2, '0', '8', 'Libre', NULL, 1),
(3, '0', '8', 'Libre', NULL, 1),
(4, '0', '4', 'Libre', NULL, 2),
(5, '0', '4', 'Libre', NULL, 2),
(6, '0', '4', 'Libre', NULL, 2),
(7, '0', '4', 'Libre', NULL, 2),
(8, '0', '4', 'Libre', NULL, 2),
(9, '0', '4', 'Libre', NULL, 2),
(10, '0', '4', 'Libre', NULL, 2),
(11, '0', '4', 'Libre', NULL, 2),
(12, '0', '4', 'Libre', NULL, 2),
(13, '0', '4', 'Libre', NULL, 2),
(14, '0', '4', 'Libre', NULL, 2),
(15, '0', '4', 'Libre', NULL, 3),
(16, '0', '4', 'Libre', NULL, 3),
(17, '0', '4', 'Libre', NULL, 3),
(18, '0', '4', 'Libre', NULL, 3),
(19, '0', '4', 'Libre', NULL, 3),
(20, '0', '4', 'Libre', NULL, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `camareros`
--
ALTER TABLE `camareros`
  ADD PRIMARY KEY (`id_camarero`),
  ADD KEY `fkmantenimiento` (`idMantenimiento`);

--
-- Indices de la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD PRIMARY KEY (`id_espacio`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`idMantenimiento`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_camarero` (`id_camarero`),
  ADD KEY `id_espacio` (`id_espacio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `camareros`
--
ALTER TABLE `camareros`
  MODIFY `id_camarero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `espacio`
--
ALTER TABLE `espacio`
  MODIFY `id_espacio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camareros`
--
ALTER TABLE `camareros`
  ADD CONSTRAINT `fkmantenimiento` FOREIGN KEY (`idMantenimiento`) REFERENCES `mantenimiento` (`idMantenimiento`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `FK_HORARIO_MESA` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id_mesa`);

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_2` FOREIGN KEY (`id_espacio`) REFERENCES `espacio` (`id_espacio`),
  ADD CONSTRAINT `mesas_ibfk_3` FOREIGN KEY (`id_camarero`) REFERENCES `camareros` (`id_camarero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
