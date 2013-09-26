<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxCurso {

    public static function montarTodosOsTipos() {
        $code = Menu::montarCaixaSelecaoTiposCurso(true, 'input-large', 'tipocurso', 'tipocurso');

        return $code;
    }

    public static function montarTodosOsCursos() {
        $code = Menu::montarCaixaSelecaoCursos(true, 'input-large', 'curso', 'curso');

        return $code;
    }

}

?>
