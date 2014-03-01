<?php

include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovodescritor extends verificadorFormularioAjax {

    public function _validar() {
        if (filter_has_var(INPUT_POST, 'inserir_novo_descritor_1')) {
            //Vai cadastrar desde a raiz
        } elseif (filter_has_var(INPUT_POST, 'inserir_novo_descritor_2')) {
            //Vai cadastrar a partir do segundo nível
        } elseif (filter_has_var(INPUT_POST, 'inserir_novo_descritor_3')) {
            //Vai cadastrar a partir do terceiro nível
        } else {
            //Vai cadastrar no último nível
        }
    }

}

$verificarnovodescritor = new verificarnovodescritor();
$verificarnovodescritor->verificar();
