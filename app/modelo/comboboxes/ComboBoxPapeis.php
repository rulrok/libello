<?php

require_once BIBLIOTECA_DIR . "configuracoes.php";
require_once APP_DIR . "modelo/enumeracao/Papel.php";

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