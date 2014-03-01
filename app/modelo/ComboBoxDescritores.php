<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxDescritores {

    public static function montarDescritorPrimeiroNivel() {

        $code = self::montarCaixaSelecaoDescritorPrimeiroNivel();

        return $code;
    }

    public static function montarDescritorFilho($idDescritorPai) {
        $code = self::montarCaixaSelecaoDescritorFilho($idDescritorPai);
        return $code;
    }

//    public static function montarDescritorFilhoSegundoNivel($idDescritorPai) {
//        $code = self::montarCaixaSelecaoDescritorFilho($idDescritorPai);
//        return $code;
//    }
//
//    public static function montarDescritorFilhoTerceiroNivel($idDescritorPai) {
//        $code = self::montarCaixaSelecaoDescritorFilho($idDescritorPai);
//        return $code;
//    }
//
//    public static function montarDescritorFilhoQuartoNivel($idDescritorPai) {
//        $code = self::montarCaixaSelecaoDescritorFilho($idDescritorPai);
//        return $code;
//    }

    private static function montarCaixaSelecaoDescritorFilho($idCategoriaPai = null) {
        if ($idCategoriaPai !== null) {
            $codigo = "";
            $imagensDAO = new imagensDAO();
            $subcategorias = $imagensDAO->consultarDescritoresFilhos("*", "pai = $idCategoriaPai");
            if (sizeof($subcategorias) == 0) {
//                $caminho = $imagensDAO->consultarCaminhoDescritores($idCategoriaPai);
                $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem descritores cadastrados --</option>\n";
//                $body = "Usuário: " . obterUsuarioSessao()->get_PNome() . " " . obterUsuarioSessao()->get_UNome() . " (" . obterUsuarioSessao()->get_email() . ")%0D%0A";
//                $body .= "Desejo cadastrar o descritor de nome <nome_do_descritor> em $caminho";
//                $codigo .="<a style=\"display: inline-block;\" target=\"_blank\" href=\"mailto:bei-bi@inep.gov.br?subject=Cadastro de descritor&body=$body\">Solicitar cadastro de novo descritor</a>";
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
        $categorias = $imagensDAO->consultarDescritoresPais();
        if (sizeof($categorias) == 0) {
            $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem descritores cadastrados --</option>\n";
//            $body = "Usuário: " . obterUsuarioSessao()->get_PNome() . " " . obterUsuarioSessao()->get_UNome() . " (" . obterUsuarioSessao()->get_email() . ")%0D%0A";
//            $body .= "Desejo cadastrar o descritor de nome <nome_do_descritor> como descritor de nível um.";
//            $codigo .="<a style=\"display: inline-block;\" target=\"_blank\" href=\"mailto:bei-bi@inep.gov.br?subject=Cadastro de descritor&body=$body\">Solicitar cadastro de novo descritor</a>";
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
