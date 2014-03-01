<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";
require_once "enumeracao/Papel.php";

class ComboBoxPapeis {

    public static function montarTodosPapeis() {
        $codigo = "";
        $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
        $DAO = new papelDAO();
        for ($i = 1; $i <= Papel::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . $DAO->obterNomePapel($i) . "</option>";
        }
        return $codigo;
    }

}

?>