<?php

namespace app\modelo\ferramentas\cursospolos;

use \app\modelo as Modelo;

class verificaredicaopolo extends Modelo\verificadorFormularioAjax {

    public function _validar() {

        $cidade = filter_input(INPUT_POST, 'cidade');
        $estado = filter_input(INPUT_POST, 'estado');
        $nomepolo = filter_input(INPUT_POST, 'nomepolo');
        $poloID = fnDecrypt(filter_input(INPUT_POST, 'poloID'));

        $poloNovo = new Modelo\Polo();
        $poloNovo->set_nome($nomepolo);
        $poloNovo->set_estado($estado);
        $poloNovo->set_cidade($cidade);

        $poloDAO = new Modelo\poloDAO();
        $polo = $poloDAO->recuperarPolo($poloID);

        if ($polo->get_nome() == "") {
            $this->adicionarMensagemErro("Nome inválido");
        }

        if ($poloDAO->atualizar($poloID, $poloNovo)) {
            $this->adicionarMensagemSucesso("Atualização concluída");
        } else {
            $this->adicionarMensagemErro("Atualização mal sucedida");
        }
    }

}

//$verificarEdicaoPolo = new VerificarEdicaoPolo();
//$verificarEdicaoPolo->executar();
?>
