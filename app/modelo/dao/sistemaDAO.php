<?php

require_once 'abstractDAO.php';

class sistemaDAO extends abstractDAO{
    
    public static function registrarAccesso($idUsuario){
        $sql = "INSERT INTO usuarios_logs(data,hora,idUsuario) VALUES (<data>,<hora>,<idUsuario>)";
        str_replace("<data>", date('j-m-y'), $sql);
        str_replace("<hora>", date('h-i-s'), $sql);
        print_r($sql);
    }
}

?>
