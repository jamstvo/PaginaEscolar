-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2025 a las 18:13:44
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
-- Base de datos: `agenda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `creado_el` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `nombre`, `apellido`, `email`, `telefono`, `password`, `creado_el`) VALUES
(1, 'Jams', 'Guadalupe', 'Ceballos', 'seshatxd@gmail.com', '6131244026', '$2y$10$2lz.ljxiW/lHEYAO898mzeqBcT324/O7jVz6k52BWSEYqoKUhFMGe', '2025-11-15 01:37:34'),
(2, 'jdoe', 'John', 'Doe', 'jdoe78@gmail.com', '6678291403', '$2y$10$LeqYsA0sI4VkO9WoD8J.5..DFFw0xvu7iBOx1rZjWJXBFBo5jE0Ma', '2025-11-15 03:01:22'),
(3, 'janeD', 'Jane', 'Doe', 'jd78@gmail.com', '6158965471', '$2y$10$i.5JTEC1E8au6wFb2umZ5ujzq9dU/fxgajLp6mwjvvWZ3r62uluiO', '2025-11-15 03:02:20'),
(4, 'Juancho', 'Juan', 'Dedos', 'deditos@gmail.com', '6862045198', '$2y$10$R4slMlgWbNTN/Izu9UBiUuFrFZ0.FnojJiepfd396USDTkp8A0qPy', '2025-11-15 03:03:26'),
(5, 'Juanita', 'Juana', 'Dedos', 'jiji@gmail.com', '2147483647', '$2y$10$NRl0d6NNOWtCgNtLowQe8.78cEh1JewwCZ0U5hTBW.p4Gslj8JCDm', '2025-11-15 03:04:15'),
(7, 'Jester', 'Jorge', 'Jijolin', 'idk@gmail.com', '5589127345', '$2y$10$YY0Iy.ZcWThc.Mie/.SdcuAXwe78DQ7Y/ztQD1Pisku5J7OqLl9Bi', '2025-11-15 13:55:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_unique` (`usuario`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
