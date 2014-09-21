<?php

namespace app\modelo\ferramentas\equipamentos;

use \app\modelo as Modelo;

class remover_saida extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $saidaID = fnDecrypt(filter_input(INPUT_GET, 'saidaID'));

        $equipamentoDAO = new Modelo\equipamentoDAO();
        if ($equipamentoDAO->removerSaida($saidaID)) {
            $this->adicionarMensagemSucesso("Saída removida com sucesso.");
//            $equipamentoDAO->registrarRemocaoSaida($saidaID);
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>