<?php

require_once 'abstractDAO.php';

class documentoDAO extends abstractDAO {
   
    public static function consultar($documento = "oficio",  $condicao = null, $colunas="*"){
        try {
            $sql = "SELECT ".$colunas . " FROM " . $documento;            
            if ($condicao != null) {
                $sql .=" WHERE ". $condicao;
            }
            $stmt = parent::getConexao()->query($sql);
            
            $documentos = array();     
            $tipo = ucfirst($documento);
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $documentos[$i] = $stmt->fetchObject($tipo);
            }
            if ($i == 0) {
                $documentos = null;                
            }
            return $documentos;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
        }
    }
    
    function inserirOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        $sql = "INSERT INTO oficio(assunto, corpo, idusuario, estadoEdicao, tratamento, destino, cargo_destino, data, tipoSigla, referencia, remetente, remetente2, cargo_remetente, cargo_remetente2, numOficio) VALUES 
        ('" . $assunto . "', '" . $corpo . "', " . $idusuario . ", " . $estadoEdicao . ", '" . $tratamento . "', '" . $destino . "', '" . $cargo_destino . "', '" . $data . "', '" . $tipoSigla . "', '" . $referencia . "', '" . $remetente . "', '" . $remetente2 . "', '" . $cargo_remetente . "', '" . $cargo_remetente2 . "', '" . $numOficio . "')";
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
    }

    function update_oficioSalvo($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        $sql = "UPDATE oficio SET assunto='" . $assunto . "', corpo='" . $corpo . "', tratamento='" . $tratamento . "', destino='" . $destino . "', cargo_destino='" . $cargo_destino . "', data='" . $data . "', estadoValidacao=1, estadoEdicao=" . $estadoEdicao . ",
        tipoSigla='" . $tipoSigla . "', referencia='" . $referencia . "', remetente='" . $remetente . "', remetente2='" . $remetente2 . "', cargo_remetente='" . $cargo_remetente . "', cargo_remetente2='" . $cargo_remetente2 . "', numOficio='" . $numOficio . "' WHERE idoficio=" . $idoficio;
        try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
    }

    function update_invalidarOficio($idoficio) {
        $sql = "UPDATE oficio SET estadoValidacao = 0 WHERE idoficio=" . $idoficio;
        try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
    }

    function deleteOficio($idoficio) {
        $sql = "DELETE FROM oficio WHERE idoficio=" . $idoficio;
        try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
    }
    
    function deleteMemorando($idmemorando){
    
    $sql = "DELETE FROM memorando WHERE idmemorando=".$idmemorando;
    //$conn->sql_query($query);  
    try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
}

function insertNovoMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao){
   
    $sql = "INSERT INTO memorando(
        idUsuario, 
        assunto,
        data,
        tipoSigla,
        numMemorando,
        estadoEdicao,
        tratamento,
        cargo_destino,
        corpo,
        remetente,
        remetente2,
        cargo_remetente,
        cargo_remetente2)
        VALUES ('".$idusuario."','"
            .$assunto. "','"
            .$data. "','"
            .$tipoSigla. "', '"
            .$numMemorando. "', '"
            .$estadoEdicao. "','"
            .$tratamento. "','"
            .$cargo_destino. "','"
            .$corpo. "','"
            .$remetente. "', '"
            .$remetente2. "','"
            .$cargo_remetente. "', '"
            .$cargo_remetente2. "')";
    try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return $e;
            }
}

function update_memorandoSalvo($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao){
    
    $sql = "UPDATE memorando SET numMemorando='".$numMemorando."', tipoSigla='".$tipoSigla."', data='".$data."', tratamento='".$tratamento."', cargo_destino='".$cargo_destino."', assunto='".$assunto."', corpo='".$corpo."', remetente='".$remetente."', remetente2='".$remetente2."',
        cargo_remetente='".$cargo_remetente."', cargo_remetente2='".$cargo_remetente2."', estadoEdicao='".$estadoEdicao."' WHERE idmemorando=".$idmemorando;
   try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }  
}

function update_invalidarMemorando($idmemorando){
    
    $sql = "UPDATE memorando SET estadoValidacao = 0 WHERE idmemorando=".$idmemorando;
    try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }   
}
    
}

?>
