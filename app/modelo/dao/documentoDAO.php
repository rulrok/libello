<?php

require_once 'abstractDAO.php';
require_once APP_DIR . "modelo/vo/Oficio.php";
require_once APP_DIR . "modelo/vo/Memorando.php";

class documentoDAO extends abstractDAO {

    public function consultar($documento = "oficio", $condicao = null) {

        $sql = "SELECT * FROM $documento ";
        if ($condicao != null) {
            $sql .=" WHERE " . $condicao;
        }
        $tipo = ucfirst($documento);
        return $this->executarSelect($sql, null, true, $tipo);
    }

    public function inserirOficio(Oficio $obj) {

        $sql = "INSERT INTO oficio (assunto, corpo, idUsuario, estadoEdicao, tratamento, destino, cargo_destino, data, tipoSigla, referencia, remetente, remetente2, cargo_remetente, cargo_remetente2, numOficio) VALUES ";
        $sql .= "(:assunto, :corpo, :idusuario, :estadoEdicao, :tratamento, :destino, :cargo_destino, :data, :tipoSigla, :referencia, :remetente, :remetente2, :cargo_remetente, :cargo_remetente2, :numOficio)";

        $params = array(
            ':assunto' => [$obj->getAssunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->getCorpo(), PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->getEstadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->getTratamento(), PDO::PARAM_STR]
            , ':idUsuario' => [$obj->getIdUsuario(), PDO::PARAM_INT]
            , ':destino' => [$obj->getDestino(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->getCargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->getData(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->getTipoSigla(), PDO::PARAM_STR]
            , ':referencia' => [$obj->getReferencia(), PDO::PARAM_STR]
            , ':remetente' => [$obj->getRemetente(), PDO::PARAM_STR]
            , ':remetente2' => [$obj->getRemetente2(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->getCargo_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente2' => [$obj->getCargo_remetente2(), PDO::PARAM_STR]
            , ':numOficio' => [$obj->getNumOficio(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function update_oficio(Oficio $obj) {

        $sql = 'UPDATE oficio SET assunto = :assunto, corpo = :corpo, estadoEdicao = :estadoEdicao, tratamento = :tratamento, destino = :destino, cargo_destino = :cargo_destino,';
        $sql .= 'data = :data, tipoSigla = :tipoSigla, referencia = :referencia, remetente = :remetente, remetente2 = :remetente2, cargo_remetente = :cargo_remetente, cargo_remetente2 = :cargo_remetente2, numOficio = :numOficio ';
        $sql .= ' WHERE idOficio = :idOficio';

        $params = array(
            ':assunto' => [$obj->getAssunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->getCorpo(), PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->getEstadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->getTratamento(), PDO::PARAM_STR]
            , ':destino' => [$obj->getDestino(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->getCargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->getData(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->getTipoSigla(), PDO::PARAM_STR]
            , ':referencia' => [$obj->getReferencia(), PDO::PARAM_STR]
            , ':remetente' => [$obj->getRemetente(), PDO::PARAM_STR]
            , ':remetente2' => [$obj->getRemetente2(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->getCargo_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente2' => [$obj->getCargo_remetente2(), PDO::PARAM_STR]
            , ':numOficio' => [$obj->getNumOficio(), PDO::PARAM_INT]
            , ':idOficio' => [$obj->getIdOficio(), PDO::PARAM_INT]
        );

        return $this->executarQuery($sql, $params);
    }

    public function invalidarOficio($idOficio) {
        $sql = "UPDATE oficio SET estadoValidacao = 0 WHERE idOficio = :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function deleteOficio($idOficio) {
        $sql = "DELETE FROM oficio WHERE idOficio= :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function deleteMemorando($idMemorando) {

        $sql = "DELETE FROM memorando WHERE idMemorando= :idMemorando";
        $params = array(
            ':idMemorando' => [$idMemorando, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function inserirMemorando(Memorando $obj) {

        $sql = "INSERT INTO memorando (assunto, corpo, idUsuario, estadoEdicao, tratamento, cargo_destino, data, tipoSigla, remetente, remetente2, cargo_remetente, cargo_remetente2, numMemorando) VALUES ";
        $sql .= "(:assunto, :corpo, :idusuario, :estadoEdicao, :tratamento, :cargo_destino, :data, :tipoSigla, :remetente, :remetente2, :cargo_remetente, :cargo_remetente2, :numMemorando)";

        $params = array(
            ':assunto' => [$obj->getAssunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->getCorpo(), PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->getEstadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->getTratamento(), PDO::PARAM_STR]
            , ':idUsuario' => [$obj->getIdUsuario(), PDO::PARAM_INT]
            , ':cargo_destino' => [$obj->getCargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->getData(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->getTipoSigla(), PDO::PARAM_STR]
            , ':remetente' => [$obj->getRemetente(), PDO::PARAM_STR]
            , ':remetente2' => [$obj->getRemetente2(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->getCargo_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente2' => [$obj->getCargo_remetente2(), PDO::PARAM_STR]
            , ':numMemorando' => [$obj->getNumMemorando(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function update_memorando(Memorando $obj) {

        $sql = 'UPDATE memorando SET assunto = :assunto, corpo = :corpo, estadoEdicao = :estadoEdicao, tratamento = :tratamento, cargo_destino = :cargo_destino, data = :data, tipoSigla = :tipoSigla, remetente = :remetente, remetente2 = :remetente2, cargo_remetente = :cargo_remetente, cargo_remetente2 = :cargo_remetente2, numMemorando = :numMemorando) WHERE idMemorando = :idMemorando';

        $params = array(
            ':assunto' => [$obj->getAssunto(), PDO::PARAM_STR]
            , ':corpo' => [$obj->getCorpo(), PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->getEstadoEdicao(), PDO::PARAM_INT]
            , ':tratamento' => [$obj->getTratamento(), PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->getCargo_destino(), PDO::PARAM_STR]
            , ':data' => [$obj->getData(), PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->getTipoSigla(), PDO::PARAM_STR]
            , ':remetente' => [$obj->getRemetente(), PDO::PARAM_STR]
            , ':remetente2' => [$obj->getRemetente2(), PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->getCargo_remetente(), PDO::PARAM_STR]
            , ':cargo_remetente2' => [$obj->getCargo_remetente2(), PDO::PARAM_STR]
            , ':numMemorando' => [$obj->getNumMemorando(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function invalidarMemorando($idmemorando) {

        $sql = "UPDATE memorando SET estadoValidacao = 0 WHERE idMemorando=" . $idmemorando;
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
