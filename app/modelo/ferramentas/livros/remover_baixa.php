<?php

namespace app\modelo\ferramentas\livros;

use \app\modelo as Modelo;

class remover_baixa extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $baixaID = fnDecrypt(filter_input(INPUT_GET, 'baixaID'));
        $livroDAO = new Modelo\livroDAO();
        if ($livroDAO->removerBaixa($baixaID)) {
            $this->adicionarMensagemSucesso("Baixa removida com sucesso.");
//            $livroDAO->registrarRemocaoBaixa($baixaID);
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>