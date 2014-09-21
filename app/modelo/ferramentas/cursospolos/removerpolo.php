<?php

namespace app\modelo\ferramentas\cursospolos;

use \app\modelo as Modelo;

class removerpolo extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt(filter_input(INPUT_GET, 'poloID'));

        if ((new Modelo\poloDAO())->remover($id)) {
//    (new sistemaDAO())->registrarExclusaoPolo(obterUsuarioSessao()->get_idUsuario());
            $this->adicionarMensagemSucesso("Excluído com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>