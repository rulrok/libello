<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxUsuarios {
    
    public static function montarPassageiros(){
        $code = Menu::montarSelecaoPassageiros(true, 'input-xxxlarge','passageiros', 'passageiros[]');

        return $code;
    }

}

?>
