<?php

namespace app\modelo\ferramentas\documentos;

use \app\modelo as Modelo;

class invalidarmemorando extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt($_REQUEST['i_idmemorando']);
        if ((new Modelo\documentoDAO())->invalidarMemorando($id)) {
            $this->adicionarMensagemSucesso("Memorando invalidado com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>