<?php
namespace app\modelo;
require_once 'abstractDAO.php';
require_once APP_DIR . "modelo/vo/Oficio.php";
require_once APP_DIR . "modelo/vo/Memorando.php";

class documentoDAO extends abstractDAO {

    /**
     * 
     * @param $nomeTabelaDocumento Nome da tabela que se deseja consultar algum último valor inserido
     * @param $campoUltimoRegistroDesejado Nome do campo que se deseja obter o ultimo registro inserido
     * @param $chavePrimariaTabela Nome da chave primaria (Auto-incrementada) da tabela ex: idOficio, idMemorando, etc.
     * @return O inteiro correspondente ao ultimo valor desejado
     */
    public function consultaUltimoRegistroValidacao($nomeTabelaDocumento, $campoUltimoRegistroDesejado, $chavePrimariaTabela) {
        $sql = "SELECT MAX(" . $chavePrimariaTabela . ") FROM " . $nomeTabelaDocumento;
        $ultimoIdInserido = $this->executarSelect($sql);

        if ($ultimoIdInserido[0][0] == "") {
            return "";
        } else {
            $sql = "SELECT " . $campoUltimoRegistroDesejado . " FROM " . $nomeTabelaDocumento . " WHERE " . $chavePrimariaTabela . " = " . $ultimoIdInserido[0][0];
            $resultado = $this->executarSelect($sql);
            return $resultado[0][0];
        }
    }

    public function consultar($documento = "documento_oficio", $condicao = null) {

        $sql = "SELECT * FROM $documento ";
        if ($condicao != null) {
            $sql .=" WHERE " . $condicao;
        }
        $tipo = ucfirst(preg_replace('/documento_/', '', $documento));
        return $this->executarSelect($sql, null, true, $tipo);
    }

    public function inserirOficio(Oficio $obj) {
        $documentoDAO = new documentoDAO();
        $ultimaInsercao = $documentoDAO->consultaUltimoRegistroValidacao("documento_oficio", "numOficio", "idOficio"); //Busca o ultimo registro de oficio
        //Caso o oficio a ser inserido não seja o primeiro
        if ($ultimaInsercao != null || $ultimaInsercao != "") {
            $ultimaInsercao = explode("/", $ultimaInsercao); //Extrai o numero do ultimo oficio. O modelo é NUMERO/ANO_ATUAL
            $ultimaInsercao = $ultimaInsercao[0]; //A posição zero resultante deste explode é o numero do ultimo ofício
            //Caso o oficio a ser inserido seja o primeiro
        } else {
            $ultimaInsercao = 0;
        }
        $ultimaInsercao++; //incrementa o número do oficio
//        $numOficio = $ultimaInsercao . "/" . date("Y");

        if ($ultimaInsercao < 10) {
            $numOficio = "0000" . $ultimaInsercao . "/" . date("Y"); //até 9
        } else if ($ultimaInsercao < 100) {
            $numOficio = "000" . $ultimaInsercao . "/" . date("Y"); //ate 99
        } else if ($ultimaInsercao < 1000) {
            $numOficio = "00" . $ultimaInsercao . "/" . date("Y"); //ate 999
        } else if ($ultimaInsercao < 10000) {
            $numOficio = "0" . $ultimaInsercao . "/" . date("Y"); //ate 9999
        } else if ($ultimaInsercao >= 10000) {
            $numOficio = $ultimaInsercao . "/" . date("Y"); //10000 pra frente a ordenação do campo "numeração" não irá funcionar
        }


        $sql = "INSERT INTO documento_oficio (assunto, corpo, idUsuario, estadoEdicao, tratamento, destino, cargo_destino, data, tipoSigla, referencia, remetente, cargo_remetente,  numOficio) VALUES ";
        $sql .= "(:assunto, :corpo, :idUsuario, :estadoEdicao, :tratamento, :destino, :cargo_destino, :data, :tipoSigla, :referencia, :remetente, :cargo_remetente, :numOficio)";

        $params = array(
            ':assunto' => [$obj->get_assunto(), \PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), \PDO::PARAM_STR]
            , ':idUsuario' => [$obj->get_idUsuario(), \PDO::PARAM_INT]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), \PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), \PDO::PARAM_STR]
            , ':destino' => [$obj->get_destino(), \PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), \PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), \PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), \PDO::PARAM_STR]
            , ':referencia' => [$obj->get_referencia(), \PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), \PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), \PDO::PARAM_STR]
//            , ':numOficio' => [$obj->get_numOficio(), \PDO::PARAM_INT]
            , ':numOficio' => [$numOficio, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function teste() {
        parent::getConexao()->lastInsertId();
    }

    public function update_oficio(Oficio $obj) {

        $sql = 'UPDATE documento_oficio SET assunto = :assunto, corpo = :corpo, estadoEdicao = :estadoEdicao, tratamento = :tratamento, destino = :destino, cargo_destino = :cargo_destino,';
        $sql .= 'data = :data, tipoSigla = :tipoSigla, referencia = :referencia, remetente = :remetente, cargo_remetente = :cargo_remetente ';
        $sql .= ' WHERE idOficio = :idOficio';

        $params = array(
            ':assunto' => [$obj->get_assunto(), \PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), \PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), \PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), \PDO::PARAM_STR]
            , ':destino' => [$obj->get_destino(), \PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), \PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), \PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), \PDO::PARAM_STR]
            , ':referencia' => [$obj->get_referencia(), \PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), \PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), \PDO::PARAM_STR]
//            , ':numOficio' => [$obj->get_numOficio(), \PDO::PARAM_INT]
            , ':idOficio' => [$obj->get_idOficio(), \PDO::PARAM_INT]
        );

        return $this->executarQuery($sql, $params);
    }

    public function invalidarOficio($idOficio) {
        $sql = "UPDATE documento_oficio SET estadoValidacao = 0, estadoEdicao = 0 WHERE idOficio = :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function deleteOficio($idOficio) {
        $sql = "DELETE FROM documento_oficio WHERE idOficio= :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function validarOficio($idOficio) { //mesmo que "gerar"
        $sql = "UPDATE documento_oficio SET estadoValidacao = 1, estadoEdicao = 0 WHERE idOficio= :idOficio";
        $params = array(
            ':idOficio' => [$idOficio, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function validarMemorando($idMemorando) { //mesmo que "gerar"
        $sql = "UPDATE documento_memorando SET estadoValidacao = 1, estadoEdicao = 0 WHERE idMemorando = :idMemorando";
        $params = array(
            ':idMemorando' => [$idMemorando, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function deleteMemorando($idMemorando) {

        $sql = "DELETE FROM documento_memorando WHERE idMemorando= :idMemorando";
        $params = array(
            ':idMemorando' => [$idMemorando, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function inserirMemorando(Memorando $obj) {
        $documentoDAO = new documentoDAO();
        $ultimaInsercao = $documentoDAO->consultaUltimoRegistroValidacao("documento_memorando", "numMemorando", "idMemorando"); //Busca o ultimo registro de oficio
        //Caso o oficio a ser inserido não seja o primeiro
        if ($ultimaInsercao != null || $ultimaInsercao != "") {
            $ultimaInsercao = explode("/", $ultimaInsercao); //Extrai o numero do ultimo oficio. O modelo é NUMERO/ANO_ATUAL
            $ultimaInsercao = $ultimaInsercao[0]; //A posição zero resultante deste explode é o numero do ultimo ofício
            //Caso o oficio a ser inserido seja o primeiro
        } else {
            $ultimaInsercao = 0;
        }
        $ultimaInsercao++; //incrementa o número do oficio
//        $numMemorando = $ultimaInsercao . "/" . date("Y");

        if ($ultimaInsercao < 10) {
            $numMemorando = "0000" . $ultimaInsercao . "/" . date("Y"); //até 9
        } else if ($ultimaInsercao < 100) {
            $numMemorando = "000" . $ultimaInsercao . "/" . date("Y"); //ate 99
        } else if ($ultimaInsercao < 1000) {
            $numMemorando = "00" . $ultimaInsercao . "/" . date("Y"); //ate 999
        } else if ($ultimaInsercao < 10000) {
            $numMemorando = "0" . $ultimaInsercao . "/" . date("Y"); //ate 9999
        } else if ($ultimaInsercao >= 10000) {
            $numMemorando = $ultimaInsercao . "/" . date("Y"); //10000 pra frente a ordenação do campo "numeração" não irá funcionar
        }

        $sql = "INSERT INTO documento_memorando (assunto, corpo, idUsuario, estadoEdicao, tratamento, cargo_destino, data, tipoSigla, remetente, cargo_remetente,  numMemorando) VALUES ";
        $sql .= "(:assunto, :corpo, :idUsuario, :estadoEdicao, :tratamento, :cargo_destino, :data, :tipoSigla, :remetente, :cargo_remetente,  :numMemorando)";

        $params = array(
            ':assunto' => [$obj->get_assunto(), \PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), \PDO::PARAM_STR]
            , ':idUsuario' => [$obj->get_idUsuario(), \PDO::PARAM_INT]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), \PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), \PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), \PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), \PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), \PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), \PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), \PDO::PARAM_STR]
            , ':numMemorando' => [$numMemorando, \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function update_memorando(Memorando $obj) {

        $sql = 'UPDATE documento_memorando SET assunto = :assunto, corpo = :corpo, estadoEdicao = :estadoEdicao, '
                . 'tratamento = :tratamento, cargo_destino = :cargo_destino, data = :data, tipoSigla = :tipoSigla, '
                . 'remetente = :remetente, cargo_remetente = :cargo_remetente '
                . 'WHERE idMemorando = :idMemorando';

        $params = array(
            ':assunto' => [$obj->get_assunto(), \PDO::PARAM_STR]
            , ':corpo' => [$obj->get_corpo(), \PDO::PARAM_STR]
            , ':estadoEdicao' => [$obj->get_estadoEdicao(), \PDO::PARAM_INT]
            , ':tratamento' => [$obj->get_tratamento(), \PDO::PARAM_STR]
            , ':cargo_destino' => [$obj->get_cargo_destino(), \PDO::PARAM_STR]
            , ':data' => [$obj->get_data(), \PDO::PARAM_STR]
            , ':tipoSigla' => [$obj->get_tipoSigla(), \PDO::PARAM_STR]
            , ':remetente' => [$obj->get_remetente(), \PDO::PARAM_STR]
            , ':cargo_remetente' => [$obj->get_cargo_remetente(), \PDO::PARAM_STR]
//            , ':numMemorando' => [$obj->get_numMemorando(), \PDO::PARAM_INT]
            , ':idMemorando' => [$obj->get_idMemorando(), \PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function invalidarMemorando($idmemorando) {

        $sql = "UPDATE documento_memorando SET estadoValidacao = 0, estadoEdicao = 0 WHERE idMemorando=" . $idmemorando;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}

?>
