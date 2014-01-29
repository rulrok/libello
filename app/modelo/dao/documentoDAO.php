<?php

require_once 'abstractDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/modelo/vo/Oficio.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/modelo/vo/Memorando.php";

class documentoDAO extends abstractDAO {

    public static function consultar($documento = "oficio", $condicao = null) {
        try {
            $sql = "SELECT * FROM " . $documento;
            if ($condicao != null) {
                $sql .=" WHERE " . $condicao;
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
            die();
        }
    }

    public static function inserirOficio(Oficio $obj) {
        $sql = "INSERT INTO oficio (assunto, corpo, idUsuario, estadoEdicao, tratamento, destino, cargo_destino, data, tipoSigla, referencia, remetente, remetente2, cargo_remetente, cargo_remetente2, numOficio) VALUES ";
        $assunto = parent::quote($obj->getAssunto());
        $corpo = parent::quote($obj->getCorpo());
        $idusuario = $obj->getIdUsuario();
        $estadoEdicao = $obj->getEstadoEdicao();
        $tratamento = parent::quote($obj->getTratamento());
        $destino = parent::quote($obj->getDestino());
        $cargo_destino = parent::quote($obj->getCargo_destino());
        $data = parent::quote($obj->getData());
        $tipoSigla = parent::quote($obj->getTipoSigla());
        $referencia = parent::quote($obj->getReferencia());
        $remetente = parent::quote($obj->getRemetente());
        $remetente2 = parent::quote($obj->getRemetente2());
        $cargo_remetente = parent::quote($obj->getCargo_remetente());
        $cargo_remetente2 = parent::quote($obj->getCargo_remetente2());
        $numOficio = $obj->getNumOficio();
        

        $values = "($assunto, $corpo, $idusuario, $estadoEdicao, $tratamento, $destino, $cargo_destino, $data, $tipoSigla, $referencia, $remetente, $remetente2, $cargo_remetente, $cargo_remetente2, $numOficio)";
        //echo $values;
        try {
            $stmt = parent::getConexao()->prepare($sql . $values);
            $stmt->execute();
            $id = parent::getConexao()->lastInsertId();
            return $id;
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
            die();
        }
    }

    public static function update_oficio(Oficio $obj) {
        
        $sql = 'UPDATE oficio SET ';
        
        $assunto = parent::quote($obj->getAssunto());
        $sql .= "assunto = $assunto,";
        $corpo = parent::quote($obj->getCorpo());
        $sql .= "corpo = $corpo,";
        $estadoEdicao = $obj->getEstadoEdicao();
        $sql .= "estadoEdicao = $estadoEdicao, ";
        $tratamento = parent::quote($obj->getTratamento());
        $sql .= "tratamento = $tratamento, ";
        $destino = parent::quote($obj->getDestino());
        $sql .= "destino = $destino, ";
        $cargo_destino = parent::quote($obj->getCargo_destino());
        $sql.="cargo_destino = $cargo_destino, ";
        $data = parent::quote($obj->getData());
        $sql.="data = $data, ";
        $tipoSigla = parent::quote($obj->getTipoSigla());
        $sql .= "tipoSigla = $tipoSigla,";
        $referencia = parent::quote($obj->getReferencia());
        $sql .="referencia = $referencia,";
        $remetente = parent::quote($obj->getRemetente());
        $sql.="remetente = $remetente,";
        $remetente2 = parent::quote($obj->getRemetente2());
        $sql .= "remetente2 = $remetente2,";
        $cargo_remetente = parent::quote($obj->getCargo_remetente());
        $sql .= "cargo_remetente = $cargo_remetente,";
        $cargo_remetente2 = parent::quote($obj->getCargo_remetente2());
        $sql.= "cargo_remetente2 = $cargo_remetente2,";
        $numOficio = $obj->getNumOficio();
        $sql.="numOficio = $numOficio";
        
        $idOficio = $obj->getIdOficio();
        
        $where = " WHERE idOficio = $idOficio";
        
//        $sql = "UPDATE oficio SET assunto='" . $assunto . "', corpo='" . $corpo . "', tratamento='" . $tratamento . "', destino='" . $destino . "', cargo_destino='" . $cargo_destino . "', data='" . $data . "', estadoValidacao=1, estadoEdicao=" . $estadoEdicao . ",
//        tipoSigla='" . $tipoSigla . "', referencia='" . $referencia . "', remetente='" . $remetente . "', remetente2='" . $remetente2 . "', cargo_remetente='" . $cargo_remetente . "', cargo_remetente2='" . $cargo_remetente2 . "', numOficio='" . $numOficio . "' WHERE idOficio=" . $idoficio;
        try {
            $stmt = parent::getConexao()->prepare($sql . $where);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function invalidarOficio($idoficio) {
        $sql = "UPDATE oficio SET estadoValidacao = 0 WHERE idOficio = " . $idoficio;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
//            print_r($e);
            return false;
        }
    }

    public static function deleteOficio($idoficio) {
        $sql = "DELETE FROM oficio WHERE idOficio=" . $idoficio;
        try {
            parent::getConexao()->query($sql);
            return true;
        }catch (Exception $e) {
//            print_r($e);
            return false;
        }
    }

    public static function deleteMemorando($idmemorando) {

        $sql = "DELETE FROM memorando WHERE idMemorando=" . $idmemorando;
        //$conn->sql_query($query);  
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
            die();
        }
    }

    public static function inserirMemorando(Memorando $obj) {
        
        $sql = "INSERT INTO memorando(assunto, corpo, idUsuario, estadoEdicao, tratamento, cargo_destino, data, tipoSigla, remetente, remetente2, cargo_remetente, cargo_remetente2, numMemorando) VALUES ";
        $assunto = parent::quote($obj->getAssunto());
        $corpo = parent::quote($obj->getCorpo());
        $idusuario = $obj->getIdUsuario();
        $estadoEdicao = $obj->getEstadoEdicao();
        $tratamento = parent::quote($obj->getTratamento());
        $cargo_destino = parent::quote($obj->getCargo_destino());
        $data = parent::quote($obj->getData());
        $tipoSigla = parent::quote($obj->getTipoSigla());
        $remetente = parent::quote($obj->getRemetente());
        $remetente2 = parent::quote($obj->getRemetente2());
        $cargo_remetente = parent::quote($obj->getCargo_remetente());
        $cargo_remetente2 = parent::quote($obj->getCargo_remetente2());
        $numMemorando = $obj->getNumMemorando();
        

        $values = "($assunto, $corpo, $idusuario, $estadoEdicao, $tratamento, $cargo_destino, $data, $tipoSigla, $remetente, $remetente2, $cargo_remetente, $cargo_remetente2, $numMemorando)";
        //echo $values;
        try {
            $stmt = parent::getConexao()->prepare($sql . $values);
            $stmt->execute();
            $id = parent::getConexao()->lastInsertId();
            return $id;
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
            die();
        }
        
        
    }

    public static function update_memorando(Memorando $obj) {
        
        $sql = 'UPDATE memorando SET ';
        
        $assunto = parent::quote($obj->getAssunto());
        $sql .= "assunto = $assunto,";
        $corpo = parent::quote($obj->getCorpo());
        $sql .= "corpo = $corpo,";
        $estadoEdicao = $obj->getEstadoEdicao();
        $sql .= "estadoEdicao = $estadoEdicao, ";
        $tratamento = parent::quote($obj->getTratamento());
        $sql .= "tratamento = $tratamento, ";
        
        $cargo_destino = parent::quote($obj->getCargo_destino());
        $sql.="cargo_destino = $cargo_destino, ";
        $data = parent::quote($obj->getData());
        $sql.="data = $data, ";
        $tipoSigla = parent::quote($obj->getTipoSigla());
        $sql .= "tipoSigla = $tipoSigla,";
       
        $remetente = parent::quote($obj->getRemetente());
        $sql.="remetente = $remetente,";
        $remetente2 = parent::quote($obj->getRemetente2());
        $sql .= "remetente2 = $remetente2,";
        $cargo_remetente = parent::quote($obj->getCargo_remetente());
        $sql .= "cargo_remetente = $cargo_remetente,";
        $cargo_remetente2 = parent::quote($obj->getCargo_remetente2());
        $sql.= "cargo_remetente2 = $cargo_remetente2,";
        $numMemorando = $obj->getNumMemorando();
        $sql.="numMemorando = $numMemorando";
        
        $idMemorando = $obj->getIdMemorando();
        
        $where = " WHERE idMemorando = $idMemorando";
        
//        $sql = "UPDATE oficio SET assunto='" . $assunto . "', corpo='" . $corpo . "', tratamento='" . $tratamento . "', destino='" . $destino . "', cargo_destino='" . $cargo_destino . "', data='" . $data . "', estadoValidacao=1, estadoEdicao=" . $estadoEdicao . ",
//        tipoSigla='" . $tipoSigla . "', referencia='" . $referencia . "', remetente='" . $remetente . "', remetente2='" . $remetente2 . "', cargo_remetente='" . $cargo_remetente . "', cargo_remetente2='" . $cargo_remetente2 . "', numOficio='" . $numOficio . "' WHERE idOficio=" . $idoficio;
        try {
            $stmt = parent::getConexao()->prepare($sql . $where);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        

    }

    public static function invalidarMemorando($idmemorando) {

        $sql = "UPDATE memorando SET estadoValidacao = 0 WHERE idMemorando=" . $idmemorando;
        try {
            parent::getConexao()->query($sql);
            return true;
        }catch (Exception $e) {
//            print_r($e);
            return false;
        }
    }

}

?>
