<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";
require_once "enumeracao/Ferramenta.php";

class ComboBoxPermissoes {

    public static function montarComboBoxPadrao() {
        $code = "";
        $nomeFerramenta = "";
        $DAO = new ferramentaDAO();
        for ($i = 1; $i <= Ferramenta::__length; $i++) {
            $code .= "<span class=\"line\">\n";
            $nomeFerramenta = $DAO->obterNomeFerramenta($i);
            $code .= "<label>" . $nomeFerramenta . "</label>\n";
            $code .= Menu::montarCaixaSelecaoPermissoes(true, null, "permissoes " . trim(strtolower($nomeFerramenta)));
            $code .= "\n</span>\n";
        }

        return $code;
    }

}

?>
