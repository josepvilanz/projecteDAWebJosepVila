-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2025 a las 11:57:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacte`
--

CREATE TABLE `contacte` (
  `idContacte` int(11) NOT NULL,
  `missatge` varchar(45) DEFAULT NULL,
  `nomUsuari` varchar(45) DEFAULT NULL,
  `correoUsuari` varchar(45) DEFAULT NULL,
  `Edat` varchar(45) DEFAULT NULL,
  `dataNaixement` varchar(45) DEFAULT NULL,
  `colorFavorit` varchar(45) DEFAULT NULL,
  `n_telefon` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfilpropi`
--

CREATE TABLE `perfilpropi` (
  `idPerfilpropi` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `Usuari_idUsuari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `perfilpropi`
--

INSERT INTO `perfilpropi` (`idPerfilpropi`, `nom`, `Usuari_idUsuari`) VALUES
(50, 'prova proves correctes', 55),
(51, 'Projecte DAW Fet', 56);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuari`
--

CREATE TABLE `usuari` (
  `idUsuari` int(11) NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `contrasenya` varchar(255) NOT NULL,
  `n_telefon` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `Videojocs_idVideojocs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuari`
--

INSERT INTO `usuari` (`idUsuari`, `login`, `contrasenya`, `n_telefon`, `email`, `Videojocs_idVideojocs`) VALUES
(55, 'prova', '$2y$10$QT1PkevdHBqo.1L6zH4kPOquYYr0iE50.Ug8gXm0dQJ5TBaoEaF86', '676356140', 'prova@gmail.com', 0),
(56, 'Projecte', '$2y$10$ObLrw5xIBHu.1Z.0T8spg.m5Tw8OZk61QeVKEl4qION6z6MK2AH7q', '676356143', 'projecte@gmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojocs`
--

CREATE TABLE `videojocs` (
  `idVideojocs` int(11) NOT NULL,
  `informacio` varchar(45) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contacte`
--
ALTER TABLE `contacte`
  ADD PRIMARY KEY (`idContacte`);

--
-- Indices de la tabla `perfilpropi`
--
ALTER TABLE `perfilpropi`
  ADD PRIMARY KEY (`idPerfilpropi`),
  ADD KEY `fk_Perfilpropi_Usuari_idx` (`Usuari_idUsuari`);

--
-- Indices de la tabla `usuari`
--
ALTER TABLE `usuari`
  ADD PRIMARY KEY (`idUsuari`),
  ADD KEY `fk_Usuari_Videojocs_idx` (`Videojocs_idVideojocs`);

--
-- Indices de la tabla `videojocs`
--
ALTER TABLE `videojocs`
  ADD PRIMARY KEY (`idVideojocs`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `perfilpropi`
--
ALTER TABLE `perfilpropi`
  MODIFY `idPerfilpropi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `usuari`
--
ALTER TABLE `usuari`
  MODIFY `idUsuari` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `perfilpropi`
--
ALTER TABLE `perfilpropi`
  ADD CONSTRAINT `fk_Perfilpropi_Usuari` FOREIGN KEY (`Usuari_idUsuari`) REFERENCES `usuari` (`idUsuari`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
