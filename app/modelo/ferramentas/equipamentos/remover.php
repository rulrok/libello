<?php

namespace app\modelo\ferramentas\equipamentos;

use \app\modelo as Modelo;

class remover extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = fnDecrypt(filter_input(INPUT_GET, 'equipamentoID'));
        $equipamentoDAO = new Modelo\equipamentoDAO();
        $novosDados = clone $equipamentoDAO->recuperarEquipamento($id);
        $novosDados->set_quantidade(0);
        $novosDados->set_numeroPatrimonio(null);
        if ($equipamentoDAO->atualizar($id, $novosDados)) {
            $this->adicionarMensagemSucesso("Equipamento removido com sucesso.");
            //TODO Sistema de registro de eventos precisa ser reelaborado
//            $equipamentoDAO->registrarExclusaoEquipamento($id);
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>