-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2024 a las 21:35:37
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS REVOLUTION;
CREATE DATABASE REVOLUTION;
USE REVOLUTION;



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `revolution`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(11) NOT NULL,
  `NOMBRE_CATEGORIA` varchar(50) NOT NULL,
  `DESCRIPCION_CATEGORIA` varchar(200) DEFAULT NULL,
  `IMAGEN_CATEGORIA` varchar(200) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE_CATEGORIA`, `DESCRIPCION_CATEGORIA`, `IMAGEN_CATEGORIA`) VALUES
(1, 'Electrónica', 'Productos electrónicos y gadgets.', 'electronica.jpg'),
(2, 'Ropa', 'Ropa y accesorios de moda.', 'ropa.jpg'),
(3, 'Hogar', 'Artículos para el hogar y decoración.', 'hogar.jpg'),
(4, 'Juguetes', 'Juguetes para niños de todas las edades.', 'juguetes.jpg'),
(5, 'Deportes', 'Equipos y accesorios deportivos.', 'deportes.jpg'),
(6, 'Libros', 'Una amplia variedad de libros y literatura.', 'libros.jpg'),
(7, 'Belleza', 'Productos de belleza y cuidado personal.', 'belleza.jpg'),
(8, 'Alimentos', 'Alimentos y bebidas de diversas categorías.', 'alimentos.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `ID_ORDEN` int(11) NOT NULL,
  `PRODUCTO` int(11) NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `ESTADO` enum('En espera','Efectuado','Cancelado') NOT NULL DEFAULT 'En espera',
  `USUARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`ID_ORDEN`, `PRODUCTO`, `CANTIDAD`, `ESTADO`, `USUARIO`) VALUES
(1, 1, 1, 'Efectuado', 1),
(2, 2, 2, 'En espera', 2),
(3, 3, 1, 'Cancelado', 3),
(4, 4, 5, 'Efectuado', 4),
(5, 5, 1, 'En espera', 5),
(6, 6, 3, 'Efectuado', 6),
(7, 7, 1, 'Cancelado', 7),
(8, 8, 4, 'En espera', 8),
(9, 1, 2, 'Efectuado', 9),
(10, 2, 1, 'Cancelado', 10),
(11, 3, 3, 'Efectuado', 1),
(12, 4, 1, 'En espera', 2),
(13, 5, 2, 'Efectuado', 3),
(14, 6, 1, 'Cancelado', 4),
(15, 7, 5, 'En espera', 5),
(16, 8, 1, 'Efectuado', 6),
(17, 1, 3, 'En espera', 7),
(18, 2, 2, 'Efectuado', 8),
(19, 3, 1, 'Cancelado', 9),
(20, 4, 4, 'Efectuado', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_PRODUCTO` int(11) NOT NULL,
  `NOMBRE_PRODUCTO` varchar(50) NOT NULL,
  `DESCRIPCION_PRODUCTO` varchar(200) DEFAULT NULL,
  `PRECIO` decimal(10,2) NOT NULL,
  `CATEGORIA` int(11) NOT NULL,
  `FOTO` varchar(100) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_PRODUCTO`, `NOMBRE_PRODUCTO`, `DESCRIPCION_PRODUCTO`, `PRECIO`, `CATEGORIA`, `FOTO`) VALUES
(1, 'Teléfono Inteligente', 'Teléfono con pantalla táctil y múltiples aplicaciones.', 699.99, 1, 'telefono.jpg'),
(2, 'Camiseta de Algodón', 'Camiseta cómoda de algodón 100%.', 19.99, 2, 'camiseta.jpg'),
(3, 'Sofá de Dos Plazas', 'Sofá moderno para sala de estar.', 499.99, 3, 'sofa.jpg'),
(4, 'Muñeca de Juguete', 'Muñeca para niñas de todas las edades.', 29.99, 4, 'muneca.jpg'),
(5, 'Bicicleta de Montaña', 'Bicicleta robusta para aventuras al aire libre.', 299.99, 5, 'bicicleta.jpg'),
(6, 'Novela de Ciencia Ficción', 'Un emocionante viaje a un futuro distópico.', 14.99, 6, 'libro.jpg'),
(7, 'Perfume Floral', 'Fragancia fresca y floral para mujeres.', 49.99, 7, 'perfume.jpg'),
(8, 'Cereal Integral', 'Cereal saludable para el desayuno.', 4.99, 8, 'cereal.jpg'),
(9, 'Auriculares Bluetooth', 'Auriculares inalámbricos con excelente calidad de sonido.', 89.99, 1, 'auriculares.jpg'),
(10, 'Chaqueta de Cuero', 'Chaqueta elegante de cuero genuino.', 159.99, 2, 'chaqueta.jpg'),
(11, 'Mesa de Centro', 'Mesa moderna para el salón con diseño minimalista.', 239.99, 3, 'mesa.jpg'),
(12, 'Juego de Construcción', 'Set de bloques para construir y crear.', 34.99, 4, 'juegoConstruccion.jpg'),
(13, 'Patines en Línea', 'Patines duraderos para uso recreativo.', 119.99, 5, 'patines.jpg'),
(14, 'Guía de Cocina Gourmet', 'Libro con recetas gourmet y técnicas culinarias.', 24.99, 6, 'guiaCocina.jpg'),
(15, 'Crema Hidratante', 'Crema hidratante para piel seca con ingredientes naturales.', 29.99, 7, 'crema.jpg'),
(16, 'Jugo de Naranja Natural', 'Jugo 100% natural sin aditivos.', 3.99, 8, 'naranja.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `ID_TARJETA` int(11) NOT NULL,
  `NOMBRE_TITULAR` varchar(100) DEFAULT NULL,
  `NUMERO_TARJETA` varchar(16) NOT NULL,
  `CCV` char(3) NOT NULL,
  `FECHA_EXPIRACION` varchar(5) NOT NULL,
  `USUARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`ID_TARJETA`, `NOMBRE_TITULAR`, `NUMERO_TARJETA`, `CCV`, `FECHA_EXPIRACION`, `USUARIO`) VALUES
(1, 'Juan Pérez', '1234567812345678', '123', '12/25', 1),
(2, 'María Gómez', '2345678923456789', '234', '11/24', 2),
(3, 'Carlos Sánchez', '3456789034567890', '345', '10/26', 3),
(4, 'Laura Martín', '4567890145678901', '456', '09/25', 4),
(5, 'Ana López', '5678901256789012', '567', '08/26', 5),
(6, 'Pedro Hernández', '6789012367890123', '678', '07/24', 6),
(7, 'Luis Moreno', '7890123478901234', '789', '06/25', 7),
(8, 'Sofía Jiménez', '8901234589012345', '890', '05/27', 8),
(9, 'Javier Vázquez', '9012345690123456', '901', '04/26', 9),
(10, 'Claudia Ríos', '0123456701234567', '012', '03/25', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL,
  `NOMBRE_USUARIO` varchar(50) NOT NULL,
  `APELLIDO_USUARIO` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `CONTRASENA` varchar(200) NOT NULL,
  `DIRECCION` varchar(255) NOT NULL,
  `ROL` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_USUARIO`, `NOMBRE_USUARIO`, `APELLIDO_USUARIO`, `EMAIL`, `CONTRASENA`, `DIRECCION`, `ROL`) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@example.com', 'contraseña123', 'Calle Falsa 123, Madrid', 0),
(2, 'María', 'Gómez', 'maria.gomez@example.com', 'contraseña123', 'Avenida de la Paz 456, Madrid', 0),
(3, 'Carlos', 'Sánchez', 'carlos.sanchez@example.com', 'contraseña123', 'Calle Real 789, Madrid', 0),
(4, 'Laura', 'Martín', 'laura.martin@example.com', 'contraseña123', 'Calle del Sol 321, Madrid', 0),
(5, 'Ana', 'López', 'ana.lopez@example.com', 'contraseña123', 'Calle del Mar 654, Madrid', 0),
(6, 'Pedro', 'Hernández', 'pedro.hernandez@example.com', 'contraseña123', 'Calle de los Olmos 987, Madrid', 0),
(7, 'Luis', 'Moreno', 'luis.moreno@example.com', 'contraseña123', 'Calle de la Luna 111, Madrid', 0),
(8, 'Sofía', 'Jiménez', 'sofia.jimenez@example.com', 'contraseña123', 'Avenida del Río 222, Madrid', 0),
(9, 'Javier', 'Vázquez', 'javier.vazquez@example.com', 'contraseña123', 'Calle de la Tierra 333, Madrid', 0),
(10, 'Claudia', 'Ríos', 'claudia.rios@example.com', 'contraseña123', 'Calle de la Nieve 444, Madrid', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_CATEGORIA`),
  ADD UNIQUE KEY `NOMBRE_CATEGORIA` (`NOMBRE_CATEGORIA`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`ID_ORDEN`),
  ADD KEY `PRODUCTO` (`PRODUCTO`),
  ADD KEY `USUARIO` (`USUARIO`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_PRODUCTO`),
  ADD UNIQUE KEY `NOMBRE_PRODUCTO` (`NOMBRE_PRODUCTO`),
  ADD KEY `CATEGORIA` (`CATEGORIA`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`ID_TARJETA`),
  ADD KEY `USUARIO` (`USUARIO`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `ID_ORDEN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_PRODUCTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `ID_TARJETA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`),
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`USUARIO`) REFERENCES `usuario` (`ID_USUARIO`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`);

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `tarjeta_ibfk_1` FOREIGN KEY (`USUARIO`) REFERENCES `usuario` (`ID_USUARIO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
