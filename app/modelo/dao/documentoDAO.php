<?php

require_once 'abstractDAO.php';
require_once APP_DIR . "modelo/vo/Oficio.php";
require_once APP_DIR . "modelo/vo/Memorando.php";

class documentoDAO extends abstractDAO {

    public function consultar($documento = "documento_oficio", $condicao = null) {

        $sql = "SELECT * FROM $documento ";
        if ($condicao != null) {
            $sql .=" WHERE " . $condicao;
        }
        $tipo = ucfirst(preg_replace('/documento_/', '', $documento));
        return $this->executarSelect($sql, null, true, $tipo);
    }

    public function inserirOficio(Oficio $obj) {

        $sql = "INSERT INTO documento_oficio (assunto, corpo, idUsuario, estadoEdicao, tratamento, destino, cargo_destino, data, tipoSigla, referencia, remetente, cargo_remetente,  numOficio) VALUES ";
        $sql .= "(:assunto, :corpo, :idUsuario, :estadoEdicao, :tratamento, :destino, :cargo_destino, :data, :tipoSigla, :referencia, :remetente, :cargo_remetente, :numOficio)";

        $params = array(
            ':assunto' => [$obj->get_assunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), PDO::PARAM_STR]
            , ':idUsuario' => [$obj->get_idUsuario(), PDO::PARAM_INT]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), PDO::PARAM_STR]
            , ':destino' => [$obj->get_destino(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), PDO::PARAM_STR]
            , ':referencia' => [$obj->get_referencia(), PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), PDO::PARAM_STR]
            , ':numOficio' => [$obj->get_numOficio(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function teste() {
        parent::getConexao()->lastInsertId();
    }

    public function update_oficio(Oficio $obj) {

        $sql = 'UPDATE documento_oficio SET assunto = :assunto, corpo = :corpo, estadoEdicao = :estadoEdicao, tratamento = :tratamento, destino = :destino, cargo_destino = :cargo_destino,';
        $sql .= 'data = :data, tipoSigla = :tipoSigla, referencia = :referencia, remetente = :remetente, cargo_remetente = :cargo_remetente,  numOficio = :numOficio ';
        $sql .= ' WHERE idOficio = :idOficio';

        $params = array(
            ':assunto' => [$obj->get_assunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), PDO::PARAM_STR]
            , ':destino' => [$obj->get_destino(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), PDO::PARAM_STR]
            , ':referencia' => [$obj->get_referencia(), PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), PDO::PARAM_STR]
            , ':numOficio' => [$obj->get_numOficio(), PDO::PARAM_INT]
            , ':idOficio' => [$obj->get_idOficio(), PDO::PARAM_INT]
        );

        return $this->executarQuery($sql, $params);
    }

    public function invalidarOficio($idOficio) {
        $sql = "UPDATE documento_oficio SET estadoValidacao = 0 WHERE idOficio = :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function deleteOficio($idOficio) {
        $sql = "DELETE FROM documento_oficio WHERE idOficio= :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function deleteMemorando($idMemorando) {

        $sql = "DELETE FROM documento_memorando WHERE idMemorando= :idMemorando";
        $params = array(
            ':idMemorando' => [$idMemorando, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function inserirMemorando(Memorando $obj) {

        $sql = "INSERT INTO documento_memorando (assunto, corpo, idUsuario, estadoEdicao, tratamento, cargo_destino, data, tipoSigla, remetente, cargo_remetente,  numMemorando) VALUES ";
        $sql .= "(:assunto, :corpo, :idUsuario, :estadoEdicao, :tratamento, :cargo_destino, :data, :tipoSigla, :remetente, :cargo_remetente,  :numMemorando)";

        $params = array(
            ':assunto' => [$obj->get_assunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), PDO::PARAM_STR]
            , ':idUsuario' => [$obj->get_idUsuario(), PDO::PARAM_INT]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), PDO::PARAM_STR]
            , ':numMemorando' => [$obj->get_numMemorando(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function update_memorando(Memorando $obj) {

        $sql = 'UPDATE documento_memorando SET assunto = :assunto, corpo = :corpo, estadoEdicao = :estadoEdicao, '
                . 'tratamento = :tratamento, cargo_destino = :cargo_destino, data = :data, tipoSigla = :tipoSigla, '
                . 'remetente = :remetente, cargo_remetente = :cargo_remetente, numMemorando = :numMemorando '
                . 'WHERE idMemorando = :idMemorando';

        $params = array(
            ':assunto' => [$obj->get_assunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), PDO::PARAM_STR]
            , ':numMemorando' => [$obj->get_numMemorando(), PDO::PARAM_INT]
            , ':idMemorando' => [$obj->get_idMemorando(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function invalidarMemorando($idmemorando) {

        $sql = "UPDATE documento_memorando SET estadoValidacao = 0 WHERE idMemorando=" . $idmemorando;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
//            print_r($e);
            return false;
        }
    }

}

?>
