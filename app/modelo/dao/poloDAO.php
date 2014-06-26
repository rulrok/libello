<?php

require_once 'abstractDAO.php';

class poloDAO extends abstractDAO {

    /**
     * 
     * @param Polo $polo
     * @return boolean
     */
    public function cadastrarPolo(Polo $polo) {
        $sql = "INSERT INTO cursospolos_polo(nomePolo,cidade,estado) VALUES (:nome, :cidade, :estado)";
        $params = array(
            ':nome' => [$polo->get_nome(), PDO::PARAM_STR]
            , ':cidade' => [$polo->get_cidade(), PDO::PARAM_STR]
            , ':estado' => [$polo->get_estado(), PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param Polo $polo
     * @return int
     */
    public function consultarPolo(Polo $polo) {
        //OBS: LIKE não foi utilizado nessa query por motivo de desempenho
        $sql = "SELECT count(idPolo) FROM cursospolos_polo WHERE nomePolo = :nome AND cidade = :cidade AND estado = :estado";
        $params = array(
            ':nome' => [$polo->get_nome(), PDO::PARAM_STR]
            , ':cidade' => [$polo->get_cidade(), PDO::PARAM_STR]
            , ':estado' => [$polo->get_estado(), PDO::PARAM_STR]
        );
        return (int) $this->executarSelect($sql, $params, false);
    }

    /**
     * 
     * @param int $idPolo
     * @return boolean
     */
    public function remover($idPolo) {
        if ($idPolo !== null) {
            if (is_array($idPolo)) {
                $idPolo = $idPolo['poloID'];
            }
            $idPolo = (int) $idPolo;
            $sql = "DELETE FROM cursospolos_polo WHERE idPolo = :idPolo";
            $params = array(
                ':idPolo' => [$idPolo, PDO::PARAM_INT]
            );
            return $this->executarQuery($sql, $params);
        }
    }

    /**
     * 
     * @param int $idPolo
     * @param Polo $novosDados
     * @return boolean
     */
    public function atualizar($idPolo, Polo $novosDados) {

        $idPolo = (int) $idPolo;
        $dadosAntigos = (new poloDAO())->recuperarPolo($idPolo);

        $nome = $novosDados->get_nome();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nome();
        }

        $cidade = $novosDados->get_cidade();
        if ($cidade == null) {
            $cidade = $dadosAntigos->get_cidade();
        }

        $estado = $novosDados->get_estado();
        if ($estado == null) {
            $estado = $dadosAntigos->get_estado();
        }


        $sql = "UPDATE cursospolos_polo SET nomePolo = :nome ,cidade = :cidade ,estado = :estado WHERE idPolo = :idPolo";
        $params = array(
            ':nome' => [$nome, PDO::PARAM_STR]
            , ':cidade' => [$cidade, PDO::PARAM_STR]
            , ':estado' => [$estado, PDO::PARAM_STR]
            , ':idPolo' => [$idPolo, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /** Retorna a lista com todos os polos, com base nas colunas especificadas e nas condições de seleção.
     * 
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param string $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return array A tabela com o resultado da consulta.
     */
    public function consultar($colunas = "*", $condicao = null) {

        $params = array();
        if ($condicao === null) {
            $sql = "SELECT $colunas FROM cursospolos_polo";
        } else {
            $sql = "SELECT :colunas FROM cursospolos_polo WHERE $condicao";
        }

        return (array) $this->executarSelect($sql, $params);
    }

    /**
     * 
     * @param int $idPolo
     * @return \Polo
     */
    public function recuperarPolo($idPolo) {
        if (is_array($idPolo)) {
            $idPolo = $idPolo['poloID'];
        }

        $sql = "SELECT * from cursospolos_polo WHERE idPolo = :idPolo";
        $params = array(
            ':idPolo' => [$idPolo, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Polo');
    }

}

?>
