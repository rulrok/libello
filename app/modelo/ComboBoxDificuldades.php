<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxDificuldades {

    public static function montarTodasAsDificuldades($required = true, $class = "input-large", $id = "dificuldade", $name = "dificuldade") {
        $code = Menu::montarCaixaSelecaoDificuldades($required, $class, $id, $name);

        return $code;
    }

}

?>
