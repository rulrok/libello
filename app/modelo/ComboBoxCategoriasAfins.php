<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxCategoriasAfins {

    public static function montarDescritorPrimeiroNivel($required = true, $class = "input-large cb_descritor", $id = "descritor1", $name = "descritor1") {
        if (!preg_match("/.*?cb_descritor.*?/", $class)) {
            $class .= " cb_descritor";
        }
        $code = Menu::montarCaixaSelecaoDescritorPrimeiroNivel($required, $class, $id, $name);

        return $code;
    }

    public static function montarDescritorFilhoSegundoNivel($idDescritorPai) {
        $code = Menu::montarCaixaSelecaoDescritorFilho(2, true, 'input-large cb_descritor', 'descritor2', 'descritor2', $idDescritorPai);
        return $code;
    }

    public static function montarDescritorFilhoTerceiroNivel($idDescritorPai) {
        $code = Menu::montarCaixaSelecaoDescritorFilho(3, true, 'input-large cb_descritor', 'descritor3', 'descritor3', $idDescritorPai);
        return $code;
    }

    public static function montarDescritorFilhoQuartoNivel($idDescritorPai) {
        $code = Menu::montarCaixaSelecaoDescritorFilho(4, true, 'input-large cb_descritor', 'descritor4', 'descritor4', $idDescritorPai);
        return $code;
    }

}

?>
