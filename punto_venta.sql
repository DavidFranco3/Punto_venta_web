-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-05-2021 a las 12:31:31
-- Versión del servidor: 8.0.25-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `punto_venta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int NOT NULL,
  `codigo_barras` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cantidad` int NOT NULL DEFAULT '0',
  `precio_venta` double NOT NULL,
  `fecha_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_barras`, `descripcion`, `cantidad`, `precio_venta`, `fecha_modificacion`) VALUES
(1, '994948484848', 'Cheetos', 19, 10, '2021-05-10 13:36:45'),
(2, '738383939939', 'Sabritas', 29, 13, '2021-05-10 17:47:11'),
(4, '000123456789', 'Doritos', 22, 12, '2021-05-04 19:33:33'),
(5, '888888888888', 'Jabon', 20, 16, '2021-05-04 19:35:57'),
(6, '738393363783', 'Cacahuates', 23, 13, '2021-05-04 19:34:58'),
(11, '111111111111', 'Jabon', 7, 25, '2021-05-24 11:08:49'),
(12, '222222222222', 'pepsi', 10, 15, '2021-05-24 11:09:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `fecha_venta`, `total`) VALUES
(1, '2021-05-04 19:29:06', 100),
(2, '2021-05-04 19:33:39', 13),
(5, '2021-05-05 12:12:36', 11),
(9, '2021-05-10 17:16:14', 0),
(10, '2021-05-10 17:30:37', 62),
(11, '2021-05-24 11:10:06', 75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE `venta_detalle` (
  `id` int NOT NULL,
  `venta` int NOT NULL,
  `producto` int NOT NULL,
  `cantidad` double NOT NULL,
  `precio_venta` double NOT NULL,
  `total` double NOT NULL,
  `fecha_modificacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `venta_detalle`
--

INSERT INTO `venta_detalle` (`id`, `venta`, `producto`, `cantidad`, `precio_venta`, `total`, `fecha_modificacion`) VALUES
(1, 1, 1, 10, 10, 100, '2021-05-04 19:29:19'),
(2, 2, 2, 1, 13, 13, '2021-05-04 19:38:01'),
(4, 5, 1, 1, 11, 11, '2021-05-05 13:44:31'),
(8, 10, 2, 2, 13, 26, '2021-05-10 17:49:33'),
(9, 10, 4, 2, 12, 24, '2021-05-10 17:46:55'),
(11, 11, 11, 3, 25, 75, '2021-05-24 11:10:23');

--
-- Disparadores `venta_detalle`
--
DELIMITER $$
CREATE TRIGGER `aumentar_producto_eliminar` BEFORE DELETE ON `venta_detalle` FOR EACH ROW UPDATE productos SET cantidad = cantidad + OLD.cantidad WHERE id_producto = OLD.producto
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `aumentar_reducir_producto_modificar` BEFORE UPDATE ON `venta_detalle` FOR EACH ROW UPDATE productos SET cantidad = cantidad + (OLD.cantidad - NEW.cantidad)  WHERE id_producto = NEW.producto
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcular_total_venta_eliminar` BEFORE DELETE ON `venta_detalle` FOR EACH ROW UPDATE venta SET total = total - OLD.cantidad * OLD.precio_venta WHERE id_venta = OLD.venta
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcular_total_venta_insertar` BEFORE INSERT ON `venta_detalle` FOR EACH ROW UPDATE venta SET total =  total + NEW.cantidad * NEW.precio_venta WHERE id_venta = NEW.venta
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcular_total_venta_modificar` BEFORE UPDATE ON `venta_detalle` FOR EACH ROW UPDATE venta SET total = total + (NEW.cantidad - OLD.cantidad) * NEW.precio_venta WHERE id_venta = NEW.venta
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reducir_producto_insertar` BEFORE INSERT ON `venta_detalle` FOR EACH ROW UPDATE productos SET cantidad = cantidad-1 WHERE id_producto = NEW.producto
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigoDeBarras` (`codigo_barras`) USING BTREE;

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `venta_2` (`venta`,`producto`),
  ADD KEY `venta` (`venta`),
  ADD KEY `producto` (`producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD CONSTRAINT `venta_detalle_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_detalle_ibfk_2` FOREIGN KEY (`venta`) REFERENCES `venta` (`id_venta`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
