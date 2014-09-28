<?php

namespace app\modelo;

require_once APP_LIBRARY_ABSOLUTE_DIR . "configuracoes.php";
require_once APP_DIR . "modelo/enumeracao/Ferramenta.php";

class ComboBoxPermissoes {

    /**
     * 
     * @deprecated Método que implementava "Selects" na área de "Permissões por ferramenta"
     */
    public static function montarTodasPermissoes() {
        $code = "";
        $nomeFerramenta = "";
        $DAO = new ferramentaDAO();
        $codigoOpcoes = self::montarCaixaSelecaoPermissoes();
        $ferramentas = Ferramenta::obterValores();
        for ($i = 1; $i <= sizeof($ferramentas); $i++) {
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

    /**
     * 
     * @deprecated Método "montarTodasPermissoes()" depende deste para pleno funcionamento. Ambos implementavam "Selects" na área de "Permissoes por ferramenta"
     */
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

    public static function montarTodasPermissoesRadio() {
        $code = "";
        $nomeFerramenta = "";
//        $ferramentaDAO = new ferramentaDAO();

        $ferramentas = Ferramenta::obterValores();
        foreach ($ferramentas as $ferramenta) {
            $code .= "<span class=\"line\">\n";
//            $nomeFerramenta = $ferramentaDAO->obterNomeFerramenta($i);
            $nomeFerramenta = Ferramenta::obterNome($ferramenta);
            $nomeNormalizado = Ferramenta::obterNome($ferramenta, true);
//            $nomeNormalizado = trim(strtolower($nomeFerramenta));

            $codigoOpcoes = self::montarCaixaSelecaoPermissoesRadio($nomeNormalizado, $ferramenta);
            $code .= "<tr>";
            $code .= "<td> <label for='permissoes $nomeNormalizado'>" . $nomeFerramenta . "</label> </td> \n";
            //$code .= "<select required id='$nomeNormalizado' name='permissoes $nomeNormalizado'>";
            $code .= $codigoOpcoes;
            //$code .= "</select>\n";
            $code .= "</span>\n";
        }

        return $code;
    }

    private static function montarCaixaSelecaoPermissoesRadio($nome, $idFerramenta) {
        $codigo = "";
        $codigo .= "<td> <center> <input type=\"radio\" name=\"permissoes $nome\" value=\"1\" ferramenta-id=\"$idFerramenta\"  checked > </center> </td>";
        $codigo .= "<td> <center> <input type=\"radio\" name=\"permissoes $nome\" value=\"10\" ferramenta-id=\"$idFerramenta\" > </center> </td>";
        $codigo .= "<td> <center> <input type=\"radio\" name=\"permissoes $nome\" value=\"20\" ferramenta-id=\"$idFerramenta\" > </center> </td>";
        $codigo .= "<td> <center> <input type=\"radio\" name=\"permissoes $nome\" value=\"30\" ferramenta-id=\"$idFerramenta\" > </center> </td>";
        $codigo .= "<td> <center> <input type=\"radio\" name=\"permissoes $nome\" value=\"40\" ferramenta-id=\"$idFerramenta\" > </center> </td>";
        $codigo .= "</tr>";
        return $codigo;
    }

}

?>
