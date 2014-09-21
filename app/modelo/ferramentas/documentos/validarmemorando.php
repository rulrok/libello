<?php

namespace app\modelo\ferramentas\documentos;

use \app\modelo as Modelo;

class validarmemorando extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt($_REQUEST['i_idmemorando']);

        if ((new Modelo\documentoDAO())->validarMemorando($id)) {
            $this->adicionarMensagemSucesso("Memorando gerado com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao gerar memorando");
        }
    }

}

?>
