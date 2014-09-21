<?php

namespace app\modelo\ferramentas\livros;

use \app\modelo as Modelo;

class remover_saida extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $saidaID = fnDecrypt(filter_input(INPUT_GET, 'saidaID'));
        $livroDAO = new Modelo\livroDAO();
        if ($livroDAO->removerSaida($saidaID)) {
            $this->adicionarMensagemSucesso("Saída removida com sucesso.");
//            $livroDAO->registrarRemocaoSaida($saidaID);
        } else {
            $$this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>