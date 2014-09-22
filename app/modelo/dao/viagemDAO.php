<?php

namespace app\modelo;

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
            ':estado' => [$estado, \PDO::PARAM_STR]
            , ':idViagem' => [$id, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT $colunas FROM `viagem` AS `v` LEFT JOIN `cursospolos_polo` AS `p` ON `p`.`idPolo` = `v`.`idPolo` NATURAL JOIN `cursospolos_curso` AS `c` JOIN `usuario` AS `u` ON `u`.`idUsuario` = `responsavel` " . $condicao;
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
            ':idCurso' => [$idCurso, \PDO::PARAM_INT]
            , ':idPolo' => [$idPolo, $idPolo === null ? \PDO::PARAM_NULL : \PDO::PARAM_INT]
            , ':responsavel' => [$responsavel, \PDO::PARAM_STR]
            , ':dataIda' => [$dataIda, \PDO::PARAM_STR]
            , ':horaIda' => [$horaIda, \PDO::PARAM_STR]
            , ':dataVolta' => [$dataVolta, \PDO::PARAM_STR]
            , ':horaVolta' => [$horaVolta, \PDO::PARAM_STR]
            , ':motivo' => [$motivo, \PDO::PARAM_STR]
            , ':estadoViagem' => [$estado, \PDO::PARAM_STR]
            , ':diarias' => [$diarias, \PDO::PARAM_STR]
            , ':outroDestino' => [$destinoAlternativo, $destinoAlternativo === null ? \PDO::PARAM_NULL : \PDO::PARAM_STR]
        );
        try {
            $this->iniciarTransacao();
            if (!$this->executarQuery($sql, $params)) {
                throw new \Exception("Erro ao cadastrar viagem");
            }


            $idViagem = $this->obterUltimoIdInserido();
//            if (is_array($idViagem))
//                $idViagem = $idViagem[0];
//            $stmt->closeCursor();
            $quantidadePassageiros = sizeof($passageiros);

            $sqlPassageiros = "INSERT INTO viagem_passageiros(idViagem,idUsuario) VALUES ";
            $params2 = array(
                ':idViagem' => [$idViagem, \PDO::PARAM_INT]
            );
            for ($i = 0; $i < $quantidadePassageiros - 1; $i++) {
                $passageiro = ":passageiro$i";
                $sqlPassageiros .= "(:idViagem,$passageiro), ";
                $params2[$passageiro] = [$passageiros[$i], \PDO::PARAM_INT];
            }
            $passageiro = ":passageiro$i";
            $sqlPassageiros .= "(:idViagem,$passageiro);";
            $params2[$passageiro] = [$passageiros[$i], \PDO::PARAM_INT];
            $this->executarQuery($sqlPassageiros, $params2);
            //TODO verificar
        } catch (\Exception $e) {
            $this->rollback();
            return false;
        }
        $this->encerrarTransacao();
        return true;
    }

    public function atualizar($idViagem, Viagem $novosDados) {
        $idViagem = (int) $idViagem;
        $dadosAntigos = viagemDAO::recuperarViagem($idViagem);

        $idCurso = $novosDados->idCurso;
        if ($idCurso === null) {
            $idCurso = $dadosAntigos->idCurso;
        }

        $idPolo = $novosDados->$idPolo;
        if ($idPolo === null) {
            $idPolo = $dadosAntigos->idPolo;
        }

        $responsavel = $novosDados->responsavel;
        if ($responsavel === null) {
            $responsavel = $dadosAntigos->responsavel;
        }

        $dataIda = $novosDados->dataIda;
        if ($dataIda === null) {
            $dataIda = $dadosAntigos->dataIda;
        }

        $dataVolta = $novosDados->dataVolta;
        if ($dataVolta === null) {
            $dataVolta = $dadosAntigos->dataVolta;
        }

        $horaIda = $novosDados->horaIda;
        if ($horaIda === null) {
            $horaIda = $dadosAntigos->horaIda;
        }

        $horaVolta = $novosDados->horaVolta;
        if ($horaVolta === null) {
            $horaVolta = $dadosAntigos->horaVolta;
        }

        $motivo = $novosDados->motivo;
        if ($motivo === null) {
            $motivo = $dadosAntigos->motivo;
        }

        $estadoViagem = $novosDados->estadoViagem;
        if ($estadoViagem === null) {
            $estadoViagem = $dadosAntigos->estadoViagem;
        }

        $diarias = $novosDados->diarias;
        if ($diarias === null) {
            $diarias = $dadosAntigos->diarias;
        }

        $passageiros = $novosDados->passageiros;
        if ($passageiros === null) {
            $passageiros = $dadosAntigos->passageiros;
        }

        $destinoAlternativo = $novosDados->destinoAlternativo;
        if ($destinoAlternativo === null) {
            $destinoAlternativo = $dadosAntigos->destinoAlternativo;
        }

        $sql = "UPDATE viagem SET idViagem = :idViagem, idCurso = :idCurso, idPolo = :idPolo, responsavel = :responsavel, dataIda = :dataIda,horaIda = :horaIda, dataVolta = :dataVolta, horaVolta = :horaVolta, motivo = :motivo, estadoViagem = :estadoViagem, diarias = :diarias, outroDestino = :destinoAlternativo";
        $params = array(
            ':idCurso' => [$idCurso, \PDO::PARAM_INT]
            , ':idPolo' => [$idPolo, $idPolo === null ? \PDO::PARAM_NULL : \PDO::PARAM_INT]
            , ':responsavel' => [$responsavel, \PDO::PARAM_STR]
            , ':dataIda' => [$dataIda, \PDO::PARAM_STR]
            , ':horaIda' => [$horaIda, \PDO::PARAM_STR]
            , ':dataVolta' => [$dataVolta, \PDO::PARAM_STR]
            , ':horaVolta' => [$horaVolta, \PDO::PARAM_STR]
            , ':motivo' => [$motivo, \PDO::PARAM_STR]
            , ':estadoViagem' => [$estado, \PDO::PARAM_STR]
            , ':diarias' => [$diarias, \PDO::PARAM_STR]
            , ':outroDestino' => [$destinoAlternativo, $destinoAlternativo === null ? \PDO::PARAM_NULL : \PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

//
//        $sql = "UPDATE livro SET nomeLivro = :nome ,quantidade = :quantidade ,dataEntrada = :dataEntrada ,numeroPatrimonio = :numeroPatrimonio ,descricao= :descricao, grafica= :grafica, area= :area WHERE idLivro = :idLivro";
//        $params = array(
//            ':nome' => [$nome, \PDO::PARAM_STR]
//            , ':quantidade' => [$quantidade, \PDO::PARAM_INT]
//            , ':dataEntrada' => [$dataEntrada, $dataEntrada !== null ? \PDO::PARAM_STR : \PDO::PARAM_NULL]
//            , ':numeroPatrimonio' => [$numeroPatrimonio, $numeroPatrimonio !== null ? \PDO::PARAM_STR : \PDO::PARAM_NULL] //TODO mudar o nome da variável para algo mais intuitivo
//            , ':descricao' => [$descricao, $descricao !== null ? \PDO::PARAM_STR : \PDO::PARAM_NULL]
//            , ':grafica' => [$grafica, \PDO::PARAM_STR]
//            , ':area' => [$area, \PDO::PARAM_INT]
//            , ':idLivro' => [$idLivro, \PDO::PARAM_INT]
//        );
//        return $this->executarQuery($sql, $params);
//    }

    public function recuperarViagem($idViagem) {
        if (is_array($idViagem)) {
            $idViagem = $idViagem['viagemID'];
        }

        $sql = "SELECT * from viagem WHERE idViagem = :idViagem";
        $params = array(
            ':idViagem' => [$idViagem, \PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Viagem');
    }

    public function recuperarResponsavel($idResponsavel) {
        $sql = "SELECT PNome,UNome from usuario WHERE idUsuario = :idResponsavel";
        $params = array(
            ':idResponsavel' => [$idResponsavel, \PDO::PARAM_INT]
        );
        $array = $this->executarSelect($sql, $params);
        $responsavel = $array[0][0] . " " . $array[0][1];
        return $responsavel;
    }

    public function recuperarCurso($idCurso) {
        $sql = "SELECT nomeCurso from cursospolos_curso WHERE idCurso = :idCurso";
        $params = array(
            ':idCurso' => [$idCurso, \PDO::PARAM_INT]
        );
        $array = $this->executarSelect($sql, $params);
        $curso = $array[0][0];
        return $curso;
    }

    public function recuperarDestino($idDestino) {
        $sql = "SELECT nomePolo from cursospolos_polo WHERE idPolo = :idDestino";
        $params = array(
            ':idDestino' => [$idDestino, \PDO::PARAM_INT]
        );
        $array = $this->executarSelect($sql, $params);
        if (!empty($array)) {
            $destino = $array[0][0];
        } else {
            $destino = "";
        }
        return $destino;
    }

    public function recuperarDestinoAlternativo($idDestino) {
        $sql = "SELECT outroDestino from viagem WHERE idViagem = :idDestino";
        $params = array(
            ':idDestino' => [$idDestino, \PDO::PARAM_INT]
        );
        $array = $this->executarSelect($sql, $params);
        $destino = $array[0][0];
        return $destino;
    }

}

?>
