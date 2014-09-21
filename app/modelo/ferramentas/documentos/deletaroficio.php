<?php

namespace app\modelo\ferramentas\documentos;

use \app\modelo as Modelo;

class deletaroficio extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt($_REQUEST['i_idoficio']);
        if ((new Modelo\documentoDAO())->deleteOficio($id)) {
            $this->adicionarMensagemSucesso("Oficio removido com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>
