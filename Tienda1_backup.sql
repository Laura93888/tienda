/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: Tienda1
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categorias` (
  `id_cat` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categorias`
--

LOCK TABLES `Categorias` WRITE;
/*!40000 ALTER TABLE `Categorias` DISABLE KEYS */;
INSERT INTO `Categorias` VALUES
(1,'Camisetas'),
(2,'Pantalones'),
(3,'Vestidos'),
(4,'Sudaderas'),
(5,'Chaquetas'),
(6,'Accesorios');
/*!40000 ALTER TABLE `Categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Productos`
--

DROP TABLE IF EXISTS `Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Productos` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Ventas` int(11) DEFAULT 0,
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_cat` (`id_cat`),
  CONSTRAINT `Productos_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `Categorias` (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Productos`
--

LOCK TABLES `Productos` WRITE;
/*!40000 ALTER TABLE `Productos` DISABLE KEYS */;
INSERT INTO `Productos` VALUES
(1,'Camiseta básica blanca',14.99,25,'camiseta_basica_blanca.jpg','Camiseta básica blanca de algodón, manga corta, cuello redondo y corte regular. Un básico versátil para cualquier ocasión.',18,1),
(2,'Camiseta oversize negra',19.99,20,'camiseta_oversize_negra.jpg','Camiseta oversize negra de algodón con manga corta y corte amplio. Una prenda cómoda y fácil de combinar.',24,1),
(3,'Camiseta estampada urbana',17.99,18,'camiseta_estampada_urbana.jpg','Camiseta de algodón en color blanco roto con un estampado gráfico urbano y un diseño moderno.',21,1),
(4,'Camiseta de rayas azul',16.99,22,'camiseta_rayas_azul.jpg','Camiseta de algodón con rayas horizontales azul marino y blancas, cuello redondo y corte regular.',15,1),
(5,'Camiseta cuello pico blanca',15.99,20,'camiseta_cuello_pico_blanca.jpg','Camiseta básica blanca de algodón con cuello de pico y manga corta. Diseño sencillo y atemporal.',12,1),
(6,'Camiseta cropped gris',18.99,16,'camiseta_cropped_gris.jpg','Camiseta cropped gris claro de algodón suave, manga corta y corte ligeramente ajustado.',19,1),
(7,'Vaquero recto azul',34.99,15,'vaquero_recto_azul.jpg','Pantalón vaquero azul de corte recto y diseño clásico de cinco bolsillos. Un básico para cualquier armario.',31,2),
(8,'Pantalón cargo beige',39.99,12,'pantalon_cargo_beige.jpg','Pantalón cargo beige de corte relajado con bolsillos laterales y diseño funcional.',17,2),
(9,'Pantalón wide leg negro',42.99,10,'pantalon_wide_leg_negro.jpg','Pantalón wide leg negro de cintura alta y pierna ancha, confeccionado en un tejido elegante y fluido.',22,2),
(10,'Vaquero skinny negro',36.99,14,'vaquero_skinny_negro.jpg','Pantalón vaquero skinny negro de denim elástico y corte ajustado desde la cintura hasta los tobillos.',28,2),
(11,'Pantalón recto beige',32.99,17,'pantalon_recto_beige.jpg','Pantalón beige de corte recto confeccionado en un tejido ligero y elegante.',14,2),
(12,'Pantalón denim wide leg azul',39.99,11,'pantalon_denim_wide_leg_azul.jpg','Pantalón vaquero azul de pierna ancha, cintura alta y diseño clásico de cinco bolsillos.',26,2),
(13,'Vestido midi floral',39.99,13,'vestido_midi_floral.jpg','Vestido midi con estampado floral delicado, manga corta, cintura ligeramente marcada y falda de media pierna.',25,3),
(14,'Vestido negro básico',34.99,16,'vestido_negro_basico.jpg','Vestido negro de corte sencillo y elegante, manga corta, silueta ligeramente entallada y longitud midi.',34,3),
(15,'Vestido camisero beige',44.99,9,'vestido_camisero_beige.jpg','Vestido camisero beige de manga corta con botones delanteros, cuello clásico y cinturón fino.',18,3),
(16,'Vestido corto negro',32.99,14,'vestido_corto_negro.jpg','Vestido corto negro de diseño minimalista, manga corta, cuello redondo y corte ligeramente entallado.',29,3),
(17,'Vestido midi negro satinado',49.99,8,'vestido_midi_negro_satinado.jpg','Vestido midi negro de tejido satinado, tirantes finos, silueta elegante y caída fluida.',23,3),
(18,'Vestido corto estampado',36.99,12,'vestido_corto_estampado.jpg','Vestido corto con estampado floral delicado, manga corta y falda ligeramente acampanada.',20,3),
(19,'Sudadera básica gris',29.99,20,'sudadera_basica_gris.jpg','Sudadera básica gris de algodón, cuello redondo, manga larga y corte regular.',27,4),
(20,'Sudadera oversize crema',34.99,15,'sudadera_oversize_crema.jpg','Sudadera oversize color crema de tejido grueso y suave, con manga larga y corte amplio.',32,4),
(21,'Sudadera con capucha negra',37.99,13,'sudadera_capucha_negra.jpg','Sudadera negra con capucha, bolsillo delantero tipo canguro y corte cómodo.',38,4),
(22,'Sudadera cropped gris',32.99,11,'sudadera_cropped_gris.jpg','Sudadera cropped gris claro de algodón suave, manga larga y corte corto a la cintura.',21,4),
(23,'Sudadera básica azul marino',29.99,18,'sudadera_basica_azul_marino.jpg','Sudadera básica azul marino de algodón, cuello redondo, manga larga y corte regular.',25,4),
(24,'Sudadera oversize verde',36.99,14,'sudadera_oversize_verde.jpg','Sudadera oversize verde oscuro de tejido grueso y suave, con manga larga y corte amplio.',16,4),
(25,'Cazadora vaquera',49.99,10,'cazadora_vaquera.jpg','Cazadora vaquera clásica azul medio con cuello camisero, botones metálicos y bolsillos delanteros.',35,5),
(26,'Chaqueta acolchada negra',54.99,8,'chaqueta_acolchada_negra.jpg','Chaqueta acolchada negra ligera con manga larga, cuello alto y cierre frontal.',19,5),
(27,'Blazer oversize beige',59.99,9,'blazer_oversize_beige.jpg','Blazer oversize beige de corte amplio, solapas clásicas y dos botones delanteros.',27,5),
(28,'Cazadora de cuero negra',69.99,7,'cazadora_cuero_negra.jpg','Cazadora biker de cuero negro con cierre metálico, solapas y bolsillos con cremalleras.',41,5),
(29,'Chaqueta de punto beige',39.99,13,'chaqueta_punto_beige.jpg','Chaqueta de punto beige de manga larga, botones delanteros y tejido suave con textura visible.',18,5),
(30,'Trench clásico beige',64.99,6,'trench_clasico_beige.jpg','Trench clásico beige con doble botonadura, cinturón, solapas y diseño elegante atemporal.',24,5),
(31,'Bolso bandolera negro',29.99,15,'bolso_bandolera_negro.jpg','Bolso bandolera pequeño de color negro, diseño minimalista y correa larga ajustable.',33,6),
(32,'Gorra básica beige',19.99,20,'gorra_basica_beige.jpg','Gorra básica de algodón color beige con visera curva y cierre ajustable trasero.',28,6),
(33,'Cinturón de piel negro',24.99,18,'cinturon_piel_negro.jpg','Cinturón de piel negro de diseño clásico con hebilla metálica plateada.',17,6),
(34,'Bolso shopper marrón',44.99,10,'bolso_shopper_marron.jpg','Bolso shopper grande de color marrón con dos asas superiores y acabado de cuero sintético.',22,6),
(35,'Bufanda de punto beige',22.99,16,'bufanda_punto_beige.jpg','Bufanda de punto suave color beige, tejido grueso y textura visible.',14,6),
(36,'Gafas de sol negras',21.99,12,'gafas_sol_negras.jpg','Gafas de sol negras de diseño clásico y montura sencilla, perfectas para completar cualquier look.',31,6);
/*!40000 ALTER TABLE `Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `contrasea` varchar(255) NOT NULL,
  `rol` varchar(50) DEFAULT 'usuario',
  `intentos` int(11) DEFAULT 0,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_carrito`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_user`),
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `Productos` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-22  8:12:42
