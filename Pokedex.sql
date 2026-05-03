-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 03-05-2026 a las 08:54:06
-- Versión del servidor: 9.6.0
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Pokedex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenadores`
--

CREATE TABLE `entrenadores` (
  `id` int NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `es_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `entrenadores`
--

INSERT INTO `entrenadores` (`id`, `usuario`, `password`, `es_admin`) VALUES
(1, 'adrian', '$2y$10$6/Prok4rZGRRANOgNEEWyusn.2yyjyx1fHTOAldOaih1/lTjSTuh2', 0),
(2, 'admin', '$2y$10$9MZB8ehJYD/TU0uX8E12kO4qR9PVN1xQ5uvxV2XBocMJfvGorsd62', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemon`
--

CREATE TABLE `pokemon` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo1` varchar(20) NOT NULL,
  `tipo2` varchar(20) DEFAULT NULL,
  `hp` int DEFAULT NULL,
  `ataque` int DEFAULT NULL,
  `defensa` int DEFAULT NULL,
  `ataque_esp` int DEFAULT NULL,
  `defensa_esp` int DEFAULT NULL,
  `velocidad` int DEFAULT NULL,
  `rareza` varchar(20) DEFAULT NULL,
  `shiny` tinyint(1) DEFAULT NULL,
  `entrenador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pokemon`
--

INSERT INTO `pokemon` (`id`, `nombre`, `tipo1`, `tipo2`, `hp`, `ataque`, `defensa`, `ataque_esp`, `defensa_esp`, `velocidad`, `rareza`, `shiny`, `entrenador_id`) VALUES
(4, 'Percan', 'Hielo', NULL, 86, 88, 108, 84, 103, 81, 'PseudoLegendario', 0, 1),
(10, 'Kity Kity', 'Fuego', 'Veneno', 120, 80, 90, 150, 130, 110, 'Legendario', 1, 1),
(11, 'Turi Malote', 'Fantasma', 'Siniestro', 80, 70, 70, 145, 120, 135, 'Legendario', 1, 1),
(12, 'Pedro Sanchez', 'Electrico', 'Psiquico', 101, 98, 149, 108, 137, 107, 'Legendario', 0, 1),
(13, 'Pau', 'Fuego', 'Tierra', 82, 71, 75, 68, 56, 48, 'Comun', 0, 2),
(14, 'Gaya', 'Fantasma', NULL, 79, 65, 76, 63, 58, 59, 'Comun', 0, 1),
(15, 'Marcos', 'Lucha', 'Normal', 64, 72, 76, 66, 64, 58, 'Comun', 0, 1),
(17, 'Nsere', 'Acero', 'Tierra', 92, 66, 59, 48, 59, 76, 'Comun', 0, 1),
(19, 'Kurk Cobain', 'Fantasma', 'Normal', 65, 69, 49, 72, 62, 83, 'Comun', 0, 2),
(23, 'Emopet', 'Bicho', 'Tierra', 99, 93, 86, 96, 101, 75, 'PseudoLegendario', 0, 2),
(24, 'Pepito', 'Normal', NULL, 58, 59, 52, 82, 77, 72, 'Comun', 0, 2),
(25, 'Faraon', 'Psiquico', NULL, 68, 57, 66, 72, 80, 57, 'Comun', 0, 2),

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entrenador` (`entrenador_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pokemon`
--
ALTER TABLE `pokemon`
  ADD CONSTRAINT `fk_entrenador` FOREIGN KEY (`entrenador_id`) REFERENCES `entrenadores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
