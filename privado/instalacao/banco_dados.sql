-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 09/07/2014 às 11:00
-- Versão do servidor: 5.5.35-0ubuntu0.12.10.2
-- Versão do PHP: 5.4.6-1ubuntu1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `libello`
--

DELIMITER $$
--
-- Funções
--
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
END$$

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
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursospolos_area`
--

CREATE TABLE IF NOT EXISTS `cursospolos_area` (
  `idArea` int(11) NOT NULL AUTO_INCREMENT,
  `nomeArea` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idArea`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Fazendo dump de dados para tabela `cursospolos_area`
--

INSERT INTO `cursospolos_area` (`idArea`, `nomeArea`) VALUES
(1, 'Ciências Exatas e da Terra'),
(2, 'Ciências Humanas'),
(3, 'Ciências Biológicas'),
(4, 'Ciências Agrárias'),
(5, 'Ciências da Saúde'),
(6, 'Ciências Sociais Aplicadas'),
(7, 'Engenharias'),
(8, 'Linguísticas, letras e artes'),
(9, 'Multidisciplinas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursospolos_curso`
--

CREATE TABLE IF NOT EXISTS `cursospolos_curso` (
  `idCurso` int(11) NOT NULL AUTO_INCREMENT,
  `nomeCurso` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCurso`),
  KEY `fk_curso_tipo` (`tipo`),
  KEY `fk_curso_area` (`area`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Fazendo dump de dados para tabela `cursospolos_curso`
--

INSERT INTO `cursospolos_curso` (`idCurso`, `nomeCurso`, `area`, `tipo`) VALUES
(50, 'Retórica II', 8, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursospolos_polo`
--

CREATE TABLE IF NOT EXISTS `cursospolos_polo` (
  `idPolo` int(11) NOT NULL AUTO_INCREMENT,
  `nomePolo` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET latin1 NOT NULL,
  `estado` char(2) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idPolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Fazendo dump de dados para tabela `cursospolos_polo`
--

INSERT INTO `cursospolos_polo` (`idPolo`, `nomePolo`, `cidade`, `estado`) VALUES
(5, 'Japaguá', 'Varginha', 'MG');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursospolos_tipocurso`
--

CREATE TABLE IF NOT EXISTS `cursospolos_tipocurso` (
  `idTipoCurso` int(11) NOT NULL AUTO_INCREMENT,
  `nomeTipoCurso` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipoCurso`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `cursospolos_tipocurso`
--

INSERT INTO `cursospolos_tipocurso` (`idTipoCurso`, `nomeTipoCurso`) VALUES
(1, 'Graduação'),
(2, 'Pós-Graduação Lato Sensu'),
(3, 'Pós-Graduação Strictu Sensu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `documento_memorando`
--

CREATE TABLE IF NOT EXISTS `documento_memorando` (
  `idMemorando` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `assunto` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoSigla` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `numMemorando` int(11) NOT NULL,
  `estadoValidacao` int(11) NOT NULL DEFAULT '1',
  `estadoEdicao` int(11) NOT NULL,
  `tratamento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_destino` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `corpo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idMemorando`),
  KEY `fk_memorando_usuario1_idx` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `documento_oficio`
--

CREATE TABLE IF NOT EXISTS `documento_oficio` (
  `idOficio` int(11) NOT NULL,
  `assunto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `corpo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estadoValidacao` int(11) NOT NULL DEFAULT '1',
  `estadoEdicao` int(11) NOT NULL,
  `destino` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `numOficio` int(11) NOT NULL,
  `data` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoSigla` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `referencia` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_remetente` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tratamento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_destino` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idOficio`),
  KEY `fk_oficio_usuario1_idx` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `documento_oficio`
--

INSERT INTO `documento_oficio` (`idOficio`, `assunto`, `corpo`, `idUsuario`, `estadoValidacao`, `estadoEdicao`, `destino`, `numOficio`, `data`, `tipoSigla`, `referencia`, `remetente`, `cargo_remetente`, `tratamento`, `cargo_destino`) VALUES
(2, 'teste_2', '<p>teste_2</p>', 1, 1, 1, 'teste_2', -1, '18/03/2014', 'TEC', 'teste_2', 'teste_2', 'teste_2', 'teste_2', 'teste_2'),
(3, 'teste_2', '<p>teste_2</p>', 1, 1, 1, 'teste_2', -1, '18/03/2014', 'TEC', 'teste_2', 'teste_2', 'teste_2', 'teste_2', 'teste_2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento`
--

CREATE TABLE IF NOT EXISTS `equipamento` (
  `idEquipamento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEquipamento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quantidade` int(11) NOT NULL,
  `descricao` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataEntrada` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroPatrimonio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idEquipamento`),
  UNIQUE KEY `numeroPatrimonio` (`numeroPatrimonio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento_baixa`
--

CREATE TABLE IF NOT EXISTS `equipamento_baixa` (
  `idBaixa` int(11) NOT NULL AUTO_INCREMENT,
  `equipamento` int(11) NOT NULL,
  `saida` int(11) DEFAULT NULL,
  `dataBaixa` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeBaixa` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idBaixa`),
  KEY `fk_equipamento_baixa_equipamento1_idx` (`equipamento`),
  KEY `fk_equipamento_baixa_equipamento_saida1_idx` (`saida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Gatilhos `equipamento_baixa`
--
DROP TRIGGER IF EXISTS `eliminar_baixa_equipamento`;
DELIMITER //
CREATE TRIGGER `eliminar_baixa_equipamento` BEFORE DELETE ON `equipamento_baixa`
 FOR EACH ROW IF OLD.`saida` IS NOT NULL THEN
	UPDATE `equipamento_saida` SET `equipamento_saida`.`quantidadeSaida` = `equipamento_saida`.`quantidadeSaida` + OLD.`quantidadeBaixa` WHERE `equipamento_saida`.`idSaida` = OLD.saida;
	else
	UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` + OLD.`quantidadeBaixa` WHERE `equipamento`.`idEquipamento` = OLD.`equipamento`;
	END IF
//
DELIMITER ;
DROP TRIGGER IF EXISTS `nova_baixa_equipamento`;
DELIMITER //
CREATE TRIGGER `nova_baixa_equipamento` BEFORE INSERT ON `equipamento_baixa`
 FOR EACH ROW IF NEW.`saida` IS NOT NULL THEN
	UPDATE `equipamento_saida` SET `equipamento_saida`.`quantidadeSaida` = `equipamento_saida`.`quantidadeSaida` - NEW.`quantidadeBaixa` WHERE `equipamento_saida`.`idSaida` = NEW.saida;
	else
	UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` - NEW.`quantidadeBaixa` WHERE `equipamento`.`idEquipamento` = NEW.`equipamento`;
	END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento_evento`
--

CREATE TABLE IF NOT EXISTS `equipamento_evento` (
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
  KEY `fk_equipamento_evento_equipamento_tipoEvento1_idx` (`tipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento_retorno`
--

CREATE TABLE IF NOT EXISTS `equipamento_retorno` (
  `idRetorno` int(11) NOT NULL AUTO_INCREMENT,
  `saida` int(11) NOT NULL,
  `dataRetorno` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeRetorno` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idRetorno`),
  KEY `fk_equipamento_retorno_equipamento_saida1_idx` (`saida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Gatilhos `equipamento_retorno`
--
DROP TRIGGER IF EXISTS `novo_retorno_equipamento`;
DELIMITER //
CREATE TRIGGER `novo_retorno_equipamento` BEFORE INSERT ON `equipamento_retorno`
 FOR EACH ROW BEGIN
UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` + NEW.`quantidadeRetorno` WHERE `equipamento`.`idEquipamento` IN ( SELECT `equipamento` FROM `equipamento_saida` WHERE `equipamento_saida`.`idSaida` = NEW.`saida`);
UPDATE `equipamento_saida` set `equipamento_saida`.`quantidadeSaida` = `equipamento_saida`.`quantidadeSaida` - NEW.`quantidadeRetorno` WHERE `equipamento_saida`.`idSaida` = NEW.`saida`;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento_saida`
--

CREATE TABLE IF NOT EXISTS `equipamento_saida` (
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
  KEY `fk_equipamento_saida_polo1_idx` (`poloDestino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Gatilhos `equipamento_saida`
--
DROP TRIGGER IF EXISTS `eliminar_saida_equipamento`;
DELIMITER //
CREATE TRIGGER `eliminar_saida_equipamento` BEFORE DELETE ON `equipamento_saida`
 FOR EACH ROW UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` + OLD.`quantidadeSaida` WHERE `equipamento`.`idEquipamento` = OLD.`equipamento`
//
DELIMITER ;
DROP TRIGGER IF EXISTS `nova_saida_equipamento`;
DELIMITER //
CREATE TRIGGER `nova_saida_equipamento` BEFORE INSERT ON `equipamento_saida`
 FOR EACH ROW UPDATE `equipamento` SET `equipamento`.`quantidade` = `equipamento`.`quantidade` - NEW.`quantidadeSaida` WHERE `equipamento`.`idEquipamento` = NEW.`equipamento`
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento_tipoevento`
--

CREATE TABLE IF NOT EXISTS `equipamento_tipoevento` (
  `idTipoEvento` int(11) NOT NULL,
  `nomeEvento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `equipamento_tipoevento`
--

INSERT INTO `equipamento_tipoevento` (`idTipoEvento`, `nomeEvento`) VALUES
(1, 'Cadastro de Equipamento'),
(2, 'Remoção de Equipamento'),
(3, 'Alteração de Equipamento'),
(21, 'Cadastro de Baixa'),
(22, 'Remoção de Baixa'),
(31, 'Cadastro de Saída'),
(32, 'Remoção de Saída'),
(41, 'Cadastro de Retorno');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem`
--

CREATE TABLE IF NOT EXISTS `imagem` (
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
  KEY `fk_imagens_imagem_usuario1_idx` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Fazendo dump de dados para tabela `imagem`
--

INSERT INTO `imagem` (`idImagem`, `idGaleria`, `autor`, `cpfAutor`, `titulo`, `observacoes`, `dificuldade`, `ano`, `utilizadoAvaliacao`, `avaliacao`, `anoAvaliacao`, `diretorio`, `diretorioMiniatura`, `nomeArquivo`, `nomeArquivoMiniatura`, `nomeArquivoVetorial`, `descritor1`, `descritor2`, `descritor3`, `descritor4`, `dataCadastro`) VALUES
(1, 2, 1, '11111111111', 'Teste dia 25', 'Testando uma decricao muito longa, que possivelmente ocupará muitas linhas.Este teste visa testar o comportamento do componenete jquery para imagens com longas descricoes, para garantir que tudo será exibido corretamente. Entretanto, veja que há uma raposa caminhando pelo campo, ela veio e me perguntou: -What time is it? E prontamente eu respondi: - It''s adventure time. Outro dia mesmo, estava eu andando por baixo das amoreiras, quando novamente me veio de encontro a raposa, ela estava inquieta, havia perdido seu relogio de bolso e não conseguia encontrar-lo. Ofereci-me em ajuda e nos colocamos a buscar pelo seu pertence. Pouco tempo depois, ela se lembrou que não o havia perdido, mas sim que raposas não usam relógios de bolso. Após isso pegamos algumas amoras e ela foi embora. Acordo de madrugada, sem sono, vou olhar o céu escuro; nesse horário do dia é possível ver alguns coelhos voando para a migração do sul, criaturas simpáticas, mas não sabia que coelhos poderiam voar também...', 'B', '2014', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-B-CE3_1395751275.png', '2-1-1-B-CE3_thumb_1395751275.png', '2-1-1-B-CE3_vetorial_1395751275.svg', 15, 18, 19, 23, 1395751276),
(7, 2, 1, '11111111111', 'Header', '', 'D', '2014', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '1-2-1-D-CE3_1395350720.jpg', '1-2-1-D-CE3_thumb_1395350720.jpg', '1-2-1-D-CE3_vetorial_1395350720.svg', 8, 25, 10, 22, 1395350720),
(9, 3, 2, '39116561813', 'Cachorro', '', 'C', '2013', '0', NULL, NULL, 'privado/galerias/39116561813/', 'privado/galerias/miniaturas/39116561813/', '1-2-1-C-CE3_1395404501.jpg', '1-2-1-C-CE3_thumb_1395404501.jpg', '1-2-1-C-CE3_vetorial_1395404501.svg', 8, 25, 10, 24, 1395404501),
(10, 2, 1, '11111111111', 'SBBQ', 'Logo da SBBQ', 'C', '2010', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-C-CE3_1395664416.png', '2-1-1-C-CE3_thumb_1395664416.png', '2-1-1-C-CE3_vetorial_1395664416.svg', 15, 18, 19, 23, 1395664422),
(11, 2, 1, '11111111111', 'Screenshot alberto', 'BigBlueButton', 'D', '2014', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-D-CE3_1395664633.png', '2-1-1-D-CE3_thumb_1395664633.png', '2-1-1-D-CE3_vetorial_1395664633.svg', 15, 18, 19, 23, 1395664633),
(13, 2, 1, '11111111111', 'Gimp imagem', '', 'A', '2014', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-A-CE3_1395865448.png', '2-1-1-A-CE3_thumb_1395865448.png', '2-1-1-A-CE3_vetorial_1395865448.xcf', 15, 18, 19, 23, 1395865448),
(14, 2, 1, '11111111111', 'Teste', '', 'B', '2020', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-B-CE3_1395866118.jpg', '2-1-1-B-CE3_thumb_1395866118.jpg', '2-1-1-B-CE3_vetorial_1395866118.cdr', 15, 18, 19, 23, 1395866134),
(15, 2, 1, '11111111111', 'Calculadora', '', 'A', '1991', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-A-CE3_1395866518.png', '2-1-1-A-CE3_thumb_1395866518.png', '2-1-1-A-CE3_vetorial_1395866518.cdr', 15, 18, 19, 23, 1395866523),
(16, 2, 1, '11111111111', 'Imagem', '', 'C', '1980', '0', NULL, NULL, 'privado/galerias/11111111111/', 'privado/galerias/miniaturas/11111111111/', '2-1-1-C-CE3_1396013912.png', '2-1-1-C-CE3_thumb_1396013912.png', '2-1-1-C-CE3_vetorial_1396013912.xcf', 15, 18, 19, 23, 1396013912);

--
-- Gatilhos `imagem`
--
DROP TRIGGER IF EXISTS `imagem_imagemCadastrada`;
DELIMITER //
CREATE TRIGGER `imagem_imagemCadastrada` AFTER INSERT ON `imagem`
 FOR EACH ROW UPDATE `imagem_galeria` SET `qtdFotos` = `qtdFotos` + 1 WHERE `imagem_galeria`.`idGaleria` = NEW.`idGaleria`
//
DELIMITER ;
DROP TRIGGER IF EXISTS `imagem_imagemRemovida`;
DELIMITER //
CREATE TRIGGER `imagem_imagemRemovida` AFTER DELETE ON `imagem`
 FOR EACH ROW UPDATE `imagem_galeria` SET `qtdFotos` = `qtdFotos` - 1 WHERE `imagem_galeria`.`idGaleria` = OLD.`idGaleria`
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem_descritor`
--

CREATE TABLE IF NOT EXISTS `imagem_descritor` (
  `idDescritor` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pai` int(11) DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `rotulo` int(11) NOT NULL,
  `qtdFilhos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idDescritor`),
  UNIQUE KEY `nivel nome pai` (`nivel`,`nome`,`pai`),
  KEY `fk_imagens_descritor_imagens_descritor1_idx` (`pai`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70 ;

--
-- Fazendo dump de dados para tabela `imagem_descritor`
--

INSERT INTO `imagem_descritor` (`idDescritor`, `nome`, `pai`, `nivel`, `rotulo`, `qtdFilhos`) VALUES
(0, 'NIL', NULL, 0, 0, 4),
(8, 'Cachorro', 0, 1, 1, 3),
(9, 'Grande', 8, 2, 1, 0),
(10, 'Peludo', 25, 3, 1, 2),
(15, 'Teste', 0, 1, 2, 1),
(18, 'Teste', 15, 2, 1, 1),
(19, 'Teste', 18, 3, 1, 1),
(22, 'Correndo', 10, 4, 1, 0),
(23, 'Teste', 19, 4, 1, 0),
(24, 'Em pé', 10, 4, 2, 0),
(25, 'Medio', 8, 2, 2, 1),
(26, 'Pequeno', 8, 2, 3, 0),
(31, 'Comida', 0, 1, 3, 5),
(54, 'Novo descritor 1', 31, 2, 2, 0),
(55, 'Novo descritor 2', 31, 2, 3, 0),
(56, 'Novo descritor 3', 31, 2, 4, 0),
(57, 'Novo descritor 4', 31, 2, 5, 0),
(58, 'Novo descritor 5', 31, 2, 6, 1),
(59, 'Novo descritor', 58, 3, 1, 1),
(60, 'Novo descritor', 59, 4, 1, 0),
(61, 'Pessoas', 0, 1, 4, 1),
(62, 'Crianças', 61, 2, 1, 2),
(63, 'Brincando', 62, 3, 1, 3),
(64, 'Juntas', 63, 4, 1, 0),
(65, 'Acompanhadas', 63, 4, 2, 0),
(66, 'Supervisionadas', 63, 4, 3, 0),
(67, 'Estudando', 62, 3, 2, 2),
(68, 'Na escola', 67, 4, 1, 0),
(69, 'Em casa', 67, 4, 2, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem_descritor_aux_inserir`
--

CREATE TABLE IF NOT EXISTS `imagem_descritor_aux_inserir` (
  `idDescritorAux` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pai` int(11) NOT NULL,
  PRIMARY KEY (`idDescritorAux`),
  KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Auxilia na manutenção dos valores ''nível'', ''rotulo'' e ''qtdFilhos'' de imagens_descritor, o MySQL ainda não permite triggers que modificam a  tabela que ativou-o' AUTO_INCREMENT=41 ;

--
-- Fazendo dump de dados para tabela `imagem_descritor_aux_inserir`
--

INSERT INTO `imagem_descritor_aux_inserir` (`idDescritorAux`, `nome`, `pai`) VALUES
(1, 'Teste 2', 19),
(2, 'Novo descritor', 19),
(3, 'Novo descritor', 0),
(4, 'Novo descritor', 29),
(5, 'Novo descritor', 0),
(6, 'Novo descritor', 31),
(7, 'Novo descritor 1', 31),
(8, 'Novo descritor 2', 31),
(9, 'Novo descritor 3', 31),
(10, 'Novo descritor 4', 31),
(11, 'Novo descritor 5', 31),
(12, 'Novo descritor 6', 31),
(13, 'Novo descritor', 35),
(14, 'Novo descritor', 32),
(15, 'Novo descritor 1', 32),
(16, 'Novo descritor 2', 32),
(17, 'Novo descritor 7', 31),
(18, 'Novo descritor', 39),
(19, 'Novo descritor 3', 32),
(20, 'Novo descritor 8', 31),
(21, 'Novo descritor 4', 32),
(22, 'Novo descritor 7', 31),
(23, 'Novo descritor 8', 31),
(24, 'Novo descritor', 31),
(25, 'Novo descritor 1', 31),
(26, 'Novo descritor 2', 31),
(27, 'Novo descritor 3', 31),
(28, 'Novo descritor 4', 31),
(29, 'Novo descritor 5', 31),
(30, 'Novo descritor', 58),
(31, 'Novo descritor', 59),
(32, 'Pessoas', 0),
(33, 'Crianças', 61),
(34, 'Brincando', 62),
(35, 'Juntas', 63),
(36, 'Acompanhadas', 63),
(37, 'Supervisionadas', 63),
(38, 'Estudando', 62),
(39, 'Na escola', 67),
(40, 'Em casa', 67);

--
-- Gatilhos `imagem_descritor_aux_inserir`
--
DROP TRIGGER IF EXISTS `imagem_descritor_aux`;
DELIMITER //
CREATE TRIGGER `imagem_descritor_aux` BEFORE INSERT ON `imagem_descritor_aux_inserir`
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
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem_descritor_aux_remover`
--

CREATE TABLE IF NOT EXISTS `imagem_descritor_aux_remover` (
  `idDescritor` int(11) NOT NULL AUTO_INCREMENT,
  `pai` int(11) NOT NULL,
  `descritor` int(11) NOT NULL,
  PRIMARY KEY (`idDescritor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Auxilia na manutenção dos valores ''nível'', ''rotulo'' e ''qtdFilhos'' de imagens_descritor, o MySQL ainda não permite triggers que modificam a  tabela que ativou-o' AUTO_INCREMENT=1 ;

--
-- Gatilhos `imagem_descritor_aux_remover`
--
DROP TRIGGER IF EXISTS `imagem_descritor_aux_remover`;
DELIMITER //
CREATE TRIGGER `imagem_descritor_aux_remover` BEFORE INSERT ON `imagem_descritor_aux_remover`
 FOR EACH ROW BEGIN
SET @qtd = 0;
SELECT qtdFilhos - 1 INTO @qtd FROM imagem_descritor WHERE idDescritor = NEW.pai;
UPDATE imagem_descritor SET qtdFilhos = @qtd WHERE idDescritor = NEW.pai;
DELETE FROM imagem_descritor WHERE idDescritor = NEW.descritor;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem_evento`
--

CREATE TABLE IF NOT EXISTS `imagem_evento` (
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
  KEY `fk_imagens_evento_imagens_tipoEvento1_idx` (`tipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem_galeria`
--

CREATE TABLE IF NOT EXISTS `imagem_galeria` (
  `idGaleria` int(11) NOT NULL AUTO_INCREMENT,
  `nomeGaleria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `qtdFotos` int(11) DEFAULT '0',
  `dataCriacao` bigint(20) DEFAULT NULL COMMENT 'Unix timestamp',
  `autor` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGaleria`),
  KEY `fk_imagem_galeria_usuario1_idx` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `imagem_galeria`
--

INSERT INTO `imagem_galeria` (`idGaleria`, `nomeGaleria`, `qtdFotos`, `dataCriacao`, `autor`) VALUES
(2, '11111111111', 8, 1395331134, 1),
(3, '39116561813', 1, 1395404500, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem_tipoevento`
--

CREATE TABLE IF NOT EXISTS `imagem_tipoevento` (
  `idTipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEvento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Fazendo dump de dados para tabela `imagem_tipoevento`
--

INSERT INTO `imagem_tipoevento` (`idTipoEvento`, `nomeEvento`) VALUES
(1, 'Cadastro de Imagem'),
(2, 'Remoção de Imagem'),
(3, 'Alteração de Imagem'),
(21, 'Cadastro de Descritor'),
(22, 'Remoção de Descritor'),
(23, 'Alteração de Descritor');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

CREATE TABLE IF NOT EXISTS `livro` (
  `idLivro` int(11) NOT NULL AUTO_INCREMENT,
  `nomeLivro` varchar(45) CHARACTER SET latin1 NOT NULL,
  `quantidade` int(11) NOT NULL,
  `descricao` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataEntrada` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroPatrimonio` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `grafica` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idLivro`),
  KEY `fk_livro_area` (`area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro_baixa`
--

CREATE TABLE IF NOT EXISTS `livro_baixa` (
  `idBaixa` int(11) NOT NULL AUTO_INCREMENT,
  `livro` int(11) NOT NULL,
  `saida` int(11) DEFAULT NULL,
  `dataBaixa` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeBaixa` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idBaixa`),
  KEY `fk_livro_baixa_livro1_idx` (`livro`),
  KEY `fk_livro_baixa_livro_saida1_idx` (`saida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Gatilhos `livro_baixa`
--
DROP TRIGGER IF EXISTS `eliminar_baixa_livro`;
DELIMITER //
CREATE TRIGGER `eliminar_baixa_livro` BEFORE DELETE ON `livro_baixa`
 FOR EACH ROW IF OLD.`saida` IS NOT NULL THEN
	UPDATE `livro_saida` SET `livro_saida`.`quantidadeSaida` = `livro_saida`.`quantidadeSaida` + OLD.`quantidadeBaixa` WHERE `livro_saida`.`idSaida` = OLD.saida;
	else
	UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` + OLD.`quantidadeBaixa` WHERE `livro`.`idLivro` = OLD.`livro`;
	END IF
//
DELIMITER ;
DROP TRIGGER IF EXISTS `nova_baixa_livro`;
DELIMITER //
CREATE TRIGGER `nova_baixa_livro` BEFORE INSERT ON `livro_baixa`
 FOR EACH ROW IF NEW.`saida` IS NOT NULL THEN
	UPDATE `livro_saida` SET `livro_saida`.`quantidadeSaida` = `livro_saida`.`quantidadeSaida` - NEW.`quantidadeBaixa` WHERE `livro_saida`.`idSaida` = NEW.saida;
	else
	UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` - NEW.`quantidadeBaixa` WHERE `livro`.`idLivro` = NEW.`livro`;
	END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro_estado`
--

CREATE TABLE IF NOT EXISTS `livro_estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro_evento`
--

CREATE TABLE IF NOT EXISTS `livro_evento` (
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
  KEY `fk_livro_evento_usuario1_idx` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro_retorno`
--

CREATE TABLE IF NOT EXISTS `livro_retorno` (
  `idRetorno` int(11) NOT NULL AUTO_INCREMENT,
  `saida` int(11) NOT NULL,
  `dataRetorno` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeRetorno` int(11) NOT NULL,
  `observacoes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idRetorno`),
  KEY `fk_livro_retorno_livro_saida1_idx` (`saida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Gatilhos `livro_retorno`
--
DROP TRIGGER IF EXISTS `novo_retorno_livro`;
DELIMITER //
CREATE TRIGGER `novo_retorno_livro` BEFORE INSERT ON `livro_retorno`
 FOR EACH ROW BEGIN
UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` + NEW.`quantidadeRetorno` WHERE `livro`.`idLivro` IN ( SELECT `livro` FROM `livro_saida` WHERE `livro_saida`.`idSaida` = NEW.`saida`);
UPDATE `livro_saida` set `livro_saida`.`quantidadeSaida` = `livro_saida`.`quantidadeSaida` - NEW.`quantidadeRetorno` WHERE `livro_saida`.`idSaida` = NEW.`saida`;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro_saida`
--

CREATE TABLE IF NOT EXISTS `livro_saida` (
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
  KEY `fk_livro_saida_polo1_idx` (`poloDestino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Gatilhos `livro_saida`
--
DROP TRIGGER IF EXISTS `eliminar_saida_livro`;
DELIMITER //
CREATE TRIGGER `eliminar_saida_livro` BEFORE DELETE ON `livro_saida`
 FOR EACH ROW UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` + OLD.`quantidadeSaida` WHERE `livro`.`idLivro` = OLD.`livro`
//
DELIMITER ;
DROP TRIGGER IF EXISTS `nova_saida_livro`;
DELIMITER //
CREATE TRIGGER `nova_saida_livro` BEFORE INSERT ON `livro_saida`
 FOR EACH ROW UPDATE `livro` SET `livro`.`quantidade` = `livro`.`quantidade` - NEW.`quantidadeSaida` WHERE `livro`.`idLivro` = NEW.`livro`
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro_tipoevento`
--

CREATE TABLE IF NOT EXISTS `livro_tipoevento` (
  `idTipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEvento` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Fazendo dump de dados para tabela `livro_tipoevento`
--

INSERT INTO `livro_tipoevento` (`idTipoEvento`, `nomeEvento`) VALUES
(1, 'Cadastro de Livro'),
(2, 'Remoção de Livro'),
(3, 'Alteração de Livro'),
(21, 'Cadastro de Baixa'),
(22, 'Remoção de Baixa'),
(31, 'Cadastro de Saída'),
(32, 'Remoção de Saída'),
(41, 'Cadastro de Retorno');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sistema_eventosistema`
--

CREATE TABLE IF NOT EXISTS `sistema_eventosistema` (
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
  KEY `fk_eventoSistema_evento` (`idTipoEventoSistema`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sistema_ferramenta`
--

CREATE TABLE IF NOT EXISTS `sistema_ferramenta` (
  `idferramenta` int(11) NOT NULL,
  `nome` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idferramenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `sistema_ferramenta`
--

INSERT INTO `sistema_ferramenta` (`idferramenta`, `nome`) VALUES
(1, 'Controle de Usuarios'),
(2, 'Controle de Cursos e Polos'),
(3, 'Controle de Livros'),
(4, 'Controle de Equipamentos'),
(5, 'Controle de Documentos'),
(6, 'Controle de Viagens'),
(7, 'Tarefas'),
(8, 'Galeria de Imagens'),
(9, 'Processos');

--
-- Gatilhos `sistema_ferramenta`
--
DROP TRIGGER IF EXISTS `nova_ferramenta`;
DELIMITER //
CREATE TRIGGER `nova_ferramenta` AFTER INSERT ON `sistema_ferramenta`
 FOR EACH ROW BEGIN
	DECLARE `i` INT DEFAULT 0;
	DECLARE `n` INT DEFAULT -1;
	SELECT min(`idUsuario`) FROM `usuario` INTO `i`;
	SELECT max(`idUsuario`) FROM `usuario` INTO `n`;
	WHILE `i` <= `n` do
		INSERT INTO `usuario_x_permissao_x_ferramenta` VALUES (i,NEW.idferramenta,1);
		SET `i` = `i` + 1;
	END WHILE;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `remover_ferramenta`;
DELIMITER //
CREATE TRIGGER `remover_ferramenta` AFTER DELETE ON `sistema_ferramenta`
 FOR EACH ROW DELETE FROM `usuario_x_permissao_x_ferramenta` WHERE `idFerramenta` = OLD.`idferramenta`
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sistema_tipoevento`
--

CREATE TABLE IF NOT EXISTS `sistema_tipoevento` (
  `idTipoEventoSistema` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idTipoEventoSistema`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
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
  KEY `fk_usuarios_papel` (`idPapel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `idPapel`, `senha`, `PNome`, `UNome`, `email`, `dataNascimento`, `ativo`, `cpf`, `iniciais`, `dataCadastro`, `ultimoAcesso`) VALUES
(1, 1, '202cb962ac59075b964b07152d234b70', 'Cead', 'Ead', 'admin@cead.com', '28/09/1991', 1, '11111111111', 'CE3', '', ''),
(2, 2, 'e10adc3949ba59abbe56e057f20f883e', 'Reuel', 'Ramos Ribeiro', 'rulrok@gmail.com', '28/09/1991', 1, '39116561813', 'RRR', '', ''),
(3, 2, 'e10adc3949ba59abbe56e057f20f883e', 'Gabriel', 'Hornink Souza', 'gabriel@gmail.com', '01/01/2020', 1, '22082879836', 'GHS', '', ''),
(4, 2, '202cb962ac59075b964b07152d234b70', 'Usuário', 'de testes', 'teste@cead.com', '31/01/2014', 0, '44444444444', 'Ut2', '', ''),
(6, 4, '6603dc207862ec39af10d91adfc02bc0', 'Cead', 'Ester', 'eliblue34@gmail.com', '06/02/2014', 0, '66666666666', 'CE2', '', ''),
(7, 2, 'e10adc3949ba59abbe56e057f20f883e', 'Luciene', 'Gouveia', 'ceadunifal.luciene@gmail.com', '03/02/2014', 0, '77777777777', 'LG2', '', ''),
(9, 2, 'e10adc3949ba59abbe56e057f20f883e', 'Marcos', 'Mazzon Filho', 'marcos.mazzonifilho@gmail.com', '05/02/2014', 1, '99999999999', 'MMF', '', ''),
(22, 2, '4297f44b13955235245b2497399d7a93', 'Reuel', 'Ribeiro', 'a11021@bcc.unifal-mg.edu.br', NULL, 1, '22222222222', 'RR', '', ''),
(23, 4, 'e10adc3949ba59abbe56e057f20f883e', 'Aluno', 'Teste', 'aluno@cead.com', '09/07/2014', 1, '35185311827', 'AT', '1404914391', '0');

--
-- Gatilhos `usuario`
--
DROP TRIGGER IF EXISTS `atualizar_iniciais`;
DELIMITER //
CREATE TRIGGER `atualizar_iniciais` BEFORE UPDATE ON `usuario`
 FOR EACH ROW IF NEW.PNome <> OLD.PNome OR NEW.UNome <> OLD.UNome THEN
	SET NEW.`iniciais` = getNameInitials(concat(NEW.`PNome`," ",NEW.`UNome`),NEW.idUsuario);
END IF
//
DELIMITER ;
DROP TRIGGER IF EXISTS `definir_iniciais`;
DELIMITER //
CREATE TRIGGER `definir_iniciais` BEFORE INSERT ON `usuario`
 FOR EACH ROW SET NEW.`iniciais` = getNameInitials(concat(NEW.`PNome`," ",NEW.`UNome`),-1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_acessos`
--

CREATE TABLE IF NOT EXISTS `usuario_acessos` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `data` bigint(20) NOT NULL COMMENT 'Unix timestamp',
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `fk_usuarios_acessos` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=69 ;

--
-- Fazendo dump de dados para tabela `usuario_acessos`
--

INSERT INTO `usuario_acessos` (`idLog`, `idUsuario`, `data`, `ip`) VALUES
(30, 1, 1395315422, '172.16.11.1'),
(31, 1, 1395316589, '172.16.11.1'),
(32, 2, 1395404446, '172.16.11.1'),
(33, 1, 1395405182, '172.16.11.1'),
(34, 2, 1395405206, '172.16.11.1'),
(35, 1, 1395412165, '172.16.11.1'),
(36, 2, 1395412218, '172.16.11.1'),
(37, 1, 1395427130, '172.16.11.1'),
(38, 1, 1395662492, '172.16.11.1'),
(39, 1, 1395670439, '172.16.11.1'),
(40, 1, 1395674150, '172.16.11.1'),
(41, 1, 1395747918, '172.16.11.1'),
(42, 2, 1395768375, '172.16.11.1'),
(43, 1, 1395768386, '172.16.11.1'),
(44, 1, 1395770659, '172.16.12.196'),
(45, 1, 1395776150, '172.16.11.1'),
(46, 1, 1395862634, '172.16.11.1'),
(47, 1, 1395863784, '172.16.11.1'),
(48, 1, 1395865274, '172.16.11.1'),
(49, 1, 1395865406, '172.16.11.1'),
(50, 1, 1395865636, '172.16.11.1'),
(51, 1, 1395869420, '172.16.11.1'),
(52, 1, 1395922437, '172.16.11.1'),
(53, 1, 1395922844, '172.16.11.1'),
(54, 1, 1395923388, '172.16.11.1'),
(55, 1, 1395927505, '172.16.11.1'),
(56, 2, 1395928350, '172.16.11.1'),
(57, 1, 1395930401, '172.16.11.1'),
(58, 2, 1395933828, '172.16.11.1'),
(59, 2, 1395954825, '172.16.11.1'),
(60, 2, 1395957433, '172.16.11.1'),
(61, 2, 1395960816, '172.16.11.1'),
(62, NULL, 1395961932, '172.16.11.1'),
(63, NULL, 1395962896, '172.16.11.1'),
(64, NULL, 1395962915, '172.16.11.1'),
(65, 1, 1395965376, '172.16.11.1'),
(66, NULL, 1395965541, '172.16.11.1'),
(67, NULL, 1395966230, '172.16.11.1'),
(68, 1, 1395967241, '172.16.11.1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_papel`
--

CREATE TABLE IF NOT EXISTS `usuario_papel` (
  `idpapel` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 DEFAULT 'Sem descrição',
  PRIMARY KEY (`idpapel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Fazendo dump de dados para tabela `usuario_papel`
--

INSERT INTO `usuario_papel` (`idpapel`, `nome`, `descricao`) VALUES
(1, 'Administrador', 'Sem descrição'),
(2, 'Gestor', 'Sem descrição'),
(3, 'Professor', 'Sem descrição'),
(4, 'Aluno', 'Sem descrição');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_permissao`
--

CREATE TABLE IF NOT EXISTS `usuario_permissao` (
  `idPermissao` int(11) NOT NULL,
  `tipo` varchar(45) CHARACTER SET latin1 NOT NULL,
  `descricao` varchar(65) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idPermissao`),
  UNIQUE KEY `tipo_UNIQUE` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `usuario_permissao`
--

INSERT INTO `usuario_permissao` (`idPermissao`, `tipo`, `descricao`) VALUES
(1, 'Sem acesso', NULL),
(10, 'Consulta', NULL),
(20, 'Escrita', NULL),
(30, 'Gestor', NULL),
(40, 'Administrador', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_recuperarsenha`
--

CREATE TABLE IF NOT EXISTS `usuario_recuperarsenha` (
  `idUsuario` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `fk_usuario_idx` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `usuario_recuperarsenha`
--

INSERT INTO `usuario_recuperarsenha` (`idUsuario`, `token`) VALUES
(2, 'b2d6aa1e4111fde91cd404043060509b');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_x_permissao_x_ferramenta`
--

CREATE TABLE IF NOT EXISTS `usuario_x_permissao_x_ferramenta` (
  `idUsuario` int(11) NOT NULL,
  `idFerramenta` int(11) NOT NULL,
  `idPermissao` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idFerramenta`,`idPermissao`),
  KEY `fk_usuarios_permissoes_1` (`idPermissao`),
  KEY `fk_usuarios_permissoes_2` (`idFerramenta`),
  KEY `fk_usuarios_permissoes_3` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `usuario_x_permissao_x_ferramenta`
--

INSERT INTO `usuario_x_permissao_x_ferramenta` (`idUsuario`, `idFerramenta`, `idPermissao`) VALUES
(3, 7, 1),
(3, 8, 1),
(4, 6, 1),
(4, 7, 1),
(4, 8, 1),
(4, 9, 1),
(6, 7, 1),
(6, 8, 1),
(6, 9, 1),
(7, 7, 1),
(7, 8, 1),
(7, 9, 1),
(6, 1, 10),
(6, 2, 10),
(6, 3, 10),
(6, 4, 10),
(6, 5, 10),
(6, 6, 10),
(7, 1, 10),
(23, 1, 10),
(23, 2, 10),
(23, 3, 10),
(23, 4, 10),
(23, 5, 10),
(23, 6, 10),
(23, 7, 10),
(23, 8, 10),
(2, 2, 20),
(2, 3, 20),
(2, 4, 20),
(2, 5, 20),
(2, 6, 20),
(2, 8, 20),
(9, 1, 20),
(9, 2, 20),
(9, 3, 20),
(9, 4, 20),
(9, 5, 20),
(9, 6, 20),
(9, 7, 20),
(9, 8, 20),
(9, 9, 20),
(2, 7, 30),
(3, 1, 30),
(3, 2, 30),
(3, 3, 30),
(3, 4, 30),
(3, 5, 30),
(3, 6, 30),
(4, 1, 30),
(4, 2, 30),
(4, 3, 30),
(4, 4, 30),
(4, 5, 30),
(7, 2, 30),
(7, 3, 30),
(7, 4, 30),
(7, 5, 30),
(7, 6, 30),
(22, 1, 30),
(22, 2, 30),
(22, 3, 30),
(22, 4, 30),
(22, 5, 30),
(22, 6, 30),
(22, 7, 30),
(22, 8, 30),
(1, 1, 40),
(1, 2, 40),
(1, 3, 40),
(1, 4, 40),
(1, 5, 40),
(1, 6, 40),
(1, 7, 40),
(1, 8, 40),
(1, 9, 40),
(2, 1, 40),
(2, 9, 40);

-- --------------------------------------------------------

--
-- Estrutura para tabela `viagem`
--

CREATE TABLE IF NOT EXISTS `viagem` (
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
  KEY `fk_viagem_usuario1_idx` (`responsavel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Fazendo dump de dados para tabela `viagem`
--

INSERT INTO `viagem` (`idViagem`, `idCurso`, `idPolo`, `responsavel`, `dataIda`, `horaIda`, `dataVolta`, `horaVolta`, `motivo`, `estadoViagem`, `diarias`, `outroDestino`) VALUES
(25, 3, 1, 2, '06/02/2014', '00:00', '20/02/2014', '10:00', 'acompanhamento', 'Executada/controle-cead', '2456', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `viagem_passageiros`
--

CREATE TABLE IF NOT EXISTS `viagem_passageiros` (
  `idViagem` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idViagem`,`idUsuario`),
  KEY `fk_viagem_has_usuario_usuario1_idx` (`idUsuario`),
  KEY `fk_viagem_has_usuario_viagem1_idx` (`idViagem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `viagem_passageiros`
--

INSERT INTO `viagem_passageiros` (`idViagem`, `idUsuario`) VALUES
(25, 1),
(25, 6),
(25, 9);

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `cursospolos_curso`
--
ALTER TABLE `cursospolos_curso`
  ADD CONSTRAINT `fk_curso_area` FOREIGN KEY (`area`) REFERENCES `cursospolos_area` (`idArea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_curso_tipo` FOREIGN KEY (`tipo`) REFERENCES `cursospolos_tipocurso` (`idTipoCurso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `documento_memorando`
--
ALTER TABLE `documento_memorando`
  ADD CONSTRAINT `fk_memorando_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `documento_oficio`
--
ALTER TABLE `documento_oficio`
  ADD CONSTRAINT `fk_oficio_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `equipamento_baixa`
--
ALTER TABLE `equipamento_baixa`
  ADD CONSTRAINT `fk_equipamento_baixa_equipamento1` FOREIGN KEY (`equipamento`) REFERENCES `equipamento` (`idEquipamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_baixa_equipamento_saida1` FOREIGN KEY (`saida`) REFERENCES `equipamento_saida` (`idSaida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `equipamento_evento`
--
ALTER TABLE `equipamento_evento`
  ADD CONSTRAINT `fk_equipamento_evento_equipamento1` FOREIGN KEY (`equipamento`) REFERENCES `equipamento` (`idEquipamento`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_evento_equipamento_baixa1` FOREIGN KEY (`baixa`) REFERENCES `equipamento_baixa` (`idBaixa`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_evento_equipamento_retorno1` FOREIGN KEY (`retorno`) REFERENCES `equipamento_retorno` (`idRetorno`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_evento_equipamento_saida1` FOREIGN KEY (`saida`) REFERENCES `equipamento_saida` (`idSaida`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_evento_equipamento_tipoEvento1` FOREIGN KEY (`tipoEvento`) REFERENCES `equipamento_tipoevento` (`idTipoEvento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_evento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `equipamento_retorno`
--
ALTER TABLE `equipamento_retorno`
  ADD CONSTRAINT `fk_equipamento_retorno_equipamento_saida1` FOREIGN KEY (`saida`) REFERENCES `equipamento_saida` (`idSaida`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `equipamento_saida`
--
ALTER TABLE `equipamento_saida`
  ADD CONSTRAINT `fk_equipamento_saida_equipamento1` FOREIGN KEY (`equipamento`) REFERENCES `equipamento` (`idEquipamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_saida_polo1` FOREIGN KEY (`poloDestino`) REFERENCES `cursospolos_polo` (`idPolo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipamento_saida_usuario1` FOREIGN KEY (`responsavel`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `imagem`
--
ALTER TABLE `imagem`
  ADD CONSTRAINT `fk_imagens_imagem_imagens_descritor1` FOREIGN KEY (`descritor1`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagens_imagem_imagens_descritor2` FOREIGN KEY (`descritor2`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagens_imagem_imagens_descritor3` FOREIGN KEY (`descritor3`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagens_imagem_imagens_descritor4` FOREIGN KEY (`descritor4`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagens_imagem_imagens_galeria1` FOREIGN KEY (`idGaleria`) REFERENCES `imagem_galeria` (`idGaleria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagens_imagem_usuario1` FOREIGN KEY (`autor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `imagem_descritor`
--
ALTER TABLE `imagem_descritor`
  ADD CONSTRAINT `fk_imagens_descritor_imagens_descritor1` FOREIGN KEY (`pai`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `imagem_evento`
--
ALTER TABLE `imagem_evento`
  ADD CONSTRAINT `fk_imagens_evento_imagens_categoria1` FOREIGN KEY (`categoria`) REFERENCES `imagem_descritor` (`idDescritor`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_imagens_evento_imagens_galeria1` FOREIGN KEY (`galeria`) REFERENCES `imagem_galeria` (`idGaleria`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_imagens_evento_imagens_imagem1` FOREIGN KEY (`imagem`) REFERENCES `imagem` (`idImagem`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_imagens_evento_imagens_tipoEvento1` FOREIGN KEY (`tipoEvento`) REFERENCES `imagem_tipoevento` (`idTipoEvento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagens_evento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `imagem_galeria`
--
ALTER TABLE `imagem_galeria`
  ADD CONSTRAINT `fk_imagem_galeria_usuario1` FOREIGN KEY (`autor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `fk_livro_area` FOREIGN KEY (`area`) REFERENCES `cursospolos_area` (`idArea`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `livro_baixa`
--
ALTER TABLE `livro_baixa`
  ADD CONSTRAINT `fk_livro_baixa_livro1` FOREIGN KEY (`livro`) REFERENCES `livro` (`idLivro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_baixa_livro_saida1` FOREIGN KEY (`saida`) REFERENCES `livro_saida` (`idSaida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `livro_evento`
--
ALTER TABLE `livro_evento`
  ADD CONSTRAINT `fk_livro_evento_livro1` FOREIGN KEY (`livro`) REFERENCES `livro` (`idLivro`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_evento_livro_baixa1` FOREIGN KEY (`baixa`) REFERENCES `livro_baixa` (`idBaixa`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_evento_livro_retorno1` FOREIGN KEY (`retorno`) REFERENCES `livro_retorno` (`idRetorno`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_evento_livro_saida1` FOREIGN KEY (`saida`) REFERENCES `livro_saida` (`idSaida`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_evento_livro_tipoEvento1` FOREIGN KEY (`tipoEvento`) REFERENCES `livro_tipoevento` (`idTipoEvento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_evento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `livro_retorno`
--
ALTER TABLE `livro_retorno`
  ADD CONSTRAINT `fk_livro_retorno_livro_saida1` FOREIGN KEY (`saida`) REFERENCES `livro_saida` (`idSaida`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `livro_saida`
--
ALTER TABLE `livro_saida`
  ADD CONSTRAINT `fk_livro_saida_livro1` FOREIGN KEY (`livro`) REFERENCES `livro` (`idLivro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_saida_polo1` FOREIGN KEY (`poloDestino`) REFERENCES `cursospolos_polo` (`idPolo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livro_saida_usuario1` FOREIGN KEY (`responsavel`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `sistema_eventosistema`
--
ALTER TABLE `sistema_eventosistema`
  ADD CONSTRAINT `fk_eventoSistema_alvo` FOREIGN KEY (`idUsuarioAlvo`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eventoSistema_autor` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eventoSistema_evento` FOREIGN KEY (`idTipoEventoSistema`) REFERENCES `sistema_tipoevento` (`idTipoEventoSistema`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuarios_papel` FOREIGN KEY (`idPapel`) REFERENCES `usuario_papel` (`idpapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_acessos`
--
ALTER TABLE `usuario_acessos`
  ADD CONSTRAINT `fk_usuarios_acessos` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_recuperarsenha`
--
ALTER TABLE `usuario_recuperarsenha`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_x_permissao_x_ferramenta`
--
ALTER TABLE `usuario_x_permissao_x_ferramenta`
  ADD CONSTRAINT `fk_usuarios_permissoes_1` FOREIGN KEY (`idPermissao`) REFERENCES `usuario_permissao` (`idPermissao`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_permissoes_2` FOREIGN KEY (`idFerramenta`) REFERENCES `sistema_ferramenta` (`idferramenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_permissoes_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `viagem`
--
ALTER TABLE `viagem`
  ADD CONSTRAINT `fk_viagem_curso1` FOREIGN KEY (`idCurso`) REFERENCES `cursospolos_curso` (`idCurso`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viagem_polo1` FOREIGN KEY (`idPolo`) REFERENCES `cursospolos_polo` (`idPolo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viagem_usuario1` FOREIGN KEY (`responsavel`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `viagem_passageiros`
--
ALTER TABLE `viagem_passageiros`
  ADD CONSTRAINT `fk_viagem_has_usuario_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viagem_has_usuario_viagem1` FOREIGN KEY (`idViagem`) REFERENCES `viagem` (`idViagem`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
