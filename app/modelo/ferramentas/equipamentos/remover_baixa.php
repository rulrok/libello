<?php

namespace app\modelo\ferramentas\equipamentos;

use \app\modelo as Modelo;

class remover_baixa extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $baixaID = fnDecrypt(filter_input(INPUT_GET, 'baixaID'));

        $equipamentoDAO = new Modelo\equipamentoDAO();
        if ($equipamentoDAO->removerBaixa($baixaID)) {
            $this->adicionarMensagemSucesso("Baixa removida com sucesso.");
//            $equipamentoDAO->registrarRemocaoBaixa($baixaID);
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>