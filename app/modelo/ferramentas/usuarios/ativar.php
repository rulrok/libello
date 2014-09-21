<?php

namespace app\modelo\ferramentas\usuarios;

require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/PaginaDeAcao.php";

class ativar extends \app\modelo\PaginaDeAcao {

    public function _acaoPadrao() {
        $id = fnDecrypt(filter_input(INPUT_GET, 'userID'));
        $usuarioDAO = new \app\modelo\usuarioDAO();
        $email = $usuarioDAO->descobrirEmail($id);

        if ($usuarioDAO->ativar($email)) {
//            $usuarioDAO->registrarAtivacaoUsuario(obterUsuarioSessao()->get_idUsuario(), $id);
            $this->adicionarMensagemSucesso("Usuário ativado com sucesso.");
        } else {
            $this->adicionarMensagemErro("Erro ao concluir a operação");
        }
    }

}

?>