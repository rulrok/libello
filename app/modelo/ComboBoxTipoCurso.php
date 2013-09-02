<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxTipoCurso {

    public static function montarTodosOsTipos() {
        $code = Menu::montarCaixaSelecaoTiposCurso(true, 'input-large', 'tipocurso');

        return $code;
    }

}

?>
