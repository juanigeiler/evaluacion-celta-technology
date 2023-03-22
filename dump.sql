/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Categorias`
--

DROP TABLE IF EXISTS `Categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Categorias` (
  `idCategoria` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `habilitada` tinyint(1) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categorias`
--

LOCK TABLES `Categorias` WRITE;
/*!40000 ALTER TABLE `Categorias` DISABLE KEYS */;
INSERT INTO `Categorias` VALUES (1,'Mujer',1),(2,'Hombre',1),(3,'Niños',0);
/*!40000 ALTER TABLE `Categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Depositos`
--

DROP TABLE IF EXISTS `Depositos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Depositos` (
  `idDeposito` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  PRIMARY KEY (`idDeposito`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Depositos`
--

LOCK TABLES `Depositos` WRITE;
/*!40000 ALTER TABLE `Depositos` DISABLE KEYS */;
INSERT INTO `Depositos` VALUES (1,'CABA','Av 9 de Julio'),(2,'AMBA','Ruta 3');
/*!40000 ALTER TABLE `Depositos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Productos`
--

DROP TABLE IF EXISTS `Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Productos` (
  `idProducto` int(4) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(4) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  `moneda` char(3) NOT NULL,
  `precio` decimal(7,2) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idProducto`,`idCategoria`),
  KEY `fk_Productos_Categorias_idx` (`idCategoria`),
  CONSTRAINT `fk_Productos_Categorias` FOREIGN KEY (`idCategoria`) REFERENCES `Categorias` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos`
--

LOCK TABLES `Productos` WRITE;
/*!40000 ALTER TABLE `Productos` DISABLE KEYS */;
INSERT INTO `Productos` VALUES (1,1,'Producto 1','Descripción 1','ARS',123.45,1),(2,1,'Producto 2','Descripción 2','ARS',75.52,1),(3,1,'Producto 3','Descripción 3','ARS',14.00,0),(4,1,'Producto 4','Descripción 4','ARS',4500.00,1),(5,1,'Producto 5','Descripción 5','ARS',235.72,1),(6,2,'Producto 6','Descripción 6','ARS',62.39,1),(7,2,'Producto 7','Descripción 7','ARS',297.21,1),(8,2,'Producto 8','Descripción 8','ARS',19.01,1),(9,2,'Producto 9','Descripción 9','ARS',140.00,0),(10,2,'Producto 10','Descripción 10','ARS',43.71,1),(11,3,'Producto 11','Descripción 11','ARS',149.32,1),(12,3,'Producto 12','Descripción 12','ARS',841.99,1),(13,3,'Producto 13','Descripción 13','ARS',19.99,1),(14,3,'Producto 14','Descripción 14','ARS',139.99,0),(15,3,'Producto 15','Descripción 15','ARS',235.72,1);
/*!40000 ALTER TABLE `Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Productos_Depositos`
--

DROP TABLE IF EXISTS `Productos_Depositos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Productos_Depositos` (
  `idProducto` int(4) NOT NULL,
  `idDeposito` int(4) NOT NULL,
  `disponibles` int(4) NOT NULL,
  `stock_minimo` int(4) NOT NULL,
  PRIMARY KEY (`idProducto`,`idDeposito`),
  KEY `fk_Productos_has_Depositos_Depositos1_idx` (`idDeposito`),
  KEY `fk_Productos_has_Depositos_Productos1_idx` (`idProducto`),
  CONSTRAINT `fk_Productos_has_Depositos_Depositos1` FOREIGN KEY (`idDeposito`) REFERENCES `Depositos` (`idDeposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Productos_has_Depositos_Productos1` FOREIGN KEY (`idProducto`) REFERENCES `Productos` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos_Depositos`
--

LOCK TABLES `Productos_Depositos` WRITE;
/*!40000 ALTER TABLE `Productos_Depositos` DISABLE KEYS */;
INSERT INTO `Productos_Depositos` VALUES (1,1,593,325),(1,2,345,501),(2,1,471,602),(2,2,597,932),(3,1,367,292),(3,2,858,916),(4,1,255,528),(4,2,874,286),(5,1,809,688),(5,2,764,755),(6,1,486,663),(6,2,857,547),(7,1,665,686),(7,2,433,608),(8,1,743,892),(8,2,482,984),(9,1,973,913),(9,2,649,255),(10,1,577,372),(10,2,631,288),(11,1,799,630),(11,2,502,371),(12,1,851,642),(12,2,409,616),(13,1,857,687),(13,2,615,762),(14,1,967,801),(14,2,852,860),(15,1,744,892),(15,2,477,958);
/*!40000 ALTER TABLE `Productos_Depositos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Productos_Imagenes`
--

DROP TABLE IF EXISTS `Productos_Imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Productos_Imagenes` (
  `idImagen` int(4) NOT NULL AUTO_INCREMENT,
  `idProducto` int(4) NOT NULL,
  `path` varchar(255) NOT NULL,
  `por_defecto` tinyint(1) NOT NULL,
  PRIMARY KEY (`idImagen`,`idProducto`),
  KEY `fk_table1_Productos1` (`idProducto`),
  CONSTRAINT `fk_table1_Productos1` FOREIGN KEY (`idProducto`) REFERENCES `Productos` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos_Imagenes`
--

LOCK TABLES `Productos_Imagenes` WRITE;
/*!40000 ALTER TABLE `Productos_Imagenes` DISABLE KEYS */;
INSERT INTO `Productos_Imagenes` VALUES (1,1,'img-listado.png',1),(2,2,'img-listado.png',1),(3,3,'img-listado.png',1),(4,4,'img-listado.png',1),(5,5,'img-listado.png',1),(6,6,'img-listado.png',1),(7,7,'img-listado.png',1),(8,8,'img-listado.png',1),(9,9,'img-listado.png',1),(10,10,'img-listado.png',1),(11,11,'img-listado.png',1),(12,12,'img-listado.png',1),(13,13,'img-listado.png',1),(14,14,'img-listado.png',1),(15,15,'img-listado.png',1),(16,1,'img-detalle.png',0),(17,2,'img-detalle.png',0),(18,3,'img-detalle.png',0),(19,4,'img-detalle.png',0),(20,5,'img-detalle.png',0),(21,6,'img-detalle.png',0),(22,7,'img-detalle.png',0),(23,8,'img-detalle.png',0),(24,9,'img-detalle.png',0),(25,10,'img-detalle.png',0),(26,11,'img-detalle.png',0),(27,12,'img-detalle.png',0),(28,13,'img-detalle.png',0),(29,14,'img-detalle.png',0),(30,15,'img-detalle.png',0);
/*!40000 ALTER TABLE `Productos_Imagenes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-20 13:40:49
