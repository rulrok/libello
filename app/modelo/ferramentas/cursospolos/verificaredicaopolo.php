<?php

class VerificarEdicaoPolo extends verificadorFormularioAjax {

    public function _validar() {

        $cidade = filter_input(INPUT_POST, 'cidade');
        $estado = filter_input(INPUT_POST, 'estado');
        $nomepolo = filter_input(INPUT_POST, 'nomepolo');
        $poloID = fnDecrypt(filter_input(INPUT_POST, 'poloID'));

        $poloNovo = new Polo();
        $poloNovo->set_nome($nomepolo);
        $poloNovo->set_estado($estado);
        $poloNovo->set_cidade($cidade);

        $poloDAO = new poloDAO();
        $polo = $poloDAO->recuperarPolo($poloID);

        if ($polo->get_nome() == "") {
            $this->mensagemErro("Nome inválido");
        }

        if ($poloDAO->atualizar($poloID, $poloNovo)) {
            $this->mensagemSucesso("Atualização concluída");
        } else {
            $this->mensagemErro("Atualização mal sucedida");
        }
    }

}

$verificarEdicaoPolo = new VerificarEdicaoPolo();
$verificarEdicaoPolo->verificar();
?>
