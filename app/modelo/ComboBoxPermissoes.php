<?php
require __DIR__."/../../biblioteca/Configurations.php";
require_once ROOT . "biblioteca/seguranca/Menu.php";
require_once ROOT . "biblioteca/seguranca/Ferramenta.php";

class ComboBoxPermissoes {

    public static function montarComboBoxPadrao() {
        $code = "";
        $nomeFerramenta = "";
        for ($i = 1; $i <= Ferramenta::__length; $i++) {
            $code .= "<span class=\"line\">\n";
            $nomeFerramenta = Ferramenta::get_nome_ferramenta($i);
            $code .= "<p>" . $nomeFerramenta . "</p>\n";
            $code .= Menu::montarCaixaSelecaoPermissoes(true, null, "permissoes" . trim(strtolower($nomeFerramenta)));
            $code .= "\n</span>\n";
        }
        
        return $code;
    }

}

?>
