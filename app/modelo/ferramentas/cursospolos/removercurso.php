<?php

namespace app\modelo\ferramentas\cursospolos;

use \app\modelo as Modelo;

class removercurso extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $id = (int) fnDecrypt(filter_input(INPUT_GET, 'cursoID'));
        if ((new Modelo\cursoDAO())->remover($id)) {
//    (new sistemaDAO())->registrarExclusaoCurso(obterUsuarioSessao()->get_idUsuario());
            $this->adicionarMensagemSucesso("Excluído com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao excluir");
        }
    }

}

?>