<?php

require_once BIBLIOTECA_DIR . "configuracoes.php";

class ComboBoxDescritores {

    public static function montarDescritorPrimeiroNivel() {

        $code = self::montarCaixaSelecaoDescritorPrimeiroNivel();

        return $code;
    }

    public static function montarDescritorFilho($idDescritorPai) {
        $code = self::montarCaixaSelecaoDescritorFilho($idDescritorPai);
        return $code;
    }

    private static function montarCaixaSelecaoDescritorFilho($idCategoriaPai = null) {
        if ($idCategoriaPai !== null) {
            $codigo = "";
            $imagensDAO = new imagensDAO();
            $subcategorias = $imagensDAO->consultarDescritoresFilhos("*", "pai = $idCategoriaPai ");
            if (sizeof($subcategorias) == 0) {
//                $caminho = $imagensDAO->consultarCaminhoDescritores($idCategoriaPai);
                $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem descritores cadastrados --</option>\n";
            } else {
                $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione um descritor --</option>\n";
                for ($i = 0; $i < sizeof($subcategorias); $i++) {
                    $codigo .= "<option value=\"" . fnEncrypt($subcategorias[$i]['idDescritor']) . "\">" . $subcategorias[$i]['nome'] . "</option>\n";
                }
            }
            return $codigo;
        } else {
            return "<p>Descritor pai não informado.</p>";
        }
    }

    private static function montarCaixaSelecaoDescritorPrimeiroNivel() {
        $codigo = "";
        $imagensDAO = new imagensDAO();
        $categorias = $imagensDAO->consultarDescritoresNivel1();
        if (sizeof($categorias) == 0) {
            $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem descritores cadastrados --</option>\n";
        } else {
            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione um descritor --</option>\n";
            for ($i = 0; $i < sizeof($categorias); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($categorias[$i]['idDescritor']) . "\">" . $categorias[$i]['nome'] . "</option>\n";
            }
        }
        return $codigo;
    }

}

?>
