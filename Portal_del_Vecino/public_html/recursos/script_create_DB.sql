-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2017 a las 22:16:45
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vecino`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `ID_ACTIVIDAD` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `FECHA_TERMINO` date NOT NULL,
  `ELIMINADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID_COMENTARIO` int(5) NOT NULL,
  `ID_TEMA` int(3) NOT NULL,
  `ID_USUARIO` int(3) NOT NULL,
  `COMENTARIO` text NOT NULL,
  `ELIMINADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna`
--

CREATE TABLE `comuna` (
  `ID_COMUNA` int(3) NOT NULL,
  `ID_REGION` int(3) NOT NULL,
  `COMUNA` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comuna`
--

INSERT INTO `comuna` (`ID_COMUNA`, `ID_REGION`, `COMUNA`) VALUES
(1, 1, 'Temuco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `ID_FORO` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `ID` int(3) NOT NULL,
  `ID_USUARIO` int(3) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`ID`, `ID_USUARIO`, `PASSWORD`) VALUES
(1, 1, '$2y$10$lnqRMpFTXmSCZn8L7cVBSuEyo8SDzjge1PGH1T05B2MXLsxEOhjnq');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizaciones`
--

CREATE TABLE `organizaciones` (
  `ID_ORGANIZACION` int(3) NOT NULL,
  `ID_COMUNA` int(3) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `organizaciones`
--

INSERT INTO `organizaciones` (`ID_ORGANIZACION`, `ID_COMUNA`, `NOMBRE`) VALUES
(1, 1, 'Junta de vecinos de prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `ID_PRESTAMO` int(3) NOT NULL,
  `ID_RECURSO` int(3) NOT NULL,
  `ID_USUARIO` int(3) NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `FECHA_TERMINO` date NOT NULL,
  `ELIMINADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `ID_PROYECTO` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `FECHA_TERMINO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `ID_RECURSO` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL,
  `NOMBRE` int(30) NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `ESTADO` tinyint(1) NOT NULL,
  `ELIMINADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE `regiones` (
  `ID_REGION` int(3) NOT NULL,
  `REGION` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`ID_REGION`, `REGION`) VALUES
(1, 'Araucania');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reuniones`
--

CREATE TABLE `reuniones` (
  `ID_REUNION` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL,
  `FECHA_REUNION` date NOT NULL,
  `ACTA_REUNION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_ROL` int(3) NOT NULL,
  `ROL` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_ROL`, `ROL`) VALUES
(1, 'Rol de pruebas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `ID_TEMA` int(3) NOT NULL,
  `ID_FORO` int(3) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL,
  `ID_USUARIO` int(3) NOT NULL,
  `ELIMINADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tesoreria`
--

CREATE TABLE `tesoreria` (
  `ID_TESORERIA` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL,
  `MONTO` int(10) UNSIGNED NOT NULL,
  `E_S` tinyint(1) NOT NULL,
  `TOTAL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_USUARIO` int(3) NOT NULL,
  `ID_ORGANIZACION` int(3) NOT NULL,
  `NOMBRE` varchar(20) NOT NULL,
  `APELLIDO` varchar(20) NOT NULL,
  `CORREO` varchar(50) NOT NULL,
  `TELEFONO` varchar(12) NOT NULL,
  `ID_ROL` int(3) NOT NULL,
  `ID_COMUNA` int(3) NOT NULL,
  `DIRECCION` varchar(70) NOT NULL,
  `ELIMINADO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_USUARIO`, `ID_ORGANIZACION`, `NOMBRE`, `APELLIDO`, `CORREO`, `TELEFONO`, `ID_ROL`, `ID_COMUNA`, `DIRECCION`, `ELIMINADO`) VALUES
(1, 1, 'Invitado', 'Maestro', 'invitado@uct.cl', '+56912345678', 1, 1, 'Rudencindo Ortega #0000', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`ID_ACTIVIDAD`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID_COMENTARIO`),
  ADD KEY `ID_TEMA` (`ID_TEMA`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD PRIMARY KEY (`ID_COMUNA`),
  ADD KEY `ID_REGION` (`ID_REGION`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`ID_FORO`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `organizaciones`
--
ALTER TABLE `organizaciones`
  ADD PRIMARY KEY (`ID_ORGANIZACION`),
  ADD KEY `ID_COMUNA` (`ID_COMUNA`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`ID_PRESTAMO`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`),
  ADD KEY `ID_RECURSO` (`ID_RECURSO`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`ID_PROYECTO`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`ID_RECURSO`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`ID_REGION`);

--
-- Indices de la tabla `reuniones`
--
ALTER TABLE `reuniones`
  ADD PRIMARY KEY (`ID_REUNION`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_ROL`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`ID_TEMA`),
  ADD KEY `ID_FORO` (`ID_FORO`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `tesoreria`
--
ALTER TABLE `tesoreria`
  ADD PRIMARY KEY (`ID_TESORERIA`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD KEY `ID_ORGANIZACION` (`ID_ORGANIZACION`),
  ADD KEY `ID_ROL` (`ID_ROL`),
  ADD KEY `usuarios_ibfk_3` (`ID_COMUNA`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `ID_ACTIVIDAD` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID_COMENTARIO` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `comuna`
--
ALTER TABLE `comuna`
  MODIFY `ID_COMUNA` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `foro`
--
ALTER TABLE `foro`
  MODIFY `ID_FORO` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `ID_PRESTAMO` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `ID_PROYECTO` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `ID_RECURSO` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `regiones`
--
ALTER TABLE `regiones`
  MODIFY `ID_REGION` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `reuniones`
--
ALTER TABLE `reuniones`
  MODIFY `ID_REUNION` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_ROL` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `ID_TEMA` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tesoreria`
--
ALTER TABLE `tesoreria`
  MODIFY `ID_TESORERIA` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_USUARIO` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`ID_TEMA`) REFERENCES `temas` (`ID_TEMA`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`);

--
-- Filtros para la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD CONSTRAINT `comuna_ibfk_1` FOREIGN KEY (`ID_REGION`) REFERENCES `regiones` (`ID_REGION`);

--
-- Filtros para la tabla `foro`
--
ALTER TABLE `foro`
  ADD CONSTRAINT `foro_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`);

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`);

--
-- Filtros para la tabla `organizaciones`
--
ALTER TABLE `organizaciones`
  ADD CONSTRAINT `organizaciones_ibfk_1` FOREIGN KEY (`ID_COMUNA`) REFERENCES `comuna` (`ID_COMUNA`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`ID_RECURSO`) REFERENCES `recursos` (`ID_RECURSO`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`);

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `recursos_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`);

--
-- Filtros para la tabla `reuniones`
--
ALTER TABLE `reuniones`
  ADD CONSTRAINT `reuniones_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`);

--
-- Filtros para la tabla `temas`
--
ALTER TABLE `temas`
  ADD CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`ID_FORO`) REFERENCES `foro` (`ID_FORO`),
  ADD CONSTRAINT `temas_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`);

--
-- Filtros para la tabla `tesoreria`
--
ALTER TABLE `tesoreria`
  ADD CONSTRAINT `tesoreria_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`ID_ORGANIZACION`) REFERENCES `organizaciones` (`ID_ORGANIZACION`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`ID_ROL`) REFERENCES `roles` (`ID_ROL`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`ID_COMUNA`) REFERENCES `comuna` (`ID_COMUNA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
