<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . "modelo/vo/Livro.php";
require_once APP_LOCATION . 'modelo/enumeracao/TipoEventoLivro.php';

class livroDAO extends abstractDAO {

    public static function cadastrarLivro(Livro $livro) {
        $sql = "INSERT INTO livro(nomeLivro,quantidade,descricao,dataEntrada,numeroPatrimonio,area,grafica) VALUES ";
        $nome = parent::quote($livro->get_nomeLivro());
        $quantidade = $livro->get_quantidade();

        $dataEntrada = $livro->get_dataEntrada();
        if ($dataEntrada === "" | $dataEntrada === null) {
            $dataEntrada = "NULL";
        }
        $dataEntrada = parent::quote($dataEntrada);


        $numeroPatrimonio = parent::quote($livro->get_numeroPatrimonio());

        $descricao = $livro->get_descricao();
        if ($descricao === "" | $descricao === null) {
            $descricao = "NULL";
        }
        $descricao = parent::quote($descricao);

        $grafica = $livro->get_grafica();
        if ($grafica === "" | $grafica === null) {
            $grafica = "NULL";
        }
        $grafica = parent::quote($grafica);

        $area = $livro->get_area();
        if ($area === "" | $area === null) {
            $area = "NULL";
        }
//        $area = parent::quote($area);


        $values = "($nome,$quantidade,$descricao,$dataEntrada,$numeroPatrimonio,$area,$grafica)";
        try {
            echo $sql . $values;
            $stmt = parent::getConexao()->prepare($sql . $values);
            $stmt->execute();
            $id = parent::getConexao()->lastInsertId();
            return $id;
//            print_r($id);
        } catch (Exception $e) {
            print_r($e);
            throw new Exception("Erro");
        }
    }

    /**
     * Retorna a lista com todos os livros, com base nas colunas especificadas e nas condições de seleção.
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
        $sql = "SELECT " . $colunas . " FROM livro JOIN area ON area = idArea " . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function recuperarLivro($livroID) {
        if (is_array($livroID)) {
            $livroID = $livroID['livroID'];
        }

        $sql = "SELECT * from livro WHERE idLivro ='" . $livroID . "'";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Livro');
            $saida = $stmt->fetch();
        } catch (Exception $e) {
            $saida = NULL;
        }
        return $saida;
    }

    public static function recuperarSaidaLivro($saidaID) {
        $saida = livroDAO::consultarSaidas("*", "ls.idSaida = " . $saidaID);
        if (is_array($saida)) {
            $saida = $saida[0];
        }
        return $saida;
    }

    public static function removerBaixa($baixaID) {
        if (is_array($baixaID)) {
            $livroID = $livroID['baixaID'];
        }

        $sql = "DELETE from livro_baixa WHERE idBaixa = " . $baixaID;
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
            $livroID = $livroID['saidaID'];
        }

        $sql = "DELETE from livro_saida WHERE idSaida = " . $saidaID;
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
        $sql = "SELECT " . $colunas . " FROM `livro_saida` AS `ls` JOIN `livro` AS `l` ON `ls`.`livro` = `l`.idLivro JOIN `usuario` AS `u` ON `ls`.`responsavel` = `u`.`idUsuario` LEFT JOIN `polo` AS `p` ON `ls`.`poloDestino` = `p`.`idPolo` JOIN `area` AS `a` ON `l`.`area` = `a`.`idArea` " . $condicao;
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
        $sql = "SELECT " . $colunas . " FROM `livro_baixa` AS `lb` JOIN `livro` AS `l` ON `lb`.`livro` = `l`.`idLivro` JOIN `area` AS `a` ON `l`.`area` = `a`.`idArea`" . $condicao;
        try {
            $resultado = parent::getConexao()->query($sql)->fetchAll();
        } catch (Exception $e) {
            die($e);
        }
        return $resultado;
    }

    /**
     * Atualiza informações de um livro.
     * @param int $livroID Usado para localizar livro no banco de dados.
     * @param Curso $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public static function atualizar($livroID, Livro $novosDados) {

        $livroID = (int) $livroID;
        $dadosAntigos = livroDAO::recuperarLivro($livroID);

        $condicao = " WHERE idLivro = " . $livroID;

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
        if ($numeroPatrimonio !== "NULL") {
            $numeroPatrimonio = parent::quote($numeroPatrimonio);
        }

        $descricao = $novosDados->get_descricao();
        $descricao = parent::quote($descricao);

        $grafica = $novosDados->get_grafica();
        if ($grafica == null) {
            $grafica = $dadosAntigos->get_grafica();
        }

        $area = $novosDados->get_area();
        if ($area === null) {
            $area = $dadosAntigos->get_area();
        }

        $sql = "UPDATE livro SET nomeLivro = '" . $nome . "' ,quantidade = " . $quantidade . " ,dataEntrada = '" . $dataEntrada . "' ,numeroPatrimonio = " . $numeroPatrimonio . " ,descricao=" . $descricao . ", grafica='" . $grafica . "', area=" . $area;
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

    public static function remover($livroID) {
        if ($livroID !== null) {
            if (is_array($livroID)) {
                $livroID = $livroID['livroID'];
            }
            $livroID = (int) $livroID;
            $sql = "DELETE FROM livro WHERE idLivro = " . $livroID;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function cadastrarSaida($idLivro, $idResponsavel, $destino, $destinoAlternativo, $quantidade, $data = "NULL") {
        $destino = $destino;
        $data = parent::quote($data);
        $destinoAlternativo = parent::quote($destinoAlternativo);
        $sql = "INSERT INTO livro_saida(livro,responsavel,destino,quantidadeSaida,quantidadeSaidaOriginal,dataSaida,poloDestino) VALUES " .
                "($idLivro,$idResponsavel,$destinoAlternativo,$quantidade,$quantidade,$data,$destino)";

        try {
            parent::getConexao()->query($sql);
            $id = parent::getConexao()->lastInsertId();
            livroDAO::registrarCadastroSaida($id);
            return true;
        } catch (Exception $e) {
            print_r($e . $sql);
            return false;
        }
    }

    public static function cadastrarRetorno($idSaida, $data, $quantidade, $observacoes = "NULL") {
        $observacoes = parent::quote($observacoes);
        $data = parent::quote($data);
        $sql = "INSERT INTO livro_retorno(saida,dataRetorno,quantidadeRetorno,observacoes) VALUES " .
                "($idSaida,$data,$quantidade,$observacoes)";
        try {
            parent::getConexao()->query($sql);
            $id = parent::getConexao()->lastInsertId();
            livroDAO::registrarRetorno($id);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function cadastrarBaixa($idLivro, $dataBaixa, $quantidade, $observacoes = "NULL", $idSaida = "NULL") {
        $observacoes = parent::quote($observacoes);
        $dataBaixa = parent::quote($dataBaixa);
        $sql = "INSERT INTO livro_baixa(livro,saida,dataBaixa,quantidadeBaixa,observacoes) VALUES " .
                "($idLivro,$idSaida,$dataBaixa,$quantidade,$observacoes)";
        try {
            parent::getConexao()->query($sql);
            $idBaixa = parent::getConexao()->lastInsertId();
            livroDAO::registrarCadastroBaixa($idBaixa);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Esta função verifica se um livro pode ter o seu tipo alterado, ou seja, se ele
     * pode ser alterado de livro de custeio para livro com patrimônio. Isso apenas acontece para
     * situações de erro na hora de cadastrar, pois, logo após que um livro tenho tido qualquer saída, e
     * consequentemente algum retorno ou baixa, ele não pode mais então ser editado.
     * @param type $idLivro
     */
    public static function livroPodeTerTipoAlterado($idLivro) {
        try {
            //  Verifica se tem saída
            $sql = "SELECT count(livro) as qtdSaidas FROM livro_saida WHERE livro = :livro";
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(":livro", $idLivro, PDO::PARAM_INT);
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
            $sql = "SELECT count(livro) as qtdBaixas FROM livro_baixa WHERE livro = :livro";
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(":livro", $idLivro, PDO::PARAM_INT);
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
            $sql = "SELECT count(livro) as qtdSaidas FROM livro_saida WHERE livro = :livro";
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(":livro", $idLivro, PDO::PARAM_INT);
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

    public static function registrarExclusaoLivro($idLivro) {
        $quote = "\"";
        $tipo = TipoEventoLivro::REMOCAO_LIVRO;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,livro,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idLivro,<data>,<hora>)";
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

    public static function registrarInsercaoLivro($idLivro) {
        $quote = "\"";
        $tipo = TipoEventoLivro::CADASTRO_LIVRO;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,livro,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idLivro,<data>,<hora>)";
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

    public static function registrarAlteracaoLivro($idLivro) {
        $quote = "\"";
        $tipo = TipoEventoLivro::ALTERACAO_LIVRO;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,livro,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idLivro,<data>,<hora>)";
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
        $tipo = TipoEventoLivro::CADASTRO_BAIXA;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,baixa,data,hora) VALUES ";
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
        $tipo = TipoEventoLivro::REMOCAO_BAIXA;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,baixa,data,hora) VALUES ";
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
        $tipo = TipoEventoLivro::CADASTRO_SAIDA;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,saida,data,hora) VALUES ";
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
        $tipo = TipoEventoLivro::REMOCAO_SAIDA;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,saida,data,hora) VALUES ";
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
        $tipo = TipoEventoLivro::CADASTRO_RETORNO;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
        $sql = "INSERT INTO livro_evento(tipoEvento,usuario,retorno,data,hora) VALUES ";
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
