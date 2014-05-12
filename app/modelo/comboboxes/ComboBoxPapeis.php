<?php

require_once APP_LIBRARY_ABSOLUTE_DIR . "configuracoes.php";
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

    /**
     * Função para montar um combobox de papéis baseados em um nível de papel informado.
     * Todos os papéis inferiores ou iguais ao nível de papel informado serão considerados.
     * 
     * Papéis de nível superior não serão inclusos.
     */
    public static function montarPapeisRestritos($papel, $naoIncluirProprioPapel = false) {
        if ($naoIncluirProprioPapel) {
            $papel += 1;
        }
        $codigo = "";
        $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
        $DAO = new papelDAO();
        for ($i = $papel; $i <= Papel::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . $DAO->obterNomePapel($i) . "</option>";
        }
        return $codigo;
    }

}

?>