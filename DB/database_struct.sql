-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-02-2015 a las 22:52:21
-- Versión del servidor: 5.5.9
-- Versión de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `programa`
--

CREATE DATABASE IF NOT EXISTS `programa`;
USE `programa`;

-- Cambiar la contraseña antes de ejecutar el script !!!
REVOKE ALL PRIVILEGES ON `programa`.*  FROM 'sec_user'@'localhost';
GRANT SELECT, INSERT, UPDATE ON `programa`.* TO 'sec_user'@'localhost' IDENTIFIED BY 'your_own_password_here';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_barrios`
--

CREATE TABLE `prog_barrios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `distrito_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_comentarios`
--

CREATE TABLE `prog_comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `propuesta_id` int(11) NOT NULL,
  `enmienda_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_config`
--

CREATE TABLE `prog_config` (
  `nombre` varchar(128) NOT NULL,
  `valor` text,
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_distritos`
--

CREATE TABLE `prog_distritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_enmiendas`
--

CREATE TABLE `prog_enmiendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `propuesta_id` int(11) NOT NULL,
  `enmienda` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_jornadas`
--

CREATE TABLE `prog_jornadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_likes_comentarios`
--

CREATE TABLE `prog_likes_comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `voto` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_like` (`usuario_id`,`comentario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_likes_enmiendas`
--

CREATE TABLE `prog_likes_enmiendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `enmienda_id` int(11) NOT NULL,
  `voto` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_like` (`usuario_id`,`enmienda_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_likes_propuestas`
--

CREATE TABLE `prog_likes_propuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `propuesta_id` int(11) NOT NULL,
  `voto` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_like` (`usuario_id`,`propuesta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_propuestas`
--

CREATE TABLE `prog_propuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `propuesta` text NOT NULL,
  `sector_id` int(11) NOT NULL,
  `barrio_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_sectores`
--

CREATE TABLE `prog_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `image_url` varchar(512) CHARACTER SET ascii NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_users`
--

CREATE TABLE `prog_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `barrio_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_users_jornada`
--

CREATE TABLE `prog_users_jornada` (
  `usuario_id` int(11) NOT NULL,
  `jornada_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
