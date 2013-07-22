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
    
    public static function cadastrarCurso(Curso $curso) {
        $sql = "INSERT INTO curso(nome,area,tipo) VALUES ";
        $nome = parent::quote($curso->get_nome());
        $area = parent::quote($curso->get_area());
        $tipocurso = parent::quote($curso->get_tipo());
        $values = "($nome,$area,$tipocurso)";
        try {
            parent::getConexao()->query($sql . $values);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public static function consultarCurso(Curso $curso) {
        $sql = "SELECT count(idCurso) FROM curso WHERE ";
        $nome = parent::quote($curso->get_nome());
        $area = parent::quote($curso->get_area());
        $tipocurso = parent::quote($curso->get_tipo());
        $condicao = "nome = $nome AND area=$area AND tipo = $tipocurso";
        try {
            $resultado = parent::getConexao()->query($sql . $condicao)->fetch();
        } catch (Exception $e) {
            echo $e;
        }

        if (is_array($resultado)) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

}

?>