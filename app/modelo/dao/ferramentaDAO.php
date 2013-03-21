<?php

require_once 'abstractDAO.php';

class ferramentaDAO extends abstractDAO {

    public static function obterNomeFerramenta($ferramentaID) {
        $ferramentaID = (int) $ferramentaID;
        $sql = "SELECT nomeFerramenta FROM ferramenta WHERE idFerramenta = " . $ferramentaID;
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
        echo $e;    
        }
        return $resultado[0];
    }

}

?>
