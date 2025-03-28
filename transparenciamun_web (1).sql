-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2025 a las 22:57:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `transparenciamun_web2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `annos`
--

CREATE TABLE `annos` (
  `id` int(10) UNSIGNED NOT NULL,
  `anno` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `annos`
--

INSERT INTO `annos` (`id`, `anno`) VALUES
(1, '2024'),
(2, '2025');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo` char(2) NOT NULL,
  `anno` char(4) NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `tipo`, `anno`, `numero`, `fecha`, `descripcion`) VALUES
(5, 'RA', '2024', 1, '2024-12-17', 'Descripción por defecto'),
(6, 'RA', '2025', 12, '2025-01-13', 'Descripción por defecto'),
(7, 'RA', '2025', 2, '2025-01-13', 'Descripción por defecto'),
(8, 'RA', '2025', 3, '2025-01-14', 'Descripción por defecto'),
(9, 'RA', '2024', 4, '2024-12-17', 'Descripción por defecto'),
(10, 'RA', '2024', 5, '2024-12-17', 'Descripción por defecto'),
(11, 'RA', '2024', 6, '2024-12-17', 'Descripción por defecto'),
(12, 'OM', '2025', 7, '2025-01-15', 'Descripción por defecto'),
(13, 'RA', '2025', 16, '2025-01-16', 'Descripción por defecto'),
(14, 'RG', '2024', 8, '2024-12-17', 'Descripción por defecto'),
(15, 'RG', '2025', 14, '2025-01-11', 'Descripción por defecto'),
(16, 'RA', '2024', 17, '2025-02-01', 'Descripción por defecto'),
(17, 'RA', '2025', 18, '2025-02-18', 'PRUEBA'),
(18, 'RG', '2024', 1079, '2025-02-21', 'DESIGNAR, AL COMITÉ DE RECEPCIÓN DE LA OBRA'),
(19, 'AC', '2025', 19, '2025-02-21', 'prueba 2'),
(21, 'RA', '2025', 19, '2025-03-17', 'qweasds'),
(37, 'OM', '2025', 322, '2025-03-20', 'autorizar prueba 2'),
(40, 'RA', '2025', 322, '2025-03-20', 'autorizar prueba 2'),
(41, 'AA', '2024', 322, '2025-03-20', 'modificación 12:27');

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
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id`, `documento_id`, `accion`, `fecha`, `descripcion`, `link`) VALUES
(1, 6, 'Actualización de datos', '2025-01-13', 'Corrección de fecha', '../uploads/S17_s2.pdf'),
(2, 7, 'Modificación', '2025-01-13', 'Cambio de descripción', '../uploads/Carta.pdf'),
(3, 8, 'Edición', '2025-01-14', 'Actualización de archivo', '../uploads/S15_s1.pdf'),
(4, 16, 'Subida', '2025-02-01', 'aaaa probrando', '../uploads/S18. Informe SIDERPERU-DIAE.pdf'),
(5, 17, 'Subida', '2025-02-18', 'Articulos de papeleria 2', '../uploads/RA/Paleta de colores.pdf'),
(6, 18, 'Subida', '2025-02-21', 'DESIGNAR, AL COMITÉ DE RECEPCIÓN DE LA OBRA', '../uploads/RG/Paleta de colores.pdf'),
(7, 19, 'Subida', '2025-02-21', 'prueba 2', '../uploads/AC/Paleta de colores (1).pdf'),
(21, 37, 'Subida', '2025-03-20', 'autorizar prueba 2', 'uploads/OM/2025/3.pdf'),
(24, 40, 'Subida', '2025-03-20', 'autorizar prueba 2', 'uploads/RA/2025/3.pdf'),
(25, 41, 'Subida', '2025-03-20', 'autorizar prueba 2', 'uploads/AA/2025/3.pdf'),
(26, 41, 'Actualización', '2025-03-20', 'modificación 12:27', 'uploads/AA/2024/67dc569417101.pdf'),
(27, 41, 'Actualización', '2025-03-20', 'modificación 12:27', 'uploads/AA/2024/AA-322-2024.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` char(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `prefijo` char(2) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `codigo`, `nombre`, `prefijo`, `estado`) VALUES
(1, '', 'RESOLUCIONES DE ALCALDIA', 'RA', 'activo'),
(2, '', 'ORDENANZA MUNICIPAL', 'OM', 'activo'),
(3, '', 'DECRETOS ALCALDIA', 'DA', 'activo'),
(4, '', 'ACUERDOS CONSEJO', 'AC', 'activo'),
(5, '', 'RESOLUCIONES GERENCIALES', 'RG', 'activo'),
(8, '10', 'Prueba', 'PR', 'inactivo'),
(14, '2', 'AAra', 'AA', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(1, 'admin', 'adminpassword'),
(2, 'usuario1', 'password123'),
(3, 'Isaac', '12345'),
(6, 'Isaac2', '12345'),
(11, 'Isaac3', '1345'),
(12, 'Isaac4', '12345'),
(13, 'Isaac5', '12345');

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
  ADD KEY `tipo` (`tipo`),
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipos` (`prefijo`) ON DELETE CASCADE ON UPDATE CASCADE,
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
