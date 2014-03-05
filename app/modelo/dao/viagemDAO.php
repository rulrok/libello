<?php

require_once 'abstractDAO.php';
require_once APP_DIR . 'modelo/vo/Viagem.php';

class viagemDAO extends abstractDAO {

    /**
     * Retorna a lista com todos as viagens, com base nas colunas especificadas e nas condições de seleção.
     * @param String $colunas Colunas a serem retornadas, por padrão, retorna
     * @param String $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return Array A tabela com o resultado da consulta.
     */
    public function atualizarEstadoViagem($id, $estado) {
        $sql = "UPDATE viagem SET estadoViagem= :estado WHERE idViagem = :idViagem";
        $params = array(
            ':estado' => [$estado, PDO::PARAM_STR]
            , ':idViagem' => [$id, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT $colunas FROM `viagem` AS `v` LEFT JOIN `polo` AS `p` ON `p`.`idPolo` = `v`.`idPolo` NATURAL JOIN `curso` AS `c` JOIN `usuario` AS `u` ON `u`.`idUsuario` = `responsavel` " . $condicao;
        return $this->executarSelect($sql);
    }

    public function inserir(Viagem $obj) {
        $idCurso = $obj->get_idCurso();
        $idPolo = $obj->get_idPolo();
        $responsavel = $obj->get_responsavel();
        $dataIda = $obj->get_dataIda();
        $horaIda = $obj->get_horaIda();
        $dataVolta = $obj->get_dataVolta();
        $horaVolta = $obj->get_horaVolta();
        $motivo = $obj->get_motivo();
        $estado = $obj->get_estado();
        $diarias = $obj->get_diarias();
        $passageiros = $obj->get_passageiros();
        $destinoAlternativo = $obj->get_destinoAlternativo();

        $sql = "INSERT INTO viagem(idCurso,idPolo,responsavel, dataIda, horaIda, dataVolta, horaVolta, motivo, estadoViagem, diarias, outroDestino)";
        $sql .= " VALUES (:idCurso, :idPolo, :responsavel, :dataIda, :horaIda, :dataVolta, :horaVolta, :motivo, :estadoViagem, :diarias, :outroDestino);";
        $params = array(
            ':idCurso' => [$idCurso, PDO::PARAM_INT]
            , ':idPolo' => [$idPolo, PDO::PARAM_INT]
            , ':responsavel' => [$responsavel, PDO::PARAM_STR]
            , ':dataIda' => [$dataIda, PDO::PARAM_STR]
            , ':horaIda' => [$horaIda, PDO::PARAM_STR]
            , ':dataVolta' => [$dataVolta, PDO::PARAM_STR]
            , ':horaVolta' => [$horaVolta, PDO::PARAM_STR]
            , ':motivo' => [$motivo, PDO::PARAM_STR]
            , ':estadoViagem' => [$estado, PDO::PARAM_STR]
            , ':diarias' => [$diarias, PDO::PARAM_STR]
            , ':outroDestino' => [$destinoAlternativo, $destinoAlternativo === null ? PDO::PARAM_NULL : PDO::PARAM_STR]
        );
        try {
            $this->iniciarTransacao();
            if (!$this->executarQuery($sql, $params)) {
                throw new Exception("Erro ao cadastrar viagem");
            }


            $idViagem = $this->obterUltimoIdInserido();
//            if (is_array($idViagem))
//                $idViagem = $idViagem[0];
//            $stmt->closeCursor();
            $quantidadePassageiros = sizeof($passageiros);

            $sqlPassageiros = "INSERT INTO viagem_passageiros(idViagem,idUsuario) VALUES ";
            $params2 = array(
                ':idViagem' => [$idViagem, PDO::PARAM_INT]
            );
            for ($i = 0; $i < $quantidadePassageiros - 1; $i++) {
                $passageiro = ":passageiro$i";
                $sqlPassageiros .= "(:idViagem,$passageiro), ";
                $params2[$passageiro] = [$passageiros[$i], PDO::PARAM_INT];
            }
            $passageiro = ":passageiro$i";
            $sqlPassageiros .= "(:idViagem,$passageiro);";
            $params2[$passageiro] = [$passageiros[$i], PDO::PARAM_INT];
            $this->executarQuery($sqlPassageiros, $params2);
            //TODO verificar
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
        $this->encerrarTransacao();
        return true;
    }

}

?>
