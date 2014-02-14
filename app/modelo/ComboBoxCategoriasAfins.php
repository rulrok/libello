<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxCategoriasAfins {

    public static function montarTodasAsCategorias($required = true, $class = "input-large", $id = "categoria", $name = "categoria") {
        $code = Menu::montarCaixaSelecaoCategorias($required, $class, $id, $name);

        return $code;
    }

    public static function montarTodasAsSubcategorias($idCategoriaPai) {
        $code = Menu::montarCaixaSelecaoSubcategorias(true, 'input-large', 'subcategoria', 'subcategoria', $idCategoriaPai);
        return $code;
    }

}

?>
