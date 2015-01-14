-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-11-2014 a las 00:40:30
-- Versión del servidor: 5.1.73
-- Versión de PHP: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `programa_colaborativo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_comentarios`
--
DROP TABLE IF EXISTS `prog_comentarios`;
CREATE TABLE IF NOT EXISTS `prog_comentarios` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `enmienda_id` int(11) NOT NULL,
  `comentario` text COLLATE utf8_bin NOT NULL,
  `sum_likes` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_enmiendas`
--
DROP TABLE IF EXISTS `prog_enmiendas`;
CREATE TABLE IF NOT EXISTS `prog_enmiendas` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `propuesta_id` int(11) NOT NULL,
  `enmienda` text COLLATE utf8_bin NOT NULL,
  `sum_likes` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_likes_comentarios`
--
DROP TABLE IF EXISTS `prog_likes_comentarios`;
CREATE TABLE IF NOT EXISTS `prog_likes_comentarios` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `comentario_voto` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_likes_enmiendas`
--
DROP TABLE IF EXISTS `prog_likes_enmiendas`;
CREATE TABLE IF NOT EXISTS `prog_likes_enmiendas` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `enmienda_id` int(11) NOT NULL,
  `enmienda_voto` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_likes_propuestas`
--
DROP TABLE IF EXISTS `prog_likes_propuestas`;
CREATE TABLE IF NOT EXISTS `prog_likes_propuestas` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `propuesta_id` int(11) NOT NULL,
  `propuesta_voto` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_propuestas`
--
DROP TABLE IF EXISTS `prog_propuestas`;
CREATE TABLE IF NOT EXISTS `prog_propuestas` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `titulo` varchar(200) COLLATE utf8_bin NOT NULL,
  `propuesta` text COLLATE utf8_bin NOT NULL,
  `sum_likes` int(11) NOT NULL,
  `positivos` int(11) NOT NULL,
  `negativos` int(11) NOT NULL,
  `comentarios` int(11) NOT NULL,
  `sector` varchar(150) COLLATE utf8_bin NOT NULL,
  `barrio` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_usuarios`
--
DROP TABLE IF EXISTS `prog_usuarios`;
CREATE TABLE IF NOT EXISTS `prog_usuarios` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  `ip` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prog_sectores`
--

DROP TABLE IF EXISTS `prog_sectores`;
CREATE TABLE `prog_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `image_url` varchar(512) CHARACTER SET ascii NOT NULL,
  `info` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
