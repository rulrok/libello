-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`reuel`@`bcc.unifal-mg.edu.br` FUNCTION `getNameInitials`(`fullname` VARCHAR(70), `idUsuarioAtual` INT(11)) RETURNS varchar(70) CHARSET utf8 COLLATE utf8_unicode_ci
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
END IF;

SET `sameInitials` = CAST(RIGHT(`iniciais_usuario_atual`,`numero_convertido`) AS SIGNED);
IF `sameInitials` > 0 THEN
SET `result` = concat(`result`,`sameInitials`+1);
END IF;

RETURN `result`;
END