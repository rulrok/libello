<?php

include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovodescritor extends verificadorFormularioAjax {

    public function _validar() {
        if (filter_has_var(INPUT_POST, 'inserir_novo_descritor_1')) {
            //Vai cadastrar desde a raiz
            $descritor1 = filter_input(INPUT_POST, 'novo_descritor_1');
            $descritor2 = filter_input(INPUT_POST, 'novo_descritor_2');
            $descritor3 = filter_input(INPUT_POST, 'novo_descritor_3');
            $descritor4 = filter_input(INPUT_POST, 'novo_descritor_4');

            if ($descritor1 == "" || $descritor2 == "" || $descritor3 == "" || $descritor4 == "") {
                $this->mensagemErro("Todos os descritores são obrigatórios.");
            }
            $imagensDAO = new imagensDAO();
            try {
                $imagensDAO->iniciarTransacao();
//                $imagensDAO->
                $imagensDAO->encerrarTransacao();
            } catch (Exception $e) {
                $imagensDAO->rollback();
            }
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
