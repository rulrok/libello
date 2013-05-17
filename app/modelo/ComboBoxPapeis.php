<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";
require_once "Papel.php";

class ComboBoxPapeis {

    public static function montarComboBoxPadrao() {
        $code = Menu::montarCaixaSelecaoPapeis(true, 'input-large', 'papel');

        return $code;
    }

}

?>
