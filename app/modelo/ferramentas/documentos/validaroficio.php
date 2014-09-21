<?php

namespace app\modelo\ferramentas\documentos;

require_once APP_DIR . "modelo/Mensagem.php";

use \app\modelo as Modelo;

class validaroficio extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt($_REQUEST['i_idoficio']);

        if ((new Modelo\documentoDAO())->validarOficio($id)) {
            $this->adicionarMensagemSucesso("Ofício gerado com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao gerar ofício");
        }
    }

}

?>