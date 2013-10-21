<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . 'modelo/vo/Viagem.php';

class viagemDAO extends abstractDAO {

    /**
     * Retorna a lista com todos as viagens, com base nas colunas especificadas e nas condições de seleção.
     * @param String $colunas Colunas a serem retornadas, por padrão, retorna
     * @param String $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return Array A tabela com o resultado da consulta.
     */
    public static function atualizarEstadoViagem($id, $estado) {
        $sql = "UPDATE viagem SET estadoViagem='" . $estado . "' WHERE idViagem = $id";
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT " . $colunas . " FROM `viagem` AS `v` LEFT JOIN `polo` AS `p` ON `p`.`idPolo` = `v`.`idPolo` NATURAL JOIN `curso` AS `c` JOIN `usuario` AS `u` ON `u`.`idUsuario` = `responsavel` " . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function inserir(Viagem $valueObject) {
        $s = "','";
        $idCurso = $valueObject->get_idCurso();
        $idPolo = $valueObject->get_idPolo();
        $responsavel = $valueObject->get_responsavel();
        $dataIda = $valueObject->get_dataIda();
        $horaIda = $valueObject->get_horaIda();
        $dataVolta = $valueObject->get_dataVolta();
        $horaVolta = $valueObject->get_horaVolta();
        $motivo = $valueObject->get_motivo();
        $estado = $valueObject->get_estado();
        $diarias = $valueObject->get_diarias();
        $passageiros = $valueObject->get_passageiros();
        $destinoAlternativo = $valueObject->get_destinoAlternativo();

        $sql = "INSERT INTO viagem(idCurso,idPolo,responsavel, dataIda, horaIda, dataVolta, horaVolta, motivo, estadoViagem, diarias, outroDestino)";
//        $sql .= " VALUES (" . $idCurso . ",'" . $idPolo . $s . $responsavel . $s . $dataIda . $s . $horaIda . $s . $dataVolta . $s . $horaVolta . $s . $motivo . $s . $estado . $s . $diarias . "')";
        $sql .= " VALUES (:idCurso, :idPolo, :responsavel, :dataIda, :horaIda, :dataVolta, :horaVolta, :motivo, :estadoViagem, :diarias, :outroDestino);";
        try {
            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindValue(':idCurso', $idCurso, PDO::PARAM_INT);
            if ($idPolo != "NULL") {
                $stmt->bindValue(':idPolo', $idPolo, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':idPolo', null, PDO::PARAM_NULL);
            }
            $stmt->bindValue(':responsavel', $responsavel, PDO::PARAM_INT);
            $stmt->bindValue(':dataIda', $dataIda, PDO::PARAM_STR);
            $stmt->bindValue(':horaIda', $horaIda, PDO::PARAM_STR);
            $stmt->bindValue(':dataVolta', $dataVolta, PDO::PARAM_STR);
            $stmt->bindValue(':horaVolta', $horaVolta, PDO::PARAM_STR);
            $stmt->bindValue(':motivo', $motivo, PDO::PARAM_STR);
            $stmt->bindValue(':estadoViagem', $estado, PDO::PARAM_STR);
            $stmt->bindValue(':diarias', $diarias, PDO::PARAM_STR);
            if ($destinoAlternativo != "NULL") {
                $stmt->bindValue(':outroDestino', $destinoAlternativo, PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':outroDestino', null, PDO::PARAM_NULL);
            }
            $stmt->execute();

//            $sqlAuxiliar = "SELECT idViagem FROM viagem WHERE idCurso = :idCurso AND idPolo = :idPolo AND responsavel = :responsavel AND dataIda = :dataIda AND horaIda = :horaIda AND dataVolta = :dataVolta AND horaVolta = :horaVolta AND motivo = :motivo AND estado = :estado AND diarias = :diarias AND :outroDestino = outroDestino ORDER BY idViagem DESC LIMIT 1";
//            $stmt = parent::getConexao()->prepare($sqlAuxiliar);
//            $stmt->bindValue(':idCurso', $idCurso, PDO::PARAM_INT);
//            $stmt->bindValue(':idPolo', $idPolo, PDO::PARAM_INT);
//            $stmt->bindValue(':responsavel', $responsavel, PDO::PARAM_INT);
//            $stmt->bindValue(':dataIda', $dataIda, PDO::PARAM_STR);
//            $stmt->bindValue(':horaIda', $horaIda, PDO::PARAM_STR);
//            $stmt->bindValue(':dataVolta', $dataVolta, PDO::PARAM_STR);
//            $stmt->bindValue(':horaVolta', $horaVolta, PDO::PARAM_STR);
//            $stmt->bindValue(':motivo', $motivo, PDO::PARAM_STR);
//            $stmt->bindValue(':estadoViagem', $estado, PDO::PARAM_STR);
//            $stmt->bindValue(':diarias', $diarias, PDO::PARAM_STR);
//            $stmt->bindValue(':outroDestino', $destinoAlternativo, PDO::PARAM_STR);
//            $stmt->execute();
            $idViagem = parent::getConexao()->lastInsertId();
            if (is_array($idViagem))
                $idViagem = $idViagem[0];
            $stmt->closeCursor();
            $quantidadePassageiros = sizeof($passageiros);

            $sqlPassageiros = "INSERT INTO viagem_passageiros(idViagem,idUsuario) VALUES ";
            for ($i = 0; $i < $quantidadePassageiros - 1; $i++) {
                $sqlPassageiros .= "($idViagem,$passageiros[$i]), ";
            }
            $sqlPassageiros .= "($idViagem,$passageiros[$i]);";
            parent::getConexao()->query($sqlPassageiros);

            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

}

?>
