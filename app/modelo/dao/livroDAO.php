<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . "modelo/vo/Livro.php";
require_once APP_LOCATION . 'modelo/enumeracao/TipoEventoLivro.php';

class livroDAO extends abstractDAO {

    /**
     * 
     * @param Livro $livro
     * @return boolean
     */
    public function cadastrarLivro(Livro $livro) {
        $sql = "INSERT INTO livro(nomeLivro,quantidade,descricao,dataEntrada,numeroPatrimonio,area,grafica) VALUES ";
        $sql .= " (:nome, :quantidade, :descricao, :dataEntrada, :numeroPatrimonio, :area, :grafica)";

        $nome = $livro->get_nomeLivro();
        $quantidade = $livro->get_quantidade();
        $dataEntrada = $livro->get_dataEntrada();
        if ($dataEntrada === "" | $dataEntrada === null) {
            $dataEntrada = "NULL";
        }

        $numeroPatrimonio = $livro->get_numeroPatrimonio();

        $descricao = $livro->get_descricao();
        if ($descricao === "" | $descricao === null) {
            $descricao = "NULL";
        }

        $grafica = $livro->get_grafica();
        if ($grafica === "" | $grafica === null) {
            $grafica = "NULL";
        }

        $area = $livro->get_area();
        if ($area === "" | $area === null) {
            $area = "NULL";
        }

        $params = array(
            ':nome' => [$nome, PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, PDO::PARAM_INT]
            , ':descricao' => [$descricao, PDO::PARAM_STR]
            , ':dataEntrada' => [$dataEntrada, PDO::PARAM_STR]
            , ':numeroPatrimonio' => [$numeroPatrimonio, PDO::PARAM_STR] //TODO O nome número não condiz muito com o tipo do dado
            , ':area' => [$area, PDO::PARAM_INT]
            , ':grafica' => [$grafica, PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * Retorna a lista com todos os livros, com base nas colunas especificadas e nas condições de seleção.
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param string $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return array A tabela com o resultado da consulta.
     */
    public function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE quantidade > 0";
        } else {
            $condicao = "WHERE " . $condicao . " AND quantidade > 0";
        }
        $sql = "SELECT $colunas FROM livro JOIN area ON area = idArea " . $condicao;
        return $this->executarSelect($sql);
    }

    /**
     * 
     * @param int $idLivro
     * @return \Livro ou null caso nenhum seja encontrado
     */
    public function recuperarLivro($idLivro) {
        if (is_array($idLivro)) {
            $idLivro = $idLivro['livroID'];
        }

        $sql = "SELECT * from livro WHERE idLivro = :idLivro";
        $params = array(
            ':idLivro' => [$idLivro, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Livro');
    }

    /**
     * 
     * @param int $saidaID
     * @return array
     */
    public function recuperarSaidaLivro($saidaID) {
        return $this->consultarSaidas('*', "ls.idSaida = $saidaID")[0];
    }

    /**
     * 
     * @param int $idBaixa
     * @return array
     */
    public function recuperarBaixaLivro($idBaixa) {
        return $this->consultarBaixas('*', "lb.idBaixa = $idBaixa")[0];
    }

    /**
     * 
     * @param int $idBaixa
     * @return boolean
     */
    public function removerBaixa($idBaixa) {
        if (is_array($idBaixa)) {
            $livroID = $livroID['baixaID'];
        }

        $sql = "DELETE from livro_baixa WHERE idBaixa = :idBaixa";
        $params = array(
            ':idBaixa' => [$idBaixa, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idSaida
     * @return boolean
     */
    public function removerSaida($idSaida) {
        if (is_array($idSaida)) {
            $livroID = $livroID['saidaID'];
        }

        $sql = "DELETE from livro_saida WHERE idSaida = :idSaida";
        $params = array(
            ':idSaida' => [$idSaida, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param string $colunas
     * @param string $condicao
     * @return array
     */
    public function consultarSaidas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE quantidadeSaida > 0";
        } else {
            $condicao = "WHERE $condicao AND quantidadeSaida > 0";
        }
        $sql = "SELECT $colunas FROM `livro_saida` AS `ls` JOIN `livro` AS `l` ON `ls`.`livro` = `l`.idLivro JOIN `usuario` AS `u` ON `ls`.`responsavel` = `u`.`idUsuario` LEFT JOIN `polo` AS `p` ON `ls`.`poloDestino` = `p`.`idPolo` JOIN `area` AS `a` ON `l`.`area` = `a`.`idArea` $condicao";
        return $this->executarSelect($sql);
    }

    /**
     * 
     * @param string $colunas
     * @param string $condicao
     * @return array
     */
    public function consultarBaixas($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE $condicao";
        }
        $sql = "SELECT $colunas FROM `livro_baixa` AS `lb` JOIN `livro` AS `l` ON `lb`.`livro` = `l`.`idLivro` JOIN `area` AS `a` ON `l`.`area` = `a`.`idArea` $condicao";
        return $this->executarSelect($sql);
    }

    /**
     * Atualiza informações de um livro.
     * @param int $idLivro Usado para localizar livro no banco de dados.
     * @param \Curso $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public function atualizar($idLivro, Livro $novosDados) {

        $idLivro = (int) $idLivro;
        $dadosAntigos = livroDAO::recuperarLivro($idLivro);


        $nome = $novosDados->get_nomeLivro();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nomeLivro();
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

        $grafica = $novosDados->get_grafica();
        if ($grafica == null) {
            $grafica = $dadosAntigos->get_grafica();
        }

        $area = $novosDados->get_area();
        if ($area === null) {
            $area = $dadosAntigos->get_idArea();
        }

        $sql = "UPDATE livro SET nomeLivro = :nome ,quantidade = :quantidade ,dataEntrada = :dataEntrada ,numeroPatrimonio = :numeroPatrimonio ,descricao= :descricao, grafica= :grafica, area= :area WHERE idLivro = :idLivro";
        $params = array(
            ':nome' => [$nome, PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, PDO::PARAM_INT]
            , ':dataEntrada' => [$dataEntrada, $dataEntrada !== null ? PDO::PARAM_STR : PDO::PARAM_NULL]
            , ':numeroPatrimonio' => [$numeroPatrimonio, $numeroPatrimonio !== null ? PDO::PARAM_STR : PDO::PARAM_NULL] //TODO mudar o nome da variável para algo mais intuitivo
            , ':descricao' => [$descricao, $descricao !== null ? PDO::PARAM_STR : PDO::PARAM_NULL]
            , ':grafica' => [$grafica, PDO::PARAM_STR]
            , ':area' => [$area, PDO::PARAM_INT]
            , ':idLivro' => [$idLivro, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idLivro
     * @return boolean
     */
    public function remover($idLivro) {
        if ($idLivro !== null) {
            if (is_array($idLivro)) {
                $idLivro = $idLivro['livroID'];
            }
            $idLivro = (int) $idLivro;
            $sql = "DELETE FROM livro WHERE idLivro = :idLivro";
            $params = array(
                ':idLivro' => [$idLivro, PDO::PARAM_INT]
            );
            return $this->executarQuery($sql, $params);
        }
    }

    /**
     * 
     * @param int $idLivro
     * @param int $idResponsavel
     * @param int $destino
     * @param string $destinoAlternativo
     * @param int $quantidade
     * @param string $data
     * @return boolean
     */
    public function cadastrarSaida($idLivro, $idResponsavel, $destino, $destinoAlternativo, $quantidade, $data = null) {
        $sql = "INSERT INTO livro_saida(livro,responsavel,destino,quantidadeSaida,quantidadeSaidaOriginal,dataSaida,poloDestino) VALUES " .
                "(:idLivro,:idResponsavel,:destinoAlternativo,:quantidade,:quantidade,:data,:destino)";
        $params = array(
            ':idLivro' => [$idLivro, PDO::PARAM_INT]
            , ':idResponsavel' => [$idResponsavel, PDO::PARAM_INT]
            , ':destinoAlternativo' => [$destinoAlternativo, PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, PDO::PARAM_INT]
            , ':data' => [$data, $data !== null ? PDO::PARAM_STR : PDO::PARAM_NULL]
            , ':destino' => [$destino, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idSaida
     * @param string $data
     * @param int $quantidade
     * @param string $observacoes
     * @return boolean
     */
    public function cadastrarRetorno($idSaida, $data, $quantidade, $observacoes = null) {
        $sql = "INSERT INTO livro_retorno(saida,dataRetorno,quantidadeRetorno,observacoes) VALUES " .
                "(:idSaida,:data,:quantidade,:observacoes)";
        $params = array(
            ':idSaida' => [$idSaida, PDO::PARAM_INT]
            , ':data' => [$data, PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, PDO::PARAM_INT]
            , ':observacoes' => [$observacoes, $observacoes !== null ? PDO::PARAM_STR : PDO::PARAM_NULL]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idLivro
     * @param string $dataBaixa
     * @param int $quantidade
     * @param string $observacoes
     * @param int $idSaida
     * @return boolean
     */
    public function cadastrarBaixa($idLivro, $dataBaixa, $quantidade, $observacoes = null, $idSaida = null) {
        $sql = "INSERT INTO livro_baixa(livro,saida,dataBaixa,quantidadeBaixa,observacoes) VALUES " .
                "(:idLivro,:idSaida,:dataBaixa,:quantidade,:observacoes)";
        $params = array(
            ':idLivro' => [$idLivro, PDO::PARAM_INT]
            , ':idSaida' => [$idSaida, $idSaida !== null ? PDO::PARAM_INT : PDO::PARAM_NULL]
            , ':dataBaixa' => [$dataBaixa, PDO::PARAM_STR]
            , ':quantidade' => [$quantidade, PDO::PARAM_INT]
            , ':observacoes' => [$observacoes, $observacoes !== null ? PDO::PARAM_STR : PDO::PARAM_NULL]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Esta função verifica se um livro pode ter o seu tipo alterado, ou seja, se ele
     * pode ser alterado de livro de custeio para livro com patrimônio. Isso apenas acontece para
     * situações de erro na hora de cadastrar, pois, logo após que um livro tenho tido qualquer saída, e
     * consequentemente algum retorno ou baixa, ele não pode mais então ser editado.
     * @param type $idLivro
     */
    public function livroPodeTerTipoAlterado($idLivro) {
        //  Verifica se tem saída
        $sql1 = "SELECT count(livro) as qtdSaidas FROM livro_saida WHERE livro = :livro LIMIT 1";
        $params = array(
            ':livro' => [$idLivro, PDO::PARAM_INT]
        );
        $resultado1 = $this->executarSelect($sql1, $params, false);

        if (is_array($resultado1)) {
            $resultado1 = $resultado1['qtdSaidas'];
        }
        if ((int) $resultado1 > 0) {
            return false;
        }
        //  Verifica se tem baixa
        $sql2 = "SELECT count(livro) as qtdBaixas FROM livro_baixa WHERE livro = :livro LIMIT 1";
        $resultado2 = $this->executarSelect($sql2, $params, false);
        if (is_array($resultado2)) {
            $resultado2 = $resultado2['qtdBaixas'];
        }
        if ((int) $resultado2 > 0) {
            return false;
        }
        //  Verifica se tem retorno
        $sql3 = "SELECT count(livro) as qtdSaidas FROM livro_saida WHERE livro = :livro LIMIT 1";
        $resultado3 = $this->executarSelect($sql3, $params, false);
        if (is_array($resultado3)) {
            $resultado3 = $resultado3['qtdSaidas'];
        }
        if ((int) $resultado3 > 0) {
            return false;
        }
        return true;
    }

    /////////////////// REGISTRO DE EVENTOS PARA LOG ///////////////////////////

    /**
     * 
     * @param int $idLivro
     * @return boolean
     */
    public function registrarExclusaoLivro($idLivro) {
        $tipo = TipoEventoLivro::REMOCAO_LIVRO;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,livro,data,hora) VALUES (:tipo,:idUsuario,:idLivro,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idLivro' => [$idLivro, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idLivro
     * @return boolean
     */
    public function registrarInsercaoLivro($idLivro) {
        $tipo = TipoEventoLivro::CADASTRO_LIVRO;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,livro,data,hora) VALUES (:tipo,:idUsuario,:idLivro,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idLivro' => [$idLivro, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param type $idLivro
     * @return boolean
     */
    public function registrarAlteracaoLivro($idLivro) {
        $tipo = TipoEventoLivro::ALTERACAO_LIVRO;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,livro,data,hora) VALUES (:tipo,:idUsuario,:idLivro,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idLivro' => [$idLivro, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idBaixa
     * @return boolean
     */
    public function registrarCadastroBaixa($idBaixa) {
        $tipo = TipoEventoLivro::CADASTRO_BAIXA;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,baixa,data,hora) VALUES (:tipo,:idUsuario,:idBaixa,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idBaixa' => [$idBaixa, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idBaixa
     * @return boolean
     */
    public function registrarRemocaoBaixa($idBaixa) {
        $tipo = TipoEventoLivro::REMOCAO_BAIXA;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,baixa,data,hora) VALUES (:tipo,:idUsuario,:idBaixa,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idBaixa' => [$idBaixa, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idSaida
     * @return boolean
     */
    public function registrarCadastroSaida($idSaida) {
        $tipo = TipoEventoLivro::CADASTRO_SAIDA;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,saida,data,hora) VALUES (:tipo,:idUsuario,:idSaida,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idSaida' => [$idSaida, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idSaida
     * @return boolean
     */
    public function registrarRemocaoSaida($idSaida) {
        $tipo = TipoEventoLivro::REMOCAO_SAIDA;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,saida,data,hora) VALUES (:tipo,:idUsuario,:idSaida,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idSaida' => [$idSaida, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * 
     * @param int $idRetorno
     * @return boolean
     */
    public function registrarRetorno($idRetorno) {
        $tipo = TipoEventoLivro::CADASTRO_RETORNO;
        $idUsuario = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,retorno,data,hora) VALUES (:tipo,:idUsuario,:idRetorno,:data,:hora)";
        $params = array(
            ':tipo' => [$tipo, PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idRetorno' => [$idRetorno, PDO::PARAM_INT]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
            , ':hora' => [obterHoraAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

}

?>
