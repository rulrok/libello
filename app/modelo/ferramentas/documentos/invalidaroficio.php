<?php

namespace app\modelo\ferramentas\documentos;

use \app\modelo as Modelo;

class invalidaroficio extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt($_REQUEST['i_idoficio']);
        if ((new Modelo\documentoDAO())->invalidarOficio($id)) {
            $this->adicionarMensagemSucesso("Oficio invalidado com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }
}

?>