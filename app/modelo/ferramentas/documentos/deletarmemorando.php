<?php

namespace app\modelo\ferramentas\documentos;

use \app\modelo as Modelo;

class deletarmemorando extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt($_REQUEST['i_idmemorando']);
        if ((new Modelo\documentoDAO())->deleteMemorando($id)) {
            $this->adicionarMensagemSucesso("Memorando removido com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>
