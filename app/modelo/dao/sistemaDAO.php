<?php

require_once 'abstractDAO.php';

class sistemaDAO extends abstractDAO {

    public static function registrarAccesso($idUsuario) {
        $quote = "\"";
        $sql = "INSERT INTO usuarios_logs(data,hora,idUsuario) VALUES (<data>,<hora>,<idUsuario>)";
        $sql = str_replace("<data>", $quote.date('Y-m-j').$quote, $sql);
        $sql = str_replace("<hora>", $quote.date('h:i:s').$quote, $sql);
        $sql = str_replace("<idUsuario>", $idUsuario, $sql);
        echo $sql;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>
