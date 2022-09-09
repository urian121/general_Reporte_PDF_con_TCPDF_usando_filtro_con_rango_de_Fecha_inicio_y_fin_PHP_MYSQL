-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2022 a las 04:29:41
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ejemplo_youtube`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `sueldo` varchar(50) DEFAULT NULL,
  `fecha_ingreso` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`id`, `nombre`, `apellido`, `email`, `telefono`, `sueldo`, `fecha_ingreso`) VALUES
(1, 'Urian', 'Viera', 'programadorphp2017@gmail.com', '123', '5000000', '2022-06-10'),
(2, 'Andres', 'Host', 'andres@gmail.com', '456', '350000', '2022-06-15'),
(3, 'Brenda', 'Viera', 'brenda@gmail.com', '365', '450000', '2022-07-20'),
(4, 'Luis', 'Benz', 'luis@gmail.com', '799', '360000', '2022-07-30'),
(5, 'Genessi', 'Aleman', 'genessi@gmail.com', '741', '2500000', '2022-08-05'),
(6, 'Alex', 'Gomez', 'alex@gmail.com', '842', '420000', '2022-08-12'),
(7, 'Humberto', 'Ter', 'humberto@gmail.com', '45215', '1900000', '2022-08-13'),
(8, 'Paula', 'Jara', 'paula@gmail.com', '8521', '3100000', '2022-08-25');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
