-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2020 a las 00:44:52
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `behealthy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `idpersona` int(10) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `genero` varchar(200) NOT NULL,
  `nacimiento` date NOT NULL,
  `estatura` int(3) NOT NULL,
  `pesodeseado` float NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idpersona`, `nombre`, `apellido`, `genero`, `nacimiento`, `estatura`, `pesodeseado`, `usuario`, `clave`) VALUES
(1, 'Nicolás', 'Martínez', 'Masculino', '1986-04-15', 170, 65, 'nmartinez', '$2y$10$JWcrdO1/7OkVoleZbS9KseMNOWXHBCdKgY23Ruc0.gg4CmBTPVA0S'),
(3, 'Juan', 'Marquez', 'Masculino', '1900-02-01', 171, 75.5, 'jmarquez', '$2y$10$yvBhF.IHR.q.80Gh7DzDguxTXvAaMxeustiGCVN5VIF1KqzoLpGOy'),
(4, 'Matías', 'Carenzo', 'Masculino', '1987-02-01', 171, 72.5, 'mcarenzo', '$2y$10$M5yDsiYkjBMbzI/Wsdxvh.TLVZMJh34eyaBoQndYnLxxfQA6vPury');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `idregistro` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `peso` float NOT NULL,
  `idpersona` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`idregistro`, `fecha`, `peso`, `idpersona`) VALUES
(1, '2020-09-01', 80, 1),
(2, '2020-09-04', 77, 1),
(3, '2020-10-01', 80, 1),
(4, '2020-10-06', 77.5, 1),
(143, '2020-10-24', 71, 4),
(144, '2020-10-25', 70, 4),
(175, '2020-10-28', 65, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`idregistro`),
  ADD KEY `idpersona` (`idpersona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idpersona` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `idregistro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
