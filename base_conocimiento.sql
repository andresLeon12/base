-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2015 a las 01:56:34
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_conocimiento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `idActividad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `Fase_idFase` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`idActividad`, `nombre`, `descripcion`, `tipo`, `Fase_idFase`) VALUES
(10, 'Entrevistas', 'Detalles.', 'requisitos', 3),
(11, 'Entrevistas', 'Detalles.', 'requisitos', 5),
(12, 'CodificaciÃ³n', 'Detalles.', 'desarrollo', 4),
(13, 'CodificaciÃ³n', 'Detalles.', 'desarrollo', 6),
(14, 'Encuestas', 'Detalles.', 'requisitos', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_rf`
--

CREATE TABLE IF NOT EXISTS `actividad_rf` (
  `idActividad_RF` int(11) NOT NULL,
  `RecursoF_idRecursoFisico` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `actividad_rf`
--

INSERT INTO `actividad_rf` (`idActividad_RF`, `RecursoF_idRecursoFisico`, `Actividad_idActividad`) VALUES
(1, 2, 10),
(2, 3, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_rh`
--

CREATE TABLE IF NOT EXISTS `actividad_rh` (
  `idActividad_RH` int(11) NOT NULL,
  `RecursoH_idRecursoHumano` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `actividad_rh`
--

INSERT INTO `actividad_rh` (`idActividad_RH`, `RecursoH_idRecursoHumano`, `Actividad_idActividad`) VALUES
(1, 1, 12),
(2, 2, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo`
--

CREATE TABLE IF NOT EXISTS `activo` (
  `idActivo` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `activo`
--

INSERT INTO `activo` (`idActivo`, `nombre`, `descripcion`) VALUES
(7, 'CMMI/use-documentation.pdf', 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `a_activo`
--

CREATE TABLE IF NOT EXISTS `a_activo` (
  `idA_Activo` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL,
  `Activo_idActivo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `a_activo`
--

INSERT INTO `a_activo` (`idA_Activo`, `Actividad_idActividad`, `Activo_idActivo`) VALUES
(3, 13, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `a_guia`
--

CREATE TABLE IF NOT EXISTS `a_guia` (
  `idA_Guia` int(11) NOT NULL,
  `Guia_idGuia` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `a_guia`
--

INSERT INTO `a_guia` (`idA_Guia`, `Guia_idGuia`, `Actividad_idActividad`) VALUES
(9, 9, 14),
(10, 10, 13),
(11, 17, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fase`
--

CREATE TABLE IF NOT EXISTS `fase` (
  `idFase` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `orden` varchar(45) NOT NULL,
  `Modelo_P_idModelo_P` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fase`
--

INSERT INTO `fase` (`idFase`, `nombre`, `descripcion`, `orden`, `Modelo_P_idModelo_P`) VALUES
(3, 'Requisitos', 'Detalles.', '1', 44),
(4, 'Desarrollo', 'Detalles.', '2', 44),
(5, 'Requisitos', 'Detalles.', '1', 45),
(6, 'Desarrollo', 'Detalles.', '2', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia`
--

CREATE TABLE IF NOT EXISTS `guia` (
  `idGuia` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `guia`
--

INSERT INTO `guia` (`idGuia`, `nombre`, `tipo`) VALUES
(9, 'Moprosoft/use-documentation.pdf', 'PDF'),
(10, 'CMMI/use-documentation.pdf', 'PRueba'),
(17, 'Moprosoft/prueba.pdf', 'Interna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo_p`
--

CREATE TABLE IF NOT EXISTS `modelo_p` (
  `idModelo_P` int(11) NOT NULL,
  `nombreM` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `version` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modelo_p`
--

INSERT INTO `modelo_p` (`idModelo_P`, `nombreM`, `descripcion`, `version`) VALUES
(44, 'Moprosoft', 'Detalles\r\n', '1.0'),
(45, 'CMMI', 'Detalles.\r\n', '1.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursof`
--

CREATE TABLE IF NOT EXISTS `recursof` (
  `idRecursoFisico` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(45) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_bin NOT NULL,
  `carga_trabajo` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `recursof`
--

INSERT INTO `recursof` (`idRecursoFisico`, `nombre`, `tipo`, `descripcion`, `carga_trabajo`) VALUES
(2, 'Computadora.', 'Equipo', 'Detalles.', 'Cero'),
(3, 'Escritorio', 'Equipo', 'Detalles.', 'Poca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursoh`
--

CREATE TABLE IF NOT EXISTS `recursoh` (
  `idRecursoHumano` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(45) COLLATE utf8_bin NOT NULL,
  `carga_trabajo` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `recursoh`
--

INSERT INTO `recursoh` (`idRecursoHumano`, `nombre`, `tipo`, `carga_trabajo`) VALUES
(1, 'Analista', 'Externo', 'Cero'),
(2, 'Programador', 'Miembro del equipo', 'Cero');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`idActividad`),
  ADD KEY `Fase_idFase` (`Fase_idFase`);

--
-- Indices de la tabla `actividad_rf`
--
ALTER TABLE `actividad_rf`
  ADD PRIMARY KEY (`idActividad_RF`),
  ADD KEY `RecursoF_idRecursoFisico` (`RecursoF_idRecursoFisico`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`);

--
-- Indices de la tabla `actividad_rh`
--
ALTER TABLE `actividad_rh`
  ADD PRIMARY KEY (`idActividad_RH`),
  ADD KEY `RecursoH_idRecursoHumano` (`RecursoH_idRecursoHumano`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`);

--
-- Indices de la tabla `activo`
--
ALTER TABLE `activo`
  ADD PRIMARY KEY (`idActivo`);

--
-- Indices de la tabla `a_activo`
--
ALTER TABLE `a_activo`
  ADD PRIMARY KEY (`idA_Activo`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`),
  ADD KEY `Activo_idActivo` (`Activo_idActivo`);

--
-- Indices de la tabla `a_guia`
--
ALTER TABLE `a_guia`
  ADD PRIMARY KEY (`idA_Guia`),
  ADD KEY `Guia_idGuia` (`Guia_idGuia`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`);

--
-- Indices de la tabla `fase`
--
ALTER TABLE `fase`
  ADD PRIMARY KEY (`idFase`),
  ADD KEY `fase` (`Modelo_P_idModelo_P`);

--
-- Indices de la tabla `guia`
--
ALTER TABLE `guia`
  ADD PRIMARY KEY (`idGuia`);

--
-- Indices de la tabla `modelo_p`
--
ALTER TABLE `modelo_p`
  ADD PRIMARY KEY (`idModelo_P`);

--
-- Indices de la tabla `recursof`
--
ALTER TABLE `recursof`
  ADD PRIMARY KEY (`idRecursoFisico`);

--
-- Indices de la tabla `recursoh`
--
ALTER TABLE `recursoh`
  ADD PRIMARY KEY (`idRecursoHumano`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `idActividad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `actividad_rf`
--
ALTER TABLE `actividad_rf`
  MODIFY `idActividad_RF` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `actividad_rh`
--
ALTER TABLE `actividad_rh`
  MODIFY `idActividad_RH` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `activo`
--
ALTER TABLE `activo`
  MODIFY `idActivo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `a_activo`
--
ALTER TABLE `a_activo`
  MODIFY `idA_Activo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `a_guia`
--
ALTER TABLE `a_guia`
  MODIFY `idA_Guia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `fase`
--
ALTER TABLE `fase`
  MODIFY `idFase` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `guia`
--
ALTER TABLE `guia`
  MODIFY `idGuia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `modelo_p`
--
ALTER TABLE `modelo_p`
  MODIFY `idModelo_P` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT de la tabla `recursof`
--
ALTER TABLE `recursof`
  MODIFY `idRecursoFisico` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `recursoh`
--
ALTER TABLE `recursoh`
  MODIFY `idRecursoHumano` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`Fase_idFase`) REFERENCES `fase` (`idFase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `actividad_rf`
--
ALTER TABLE `actividad_rf`
  ADD CONSTRAINT `actividad_rf_ibfk_1` FOREIGN KEY (`RecursoF_idRecursoFisico`) REFERENCES `recursof` (`idRecursoFisico`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividad_rf_ibfk_2` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `actividad_rh`
--
ALTER TABLE `actividad_rh`
  ADD CONSTRAINT `actividad_rh_ibfk_1` FOREIGN KEY (`RecursoH_idRecursoHumano`) REFERENCES `recursoh` (`idRecursoHumano`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividad_rh_ibfk_2` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `a_activo`
--
ALTER TABLE `a_activo`
  ADD CONSTRAINT `a_activo_ibfk_1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_activo_ibfk_2` FOREIGN KEY (`Activo_idActivo`) REFERENCES `activo` (`idActivo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `a_guia`
--
ALTER TABLE `a_guia`
  ADD CONSTRAINT `a_guia_ibfk_5` FOREIGN KEY (`Guia_idGuia`) REFERENCES `guia` (`idGuia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_guia_ibfk_6` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fase`
--
ALTER TABLE `fase`
  ADD CONSTRAINT `fase_ibfk_1` FOREIGN KEY (`Modelo_P_idModelo_P`) REFERENCES `modelo_p` (`idModelo_P`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
