<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxDificuldades {

    public static function montarTodasAsComplexidades($required = true, $class = "input-large", $id = "complexidade", $name = "complexidade") {
        $code = Menu::montarCaixaSelecaoComplexidades($required, $class, $id, $name);

        return $code;
    }

}

?>
