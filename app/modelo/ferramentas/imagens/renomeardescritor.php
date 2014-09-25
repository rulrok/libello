<?php

namespace app\modelo\ferramentas\imagens;

use app\modelo as Modelo;

class renomeardescritor extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt(filter_input(INPUT_POST, 'id'));
        $novoNome = filter_input(INPUT_POST, 'novoNome');
        $novoNomeNormalizado = normalizarNomeDescritor($novoNome);

        if (!empty($id) && is_numeric($id) && !empty($novoNomeNormalizado)) {
            $imagensDAO = new Modelo\imagensDAO();
            if ($imagensDAO->renomearDescritor($id, $novoNomeNormalizado)) {
                $this->adicionarMensagemSucesso("Renomeado com sucesso");
                $this->adicionarMensagemPersonalizada("msg_renomeardescritor", true);
            } else {
                $this->adicionarMensagemPersonalizada("msg_renomeardescritor", false);
                $this->adicionarMensagemErro("Falha ao renomear.");
            }
        } else {
            $this->adicionarMensagemPersonalizada("msg_renomeardescritor", false);
            $this->adicionarMensagemErro("Falha ao receber informações.");
        }
    }

}
