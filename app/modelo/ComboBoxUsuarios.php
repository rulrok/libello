<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxUsuarios {

    public static function montarPassageiros() {
        $code = Menu::montarSelecaoUsuarios(true, 'input-xxxlarge', 'passageiros', 'passageiros[]', true);

        return $code;
    }

    public static function montarResponsavelViagem() {
        $code = Menu::montarSelecaoUsuarios(true, 'input-xxxlarge', 'responsavel', 'responsavel',false);

        return $code;
    }

}

?>
