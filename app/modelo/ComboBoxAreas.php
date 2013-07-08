<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxAreas {
    
    public static function montarTodasAsAreas(){
        $code = Menu::montarCaixaSelecaoAreas(true, 'input-large', 'area');

        return $code;
    }
}

?>
