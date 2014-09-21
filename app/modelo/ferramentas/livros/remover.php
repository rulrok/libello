<?php

namespace app\modelo\ferramentas\livros;

use \app\modelo as Modelo;

class remover extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt(filter_input(INPUT_GET, 'livroID'));
        $livroDAO = new Modelo\livroDAO();
        $novosDados = clone $livroDAO->recuperarlivro($id);
        $novosDados->set_quantidade(0);
        $novosDados->set_numeroPatrimonio(null);
        if ($livroDAO->atualizar($id, $novosDados)) {
            $this->adicionarMensagemSucesso("Livro removido com sucesso.");
            $livroDAO->registrarExclusaoLivro($id);
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>