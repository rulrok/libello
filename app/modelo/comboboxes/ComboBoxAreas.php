<?php

require_once APP_LIBRARY_DIR . "configuracoes.php";
require_once APP_DIR . 'modelo/enumeracao/Area.php';

class ComboBoxAreas {

    public static function montarTodasAsAreas() {
        $codigo = "";
        $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
        $areaDAO = new areaDAO();
        for ($i = 1; $i <= Area::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . $areaDAO->obterNomeArea($i) . "</option>";
        }
        return $codigo;
    }

}

?>