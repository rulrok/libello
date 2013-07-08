<?php

require_once 'abstractDAO.php';

class cursoDAO extends abstractDAO {

    public static function obterNomeTipoCurso($cursoId) {
        $cursoId = (int) $cursoId;
        $sql = "SELECT nome FROM tipoCurso WHERE idTipoCurso = " . $cursoId;
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

    public static function obterIdCurso($nomeCurso) {

        $sql = "SELECT idTipoCurso FROM tipoCurso WHERE nome = '" . $nomeCurso . "'";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

}

?>