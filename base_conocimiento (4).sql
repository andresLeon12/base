-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-08-2015 a las 16:37:53
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
  `Fase_idFase` int(11) NOT NULL,
  `identificador` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`idActividad`, `nombre`, `descripcion`, `tipo`, `Fase_idFase`, `identificador`) VALUES
(7, 'Actividad 1', 'Actividad de desarrollo', 'Desarrollo', 90, 'A 1.1'),
(8, 'Actividad 2', 'Desarrollo', 'Desarrollo', 90, 'A 1.2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_rf`
--

CREATE TABLE IF NOT EXISTS `actividad_rf` (
  `idActividad_RF` int(11) NOT NULL,
  `RecursoF_idRecursoFisico` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_rh`
--

CREATE TABLE IF NOT EXISTS `actividad_rh` (
  `idActividad_RH` int(11) NOT NULL,
  `RecursoH_idRecursoHumano` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo`
--

CREATE TABLE IF NOT EXISTS `activo` (
  `idActivo` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actmed`
--

CREATE TABLE IF NOT EXISTS `actmed` (
  `idActMed` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL,
  `Medida_idMedida` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `actmed`
--

INSERT INTO `actmed` (`idActMed`, `Actividad_idActividad`, `Medida_idMedida`) VALUES
(10, 7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_ent`
--

CREATE TABLE IF NOT EXISTS `act_ent` (
  `idActividad_Ent` int(11) NOT NULL,
  `Entrada_idEntrada` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_sal`
--

CREATE TABLE IF NOT EXISTS `act_sal` (
  `idActividad_Sal` int(11) NOT NULL,
  `Salida_idSalida` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `a_activo`
--

CREATE TABLE IF NOT EXISTS `a_activo` (
  `idA_Activo` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL,
  `Activo_idActivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `a_guia`
--

CREATE TABLE IF NOT EXISTS `a_guia` (
  `idA_Guia` int(11) NOT NULL,
  `Guia_idGuia` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `a_guia`
--

INSERT INTO `a_guia` (`idA_Guia`, `Guia_idGuia`, `Actividad_idActividad`) VALUES
(5, 5, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE IF NOT EXISTS `dependencia` (
  `idDependencia` int(11) NOT NULL,
  `depende_De` int(11) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`idDependencia`, `depende_De`, `Actividad_idActividad`) VALUES
(24, 7, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE IF NOT EXISTS `entrada` (
  `idEntrada` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fase`
--

INSERT INTO `fase` (`idFase`, `nombre`, `descripcion`, `orden`, `Modelo_P_idModelo_P`) VALUES
(90, 'Fase 1', 'Fase 1 MP', '1', 54),
(91, 'Fase 2', 'Fase 2 MP', '2', 54);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia`
--

CREATE TABLE IF NOT EXISTS `guia` (
  `idGuia` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `guia`
--

INSERT INTO `guia` (`idGuia`, `nombre`, `tipo`) VALUES
(5, 'Moprosoft/guia-apa.pdf', 'pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medida`
--

CREATE TABLE IF NOT EXISTS `medida` (
  `idMedida` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `unidad_medida` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medida`
--

INSERT INTO `medida` (`idMedida`, `nombre`, `descripcion`, `unidad_medida`) VALUES
(4, 'LOC', 'Lineas de cÃ³digo', 'Lineas de cÃ³digo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo_p`
--

CREATE TABLE IF NOT EXISTS `modelo_p` (
  `idModelo_P` int(11) NOT NULL,
  `nombreM` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `version` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modelo_p`
--

INSERT INTO `modelo_p` (`idModelo_P`, `nombreM`, `descripcion`, `version`) VALUES
(54, 'Moprosoft', 'Mp V 1.0', '1.0'),
(55, 'CMMI', 'CMMI', '1.2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE IF NOT EXISTS `personal` (
  `idPersonal` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidoP` varchar(45) NOT NULL,
  `apellidoM` varchar(45) NOT NULL,
  `habilidades` varchar(100) NOT NULL,
  `correo_electronico` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idPersonal`, `nombre`, `apellidoP`, `apellidoM`, `habilidades`, `correo_electronico`) VALUES
(15, 'Manuel', 'Santiago', 'Cruz', 'sdfsfds', 'manuel@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_rol`
--

CREATE TABLE IF NOT EXISTS `personal_rol` (
  `idPersonal_Rol` int(11) NOT NULL,
  `Rol_idRol` int(11) NOT NULL,
  `Personal_idPersonal` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal_rol`
--

INSERT INTO `personal_rol` (`idPersonal_Rol`, `Rol_idRol`, `Personal_idPersonal`) VALUES
(23, 8, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_t`
--

CREATE TABLE IF NOT EXISTS `prod_t` (
  `idProd_T` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `version` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursoh`
--

CREATE TABLE IF NOT EXISTS `recursoh` (
  `idRecursoHumano` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(45) COLLATE utf8_bin NOT NULL,
  `carga_trabajo` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombre`, `descripcion`) VALUES
(8, 'Programador', 'Programador\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE IF NOT EXISTS `salida` (
  `idSalida` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE IF NOT EXISTS `tarea` (
  `idTarea` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `Actividad_idActividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tarea`
--

INSERT INTO `tarea` (`idTarea`, `nombre`, `descripcion`, `Actividad_idActividad`) VALUES
(4, 'Tarea 1', 'Tarea 1', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea_prodt`
--

CREATE TABLE IF NOT EXISTS `tarea_prodt` (
  `idTarea_ProdT` int(11) NOT NULL,
  `Tarea_idTarea` int(11) NOT NULL,
  `Prod_T_idProd_T` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `password` varchar(8) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indices de la tabla `actmed`
--
ALTER TABLE `actmed`
  ADD PRIMARY KEY (`idActMed`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`),
  ADD KEY `Medida_idMedida` (`Medida_idMedida`);

--
-- Indices de la tabla `act_ent`
--
ALTER TABLE `act_ent`
  ADD PRIMARY KEY (`idActividad_Ent`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`),
  ADD KEY `Entrada_idEntrada` (`Entrada_idEntrada`);

--
-- Indices de la tabla `act_sal`
--
ALTER TABLE `act_sal`
  ADD PRIMARY KEY (`idActividad_Sal`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`),
  ADD KEY `Salida_idSalida` (`Salida_idSalida`);

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
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`idDependencia`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`);

--
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`idEntrada`);

--
-- Indices de la tabla `fase`
--
ALTER TABLE `fase`
  ADD PRIMARY KEY (`idFase`),
  ADD KEY `fase_ibfk_1` (`Modelo_P_idModelo_P`);

--
-- Indices de la tabla `guia`
--
ALTER TABLE `guia`
  ADD PRIMARY KEY (`idGuia`);

--
-- Indices de la tabla `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`idMedida`);

--
-- Indices de la tabla `modelo_p`
--
ALTER TABLE `modelo_p`
  ADD PRIMARY KEY (`idModelo_P`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idPersonal`);

--
-- Indices de la tabla `personal_rol`
--
ALTER TABLE `personal_rol`
  ADD PRIMARY KEY (`idPersonal_Rol`),
  ADD KEY `personal_rol_ibfk_1` (`Rol_idRol`),
  ADD KEY `personal_rol_ibfk_2` (`Personal_idPersonal`);

--
-- Indices de la tabla `prod_t`
--
ALTER TABLE `prod_t`
  ADD PRIMARY KEY (`idProd_T`);

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
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`idSalida`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`idTarea`),
  ADD KEY `Actividad_idActividad` (`Actividad_idActividad`);

--
-- Indices de la tabla `tarea_prodt`
--
ALTER TABLE `tarea_prodt`
  ADD PRIMARY KEY (`idTarea_ProdT`),
  ADD KEY `Prod_T_idProd_T` (`Prod_T_idProd_T`),
  ADD KEY `Tarea_IdTarea` (`Tarea_idTarea`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `idActividad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `actividad_rf`
--
ALTER TABLE `actividad_rf`
  MODIFY `idActividad_RF` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `actividad_rh`
--
ALTER TABLE `actividad_rh`
  MODIFY `idActividad_RH` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `activo`
--
ALTER TABLE `activo`
  MODIFY `idActivo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `actmed`
--
ALTER TABLE `actmed`
  MODIFY `idActMed` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `act_ent`
--
ALTER TABLE `act_ent`
  MODIFY `idActividad_Ent` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `act_sal`
--
ALTER TABLE `act_sal`
  MODIFY `idActividad_Sal` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `a_activo`
--
ALTER TABLE `a_activo`
  MODIFY `idA_Activo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `a_guia`
--
ALTER TABLE `a_guia`
  MODIFY `idA_Guia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  MODIFY `idDependencia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `idEntrada` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fase`
--
ALTER TABLE `fase`
  MODIFY `idFase` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT de la tabla `guia`
--
ALTER TABLE `guia`
  MODIFY `idGuia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `medida`
--
ALTER TABLE `medida`
  MODIFY `idMedida` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `modelo_p`
--
ALTER TABLE `modelo_p`
  MODIFY `idModelo_P` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idPersonal` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `personal_rol`
--
ALTER TABLE `personal_rol`
  MODIFY `idPersonal_Rol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `prod_t`
--
ALTER TABLE `prod_t`
  MODIFY `idProd_T` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursof`
--
ALTER TABLE `recursof`
  MODIFY `idRecursoFisico` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursoh`
--
ALTER TABLE `recursoh`
  MODIFY `idRecursoHumano` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `idSalida` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `idTarea` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tarea_prodt`
--
ALTER TABLE `tarea_prodt`
  MODIFY `idTarea_ProdT` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;
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
-- Filtros para la tabla `actmed`
--
ALTER TABLE `actmed`
  ADD CONSTRAINT `actmed_ibfk_1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actmed_ibfk_2` FOREIGN KEY (`Medida_idMedida`) REFERENCES `medida` (`idMedida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `act_ent`
--
ALTER TABLE `act_ent`
  ADD CONSTRAINT `act_ent_ibfk_1` FOREIGN KEY (`Entrada_idEntrada`) REFERENCES `entrada` (`idEntrada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `act_ent_ibfk_2` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `act_sal`
--
ALTER TABLE `act_sal`
  ADD CONSTRAINT `act_sal_ibfk_1` FOREIGN KEY (`Salida_idSalida`) REFERENCES `salida` (`idSalida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `act_sal_ibfk_2` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `a_activo`
--
ALTER TABLE `a_activo`
  ADD CONSTRAINT `a_activo_ibfk_2` FOREIGN KEY (`Activo_idActivo`) REFERENCES `activo` (`idActivo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_activo_ibfk_3` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `a_guia`
--
ALTER TABLE `a_guia`
  ADD CONSTRAINT `a_guia_ibfk_1` FOREIGN KEY (`Guia_idGuia`) REFERENCES `guia` (`idGuia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_guia_ibfk_2` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD CONSTRAINT `dependencia_ibfk_1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fase`
--
ALTER TABLE `fase`
  ADD CONSTRAINT `fase_ibfk_1` FOREIGN KEY (`Modelo_P_idModelo_P`) REFERENCES `modelo_p` (`idModelo_P`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal_rol`
--
ALTER TABLE `personal_rol`
  ADD CONSTRAINT `personal_rol_ibfk_1` FOREIGN KEY (`Rol_idRol`) REFERENCES `rol` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_rol_ibfk_2` FOREIGN KEY (`Personal_idPersonal`) REFERENCES `personal` (`idPersonal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarea_prodt`
--
ALTER TABLE `tarea_prodt`
  ADD CONSTRAINT `tarea_prodt_ibfk_1` FOREIGN KEY (`Prod_T_idProd_T`) REFERENCES `prod_t` (`idProd_T`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tarea_prodt_ibfk_2` FOREIGN KEY (`Tarea_idTarea`) REFERENCES `tarea` (`idTarea`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
