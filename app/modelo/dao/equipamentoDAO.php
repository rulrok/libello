<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . "modelo/vo/Equipamento.php";

class equipamentoDAO extends abstractDAO {

    public static function cadastrarEquipamento(Equipamento $equipamento) {
        $sql = "INSERT INTO equipamento(nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio) VALUES ";
        $nome = parent::quote($equipamento->get_nomeEquipamento());
        $quantidade = $equipamento->get_quantidade();
        $dataEntrada = parent::quote($equipamento->get_dataEntrada());
        $numeroPatrimonio = parent::quote($equipamento->get_numeroPatrimonio());
        $values = "($nome,$quantidade,$dataEntrada,$numeroPatrimonio)";
        try {
            parent::getConexao()->query($sql . $values);
        } catch (Exception $e) {
            throw new Exception("Erro");
        }
    }

    /**
     * Retorna a lista com todos os equipamentos, com base nas colunas especificadas e nas condições de seleção.
     * @param String $colunas Colunas a serem retornadas, por padrão, retorna
     * @param String $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return Array A tabela com o resultado da consulta.
     */
    public static function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT " . $colunas . " FROM equipamento " . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function recuperarEquipamento($equipamentoID) {
        if (is_array($equipamentoID)) {
            $equipamentoID = $equipamentoID['equipamentoID'];
        }

        $sql = "SELECT * from equipamento WHERE idEquipamento ='" . $equipamentoID . "'";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Equipamento');
            $equipamentos = $stmt->fetch();
        } catch (Exception $e) {
            $equipamentos = NULL;
        }
        return $equipamentos;
    }

    /**
     * Atualiza informações de um equipamento.
     * @param int $equipamentoID Usado para localizar equipamento no banco de dados.
     * @param Curso $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public static function atualizar($equipamentoID, Equipamento $novosDados) {

        $equipamentoID = (int) $equipamentoID;
        $dadosAntigos = equipamentoDAO::recuperarEquipamento($equipamentoID);

        $condicao = " WHERE idEquipamento = " . $equipamentoID;

        $nome = $novosDados->get_nomeEquipamento();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nomeEquipamento();
        }

        $quantidade = $novosDados->get_quantidade();
        if ($quantidade == null) {
            $quantidade = $dadosAntigos->get_quantidade();
        }

        $dataEntrada = $novosDados->get_dataEntrada();
        if ($dataEntrada == null) {
            $dataEntrada = $dadosAntigos->get_dataEntrada();
        }

        $numeroPatrimonio = $novosDados->get_numeroPatrimonio();
        if ($numeroPatrimonio !== "NULL"){
            $numeroPatrimonio = parent::quote($numeroPatrimonio);
        }


        $sql = "UPDATE equipamento SET nomeEquipamento = '" . $nome . "' ,quantidade = " . $quantidade . " ,dataEntrada = '" . $dataEntrada . "' ,numeroPatrimonio = " . $numeroPatrimonio;
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

        public static function remover($equipamentoID) {
        if ($equipamentoID !== null) {
            if (is_array($equipamentoID)) {
                $equipamentoID = $equipamentoID['equipamentoID'];
            }
            $equipamentoID = (int) $equipamentoID;
            $sql = "DELETE FROM equipamento WHERE idEquipamento = " . $equipamentoID;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }
}

?>
