-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-06-2026 a las 04:17:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Gestion_ecotaxisverde`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_estatus`
--

CREATE TABLE `pago_estatus` (
  `pago_id` int(7) NOT NULL,
  `taxi_id` int(7) NOT NULL,
  `año_fiscal` int(4) NOT NULL,
  `pago_referendo` enum('Pagado','Pendiente') NOT NULL DEFAULT 'Pendiente',
  `pago_impuestos` enum('Pagado','Pendiente') NOT NULL DEFAULT 'Pendiente',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisionario`
--

CREATE TABLE `permisionario` (
  `permisionario_id` int(7) NOT NULL,
  `permisionario_nombre` varchar(100) NOT NULL,
  `permisionario_rfc` varchar(13) NOT NULL,
  `permisionario_telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taxi`
--

CREATE TABLE `taxi` (
  `taxi_id` int(7) NOT NULL,
  `taxi_numero_economico` int(5) NOT NULL,
  `taxi_placa` varchar(10) NOT NULL,
  `taxi_modelo` varchar(30) NOT NULL,
  `taxi_año` int(4) NOT NULL,
  `taxi_permiso` varchar(20) NOT NULL,
  `permisionario_id` int(7) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(40) NOT NULL,
  `usuario_apellido` varchar(20) NOT NULL,
  `usuario_usuario` varchar(200) NOT NULL,
  `usuario_email` varchar(70) NOT NULL,
  `usuario_clave` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pago_estatus`
--
ALTER TABLE `pago_estatus`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `taxi_id` (`taxi_id`);

--
-- Indices de la tabla `permisionario`
--
ALTER TABLE `permisionario`
  ADD PRIMARY KEY (`permisionario_id`);

--
-- Indices de la tabla `taxi`
--
ALTER TABLE `taxi`
  ADD PRIMARY KEY (`taxi_id`),
  ADD UNIQUE KEY `taxi_numero_economico` (`taxi_numero_economico`),
  ADD UNIQUE KEY `taxi_placa` (`taxi_placa`),
  ADD KEY `permisionario_id` (`permisionario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pago_estatus`
--
ALTER TABLE `pago_estatus`
  MODIFY `pago_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisionario`
--
ALTER TABLE `permisionario`
  MODIFY `permisionario_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `taxi`
--
ALTER TABLE `taxi`
  MODIFY `taxi_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pago_estatus`
--
ALTER TABLE `pago_estatus`
  ADD CONSTRAINT `fk_pago_taxi` FOREIGN KEY (`taxi_id`) REFERENCES `taxi` (`taxi_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `taxi`
--
ALTER TABLE `taxi`
  ADD CONSTRAINT `fk_taxi_permisionario` FOREIGN KEY (`permisionario_id`) REFERENCES `permisionario` (`permisionario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_taxi_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
