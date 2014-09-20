<?php

require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/PaginaDeAcao.php";

class ativarUsuario extends PaginaDeAcao {

    public function _acaoPadrao() {
        $id = fnDecrypt(filter_input(INPUT_GET, 'userID'));
        $usuarioDAO = new usuarioDAO();
        $email = $usuarioDAO->descobrirEmail($id);

        if ($usuarioDAO->ativar($email)) {
//            $usuarioDAO->registrarAtivacaoUsuario(obterUsuarioSessao()->get_idUsuario(), $id);
            $this->adicionarMensagemSucesso("Usuário ativado com sucesso.");
            $this->adicionarMensagemInfo(print_r(__NAMESPACE__,true));
        } else {
            $this->adicionarMensagemErro("Erro ao concluir a operação");
        }
    }

}

?>