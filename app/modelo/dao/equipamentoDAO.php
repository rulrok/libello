<?php
namespace app\modelo;
require_once 'abstractDAO.php';
require_once APP_DIR . "modelo/vo/Equipamento.php";
require_once APP_DIR . 'modelo/enumeracao/TipoEventoEquipamento.php';

class equipamentoDAO extends abstractDAO {

    public function cadastrarEquipamento(Equipamento $equipamento) {
        $sql = "INSERT INTO equipamento(nomeEquipamento,quantidade,descricao,dataEntrada,numeroPatrimonio) VALUES ";
        $sql .= "(:nome,:quantidade,:descricao,:dataEntrada,:numeroPatrimonio)";

        $params = array(
            ':nome' => [$equipamento->get_nomeEquipamento(), \PDO::PARAM_STR]
            , ':quantidade' => [$equipamento->get_quantidade(), \PDO::PARAM_INT]
            , ':descricao' => [$equipamento->get_descricao(), \PDO::PARAM_STR]
            , ':dataEntrada' => [$equipamento->get_dataEntrada(), \PDO::PARAM_STR]
            , ':numeroPatrimonio' => [$equipamento->get_numeroPatrimonio(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Retorna a lista com todos os equipame`ntos, com base nas colunas especificadas e nas condições de seleção.
     * @param String $colunas Colunas a serem retornadas, por padrão, retorna
     * @param String $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return Array A tabela com o resultado da consulta.
     */
    public function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE quantidade > 0";
        } else {
            $condicao = "WHERE " . $condicao . " AND quantidade > 0";
        }
        $sql = "SELECT  $colunas  FROM equipamento " . $condicao;
        return $this->executarSelect($sql);
    }

    public function recuperarEquipamento($idEquipamento) {
        if (is_array($idEquipamento)) {
            $idEquipamento = $idEquipamento['equipamentoID'];
        }

        $sql = "SELECT * from equipamento WHERE idEquipamento = :idEquipamento";
        $params = array(
            ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Equipamento');
    }

    public function recuperarSaidaEquipamento($saidaID) {
        $saida = $this->consultarSaidas("*", "es.idSaida = " . $saidaID);
        if (is_array($saida)) {
            $saida = $saida[0];
        }
        return $saida;
    }

    public function removerBaixa($baixaID) {
        if (is_array($baixaID)) {
            $idEquipamento = $idEquipamento['baixaID'];
        } else {
            $idEquipamento = $baixaID;
        }
        
        $sql = "DELETE from equipamento_baixa WHERE idBaixa = :idBaixa";
        $params = array(
            ':idBaixa' => [$idEquipamento, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function removerSaida($idSaida) {
        if (is_array($idSaida)) {
            $equipamentoID = $equipamentoID['saidaID'];
        }

        $sql = "DELETE from equipamento_saida WHERE idSaida = :idSaida";
        $params = array(
            ':idSaida' => [$idSaida, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function consultarSaidas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE quantidadeSaida > 0";
        } else {
            $condicao = "WHERE " . $condicao . " AND quantidadeSaida > 0";
        }
        $sql = "SELECT $colunas FROM `equipamento_saida` AS `es` JOIN `equipamento` AS `e` ON `es`.`equipamento` = `e`.idEquipamento JOIN `usuario` AS `u` ON `es`.`responsavel` = `u`.`idUsuario` LEFT JOIN `cursospolos_polo` AS `p` ON `es`.`poloDestino` = `p`.`idPolo` " . $condicao;
        return $this->executarSelect($sql);
    }

    public function consultarBaixas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT $colunas  FROM `equipamento_baixa` AS `eb` JOIN `equipamento` AS `e` ON `eb`.`equipamento` = `e`.idEquipamento " . $condicao;
        return $this->executarSelect($sql);
    }

    /**
     * Atualiza informações de um equipamento.
     * @param int $idEquipamento Usado para localizar equipamento no banco de dados.
     * @param Curso $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public function atualizar($idEquipamento, Equipamento $novosDados) {

        $idEquipamento = (int) $idEquipamento;
        $dadosAntigos = $this->recuperarEquipamento($idEquipamento);

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

        $descricao = $novosDados->get_descricao();

        $params = array(
            ':nome' => [$nome, \PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, \PDO::PARAM_INT]
            , ':dataEntrada' => [$dataEntrada, \PDO::PARAM_STR]
            , ':numeroPatrimonio' => [$numeroPatrimonio, \PDO::PARAM_STR]
            , ':descricao' => [$descricao, \PDO::PARAM_STR]
            , ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
        );

        $sql = "UPDATE equipamento SET nomeEquipamento = :nome ,quantidade = :quantidade ,dataEntrada = :dataEntrada ,numeroPatrimonio = :numeroPatrimonio ,descricao = :descricao WHERE idEquipamento = :idEquipamento";

        return $this->executarQuery($sql, $params);
    }

    public function remover($idEquipamento) {
        if ($idEquipamento !== null) {
            if (is_array($idEquipamento)) {
                $idEquipamento = $idEquipamento['equipamentoID'];
            }
            $idEquipamento = (int) $idEquipamento;
            $sql = "DELETE FROM equipamento WHERE idEquipamento = :idEquipamento";
            $params = array(
                ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
            );
            return $this->executarQuery($sql, $params);
        }
    }

    public function cadastrarSaida($idEquipamento, $idResponsavel, $destino, $destinoAlternativo, $quantidade, $data = null) {
        $sql = "INSERT INTO equipamento_saida(equipamento,responsavel,destino,quantidadeSaida,quantidadeSaidaOriginal,dataSaida,PoloDestino) VALUES " .
                "(:idEquipamento,:idResponsavel,:destinoAlternativo,:quantidade,:quantidade,:data,:destino)";
        $params = array(
            ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
            , ':idResponsavel' => [$idResponsavel, \PDO::PARAM_INT]
            , ':destinoAlternativo' => [$destinoAlternativo, \PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, \PDO::PARAM_INT]
            , ':data' => [$data, $data === null ? \PDO::PARAM_NULL : \PDO::PARAM_STR]
            , ':destino' => [$destino, \PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    public function cadastrarRetorno($idSaida, $data, $quantidade, $observacoes = null) {
        $sql = "INSERT INTO equipamento_retorno(saida,dataRetorno,quantidadeRetorno,observacoes) VALUES " .
                "(:idSaida,:data,:quantidade,:observacoes)";
        $params = array(
            ':idSaida' => [$idSaida, \PDO::PARAM_INT]
            , ':data' => [$data, \PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, \PDO::PARAM_INT]
            , ':observacoes' => [$observacoes, $observacoes === null ? \PDO::PARAM_NULL : \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function cadastrarBaixa($idEquipamento, $dataBaixa, $quantidade, $observacoes = null, $idSaida = null) {
        $sql = "INSERT INTO equipamento_baixa(equipamento,saida,dataBaixa,quantidadeBaixa,observacoes) VALUES " .
                "(:idEquipamento,:idSaida,:dataBaixa,:quantidade,:observacoes)";
        $params = array(
            ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
            , ':idSaida' => [$idSaida, $idSaida === null ? \PDO::PARAM_NULL : \PDO::PARAM_INT]
            , ':dataBaixa' => [$dataBaixa, \PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, \PDO::PARAM_INT]
            , ':observacoes' => [$observacoes, $observacoes === null ? \PDO::PARAM_NULL : \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Esta função verifica se um equipamento pode ter o seu tipo alterado, ou seja, se ele
     * pode ser alterado de equipamento de custeio para equipamento com patrimônio. Isso apenas acontece para
     * situações de erro na hora de cadastrar, pois, logo após que um equipamento tenho tido qualquer saída, e
     * consequentemente algum retorno ou baixa, ele não pode mais então ser editado.
     * @param type $idEquipamento
     */
    public function equipamentoPodeTerTipoAlterado($idEquipamento) {
        //  Verifica se tem saída
        $sql1 = "SELECT count(equipamento) as qtdSaidas FROM equipamento_saida WHERE equipamento = :equipamento LIMIT 1";
        $params = array(
            ':equipamento' => [$idEquipamento, \PDO::PARAM_INT]
        );
        $resultado1 = $this->executarSelect($sql1, $params, false);
        if (is_array($resultado1)) {
            $resultado1 = $resultado1['qtdSaidas'];
        }
        if ((int) $resultado1 > 0) {
            return false;
        }
        //  Verifica se tem baixa
        $sql2 = "SELECT count(equipamento) as qtdBaixas FROM equipamento_baixa WHERE equipamento = :equipamento LIMIT 1";
        $params2 = array(
            ':equipamento' => [$idEquipamento, \PDO::PARAM_INT]
        );
        $resultado2 = $this->executarSelect($sql2, $params2, false);
        if (is_array($resultado2)) {
            $resultado2 = $resultado2['qtdBaixas'];
        }
        if ((int) $resultado2 > 0) {
            return false;
        }
        //  Verifica se tem retorno
        $sql3 = "SELECT count(equipamento) as qtdSaidas FROM equipamento_saida WHERE equipamento = :equipamento LIMIT 1";
        $params3 = array(
            ':equipamento' => [$idEquipamento, \PDO::PARAM_INT]
        );
        $resultado = $this->executarSelect($sql3, $params3, false);
        if (is_array($resultado)) {
            $resultado = $resultado['qtdSaidas'];
        }
        if ((int) $resultado > 0) {
            return false;
        }
        return true;
    }

    /////////////////// REGISTRO DE EVENTOS PARA LOG ///////////////////////////

    public function registrarExclusaoEquipamento($idEquipamento) {
        $tipo = TipoEventoEquipamento::REMOCAO_EQUIPAMENTO;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,equipamento,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idEquipamento,:data )";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarInsercaoEquipamento($idEquipamento) {
        $tipo = TipoEventoEquipamento::CADASTRO_EQUIPAMENTO;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,equipamento,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idEquipamento,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarAlteracaoEquipamento($idEquipamento) {
        $tipo = TipoEventoEquipamento::ALTERACAO_EQUIPAMENTO;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,equipamento,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idEquipamento,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idEquipamento' => [$idEquipamento, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarCadastroBaixa($idBaixa) {
        $tipo = TipoEventoEquipamento::CADASTRO_BAIXA;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,baixa,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idBaixa,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idBaixa' => [$idBaixa, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarRemocaoBaixa($idBaixa) {
        $tipo = TipoEventoEquipamento::REMOCAO_BAIXA;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,baixa,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idBaixa,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idBaixa' => [$idBaixa, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarCadastroSaida($idSaida) {
        $tipo = TipoEventoEquipamento::CADASTRO_SAIDA;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,saida,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idSaida,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idSaida' => [$idSaida, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarRemocaoSaida($idSaida) {
        $tipo = TipoEventoEquipamento::REMOCAO_SAIDA;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,saida,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idSaida,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idSaida' => [$idSaida, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarRetorno($idRetorno) {
        $tipo = TipoEventoEquipamento::CADASTRO_RETORNO;
        $sql = "INSERT INTO equipamento_evento(tipoEvento,usuario,retorno,data) VALUES ";
        $sql .= " (:tipo,:usuarioID,:idSaida,:data)";
        $params = array(
            ':tipo' => [$tipo, \PDO::PARAM_INT]
            , ':usuarioID' => [obterUsuarioSessao()->get_idUsuario(), \PDO::PARAM_INT]
            , ':idSaida' => [$idRetorno, \PDO::PARAM_INT]
            , ':data' => [time(), \PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

}

?>