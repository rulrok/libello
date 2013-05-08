<?php

require_once 'abstractDAO.php';

class papelDAO extends abstractDAO {

    public static function obterNomePapel($papelID) {
        $papelID = (int) $papelID;
        $sql = "SELECT nome FROM papel WHERE idpapel = " . $papelID;
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

    public static function obterIdPapel($nomePapel) {
        
        $sql = "SELECT idPapel FROM papel WHERE nome = '" . $nomePapel."'";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

}

?>