<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . "modelo/vo/Equipamento.php";
require_once APP_LOCATION . 'modelo/enumeracao/TipoEventoEquipamento.php';

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
            $stmt = parent::getConexao()->prepare($sql . $values);
            $stmt->execute();
            $id = parent::getConexao()->lastInsertId();
            return $id;
//            print_r($id);
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

    public static function removerBaixa($baixaID) {
        if (is_array($baixaID)) {
            $equipamentoID = $equipamentoID['baixaID'];
        }

        $sql = "DELETE from equipamento_baixa WHERE idBaixa = " . $baixaID;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
//            print_r($e);
            return false;
        }
    }

    public static function removerSaida($saidaID) {
        if (is_array($saidaID)) {
            $equipamentoID = $equipamentoID['saidaID'];
        }

        $sql = "DELETE from equipamento_saida WHERE idSaida = " . $saidaID;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
//            print_r($e);
            return false;
        }
    }

    public static function consultarSaidas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE quantidadeSaida > 0";
        } else {
            $condicao = "WHERE " . $condicao . " AND quantidadeSaida > 0";
        }
        $sql = "SELECT " . $colunas . " FROM `equipamento_saida` AS `es` JOIN `equipamento` AS `e` ON `es`.`equipamento` = `e`.idEquipamento JOIN `usuario` AS `u` ON `es`.`responsavel` = `u`.`idUsuario` LEFT JOIN `polo` AS `p` ON `es`.`poloDestino` = `p`.`idPolo` " . $condicao;
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

        $descricao = $novosDados->get_descricao();
        $descricao = parent::quote($descricao);

        $sql = "UPDATE equipamento SET nomeEquipamento = '" . $nome . "' ,quantidade = " . $quantidade . " ,dataEntrada = '" . $dataEntrada . "' ,numeroPatrimonio = " . $numeroPatrimonio . " ,descricao=" . $descricao;
        $sql .= $condicao;
        try {
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->execute();
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

    public static function cadastrarSaida($idEquipamento, $idResponsavel, $destino, $destinoAlternativo, $quantidade, $data = "NULL") {
        $destino = $destino;
        $data = parent::quote($data);
        $destinoAlternativo = parent::quote($destinoAlternativo);
        $sql = "INSERT INTO equipamento_saida(equipamento,responsavel,destino,quantidadeSaida,quantidadeSaidaOriginal,dataSaida,PoloDestino) VALUES " .
                "($idEquipamento,$idResponsavel,$destinoAlternativo,$quantidade,$quantidade,$data,$destino)";

        try {
            parent::getConexao()->query($sql);
            $id = parent::getConexao()->lastInsertId();
            equipamentoDAO::registrarCadastroSaida($id);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function cadastrarRetorno($idSaida, $data, $quantidade, $observacoes = "NULL") {
        $observacoes = parent::quote($observacoes);
        $data = parent::quote($data);
        $sql = "INSERT INTO equipamento_retorno(saida,dataRetorno,quantidadeRetorno,observacoes) VALUES " .
                "($idSaida,$data,$quantidade,$observacoes)";
        try {
            parent::getConexao()->query($sql);
            $id = parent::getConexao()->lastInsertId();
            equipamentoDAO::registrarRetorno($id);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function cadastrarBaixa($idEquipamento, $dataBaixa, $quantidade, $observacoes = "NULL", $idSaida = "NULL") {
        $observacoes = parent::quote($observacoes);
        $dataBaixa = parent::quote($dataBaixa);
        $sql = "INSERT INTO equipamento_baixa(equipamento,saida,dataBaixa,quantidadeBaixa,observacoes) VALUES " .
                "($idEquipamento,$idSaida,$dataBaixa,$quantidade,$observacoes)";
        try {
            parent::getConexao()->query($sql);
            $idBaixa = parent::getConexao()->lastInsertId();
            equipamentoDAO::registrarCadastroBaixa($idBaixa);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Esta função verifica se um equipamento pode ter o seu tipo alterado, ou seja, se ele
     * pode ser alterado de equipamento de custeio para equipamento com patrimônio. Isso apenas acontece para
     * situações de erro na hora de cadastrar, pois, logo após que um equipamento tenho tido qualquer saída, e
     * consequentemente algum retorno ou baixa, ele não pode mais então ser editado.
     * @param type $idEquipamento
     */
    public static function equipamentoPodeTerTipoAlterado($idEquipamento) {
        try {
            //  Verifica se tem saída
            $sql = "SELECT count(equipamento) as qtdSaidas FROM equipamento_saida WHERE equipamento = :equipamento";
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(":equipamento", $idEquipamento, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if (is_array($resultado)) {
                $resultado = $resultado['qtdSaidas'];
            } else {
                $stmt->closeCursor();
            }
            if ((int) $resultado > 0) {
                return false;
            }
            //  Verifica se tem baixa
            $sql = "SELECT count(equipamento) as qtdBaixas FROM equipamento_baixa WHERE equipamento = :equipamento";
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(":equipamento", $idEquipamento, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if (is_array($resultado)) {
                $resultado = $resultado['qtdBaixas'];
            } else {
                $stmt->closeCursor();
            }
            if ((int) $resultado > 0) {
                return false;
            }
            //  Verifica se tem retorno
            $sql = "SELECT count(equipamento) as qtdSaidas FROM equipamento_saida WHERE equipamento = :equipamento";
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(":equipamento", $idEquipamento, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if (is_array($resultado)) {
                $resultado = $resultado['qtdSaidas'];
            } else {
                $stmt->closeCursor();
            }
            if ((int) $resultado > 0) {
                return false;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /////////////////// REGISTRO DE EVENTOS PARA LOG ///////////////////////////

    public static function registrarExclusaoEquipamento($idEquipamento) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::REMOCAO_EQUIPAMENTO;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,equipamento,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idEquipamento,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarInsercaoEquipamento($idEquipamento) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::CADASTRO_EQUIPAMENTO;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,equipamento,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idEquipamento,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarAlteracaoEquipamento($idEquipamento) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::ALTERACAO_EQUIPAMENTO;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,equipamento,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idEquipamento,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarCadastroBaixa($idBaixa) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::CADASTRO_BAIXA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,baixa,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idBaixa,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarRemocaoBaixa($idBaixa) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::REMOCAO_BAIXA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,baixa,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idBaixa,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }
    
    public static function registrarCadastroSaida($idSaida) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::CADASTRO_SAIDA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,saida,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idSaida,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }
    public static function registrarRemocaoSaida($idSaida) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::REMOCAO_SAIDA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,saida,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idSaida,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }
    
    public static function registrarRetorno($idRetorno) {
        $quote = "\"";
        $tipo = TipoEventoEquipamento::CADASTRO_RETORNO;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,retorno,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idRetorno,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

}

?>
