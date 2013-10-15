<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION."modelo/vo/Curso.php";

class cursoDAO extends abstractDAO {

    public static function obterNomeTipoCurso($cursoId) {
        $cursoId = (int) $cursoId;
        $sql = "SELECT nomeTipoCurso FROM tipoCurso WHERE idTipoCurso = " . $cursoId;
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

    public static function obterIdCurso($nomeCurso) {

        $sql = "SELECT idTipoCurso FROM tipoCurso WHERE nomeCurso = '" . $nomeCurso . "'";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

    public static function cadastrarCurso(Curso $curso) {
        $sql = "INSERT INTO curso(nomeCurso,area,tipo) VALUES ";
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
        $condicao = "nomeCurso = $nome AND area=$area AND tipo = $tipocurso";
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

    /**
     * Atualiza informações de um curso.
     * @param type $idCurso Usado para localizar o curso no banco de dados.
     * @param Curso $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public static function atualizar($idCurso, Curso $novosDados) {

        $idCurso = (int) $idCurso;
        $dadosAntigos = cursoDAO::recuperarCurso($idCurso);

        $condicao = " WHERE idCurso = " . $idCurso;

        $nome = $novosDados->get_nome();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nome();
        }
        
        $area = $novosDados->get_area();
        if ($area == null) {
            $area = $dadosAntigos->get_area();
        }
        
        $tipocurso = (int) $novosDados->get_tipo();
        if ($tipocurso == null) {
            $tipocurso = $dadosAntigos->get_tipo();
        }
        

        $sql = "UPDATE curso SET nomeCurso = '".$nome."' ,area = ".$area." ,tipo = ".$tipocurso ;
        $sql .= $condicao;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
            exit;
            return false;
        }
    }

    /**
     * Retorna a lista com todos os curso, com base nas colunas especificadas e nas condições de seleção.
     * A consulta junta a tabela curso com a tabela 'area' e 'tipoCurso'.
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param type $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return type A tabela com o resultado da consulta.
     */
    public static function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        }
        $sql = "SELECT " . $colunas . " FROM curso JOIN area ON area=idArea JOIN tipoCurso ON tipo=idtipoCurso" . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function remover($idCurso) {
        if ($idCurso !== null) {
            if (is_array($idCurso)) {
                $idCurso = $idCurso['cursoID'];
            }
            $idCurso = (int) $idCurso;
            $sql = "DELETE FROM curso WHERE idCurso = " . $idCurso;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function recuperarCurso($cursoID) {
        if (is_array($cursoID)) {
            $cursoID = $cursoID['cursoID'];
        }

        $sql = "SELECT * from curso WHERE idCurso ='" . $cursoID . "'";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Curso');
            $curso = $stmt->fetch();
//            if ($usuario == null) {
//                $usuario = "Usuário não encontrado";
//            }
        } catch (Exception $e) {
            $curso = NULL;
        }
        return $curso;
    }

}

?>