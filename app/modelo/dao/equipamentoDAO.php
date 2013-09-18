<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . "modelo/vo/Equipamento.php";

class equipamentoDAO extends abstractDAO {

    public static function cadastrarEquipamento(Equipamento $equipamento) {
        $sql = "INSERT INTO equipamento(nomeEquipamento,quantidade,descricao,dataEntrada,numeroPatrimonio) VALUES ";
        $nome = parent::quote($equipamento->get_nomeEquipamento());
        $quantidade = $equipamento->get_quantidade();

        $dataEntrada = $equipamento->get_dataEntrada();
        if ($dataEntrada === "" | $dataEntrada === null) {
            $dataEntrada = "NULL";
        }
        $dataEntrada = parent::quote($dataEntrada);


        $numeroPatrimonio = parent::quote($equipamento->get_numeroPatrimonio());

        $descricao = $equipamento->get_descricao();
        if ($descricao === "" | $descricao === null) {
            $descricao = "NULL";
        }
        $descricao = parent::quote($descricao);


        $values = "($nome,$quantidade,$descricao,$dataEntrada,$numeroPatrimonio)";
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
            $condicao = "WHERE quantidade > 0";
        } else {
            $condicao = "WHERE " . $condicao . " AND quantidade > 0";
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
            $saida = $stmt->fetch();
        } catch (Exception $e) {
            $saida = NULL;
        }
        return $saida;
    }

    public static function recuperarSaidaEquipamento($saidaID) {
        $saida = equipamentoDAO::consultarSaidas("*", "es.idSaida = " . $saidaID);
        if (is_array($saida)) {
            $saida = $saida[0];
        }
        return $saida;
    }

    public static function consultarSaidas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE quantidadeSaida > 0";
        } else {
            $condicao = "WHERE " . $condicao . " AND quantidadeSaida > 0";
        }
        $sql = "SELECT " . $colunas . " FROM `equipamento_saida` AS `es` JOIN `equipamento` AS `e` ON `es`.`equipamento` = `e`.idEquipamento JOIN `usuario` AS `u` ON `es`.`responsavel` = `u`.`idUsuario`" . $condicao;
        try {
            $resultado = parent::getConexao()->query($sql)->fetchAll();
        } catch (Exception $e) {
            die($e);
        }
        return $resultado;
    }

    public static function consultarBaixas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT " . $colunas . " FROM `equipamento_baixa` AS `eb` JOIN `equipamento` AS `e` ON `eb`.`equipamento` = `e`.idEquipamento" . $condicao;
        try {
            $resultado = parent::getConexao()->query($sql)->fetchAll();
        } catch (Exception $e) {
            die($e);
        }
        return $resultado;
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
        if ($quantidade === null) {
            $quantidade = $dadosAntigos->get_quantidade();
        }

        $dataEntrada = $novosDados->get_dataEntrada();
        if ($dataEntrada == null) {
            $dataEntrada = $dadosAntigos->get_dataEntrada();
        }

        $numeroPatrimonio = $novosDados->get_numeroPatrimonio();
        if ($numeroPatrimonio !== "NULL") {
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

    public static function cadastrarSaida($idEquipamento, $idResponsavel, $destino, $quantidade, $data = "NULL") {
        $destino = parent::quote($destino);
        $data = parent::quote($data);
        $sql = "INSERT INTO equipamento_saida(equipamento,responsavel,destino,quantidadeSaida,quantidadeSaidaOriginal,data) VALUES " .
                "($idEquipamento,$idResponsavel,$destino,$quantidade,$quantidade,$data)";

        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function cadastrarRetorno($idSaida, $data, $quantidade, $observacoes = "NULL") {
        $observacoes = parent::quote($observacoes);
        $data = parent::quote($data);
        $sql = "INSERT INTO equipamento_retorno(saida,data,quantidadeRetorno,observacoes) VALUES " .
                "($idSaida,$data,$quantidade,$observacoes)";
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function cadastrarBaixa($idEquipamento, $dataBaixa, $quantidade, $observacoes = "NULL", $idSaida = "'NULL'") {
        $observacoes = parent::quote($observacoes);
        $dataBaixa = parent::quote($dataBaixa);
        $sql = "INSERT INTO equipamento_baixa(equipamento,saida,dataBaixa,quantidadeBaixa,observacoes) VALUES " .
                "($idEquipamento,$idSaida,$dataBaixa,$quantidade,$observacoes)";
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>
