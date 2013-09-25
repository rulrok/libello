<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxUsuarios {
    
    public static function montarPassageiros(){
        $code = Menu::montarSelecaoPassageiros(false, 'input-xlarge passageirosPossiveis selecaoPassageiros', 'passageirosPossiveis[]');

        return $code;
    }

}

?>
