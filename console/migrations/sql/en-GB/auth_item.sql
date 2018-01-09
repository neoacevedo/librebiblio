-- MySQL dump 10.16  Distrib 10.2.11-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: openbiblio2
-- ------------------------------------------------------
-- Server version	10.2.11-MariaDB

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
-- Dumping data for table `auth_item`
--

LOCK TABLES {{%auth_item}} WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO {{%auth_item}} VALUES ('admin',1,'Library Administrator.',NULL,NULL,1498187435,1510242014);
INSERT INTO {{%auth_item}} VALUES ('biblio-copy/create',2,'Permissions to create bibliographic copies.',NULL,NULL,1510242513,1510242513);
INSERT INTO {{%auth_item}} VALUES ('Catalog Manager',1,'Manager of the Library Catalog',NULL,NULL,1498187505,1510242758);
INSERT INTO {{%auth_item}} VALUES ('cataloging/biblio/create',2,'Permission to register new bibliographic material.',NULL,NULL,1510239732,1510241107);
INSERT INTO {{%auth_item}} VALUES ('cataloging/biblio/delete',2,'Permission to delete bibliographic material.',NULL,NULL,1510239808,1510241927);
INSERT INTO {{%auth_item}} VALUES ('cataloging/biblio/index',2,'Permission to access the cataloging area.',NULL,NULL,1510239975,1510243152);
INSERT INTO {{%auth_item}} VALUES ('cataloging/biblio/update',2,'Permiso para actualizar información de material bibliográfico.',NULL,NULL,1510238268,1510241971);
INSERT INTO {{%auth_item}} VALUES ('cataloging/biblio/view',2,'Permiso para ver información de material bibliográfico',NULL,NULL,1510242740,1510242740);
INSERT INTO {{%auth_item}} VALUES ('Circulation Manager',1,'Gestor de Préstamos',NULL,NULL,1498187454,1510243311);
INSERT INTO {{%auth_item}} VALUES ('circulation/cart',2,'Permiso para ver la lista de material en el carrito.',NULL,NULL,1510243292,1510243292);
INSERT INTO {{%auth_item}} VALUES ('circulation/create',2,'Permiso para registrar nuevos préstamos',NULL,NULL,1510238262,1510243084);
INSERT INTO {{%auth_item}} VALUES ('circulation/delete',2,'Permiso para borrar préstamos o reservas.',NULL,NULL,1510238281,1510243170);
INSERT INTO {{%auth_item}} VALUES ('circulation/index',2,'Permiso para acceder a la zona de préstamos.',NULL,NULL,1510243113,1510243113);
INSERT INTO {{%auth_item}} VALUES ('circulation/update',2,'Permiso para Actualizar información de préstamos o reservas.',NULL,NULL,1510239900,1510243199);
INSERT INTO {{%auth_item}} VALUES ('circulation/view',2,'Permiso para listar/ver usuarios, préstamos o reservas',NULL,NULL,1510238250,1510243184);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-08 17:33:07
