-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: libello
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.10.2

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
-- Table structure for table `cursospolos_area`
--

DROP TABLE IF EXISTS `cursospolos_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursospolos_area` (
  `idArea` int(11) NOT NULL AUTO_INCREMENT,
  `nomeArea` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idArea`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursospolos_area`
--

LOCK TABLES `cursospolos_area` WRITE;
/*!40000 ALTER TABLE `cursospolos_area` DISABLE KEYS */;
INSERT INTO `cursospolos_area` VALUES (1,'Ciências Exatas e da Terra'),(2,'Ciências Humanas'),(3,'Ciências Biológicas'),(4,'Ciências Agrárias'),(5,'Ciências da Saúde'),(6,'Ciências Sociais Aplicadas'),(7,'Engenharias'),(8,'Linguísticas, letras e artes'),(9,'Multidisciplinas');
/*!40000 ALTER TABLE `cursospolos_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursospolos_curso`
--

DROP TABLE IF EXISTS `cursospolos_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursospolos_curso` (
  `idCurso` int(11) NOT NULL AUTO_INCREMENT,
  `nomeCurso` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCurso`),
  KEY `fk_curso_tipo` (`tipo`),
  KEY `fk_curso_area` (`area`),
  CONSTRAINT `fk_curso_area` FOREIGN KEY (`area`) REFERENCES `cursospolos_area` (`idArea`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_curso_tipo` FOREIGN KEY (`tipo`) REFERENCES `cursospolos_tipocurso` (`idTipoCurso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursospolos_curso`
--

LOCK TABLES `cursospolos_curso` WRITE;
/*!40000 ALTER TABLE `cursospolos_curso` DISABLE KEYS */;
INSERT INTO `cursospolos_curso` VALUES (50,'Retórica II',8,1);
/*!40000 ALTER TABLE `cursospolos_curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursospolos_polo`
--

DROP TABLE IF EXISTS `cursospolos_polo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursospolos_polo` (
  `idPolo` int(11) NOT NULL AUTO_INCREMENT,
  `nomePolo` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET latin1 NOT NULL,
  `estado` char(2) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idPolo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursospolos_polo`
--

LOCK TABLES `cursospolos_polo` WRITE;
/*!40000 ALTER TABLE `cursospolos_polo` DISABLE KEYS */;
INSERT INTO `cursospolos_polo` VALUES (5,'Japaguá','Varginha','MG');
/*!40000 ALTER TABLE `cursospolos_polo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursospolos_tipocurso`
--

DROP TABLE IF EXISTS `cursospolos_tipocurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursospolos_tipocurso` (
  `idTipoCurso` int(11) NOT NULL AUTO_INCREMENT,
  `nomeTipoCurso` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipoCurso`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursospolos_tipocurso`
--

LOCK TABLES `cursospolos_tipocurso` WRITE;
/*!40000 ALTER TABLE `cursospolos_tipocurso` DISABLE KEYS */;
INSERT INTO `cursospolos_tipocurso` VALUES (1,'Graduação'),(2,'Pós-Graduação Lato Sensu'),(3,'Pós-Graduação Strictu Sensu');
/*!40000 ALTER TABLE `cursospolos_tipocurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documento_memorando`
--

DROP TABLE IF EXISTS `documento_memorando`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_memorando` (
  `idMemorando` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `assunto` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoSigla` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `numMemorando` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `estadoValidacao` int(11) NOT NULL DEFAULT '0',
  `estadoEdicao` int(11) NOT NULL,
  `tratamento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_destino` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `corpo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idMemorando`),
  KEY `fk_memorando_usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_memorando_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_memorando`
--

LOCK TABLES `documento_memorando` WRITE;
/*!40000 ALTER TABLE `documento_memorando` DISABLE KEYS */;
INSERT INTO `documento_memorando` VALUES (27,1,' Administração. Instalação de microcomputadores','01/08/2014','TEC','1/2014',0,1,'Ao Sr','Chefe do departamento de Administração','<p>Teste editor&nbsp;<span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span><span style=\"font-size: 11px;\">Teste editor&nbsp;</span></p>','Prof. Dr. Luiz Eduardo ','Coordenador CEAD');
/*!40000 ALTER TABLE `documento_memorando` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documento_oficio`
--

DROP TABLE IF EXISTS `documento_oficio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_oficio` (
  `idOficio` int(11) NOT NULL AUTO_INCREMENT,
  `assunto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `corpo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estadoValidacao` int(11) NOT NULL DEFAULT '0',
  `estadoEdicao` int(11) NOT NULL,
  `destino` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `numOficio` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoSigla` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `referencia` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tratamento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_destino` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idOficio`),
  KEY `fk_oficio_usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_oficio_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_oficio`
--

LOCK TABLES `documento_oficio` WRITE;
/*!40000 ALTER TABLE `documento_oficio` DISABLE KEYS */;
INSERT INTO `documento_oficio` VALUES (29,'Indicação de nome para....','<p>teste editor&nbsp;<span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span><span style=\"font-size: 11px;\">teste editor&nbsp;</span></p>',1,0,1,'Luiz Eduardo da Silva','1/2014','01/08/2014','TEC','Magnifico Reitor','Prof. Dr. Luiz','Coordenador CEAD','Ao Sr.','Coordenador do núcleo CEAD');
/*!40000 ALTER TABLE `documento_oficio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipamento`
--

DROP TABLE IF EXISTS `equipamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento` (
  `idEquipamento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEquipamento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quantidade` int(11) NOT NULL,
  `descricao` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataEntrada` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroPatrimonio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idEquipamento`),
  UNIQUE KEY `numeroPatrimonio` (`numeroPatrimonio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento`
--

LOCK TABLES `equipamento` WRITE;
/*!40000 ALTER TABLE `equipamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipamento_baixa`
--

DROP TABLE IF EXISTS `equipamento_baixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento_baixa` (
  `idBaixa` int(11) NOT NULL AUTO_INCREMENT,
  `equipamento` int(11) NOT NULL,
  `saida` int(11) DEFAULT NULL,
  `dataBaixa` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeBaixa` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idBaixa`),
  KEY `fk_equipamento_baixa_equipamento1_idx` (`equipamento`),
  KEY `fk_equipamento_baixa_equipamento_saida1_idx` (`saida`),
  CONSTRAINT `fk_equipamento_baixa_equipamento1` FOREIGN KEY (`equipamento`) REFERENCES `equipamento` (`idEquipamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_baixa_equipamento_saida1` FOREIGN KEY (`saida`) REFERENCES `equipamento_saida` (`idSaida`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento_baixa`
--

LOCK TABLES `equipamento_baixa` WRITE;
/*!40000 ALTER TABLE `equipamento_baixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipamento_baixa` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `nova_baixa_equipamento` BEFORE INSERT ON `equipamento_baixa`
 FOR EACH ROW IF NEW.`saida` IS NOT NULL THEN
	UPDATE `equipamento_saida` SET `equipamento_saida`.`quantidadeSaida` = `equipamento_saida`.`quantidadeSaida` - NEW.`quantidadeBaixa` WHERE `equipamento_saida`.`idSaida` = NEW.saida;
	else
	UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` - NEW.`quantidadeBaixa` WHERE `equipamento`.`idEquipamento` = NEW.`equipamento`;
	END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eliminar_baixa_equipamento` BEFORE DELETE ON `equipamento_baixa`
 FOR EACH ROW IF OLD.`saida` IS NOT NULL THEN
	UPDATE `equipamento_saida` SET `equipamento_saida`.`quantidadeSaida` = `equipamento_saida`.`quantidadeSaida` + OLD.`quantidadeBaixa` WHERE `equipamento_saida`.`idSaida` = OLD.saida;
	else
	UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` + OLD.`quantidadeBaixa` WHERE `equipamento`.`idEquipamento` = OLD.`equipamento`;
	END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `equipamento_evento`
--

DROP TABLE IF EXISTS `equipamento_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento_evento` (
  `idEquipamentoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `tipoEvento` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `equipamento` int(11) DEFAULT NULL,
  `baixa` int(11) DEFAULT NULL,
  `saida` int(11) DEFAULT NULL,
  `retorno` int(11) DEFAULT NULL,
  `data` bigint(20) NOT NULL COMMENT 'Unix timestamp',
  PRIMARY KEY (`idEquipamentoEvento`),
  KEY `fk_equipamento_evento_usuario1_idx` (`usuario`),
  KEY `fk_equipamento_evento_equipamento1_idx` (`equipamento`),
  KEY `fk_equipamento_evento_equipamento_baixa1_idx` (`baixa`),
  KEY `fk_equipamento_evento_equipamento_saida1_idx` (`saida`),
  KEY `fk_equipamento_evento_equipamento_retorno1_idx` (`retorno`),
  KEY `fk_equipamento_evento_equipamento_tipoEvento1_idx` (`tipoEvento`),
  CONSTRAINT `fk_equipamento_evento_equipamento1` FOREIGN KEY (`equipamento`) REFERENCES `equipamento` (`idEquipamento`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_evento_equipamento_baixa1` FOREIGN KEY (`baixa`) REFERENCES `equipamento_baixa` (`idBaixa`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_evento_equipamento_retorno1` FOREIGN KEY (`retorno`) REFERENCES `equipamento_retorno` (`idRetorno`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_evento_equipamento_saida1` FOREIGN KEY (`saida`) REFERENCES `equipamento_saida` (`idSaida`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_evento_equipamento_tipoEvento1` FOREIGN KEY (`tipoEvento`) REFERENCES `equipamento_tipoevento` (`idTipoEvento`) ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_evento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento_evento`
--

LOCK TABLES `equipamento_evento` WRITE;
/*!40000 ALTER TABLE `equipamento_evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipamento_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipamento_retorno`
--

DROP TABLE IF EXISTS `equipamento_retorno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento_retorno` (
  `idRetorno` int(11) NOT NULL AUTO_INCREMENT,
  `saida` int(11) NOT NULL,
  `dataRetorno` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeRetorno` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idRetorno`),
  KEY `fk_equipamento_retorno_equipamento_saida1_idx` (`saida`),
  CONSTRAINT `fk_equipamento_retorno_equipamento_saida1` FOREIGN KEY (`saida`) REFERENCES `equipamento_saida` (`idSaida`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento_retorno`
--

LOCK TABLES `equipamento_retorno` WRITE;
/*!40000 ALTER TABLE `equipamento_retorno` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipamento_retorno` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `novo_retorno_equipamento` BEFORE INSERT ON `equipamento_retorno`
 FOR EACH ROW BEGIN
UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` + NEW.`quantidadeRetorno` WHERE `equipamento`.`idEquipamento` IN ( SELECT `equipamento` FROM `equipamento_saida` WHERE `equipamento_saida`.`idSaida` = NEW.`saida`);
UPDATE `equipamento_saida` set `equipamento_saida`.`quantidadeSaida` = `equipamento_saida`.`quantidadeSaida` - NEW.`quantidadeRetorno` WHERE `equipamento_saida`.`idSaida` = NEW.`saida`;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `equipamento_saida`
--

DROP TABLE IF EXISTS `equipamento_saida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento_saida` (
  `idSaida` int(11) NOT NULL AUTO_INCREMENT,
  `equipamento` int(11) NOT NULL,
  `responsavel` int(11) NOT NULL,
  `destino` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantidadeSaida` int(11) NOT NULL,
  `quantidadeSaidaOriginal` int(11) NOT NULL,
  `dataSaida` varchar(45) CHARACTER SET utf8 NOT NULL,
  `poloDestino` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSaida`),
  KEY `fk_equipamento_saida_equipamento1_idx` (`equipamento`),
  KEY `fk_equipamento_saida_usuario1_idx` (`responsavel`),
  KEY `fk_equipamento_saida_polo1_idx` (`poloDestino`),
  CONSTRAINT `fk_equipamento_saida_equipamento1` FOREIGN KEY (`equipamento`) REFERENCES `equipamento` (`idEquipamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_saida_polo1` FOREIGN KEY (`poloDestino`) REFERENCES `cursospolos_polo` (`idPolo`) ON UPDATE CASCADE,
  CONSTRAINT `fk_equipamento_saida_usuario1` FOREIGN KEY (`responsavel`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento_saida`
--

LOCK TABLES `equipamento_saida` WRITE;
/*!40000 ALTER TABLE `equipamento_saida` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipamento_saida` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `nova_saida_equipamento` BEFORE INSERT ON `equipamento_saida`
 FOR EACH ROW UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` - NEW.`quantidadeSaida` WHERE `equipamento`.`idEquipamento` = NEW.`equipamento` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eliminar_saida_equipamento` BEFORE DELETE ON `equipamento_saida`
 FOR EACH ROW UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` + OLD.`quantidadeSaida` WHERE `equipamento`.`idEquipamento` = OLD.`equipamento` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `equipamento_tipoevento`
--

DROP TABLE IF EXISTS `equipamento_tipoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento_tipoevento` (
  `idTipoEvento` int(11) NOT NULL,
  `nomeEvento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento_tipoevento`
--

LOCK TABLES `equipamento_tipoevento` WRITE;
/*!40000 ALTER TABLE `equipamento_tipoevento` DISABLE KEYS */;
INSERT INTO `equipamento_tipoevento` VALUES (1,'Cadastro de Equipamento'),(2,'Remoção de Equipamento'),(3,'Alteração de Equipamento'),(21,'Cadastro de Baixa'),(22,'Remoção de Baixa'),(31,'Cadastro de Saída'),(32,'Remoção de Saída'),(41,'Cadastro de Retorno');
/*!40000 ALTER TABLE `equipamento_tipoevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem`
--

DROP TABLE IF EXISTS `imagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem` (
  `idImagem` int(11) NOT NULL AUTO_INCREMENT,
  `idGaleria` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `cpfAutor` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dificuldade` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `ano` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `utilizadoAvaliacao` binary(1) NOT NULL DEFAULT '0',
  `avaliacao` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anoAvaliacao` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diretorio` varchar(300) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Localização da imagem e do arquivo vetorial. Deve terminar com ''/''',
  `diretorioMiniatura` varchar(300) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Localização da thumbnail. Deve terminar com ''/''',
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivoMiniatura` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivoVetorial` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descritor1` int(11) NOT NULL,
  `descritor2` int(11) NOT NULL,
  `descritor3` int(11) NOT NULL,
  `descritor4` int(11) NOT NULL,
  `dataCadastro` bigint(20) NOT NULL COMMENT 'Unix timestamp',
  PRIMARY KEY (`idImagem`),
  KEY `fk_imagens_imagem_imagens_galeria1_idx` (`idGaleria`),
  KEY `fk_imagens_imagem_imagens_descritor1_idx` (`descritor1`),
  KEY `fk_imagens_imagem_imagens_descritor2_idx` (`descritor2`),
  KEY `fk_imagens_imagem_imagens_descritor3_idx` (`descritor3`),
  KEY `fk_imagens_imagem_imagens_descritor4_idx` (`descritor4`),
  KEY `fk_imagens_imagem_usuario1_idx` (`autor`),
  CONSTRAINT `fk_imagens_imagem_imagens_descritor1` FOREIGN KEY (`descritor1`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagens_imagem_imagens_descritor2` FOREIGN KEY (`descritor2`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagens_imagem_imagens_descritor3` FOREIGN KEY (`descritor3`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagens_imagem_imagens_descritor4` FOREIGN KEY (`descritor4`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagens_imagem_imagens_galeria1` FOREIGN KEY (`idGaleria`) REFERENCES `imagem_galeria` (`idGaleria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagens_imagem_usuario1` FOREIGN KEY (`autor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem`
--

LOCK TABLES `imagem` WRITE;
/*!40000 ALTER TABLE `imagem` DISABLE KEYS */;
INSERT INTO `imagem` VALUES (1,2,1,'11111111111','Teste dia 25','Testando uma decricao muito longa, que possivelmente ocupará muitas linhas.Este teste visa testar o comportamento do componenete jquery para imagens com longas descricoes, para garantir que tudo será exibido corretamente. Entretanto, veja que há uma raposa caminhando pelo campo, ela veio e me perguntou: -What time is it? E prontamente eu respondi: - It\'s adventure time. Outro dia mesmo, estava eu andando por baixo das amoreiras, quando novamente me veio de encontro a raposa, ela estava inquieta, havia perdido seu relogio de bolso e não conseguia encontrar-lo. Ofereci-me em ajuda e nos colocamos a buscar pelo seu pertence. Pouco tempo depois, ela se lembrou que não o havia perdido, mas sim que raposas não usam relógios de bolso. Após isso pegamos algumas amoras e ela foi embora. Acordo de madrugada, sem sono, vou olhar o céu escuro; nesse horário do dia é possível ver alguns coelhos voando para a migração do sul, criaturas simpáticas, mas não sabia que coelhos poderiam voar também...','B','2014','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-B-CE3_1395751275.png','2-1-1-B-CE3_thumb_1395751275.png','2-1-1-B-CE3_vetorial_1395751275.svg',15,18,19,23,1395751276),(7,2,1,'11111111111','Header','','D','2014','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','1-2-1-D-CE3_1395350720.jpg','1-2-1-D-CE3_thumb_1395350720.jpg','1-2-1-D-CE3_vetorial_1395350720.svg',8,25,10,22,1395350720),(9,3,2,'39116561813','Cachorro','','C','2013','0',NULL,NULL,'privado/galerias/39116561813/','privado/galerias/miniaturas/39116561813/','1-2-1-C-CE3_1395404501.jpg','1-2-1-C-CE3_thumb_1395404501.jpg','1-2-1-C-CE3_vetorial_1395404501.svg',8,25,10,24,1395404501),(10,2,1,'11111111111','SBBQ','Logo da SBBQ','C','2010','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-C-CE3_1395664416.png','2-1-1-C-CE3_thumb_1395664416.png','2-1-1-C-CE3_vetorial_1395664416.svg',15,18,19,23,1395664422),(11,2,1,'11111111111','Screenshot alberto','BigBlueButton','D','2014','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-D-CE3_1395664633.png','2-1-1-D-CE3_thumb_1395664633.png','2-1-1-D-CE3_vetorial_1395664633.svg',15,18,19,23,1395664633),(13,2,1,'11111111111','Gimp imagem','','A','2014','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-A-CE3_1395865448.png','2-1-1-A-CE3_thumb_1395865448.png','2-1-1-A-CE3_vetorial_1395865448.xcf',15,18,19,23,1395865448),(14,2,1,'11111111111','Teste','','B','2020','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-B-CE3_1395866118.jpg','2-1-1-B-CE3_thumb_1395866118.jpg','2-1-1-B-CE3_vetorial_1395866118.cdr',15,18,19,23,1395866134),(15,2,1,'11111111111','Calculadora','','A','1991','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-A-CE3_1395866518.png','2-1-1-A-CE3_thumb_1395866518.png','2-1-1-A-CE3_vetorial_1395866518.cdr',15,18,19,23,1395866523),(16,2,1,'11111111111','Imagem','','C','1980','0',NULL,NULL,'privado/galerias/11111111111/','privado/galerias/miniaturas/11111111111/','2-1-1-C-CE3_1396013912.png','2-1-1-C-CE3_thumb_1396013912.png','2-1-1-C-CE3_vetorial_1396013912.xcf',15,18,19,23,1396013912);
/*!40000 ALTER TABLE `imagem` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `imagem_imagemCadastrada` AFTER INSERT ON `imagem`
 FOR EACH ROW UPDATE `imagem_galeria` SET `qtdFotos` = `qtdFotos` + 1 WHERE `imagem_galeria`.`idGaleria` = NEW.`idGaleria` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `imagem_imagemRemovida` AFTER DELETE ON `imagem`
 FOR EACH ROW UPDATE `imagem_galeria` SET `qtdFotos` = `qtdFotos` - 1 WHERE `imagem_galeria`.`idGaleria` = OLD.`idGaleria` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `imagem_descritor`
--

DROP TABLE IF EXISTS `imagem_descritor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem_descritor` (
  `idDescritor` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pai` int(11) DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `rotulo` int(11) NOT NULL,
  `qtdFilhos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idDescritor`),
  UNIQUE KEY `nivel nome pai` (`nivel`,`nome`,`pai`),
  KEY `fk_imagens_descritor_imagens_descritor1_idx` (`pai`),
  CONSTRAINT `fk_imagens_descritor_imagens_descritor1` FOREIGN KEY (`pai`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_descritor`
--

LOCK TABLES `imagem_descritor` WRITE;
/*!40000 ALTER TABLE `imagem_descritor` DISABLE KEYS */;
INSERT INTO `imagem_descritor` VALUES (0,'NIL',NULL,0,0,4),(8,'Cachorro',0,1,1,3),(9,'Grande',8,2,1,0),(10,'Peludo',25,3,1,2),(15,'Teste',0,1,2,1),(18,'Teste',15,2,1,1),(19,'Teste',18,3,1,1),(22,'Correndo',10,4,1,0),(23,'Teste',19,4,1,0),(24,'Em pé',10,4,2,0),(25,'Medio',8,2,2,1),(26,'Pequeno',8,2,3,0),(31,'Comida',0,1,3,5),(54,'Novo descritor 1',31,2,2,0),(55,'Novo descritor 2',31,2,3,0),(56,'Novo descritor 3',31,2,4,0),(57,'Novo descritor 4',31,2,5,0),(58,'Novo descritor 5',31,2,6,1),(59,'Novo descritor',58,3,1,1),(60,'Novo descritor',59,4,1,0),(61,'Pessoas',0,1,4,1),(62,'Crianças',61,2,1,2),(63,'Brincando',62,3,1,3),(64,'Juntas',63,4,1,0),(65,'Acompanhadas',63,4,2,0),(66,'Supervisionadas',63,4,3,0),(67,'Estudando',62,3,2,2),(68,'Na escola',67,4,1,0),(69,'Em casa',67,4,2,0);
/*!40000 ALTER TABLE `imagem_descritor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem_descritor_aux_inserir`
--

DROP TABLE IF EXISTS `imagem_descritor_aux_inserir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem_descritor_aux_inserir` (
  `idDescritorAux` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pai` int(11) NOT NULL,
  PRIMARY KEY (`idDescritorAux`),
  KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Auxilia na manutenção dos valores ''nível'', ''rotulo'' e ''qtdFilhos'' de imagens_descritor, o MySQL ainda não permite triggers que modificam a  tabela que ativou-o';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_descritor_aux_inserir`
--

LOCK TABLES `imagem_descritor_aux_inserir` WRITE;
/*!40000 ALTER TABLE `imagem_descritor_aux_inserir` DISABLE KEYS */;
INSERT INTO `imagem_descritor_aux_inserir` VALUES (1,'Teste 2',19),(2,'Novo descritor',19),(3,'Novo descritor',0),(4,'Novo descritor',29),(5,'Novo descritor',0),(6,'Novo descritor',31),(7,'Novo descritor 1',31),(8,'Novo descritor 2',31),(9,'Novo descritor 3',31),(10,'Novo descritor 4',31),(11,'Novo descritor 5',31),(12,'Novo descritor 6',31),(13,'Novo descritor',35),(14,'Novo descritor',32),(15,'Novo descritor 1',32),(16,'Novo descritor 2',32),(17,'Novo descritor 7',31),(18,'Novo descritor',39),(19,'Novo descritor 3',32),(20,'Novo descritor 8',31),(21,'Novo descritor 4',32),(22,'Novo descritor 7',31),(23,'Novo descritor 8',31),(24,'Novo descritor',31),(25,'Novo descritor 1',31),(26,'Novo descritor 2',31),(27,'Novo descritor 3',31),(28,'Novo descritor 4',31),(29,'Novo descritor 5',31),(30,'Novo descritor',58),(31,'Novo descritor',59),(32,'Pessoas',0),(33,'Crianças',61),(34,'Brincando',62),(35,'Juntas',63),(36,'Acompanhadas',63),(37,'Supervisionadas',63),(38,'Estudando',62),(39,'Na escola',67),(40,'Em casa',67);
/*!40000 ALTER TABLE `imagem_descritor_aux_inserir` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `imagem_descritor_aux` BEFORE INSERT ON `imagem_descritor_aux_inserir`
 FOR EACH ROW BEGIN
SET @niv = 0;
SET @rot = 0;
SET @qtd = 0;
SELECT nivel + 1 INTO @niv FROM imagem_descritor WHERE idDescritor = NEW.pai;
SELECT rotulo + 1 INTO @rot FROM imagem_descritor WHERE pai = NEW.pai ORDER BY ROTULO DESC LIMIT 1;
SELECT IF (EXISTS (SELECT rotulo FROM imagem_descritor WHERE pai = NEW.pai LIMIT 1),(SELECT rotulo + 1 FROM imagem_descritor WHERE pai = NEW.pai ORDER BY rotulo DESC LIMIT 1),1) INTO @rot;
SELECT qtdFilhos + 1 INTO @qtd FROM imagem_descritor WHERE idDescritor = NEW.pai;
INSERT INTO imagem_descritor(nome,pai,nivel,rotulo,qtdFilhos) VALUES (NEW.nome,NEW.pai, @niv, @rot, 0);
UPDATE imagem_descritor SET qtdFilhos = @qtd WHERE idDescritor = NEW.pai;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `imagem_descritor_aux_remover`
--

DROP TABLE IF EXISTS `imagem_descritor_aux_remover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem_descritor_aux_remover` (
  `idDescritor` int(11) NOT NULL AUTO_INCREMENT,
  `pai` int(11) NOT NULL,
  `descritor` int(11) NOT NULL,
  PRIMARY KEY (`idDescritor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Auxilia na manutenção dos valores ''nível'', ''rotulo'' e ''qtdFilhos'' de imagens_descritor, o MySQL ainda não permite triggers que modificam a  tabela que ativou-o';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_descritor_aux_remover`
--

LOCK TABLES `imagem_descritor_aux_remover` WRITE;
/*!40000 ALTER TABLE `imagem_descritor_aux_remover` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagem_descritor_aux_remover` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `imagem_descritor_aux_remover` BEFORE INSERT ON `imagem_descritor_aux_remover`
 FOR EACH ROW BEGIN
SET @qtd = 0;
SELECT qtdFilhos - 1 INTO @qtd FROM imagem_descritor WHERE idDescritor = NEW.pai;
UPDATE imagem_descritor SET qtdFilhos = @qtd WHERE idDescritor = NEW.pai;
DELETE FROM imagem_descritor WHERE idDescritor = NEW.descritor;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `imagem_evento`
--

DROP TABLE IF EXISTS `imagem_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem_evento` (
  `idEvento` int(11) NOT NULL AUTO_INCREMENT,
  `tipoEvento` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `galeria` int(11) DEFAULT NULL,
  `imagem` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`idEvento`),
  KEY `fk_imagens_evento_usuario1_idx` (`usuario`),
  KEY `fk_imagens_evento_imagens_categoria1_idx` (`categoria`),
  KEY `fk_imagens_evento_imagens_galeria1_idx` (`galeria`),
  KEY `fk_imagens_evento_imagens_imagem1_idx` (`imagem`),
  KEY `fk_imagens_evento_imagens_tipoEvento1_idx` (`tipoEvento`),
  CONSTRAINT `fk_imagens_evento_imagens_categoria1` FOREIGN KEY (`categoria`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_imagens_evento_imagens_galeria1` FOREIGN KEY (`galeria`) REFERENCES `imagem_galeria` (`idGaleria`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_imagens_evento_imagens_imagem1` FOREIGN KEY (`imagem`) REFERENCES `imagem` (`idImagem`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_imagens_evento_imagens_tipoEvento1` FOREIGN KEY (`tipoEvento`) REFERENCES `imagem_tipoevento` (`idTipoEvento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagens_evento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_evento`
--

LOCK TABLES `imagem_evento` WRITE;
/*!40000 ALTER TABLE `imagem_evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagem_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem_galeria`
--

DROP TABLE IF EXISTS `imagem_galeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem_galeria` (
  `idGaleria` int(11) NOT NULL AUTO_INCREMENT,
  `nomeGaleria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `qtdFotos` int(11) DEFAULT '0',
  `dataCriacao` bigint(20) DEFAULT NULL COMMENT 'Unix timestamp',
  `autor` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGaleria`),
  KEY `fk_imagem_galeria_usuario1_idx` (`autor`),
  CONSTRAINT `fk_imagem_galeria_usuario1` FOREIGN KEY (`autor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_galeria`
--

LOCK TABLES `imagem_galeria` WRITE;
/*!40000 ALTER TABLE `imagem_galeria` DISABLE KEYS */;
INSERT INTO `imagem_galeria` VALUES (2,'11111111111',8,1395331134,1),(3,'39116561813',1,1395404500,2);
/*!40000 ALTER TABLE `imagem_galeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem_tipoevento`
--

DROP TABLE IF EXISTS `imagem_tipoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem_tipoevento` (
  `idTipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEvento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_tipoevento`
--

LOCK TABLES `imagem_tipoevento` WRITE;
/*!40000 ALTER TABLE `imagem_tipoevento` DISABLE KEYS */;
INSERT INTO `imagem_tipoevento` VALUES (1,'Cadastro de Imagem'),(2,'Remoção de Imagem'),(3,'Alteração de Imagem'),(21,'Cadastro de Descritor'),(22,'Remoção de Descritor'),(23,'Alteração de Descritor');
/*!40000 ALTER TABLE `imagem_tipoevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro`
--

DROP TABLE IF EXISTS `livro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro` (
  `idLivro` int(11) NOT NULL AUTO_INCREMENT,
  `nomeLivro` varchar(45) CHARACTER SET latin1 NOT NULL,
  `quantidade` int(11) NOT NULL,
  `descricao` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataEntrada` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroPatrimonio` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `grafica` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idLivro`),
  KEY `fk_livro_area` (`area`),
  CONSTRAINT `fk_livro_area` FOREIGN KEY (`area`) REFERENCES `cursospolos_area` (`idArea`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro`
--

LOCK TABLES `livro` WRITE;
/*!40000 ALTER TABLE `livro` DISABLE KEYS */;
INSERT INTO `livro` VALUES (1,'Para baixa',1,'Para baixa','17/07/2014',NULL,4,'Para baixa');
/*!40000 ALTER TABLE `livro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_baixa`
--

DROP TABLE IF EXISTS `livro_baixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_baixa` (
  `idBaixa` int(11) NOT NULL AUTO_INCREMENT,
  `livro` int(11) NOT NULL,
  `saida` int(11) DEFAULT NULL,
  `dataBaixa` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeBaixa` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idBaixa`),
  KEY `fk_livro_baixa_livro1_idx` (`livro`),
  KEY `fk_livro_baixa_livro_saida1_idx` (`saida`),
  CONSTRAINT `fk_livro_baixa_livro1` FOREIGN KEY (`livro`) REFERENCES `livro` (`idLivro`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_baixa_livro_saida1` FOREIGN KEY (`saida`) REFERENCES `livro_saida` (`idSaida`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_baixa`
--

LOCK TABLES `livro_baixa` WRITE;
/*!40000 ALTER TABLE `livro_baixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_baixa` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `nova_baixa_livro` BEFORE INSERT ON `livro_baixa`
 FOR EACH ROW IF NEW.`saida` IS NOT NULL THEN
	UPDATE `livro_saida` SET `livro_saida`.`quantidadeSaida` = `livro_saida`.`quantidadeSaida` - NEW.`quantidadeBaixa` WHERE `livro_saida`.`idSaida` = NEW.saida;
	else
	UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` - NEW.`quantidadeBaixa` WHERE `livro`.`idLivro` = NEW.`livro`;
	END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eliminar_baixa_livro` BEFORE DELETE ON `livro_baixa`
 FOR EACH ROW IF OLD.`saida` IS NOT NULL THEN
	UPDATE `livro_saida` SET `livro_saida`.`quantidadeSaida` = `livro_saida`.`quantidadeSaida` + OLD.`quantidadeBaixa` WHERE `livro_saida`.`idSaida` = OLD.saida;
	else
	UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` + OLD.`quantidadeBaixa` WHERE `livro`.`idLivro` = OLD.`livro`;
	END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `livro_estado`
--

DROP TABLE IF EXISTS `livro_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_estado`
--

LOCK TABLES `livro_estado` WRITE;
/*!40000 ALTER TABLE `livro_estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_evento`
--

DROP TABLE IF EXISTS `livro_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_evento` (
  `idLivroEvento` int(11) NOT NULL AUTO_INCREMENT,
  `tipoEvento` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `livro` int(11) DEFAULT NULL,
  `baixa` int(11) DEFAULT NULL,
  `saida` int(11) DEFAULT NULL,
  `retorno` int(11) DEFAULT NULL,
  `data` bigint(20) NOT NULL COMMENT 'Unix timestamp',
  PRIMARY KEY (`idLivroEvento`),
  KEY `fk_livro_evento_livro_tipoEvento1_idx` (`tipoEvento`),
  KEY `fk_livro_evento_livro1_idx` (`livro`),
  KEY `fk_livro_evento_livro_baixa1_idx` (`baixa`),
  KEY `fk_livro_evento_livro_saida1_idx` (`saida`),
  KEY `fk_livro_evento_livro_retorno1_idx` (`retorno`),
  KEY `fk_livro_evento_usuario1_idx` (`usuario`),
  CONSTRAINT `fk_livro_evento_livro1` FOREIGN KEY (`livro`) REFERENCES `livro` (`idLivro`) ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_evento_livro_baixa1` FOREIGN KEY (`baixa`) REFERENCES `livro_baixa` (`idBaixa`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_evento_livro_retorno1` FOREIGN KEY (`retorno`) REFERENCES `livro_retorno` (`idRetorno`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_evento_livro_saida1` FOREIGN KEY (`saida`) REFERENCES `livro_saida` (`idSaida`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_evento_livro_tipoEvento1` FOREIGN KEY (`tipoEvento`) REFERENCES `livro_tipoevento` (`idTipoEvento`) ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_evento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_evento`
--

LOCK TABLES `livro_evento` WRITE;
/*!40000 ALTER TABLE `livro_evento` DISABLE KEYS */;
INSERT INTO `livro_evento` VALUES (1,1,1,1,NULL,NULL,NULL,1405604697),(2,41,1,NULL,NULL,NULL,1,1405604737);
/*!40000 ALTER TABLE `livro_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_retorno`
--

DROP TABLE IF EXISTS `livro_retorno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_retorno` (
  `idRetorno` int(11) NOT NULL AUTO_INCREMENT,
  `saida` int(11) NOT NULL,
  `dataRetorno` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeRetorno` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idRetorno`),
  KEY `fk_livro_retorno_livro_saida1_idx` (`saida`),
  CONSTRAINT `fk_livro_retorno_livro_saida1` FOREIGN KEY (`saida`) REFERENCES `livro_saida` (`idSaida`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_retorno`
--

LOCK TABLES `livro_retorno` WRITE;
/*!40000 ALTER TABLE `livro_retorno` DISABLE KEYS */;
INSERT INTO `livro_retorno` VALUES (1,1,'17/07/2014',1,'RETORNOU');
/*!40000 ALTER TABLE `livro_retorno` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `novo_retorno_livro` BEFORE INSERT ON `livro_retorno`
 FOR EACH ROW BEGIN
UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` + NEW.`quantidadeRetorno` WHERE `livro`.`idLivro` IN ( SELECT `livro` FROM `livro_saida` WHERE `livro_saida`.`idSaida` = NEW.`saida`);
UPDATE `livro_saida` set `livro_saida`.`quantidadeSaida` = `livro_saida`.`quantidadeSaida` - NEW.`quantidadeRetorno` WHERE `livro_saida`.`idSaida` = NEW.`saida`;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `livro_saida`
--

DROP TABLE IF EXISTS `livro_saida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_saida` (
  `idSaida` int(11) NOT NULL AUTO_INCREMENT,
  `livro` int(11) NOT NULL,
  `responsavel` int(11) NOT NULL,
  `destino` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantidadeSaida` int(11) NOT NULL,
  `quantidadeSaidaOriginal` int(11) NOT NULL,
  `dataSaida` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `poloDestino` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSaida`),
  KEY `fk_livro_saida_livro1_idx` (`livro`),
  KEY `fk_livro_saida_usuario1_idx` (`responsavel`),
  KEY `fk_livro_saida_polo1_idx` (`poloDestino`),
  CONSTRAINT `fk_livro_saida_livro1` FOREIGN KEY (`livro`) REFERENCES `livro` (`idLivro`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_saida_polo1` FOREIGN KEY (`poloDestino`) REFERENCES `cursospolos_polo` (`idPolo`) ON UPDATE CASCADE,
  CONSTRAINT `fk_livro_saida_usuario1` FOREIGN KEY (`responsavel`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_saida`
--

LOCK TABLES `livro_saida` WRITE;
/*!40000 ALTER TABLE `livro_saida` DISABLE KEYS */;
INSERT INTO `livro_saida` VALUES (1,1,1,NULL,0,1,'17/07/2014',5);
/*!40000 ALTER TABLE `livro_saida` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `nova_saida_livro` BEFORE INSERT ON `livro_saida`
 FOR EACH ROW UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` - NEW.`quantidadeSaida` WHERE `livro`.`idLivro` = NEW.`livro` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eliminar_saida_livro` BEFORE DELETE ON `livro_saida`
 FOR EACH ROW UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` + OLD.`quantidadeSaida` WHERE `livro`.`idLivro` = OLD.`livro` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `livro_tipoevento`
--

DROP TABLE IF EXISTS `livro_tipoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_tipoevento` (
  `idTipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEvento` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_tipoevento`
--

LOCK TABLES `livro_tipoevento` WRITE;
/*!40000 ALTER TABLE `livro_tipoevento` DISABLE KEYS */;
INSERT INTO `livro_tipoevento` VALUES (1,'Cadastro de Livro'),(2,'Remoção de Livro'),(3,'Alteração de Livro'),(21,'Cadastro de Baixa'),(22,'Remoção de Baixa'),(31,'Cadastro de Saída'),(32,'Remoção de Saída'),(41,'Cadastro de Retorno');
/*!40000 ALTER TABLE `livro_tipoevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistema_eventosistema`
--

DROP TABLE IF EXISTS `sistema_eventosistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sistema_eventosistema` (
  `ideventoSistema` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idUsuarioAlvo` int(11) DEFAULT NULL,
  `idTipoEventoSistema` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`ideventoSistema`),
  KEY `fk_eventoSistema_autor` (`idUsuario`),
  KEY `fk_eventoSistema_tipoEvento` (`ideventoSistema`),
  KEY `fk_eventoSistema_alvo` (`idUsuarioAlvo`),
  KEY `fk_eventoSistema_evento` (`idTipoEventoSistema`),
  CONSTRAINT `fk_eventoSistema_alvo` FOREIGN KEY (`idUsuarioAlvo`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_eventoSistema_autor` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_eventoSistema_evento` FOREIGN KEY (`idTipoEventoSistema`) REFERENCES `sistema_tipoevento` (`idTipoEventoSistema`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistema_eventosistema`
--

LOCK TABLES `sistema_eventosistema` WRITE;
/*!40000 ALTER TABLE `sistema_eventosistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `sistema_eventosistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistema_ferramenta`
--

DROP TABLE IF EXISTS `sistema_ferramenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sistema_ferramenta` (
  `idferramenta` int(11) NOT NULL,
  `nome` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idferramenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistema_ferramenta`
--

LOCK TABLES `sistema_ferramenta` WRITE;
/*!40000 ALTER TABLE `sistema_ferramenta` DISABLE KEYS */;
INSERT INTO `sistema_ferramenta` VALUES (1,'Controle de Usuarios'),(2,'Controle de Cursos e Polos'),(3,'Controle de Livros'),(4,'Controle de Equipamentos'),(5,'Controle de Documentos'),(6,'Controle de Viagens'),(7,'Tarefas'),(8,'Galeria de Imagens'),(9,'Processos');
/*!40000 ALTER TABLE `sistema_ferramenta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `nova_ferramenta` AFTER INSERT ON `sistema_ferramenta`
 FOR EACH ROW BEGIN
	DECLARE `i` INT DEFAULT 0;
	DECLARE `n` INT DEFAULT -1;
	SELECT min(`idUsuario`) FROM `usuario` INTO `i`;
	SELECT max(`idUsuario`) FROM `usuario` INTO `n`;
	WHILE `i` <= `n` do
		INSERT INTO `usuario_x_permissao_x_ferramenta` VALUES (i,NEW.idferramenta,1);
		SET `i` = `i` + 1;
	END WHILE;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `remover_ferramenta` AFTER DELETE ON `sistema_ferramenta`
 FOR EACH ROW DELETE FROM `usuario_x_permissao_x_ferramenta` WHERE `idFerramenta` = OLD.`idferramenta` */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `sistema_tipoevento`
--

DROP TABLE IF EXISTS `sistema_tipoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sistema_tipoevento` (
  `idTipoEventoSistema` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idTipoEventoSistema`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistema_tipoevento`
--

LOCK TABLES `sistema_tipoevento` WRITE;
/*!40000 ALTER TABLE `sistema_tipoevento` DISABLE KEYS */;
/*!40000 ALTER TABLE `sistema_tipoevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idPapel` int(11) NOT NULL,
  `senha` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `PNome` varchar(45) CHARACTER SET latin1 NOT NULL,
  `UNome` varchar(45) CHARACTER SET latin1 NOT NULL,
  `email` varchar(45) CHARACTER SET latin1 NOT NULL,
  `dataNascimento` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `iniciais` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `dataCadastro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ultimoAcesso` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  UNIQUE KEY `iniciais` (`iniciais`),
  KEY `fk_usuarios_papel` (`idPapel`),
  CONSTRAINT `fk_usuarios_papel` FOREIGN KEY (`idPapel`) REFERENCES `usuario_papel` (`idpapel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'202cb962ac59075b964b07152d234b70','Cead','Ead','admin@cead.com','28/09/1991',1,'11111111111','CE3','','1406902429'),(2,2,'e10adc3949ba59abbe56e057f20f883e','Reuel','Ramos Ribeiro','rulrok@gmail.com','28/09/1991',1,'39116561813','RRR','',''),(3,2,'e10adc3949ba59abbe56e057f20f883e','Gabriel','Hornink Souza','gabriel@gmail.com','01/01/2020',1,'22082879836','GHS','',''),(4,2,'202cb962ac59075b964b07152d234b70','Usuário','de testes','teste@cead.com','31/01/2014',0,'44444444444','Ut2','',''),(6,4,'6603dc207862ec39af10d91adfc02bc0','Cead','Ester','eliblue34@gmail.com','06/02/2014',0,'66666666666','CE2','',''),(7,2,'e10adc3949ba59abbe56e057f20f883e','Luciene','Gouveia','ceadunifal.luciene@gmail.com','03/02/2014',0,'77777777777','LG2','',''),(9,2,'e10adc3949ba59abbe56e057f20f883e','Marcos','Mazzon Filho','marcos.mazzonifilho@gmail.com','05/02/2014',1,'99999999999','MMF','',''),(22,2,'4297f44b13955235245b2497399d7a93','Reuel','Ribeiro','a11021@bcc.unifal-mg.edu.br',NULL,1,'22222222222','RR','',''),(23,4,'e10adc3949ba59abbe56e057f20f883e','Aluno','Teste','aluno@cead.com','09/07/2014',1,'35185311827','AT','1404914391','0'),(24,2,'e10adc3949ba59abbe56e057f20f883e','Luiz','da Silva','luiz@cead.com','01/08/2014',1,'78596682708','LS','1406902527','0');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `definir_iniciais` BEFORE INSERT ON `usuario`
 FOR EACH ROW SET NEW.`iniciais` = getNameInitials(concat(NEW.`PNome`," ",NEW.`UNome`),-1) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `atualizar_iniciais` BEFORE UPDATE ON `usuario`
 FOR EACH ROW IF NEW.PNome <> OLD.PNome OR NEW.UNome <> OLD.UNome THEN
	SET NEW.`iniciais` = getNameInitials(concat(NEW.`PNome`," ",NEW.`UNome`),NEW.idUsuario);
END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `usuario_acessos`
--

DROP TABLE IF EXISTS `usuario_acessos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_acessos` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `data` bigint(20) NOT NULL COMMENT 'Unix timestamp',
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `fk_usuarios_acessos` (`idUsuario`),
  CONSTRAINT `fk_usuarios_acessos` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_acessos`
--

LOCK TABLES `usuario_acessos` WRITE;
/*!40000 ALTER TABLE `usuario_acessos` DISABLE KEYS */;
INSERT INTO `usuario_acessos` VALUES (30,1,1395315422,'172.16.11.1'),(31,1,1395316589,'172.16.11.1'),(32,2,1395404446,'172.16.11.1'),(33,1,1395405182,'172.16.11.1'),(34,2,1395405206,'172.16.11.1'),(35,1,1395412165,'172.16.11.1'),(36,2,1395412218,'172.16.11.1'),(37,1,1395427130,'172.16.11.1'),(38,1,1395662492,'172.16.11.1'),(39,1,1395670439,'172.16.11.1'),(40,1,1395674150,'172.16.11.1'),(41,1,1395747918,'172.16.11.1'),(42,2,1395768375,'172.16.11.1'),(43,1,1395768386,'172.16.11.1'),(44,1,1395770659,'172.16.12.196'),(45,1,1395776150,'172.16.11.1'),(46,1,1395862634,'172.16.11.1'),(47,1,1395863784,'172.16.11.1'),(48,1,1395865274,'172.16.11.1'),(49,1,1395865406,'172.16.11.1'),(50,1,1395865636,'172.16.11.1'),(51,1,1395869420,'172.16.11.1'),(52,1,1395922437,'172.16.11.1'),(53,1,1395922844,'172.16.11.1'),(54,1,1395923388,'172.16.11.1'),(55,1,1395927505,'172.16.11.1'),(56,2,1395928350,'172.16.11.1'),(57,1,1395930401,'172.16.11.1'),(58,2,1395933828,'172.16.11.1'),(59,2,1395954825,'172.16.11.1'),(60,2,1395957433,'172.16.11.1'),(61,2,1395960816,'172.16.11.1'),(62,NULL,1395961932,'172.16.11.1'),(63,NULL,1395962896,'172.16.11.1'),(64,NULL,1395962915,'172.16.11.1'),(65,1,1395965376,'172.16.11.1'),(66,NULL,1395965541,'172.16.11.1'),(67,NULL,1395966230,'172.16.11.1'),(68,1,1395967241,'172.16.11.1'),(69,1,1405090197,'127.0.0.1'),(70,1,1405350221,'127.0.0.1'),(71,1,1405432862,'127.0.0.1'),(72,1,1405513070,'127.0.0.1'),(73,1,1405519668,'127.0.0.1'),(74,1,1405528398,'127.0.0.1'),(75,1,1405604649,'127.0.0.1'),(76,1,1405606542,'127.0.0.1'),(77,1,1405608131,'127.0.0.1'),(78,1,1406030530,'127.0.0.1'),(79,1,1406032900,'127.0.0.1'),(80,1,1406032987,'127.0.0.1'),(81,1,1406033073,'127.0.0.1'),(82,1,1406117562,'127.0.0.1'),(83,1,1406121293,'127.0.0.1'),(84,1,1406210939,'127.0.0.1'),(85,1,1406568593,'127.0.0.1'),(86,1,1406572738,'127.0.0.1'),(87,1,1406668676,'127.0.0.1'),(88,1,1406751464,'127.0.0.1'),(89,1,1406752532,'127.0.0.1'),(90,1,1406762847,'127.0.0.1'),(91,1,1406767165,'127.0.0.1'),(92,1,1406771485,'127.0.0.1'),(93,1,1406777117,'127.0.0.1'),(94,1,1406811027,'127.0.0.1'),(95,1,1406852013,'127.0.0.1'),(96,1,1406862389,'127.0.0.1'),(97,1,1406898790,'127.0.0.1'),(98,1,1406902429,'127.0.0.1');
/*!40000 ALTER TABLE `usuario_acessos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_papel`
--

DROP TABLE IF EXISTS `usuario_papel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_papel` (
  `idpapel` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 DEFAULT 'Sem descrição',
  PRIMARY KEY (`idpapel`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_papel`
--

LOCK TABLES `usuario_papel` WRITE;
/*!40000 ALTER TABLE `usuario_papel` DISABLE KEYS */;
INSERT INTO `usuario_papel` VALUES (1,'Administrador','Sem descrição'),(2,'Gestor','Sem descrição'),(3,'Professor','Sem descrição'),(4,'Aluno','Sem descrição');
/*!40000 ALTER TABLE `usuario_papel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_permissao`
--

DROP TABLE IF EXISTS `usuario_permissao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_permissao` (
  `idPermissao` int(11) NOT NULL,
  `tipo` varchar(45) CHARACTER SET latin1 NOT NULL,
  `descricao` varchar(65) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idPermissao`),
  UNIQUE KEY `tipo_UNIQUE` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_permissao`
--

LOCK TABLES `usuario_permissao` WRITE;
/*!40000 ALTER TABLE `usuario_permissao` DISABLE KEYS */;
INSERT INTO `usuario_permissao` VALUES (1,'Sem acesso',NULL),(10,'Consulta',NULL),(20,'Escrita',NULL),(30,'Gestor',NULL),(40,'Administrador',NULL);
/*!40000 ALTER TABLE `usuario_permissao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_recuperarsenha`
--

DROP TABLE IF EXISTS `usuario_recuperarsenha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_recuperarsenha` (
  `idUsuario` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `fk_usuario_idx` (`idUsuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_recuperarsenha`
--

LOCK TABLES `usuario_recuperarsenha` WRITE;
/*!40000 ALTER TABLE `usuario_recuperarsenha` DISABLE KEYS */;
INSERT INTO `usuario_recuperarsenha` VALUES (2,'b2d6aa1e4111fde91cd404043060509b');
/*!40000 ALTER TABLE `usuario_recuperarsenha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_x_permissao_x_ferramenta`
--

DROP TABLE IF EXISTS `usuario_x_permissao_x_ferramenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_x_permissao_x_ferramenta` (
  `idUsuario` int(11) NOT NULL,
  `idFerramenta` int(11) NOT NULL,
  `idPermissao` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idFerramenta`,`idPermissao`),
  KEY `fk_usuarios_permissoes_1` (`idPermissao`),
  KEY `fk_usuarios_permissoes_2` (`idFerramenta`),
  KEY `fk_usuarios_permissoes_3` (`idUsuario`),
  CONSTRAINT `fk_usuarios_permissoes_1` FOREIGN KEY (`idPermissao`) REFERENCES `usuario_permissao` (`idPermissao`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_permissoes_2` FOREIGN KEY (`idFerramenta`) REFERENCES `sistema_ferramenta` (`idferramenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_permissoes_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_x_permissao_x_ferramenta`
--

LOCK TABLES `usuario_x_permissao_x_ferramenta` WRITE;
/*!40000 ALTER TABLE `usuario_x_permissao_x_ferramenta` DISABLE KEYS */;
INSERT INTO `usuario_x_permissao_x_ferramenta` VALUES (3,7,1),(3,8,1),(4,6,1),(4,7,1),(4,8,1),(4,9,1),(6,7,1),(6,8,1),(6,9,1),(7,7,1),(7,8,1),(7,9,1),(6,1,10),(6,2,10),(6,3,10),(6,4,10),(6,5,10),(6,6,10),(7,1,10),(23,1,10),(23,2,10),(23,3,10),(23,4,10),(23,5,10),(23,6,10),(23,7,10),(23,8,10),(2,2,20),(2,3,20),(2,4,20),(2,5,20),(2,6,20),(2,8,20),(9,1,20),(9,2,20),(9,3,20),(9,4,20),(9,5,20),(9,6,20),(9,7,20),(9,8,20),(9,9,20),(2,7,30),(3,1,30),(3,2,30),(3,3,30),(3,4,30),(3,5,30),(3,6,30),(4,1,30),(4,2,30),(4,3,30),(4,4,30),(4,5,30),(7,2,30),(7,3,30),(7,4,30),(7,5,30),(7,6,30),(22,1,30),(22,2,30),(22,3,30),(22,4,30),(22,5,30),(22,6,30),(22,7,30),(22,8,30),(24,1,30),(24,2,30),(24,3,30),(24,4,30),(24,5,30),(24,6,30),(24,7,30),(24,8,30),(1,1,40),(1,2,40),(1,3,40),(1,4,40),(1,5,40),(1,6,40),(1,7,40),(1,8,40),(1,9,40),(2,1,40),(2,9,40);
/*!40000 ALTER TABLE `usuario_x_permissao_x_ferramenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viagem`
--

DROP TABLE IF EXISTS `viagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viagem` (
  `idViagem` int(11) NOT NULL AUTO_INCREMENT,
  `idCurso` int(11) NOT NULL,
  `idPolo` int(11) DEFAULT NULL,
  `responsavel` int(11) NOT NULL,
  `dataIda` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `horaIda` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataVolta` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `horaVolta` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motivo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estadoViagem` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diarias` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `outroDestino` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idViagem`),
  KEY `fk_viagem_curso1_idx` (`idCurso`),
  KEY `fk_viagem_polo1_idx` (`idPolo`),
  KEY `fk_viagem_usuario1_idx` (`responsavel`),
  CONSTRAINT `fk_viagem_curso1` FOREIGN KEY (`idCurso`) REFERENCES `cursospolos_curso` (`idCurso`) ON UPDATE CASCADE,
  CONSTRAINT `fk_viagem_polo1` FOREIGN KEY (`idPolo`) REFERENCES `cursospolos_polo` (`idPolo`) ON UPDATE CASCADE,
  CONSTRAINT `fk_viagem_usuario1` FOREIGN KEY (`responsavel`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viagem`
--

LOCK TABLES `viagem` WRITE;
/*!40000 ALTER TABLE `viagem` DISABLE KEYS */;
INSERT INTO `viagem` VALUES (25,3,1,2,'06/02/2014','00:00','20/02/2014','10:00','acompanhamento','Executada/controle-cead','2456',NULL);
/*!40000 ALTER TABLE `viagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viagem_passageiros`
--

DROP TABLE IF EXISTS `viagem_passageiros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viagem_passageiros` (
  `idViagem` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idViagem`,`idUsuario`),
  KEY `fk_viagem_has_usuario_usuario1_idx` (`idUsuario`),
  KEY `fk_viagem_has_usuario_viagem1_idx` (`idViagem`),
  CONSTRAINT `fk_viagem_has_usuario_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_viagem_has_usuario_viagem1` FOREIGN KEY (`idViagem`) REFERENCES `viagem` (`idViagem`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viagem_passageiros`
--

LOCK TABLES `viagem_passageiros` WRITE;
/*!40000 ALTER TABLE `viagem_passageiros` DISABLE KEYS */;
INSERT INTO `viagem_passageiros` VALUES (25,1),(25,6),(25,9);
/*!40000 ALTER TABLE `viagem_passageiros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'libello'
--
/*!50003 DROP FUNCTION IF EXISTS `getNameInitials` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `getNameInitials`(`fullname` VARCHAR(70), `idUsuarioAtual` INT(11)) RETURNS varchar(70) CHARSET utf8 COLLATE utf8_unicode_ci
    DETERMINISTIC
BEGIN
DECLARE `numero_convertido` INTEGER DEFAULT 0;
DECLARE `iniciais_usuario_atual` VARCHAR(10) DEFAULT '';
DECLARE `result` VARCHAR(70) DEFAULT '';
DECLARE `position` TINYINT;

DECLARE `separator` VARCHAR(1) DEFAULT ' ';
DECLARE `append` VARCHAR(1) DEFAULT '';

DECLARE `buffer` VARCHAR(10);

DECLARE `sameInitials` INTEGER;

SET `fullname` = REPLACE(`fullname`," dos "," ");
SET `fullname` = REPLACE(`fullname`," do "," ");
SET `fullname` = REPLACE(`fullname`," das "," ");
SET `fullname` = REPLACE(`fullname`," da "," ");
SET `fullname` = REPLACE(`fullname`," de "," ");

SET `fullname` = CONCAT(TRIM(`fullname`), `separator`);
SET `position` = LOCATE(`separator`, `fullname`);

IF NOT `position`
THEN RETURN LEFT(`fullname`,1);
END IF;

SET `result`   = CONCAT(LEFT(`fullname`,  1),`append`);

cycle: LOOP
    SET `fullname` = SUBSTR(`fullname`, `position` + 1);
    SET `position` = LOCATE(`separator`, `fullname`);

    IF NOT `position` OR NOT LENGTH(`fullname`)
    THEN LEAVE cycle;
    END IF;

    SET `buffer` = CONCAT(LEFT(`fullname`, 1), `append`);
    SET `result` = CONCAT_WS("", `result`, `buffer`);
END LOOP cycle;

SELECT `iniciais` INTO `iniciais_usuario_atual` FROM `usuario` u WHERE u.`idUsuario` <> `idUsuarioAtual` AND `iniciais` RLIKE concat(`result`,"[0-9]{0,2}$") ORDER BY `iniciais` DESC LIMIT 1;

IF `iniciais_usuario_atual` RLIKE "[0-9]" THEN
	SET `numero_convertido` = 1;
ELSEIF `iniciais_usuario_atual` RLIKE "[0-9]{2}" THEN
	SET `numero_convertido` = 2;
ELSEIF `iniciais_usuario_atual` RLIKE "[0-9]{3}" THEN
	SET `numero_convertido` = 3;
ELSE SET `numero_convertido` = 0;
END IF;

SET `sameInitials` = CAST(RIGHT(`iniciais_usuario_atual`,`numero_convertido`) AS SIGNED);
IF `sameInitials` > 0 THEN
SET `result` = concat(`result`,`sameInitials`+1);
END IF;

RETURN `result`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `regex_replace` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `regex_replace`(pattern VARCHAR(1000),replacement VARCHAR(1000),original VARCHAR(1000)) RETURNS varchar(1000) CHARSET utf8 COLLATE utf8_unicode_ci
    DETERMINISTIC
BEGIN 
 DECLARE temp VARCHAR(1000); 
 DECLARE ch VARCHAR(1); 
 DECLARE i INT;
 SET i = 1;
 SET temp = '';
 IF original REGEXP pattern THEN 
  loop_label: LOOP 
   IF i>CHAR_LENGTH(original) THEN
    LEAVE loop_label;  
   END IF;
   SET ch = SUBSTRING(original,i,1);
   IF NOT ch REGEXP pattern THEN
    SET temp = CONCAT(temp,ch);
   ELSE
    SET temp = CONCAT(temp,replacement);
   END IF;
   SET i=i+1;
  END LOOP;
 ELSE
  SET temp = original;
 END IF;
 RETURN temp;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-01 11:31:02
