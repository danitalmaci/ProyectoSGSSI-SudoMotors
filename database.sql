-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-09-2020 a las 16:37:17
-- Versión del servidor: 10.5.5-MariaDB-1:10.5.5+maria~focal
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `USUARIO` (
  `DNI` varchar(10) NOT NULL UNIQUE,
  `NOMBRE` text NOT NULL,
  `APELLIDOS` text NOT NULL,
  `TELEFONO` int(9) NOT NULL UNIQUE,
  `EMAIL` text NOT NULL UNIQUE,
  `F_NACIMIENTO` date NOT NULL,
  `CONTRASENA` varchar(255) NOT NULL,
  `USERNAME` text NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `USUARIO` (`DNI`, `NOMBRE`, `APELLIDOS`, `TELEFONO`, `EMAIL`, `F_NACIMIENTO`, `CONTRASENA`, `USERNAME`) VALUES
('12345678Z', 'Aitor', 'Jimenez Jimenez', '668252000', 'aitorji@gmail.com', '2002/10/12', 'RonCola300', 'aitorjiji');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `VEHICULO` (
  `MATRICULA` varchar(8) NOT NULL UNIQUE,
  `MARCA` text NOT NULL,
  `MODELO` text NOT NULL,
  `ANO` int(4) NOT NULL,
  `KMS` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `VEHICULO` (`MATRICULA`, `MARCA`, `MODELO`, `ANO`, `KMS`) VALUES
('7777 XDD', 'Kia', 'Sportage', '2018', '205623');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `VEHICULO`
  ADD PRIMARY KEY (`MATRICULA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
