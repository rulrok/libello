<?php

require_once 'abstractDAO.php';

class poloDAO extends abstractDAO {

    public static function cadastrarPolo(Polo $polo) {
        $sql = "INSERT INTO polo(nome,cidade,estado) VALUES ";
        $nome = parent::quote($polo->get_nome());
        $cidade = parent::quote($polo->get_cidade());
        $estado = parent::quote($polo->get_estado());
        $values = "($nome,$cidade,$estado)";
        try {
            parent::getConexao()->query($sql . $values);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public static function consultarPolo(Polo $polo) {
        $sql = "SELECT count(idPolo) FROM polo WHERE ";
        $nome = parent::quote($polo->get_nome());
        $cidade = parent::quote($polo->get_cidade());
        $estado = parent::quote($polo->get_estado());
        $condicao = "nome = $nome AND cidade=$cidade AND estado = $estado";
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

    public static function remover($idPolo) {
        if ($idPolo !== null) {
            if (is_array($idPolo)) {
                $idPolo = $idPolo['poloID'];
            }
            $idPolo = (int) $idPolo;
            $sql = "DELETE FROM polo WHERE idPolo = " . $idPolo;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function atualizar($idPolo, Polo $novosDados) {

        $idPolo = (int) $idPolo;
        $dadosAntigos = poloDAO::recuperarPolo($idPolo);

        $condicao = " WHERE idPolo = " . $idPolo;

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


        $sql = "UPDATE polo SET nome = '" . $nome . "' ,cidade = '" . $cidade . "' ,estado = '" . $estado."'";
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

    /** Retorna a lista com todos os polos, com base nas colunas especificadas e nas condições de seleção.
     * 
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param type $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return type A tabela com o resultado da consulta.
     */
    public static function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        }
        $sql = "SELECT " . $colunas . " FROM polo " . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function recuperarPolo($poloID) {
        if (is_array($poloID)) {
            $poloID = $poloID['cursoID'];
        }

        $sql = "SELECT * from polo WHERE idPolo ='" . $poloID . "'";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Polo');
            $polo = $stmt->fetch();
//            if ($usuario == null) {
//                $usuario = "Usuário não encontrado";
//            }
        } catch (Exception $e) {
            $polo = NULL;
        }
        return $polo;
    }

}

?>
