-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2025 a las 16:00:40
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
-- Base de datos: `transparenciamun_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `annos`
--

CREATE TABLE `annos` (
  `id` int(10) UNSIGNED NOT NULL,
  `anno` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `annos`
--

INSERT INTO `annos` (`id`, `anno`) VALUES
(1, '0000-00-00'),
(6, '2024-12-17'),
(7, '2025-01-11'),
(2, '2025-01-13'),
(3, '2025-01-14'),
(4, '2025-01-15'),
(5, '2025-01-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipos` char(4) NOT NULL,
  `anno` date NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `anio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `tipos`, `anno`, `numero`, `descripcion`, `link`, `anio`) VALUES
(5, 'RA', '0000-00-00', 1, 'P', '../uploads/Carta para prácticas pre empresa pública.pdf', NULL),
(6, 'RA', '2025-01-13', 12, 'Articulos de papeleria', '../uploads/S17_s2.pdf', 2025),
(7, 'RA', '2025-01-13', 2, 'delegar', '../uploads/Carta para prácticas pre empresa pública.pdf', 2025),
(8, 'RA', '2025-01-14', 3, 'autorizar', '../uploads/S15_s1.pdf', 2025),
(9, 'RA', '0000-00-00', 4, 'autorizar2', '../uploads/S15_s2.pdf', NULL),
(10, 'RA', '0000-00-00', 5, 'Articulos de papeleria2', '../uploads/iiii.pdf', NULL),
(11, 'RA', '0000-00-00', 6, 'Articulos de papeleria3', '../uploads/aaaa.pdf', NULL),
(12, 'OM', '2025-01-15', 6, 'autorizar3', '../uploads/S17_s1 - Material.pdf', 2025),
(13, 'RA', '2025-01-16', 16, 'PRORROGAR LA ENCARGATURA DEL PUESTO DE AUXILIAR COACTIVO DE LA GERENCIA DE EJECUTORIA', '../uploads/RA_16_2025_MDNCH.pdf', 2025),
(14, 'RG', '2024-12-17', 1061, 'APROBAR, EL PLAN DE TRABAJO:\"ECO DORADO FEST 2025\", POR EL MONTO ASCENDENTE', '../uploads/1061.pdf', 2024),
(15, 'RG', '2025-01-11', 14, 'APROBAR, EL PLAN DE TRABAJO: \"SERVICIO DE CONSULTORIO EN NUTRICION DIRIGIDO A BENEFICIARIOS DEL PROGRAMA VASO DE LECHE\"', '../uploads/20250113_014.pdf', 2025);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id` int(10) UNSIGNED NOT NULL,
  `documento_id` int(10) UNSIGNED NOT NULL,
  `accion` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` char(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `prefijo` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `codigo`, `nombre`, `prefijo`) VALUES
(1, '', 'RESOLUCIONES DE ALCALDIA', 'RA'),
(2, '', 'ORDENANZA MUNICIPAL', 'OM'),
(3, '', 'DECRETOS ALCALDIA', 'DA'),
(4, '', 'ACUERDOS CONSEJO', 'AC'),
(5, '', 'RESOLUCIONES GERENCIALES', 'RG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `annos`
--
ALTER TABLE `annos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anno` (`anno`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo` (`tipos`),
  ADD KEY `anno` (`anno`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documento_id` (`documento_id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prefijo` (`prefijo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `annos`
--
ALTER TABLE `annos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`tipos`) REFERENCES `tipos` (`prefijo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documentos_ibfk_2` FOREIGN KEY (`anno`) REFERENCES `annos` (`anno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;