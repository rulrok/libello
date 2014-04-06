<?php

require_once APP_LIBRARY_DIR . "configuracoes.php";

class ComboBoxPolo {

    public static function montarTodosOsPolos() {
        $codigo = "";
        $polos = (new poloDAO())->consultar();
        if (sizeof($polos) == 0) {
            $codigo .= '<option value="default" selected="selected"> -- Não existem polos cadastrados --</option>';
        } else {
            $codigo .= '<option value="default" selected="selected"> -- Selecione um descritor --</option>';
            $codigo .= '<optgroup label="Polos">';
            for ($i = 0; $i < sizeof($polos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($polos[$i]['idPolo']) . "\">" . $polos[$i]['nomePolo'] . "</option>";
            }
        }
        $codigo .= "</optgroup>";
        return $codigo;
    }

}

?>
