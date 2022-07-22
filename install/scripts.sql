CREATE TABLE IF NOT EXISTS `accesorios` (
  `idAccesorio` int(11) NOT NULL AUTO_INCREMENT,
 `nombre` varchar(100) DEFAULT NULL COMMENT '',
 `fechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAct` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAccesorio`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `categorias` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoriaPadreId` int(11) DEFAULT 0 COMMENT '0 categoria principal',
 `nombre` varchar(100) DEFAULT NULL COMMENT '',
 `fechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAct` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCategoria`),
  KEY `categoriaPadreId` (`categoriaPadreId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `categoriaPrincipalId` int(11) DEFAULT NULL,
  `categorias` TEXT DEFAULT NULL COMMENT 'categorias asociadas separadas por coma',
 `nombre` varchar(100) DEFAULT NULL COMMENT '',
 `modelo` varchar(100) DEFAULT NULL COMMENT '',
 `especificaciones` TEXT DEFAULT NULL COMMENT '',
 `precio` DOUBLE DEFAULT NULL COMMENT '',
 `fechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAct` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idProducto`),
  KEY `categoriaPrincipalId` (`categoriaPrincipalId`),
  FOREIGN KEY (categoriaPrincipalId) REFERENCES categorias(idCategoria)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comentarios` (
  `idComentario` int(11) NOT NULL AUTO_INCREMENT,
  `productoId` int(11) DEFAULT NULL,
 `nombre` varchar(100) DEFAULT NULL COMMENT '',
 `text` TEXT DEFAULT NULL COMMENT '',
 `calificacion` INT(11) DEFAULT NULL COMMENT '',
 `fechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAct` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idComentario`),
  KEY `productoId` (`productoId`),
  FOREIGN KEY (productoId) REFERENCES productos(idProducto)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


INSERT INTO `accesorios` (`nombre`) VALUES
('Teclado'),
('Mouse'),
('Ventilador'),
('Hub usb'),
('Combo mouse y teclado'),
('Soporte'),
('Mouse inalambrico'),
('Teclado inalambrico'),
('Mouse pad'),
('Etiquetas engomadas para teclado');


INSERT INTO `categorias` (`categoriaPadreId`, `nombre`) VALUES
(0, 'PC'),
(0, 'Laptop'),
(0, 'Notebook'),
(0, 'Mini'),
(1, 'PC 1'),
(1, 'PC 2'),
(2, 'Laptop 1'),
(3, 'Notebook 1'),
(4, 'Mini 1'),
(4, 'Mini 2');


INSERT INTO `productos` (categoriaPrincipalId, categorias, nombre, modelo, especificaciones, precio) VALUES
(5, '5', 'PC Gamer', 'LG', 'Texto pc gamer lg', 20000),
(5, '5', 'PC Gamer 2', 'Toshiba', 'Texto pc gamer 2 toshiba ', 25000),
(6, '6', 'PC Gamer 3', 'Acer', 'Texto pc gamer 3 Acer', 22000),
(6, '6', 'Laptop gamer', 'HP', 'Texto laptop gamer hp', 18000),
(7, '7', 'Laptop gamer 2', 'LG', 'Texto laptop gamer 2 lg', 19000),
(7, '7', 'Laptop gamer 3', 'Toshiba', 'Texto laptop gamer 2 toshiba', 21000),
(8, '8', 'Notebook', 'Acer', 'Texto notebook acer', 15000),
(8, '8', 'Notebook light', 'HP', 'Texto notebool light hp', 16000),
(9, '9', 'Mini lap', 'LG', 'Texto mini lap lg', 12000),
(9, '9', 'Mini lap 2', 'Toshiba', 'Texto mini lap 2 toshiba', 10000);


INSERT INTO `comentarios` (`productoId`, `nombre`, `text`, `calificacion`) VALUES
(1, 'Jair', 'Buen producto', 4),
(2, 'Juan', 'Me encanta', 5),
(3, 'Jose', 'Excelente calidad', 4),
(4, 'Lola', 'Buen precio', 4),
(5, 'Betty', 'Mal producto', 3),
(6, 'Laura', 'Muy caro', 3),
(7, 'Alberto', 'Su precio vale la pena', 4),
(8, 'Carlos', 'Esta padrisimo me encanta', 5),
(9, 'Lorena', 'Muy buenas condiciones', 4),
(10, 'Anna', 'No me gusto', 3);

ALTER TABLE productos ADD visitas INT(11) DEFAULT 0 AFTER precio;
ALTER TABLE categorias ADD accesorios TEXT DEFAULT NULL AFTER nombre;
-- UPDATE categorias i
--  SET i.accesorios=(SELECT GROUP_CONCAT(idAccesorio) AS accesoriosTxt
--   FROM (SELECT idAccesorio FROM accesorios ORDER BY RAND() LIMIT 2) AS accesoriosTxt);
UPDATE categorias i
 SET i.accesorios=CONCAT( (SELECT idAccesorio FROM accesorios ORDER BY RAND() LIMIT 1), ",", (SELECT idAccesorio FROM accesorios ORDER BY RAND() LIMIT 1));