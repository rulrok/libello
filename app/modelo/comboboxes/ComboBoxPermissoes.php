<?php

require_once BIBLIOTECA_DIR . "configuracoes.php";
require_once APP_DIR . "modelo/enumeracao/Ferramenta.php";

class ComboBoxPermissoes {

    public static function montarTodasPermissoes() {
        $code = "";
        $nomeFerramenta = "";
        $DAO = new ferramentaDAO();
        $codigoOpcoes = self::montarCaixaSelecaoPermissoes();
        for ($i = 1; $i <= Ferramenta::__length; $i++) {
            $code .= "<span class=\"line\">\n";
//            $nomeferramenta
            $nomeFerramenta = $DAO->obterNomeFerramenta($i);
            $nomeNormalizado = trim(strtolower($nomeFerramenta));
            $code .= "<label for='$nomeNormalizado'>" . $nomeFerramenta . "</label>\n";
            $code .= "<select required id='$nomeNormalizado' name='permissoes $nomeNormalizado'>";
            $code .= $codigoOpcoes;
            $code .= "</select>\n";
            $code .= "</span>\n";
        }

        return $code;
    }

    private static function montarCaixaSelecaoPermissoes() {
        $codigo = "";
        $codigo .= "\n<option value=\"default\"> -- Selecione uma opção -- </option>";
        $codigo .= "\n<option value=\"1\">Sem acesso</option>";
        $codigo .= "\n<option value=\"10\">Consulta</option>";
        $codigo .= "\n<option value=\"20\">Escrita</option>";
        $codigo .= "\n<option value=\"30\">Gestor</option>";
        $codigo .= "\n<option value=\"40\">Administrador</option>";
        return $codigo;
    }

}

?>
