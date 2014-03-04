<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . "modelo/vo/Curso.php";

class cursoDAO extends abstractDAO {

    /**
     * 
     * @param int $idCurso
     * @return string
     */
    public function obterNomeTipoCurso($idCurso) {
        $idCurso = (int) $idCurso;
        $sql = "SELECT nomeTipoCurso FROM tipoCurso WHERE idTipoCurso = :idCurso";
        $params = array(
            'idCurso' => [$idCurso, PDO::PARAM_INT]
        );
        return (string) $this->executarSelect($sql, $params, false);
    }

    /**
     * 
     * @param string $nomeCurso
     * @return int
     */
    public function obterIdCurso($nomeCurso) {

        $sql = "SELECT idTipoCurso FROM tipoCurso WHERE nomeCurso = :nomeCurso";
        $params = array(
            ':nomeCurso' => [$nomeCurso, PDO::PARAM_STR]
        );
        return (int) $this->executarSelect($sql, $params, false);
    }

    /**
     * 
     * @param Curso $curso
     * @return boolean
     */
    public function cadastrarCurso(Curso $curso) {
        $sql = "INSERT INTO curso(nomeCurso,area,tipo) VALUES (:nome, :area, :tipoCurso)";
        $params = array(
            ':nome' => [$curso->get_nome(), PDO::PARAM_STR]
            , ':area' => [$curso->get_idArea(), PDO::PARAM_INT]
            , ':tipoCurso' => [$curso->get_idTipo(), PDO::PARAM_INT]
        );
        return (boolean) $this->executarQuery($sql, $params);
    }

    /**
     * Retorna a quantidade de cursos cadastrados com o respectivo nome, area e tipo de curso
     * informados em $curso
     * @param Curso $curso
     * @return int
     */
    public function consultarCurso(Curso $curso) {
        $sql = "SELECT count(idCurso) FROM curso WHERE nomeCurso = :nomeCurso AND area=:area AND tipo = :tCurso";
        $params = array(
            ':nomeCurso' => [$curso->get_nome(), PDO::PARAM_STR]
            , ':area' => [$curso->get_idArea(), PDO::PARAM_INT]
            , ':tCurso' => [$curso->get_idTipo(), PDO::PARAM_INT]
        );
        return (int) $this->executarSelect($sql, $params, false);
    }

    /**
     * Atualiza informações de um curso.
     * @param int $idCurso Usado para localizar o curso no banco de dados.
     * @param Curso $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public function atualizar($idCurso, Curso $novosDados) {

        $idCurso = (int) $idCurso;
        $dadosAntigos = (new cursoDAO())->recuperarCurso($idCurso);

        $nome = $novosDados->get_nome();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nome();
        }

        $area = $novosDados->get_idArea();
        if ($area == null) {
            $area = $dadosAntigos->get_idArea();
        }

        $tipocurso = (int) $novosDados->get_idTipo();
        if ($tipocurso == null) {
            $tipocurso = $dadosAntigos->get_idTipo();
        }


        $sql = "UPDATE curso SET nomeCurso = :nome ,area = :area ,tipo = :tipoCurso WHERE idCurso = :idCurso";
        $params = array(
            ':nome' => [$nome, PDO::PARAM_STR]
            , ':area' => [$area, PDO::PARAM_INT]
            , ':tipoCurso' => [$tipocurso, PDO::PARAM_INT]
            , ':idCurso' => [$idCurso, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Retorna a lista com todos os curso, com base nas colunas especificadas e nas condições de seleção.
     * A consulta junta a tabela curso com a tabela 'area' e 'tipoCurso'.
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param string $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return array A tabela com o resultado da consulta.
     */
    public function consultar($colunas = "*", $condicao = null) {

        $params = array();
        if ($condicao === null) {
            $sql = "SELECT $colunas FROM curso JOIN area ON area=idArea JOIN tipoCurso ON tipo=idtipoCurso";
        } else {
            $sql = "SELECT :colunas FROM curso JOIN area ON area=idArea JOIN tipoCurso ON tipo=idtipoCurso WHERE $condicao";
            //TODO acrescertar opcoes para o método
        }

        return (array) $this->executarSelect($sql, $params);
    }

    /**
     * 
     * @param int $idCurso
     * @return boolean
     */
    public function remover($idCurso) {
        if ($idCurso !== null) {
            if (is_array($idCurso)) {
                $idCurso = $idCurso['cursoID'];
            }
            $idCurso = (int) $idCurso;
            $sql = "DELETE FROM curso WHERE idCurso = :idCurso";
            $params = array(
                ':idCurso' => [$idCurso, PDO::PARAM_INT]
            );
            return $this->executarQuery($sql, $params);
        }
    }

    /**
     * 
     * @param int $idCurso
     * @return \Curso
     */
    public function recuperarCurso($idCurso) {
        if (is_array($idCurso)) {
            $idCurso = $idCurso['cursoID'];
        }

        $sql = "SELECT * from curso WHERE idCurso = :idCurso";
        $params = array(
            ':idCurso' => [$idCurso, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Curso');
    }

}

?>