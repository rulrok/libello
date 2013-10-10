<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxPolo {
    
    public static function montarTodosOsPolos(){
        $code = Menu::montarCaixaSelecaoPolos(true, 'input-large', 'polo','polo');

        return $code;
    }

}

?>
