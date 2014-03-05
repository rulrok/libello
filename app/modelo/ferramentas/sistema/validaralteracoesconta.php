<?php

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "visao/verificadorFormularioAjax.php";
require_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';

class validarAlteracoesConta extends verificadorFormularioAjax {

    public function _validar() {
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');

        //!!! Garantir que o usuario nao burlou o JS da página e alterou o email do campo apenas leitura !!!
        $email = obterUsuarioSessao()->get_email();

        $novaSenha = filter_input(INPUT_POST, 'senha') == "" ? "" : encriptarSenha(filter_input(INPUT_POST, 'senha'));
        $confSenha = filter_input(INPUT_POST, 'confSenha') == "" ? "" : encriptarSenha(filter_input(INPUT_POST, 'confSenha'));
        $senha = encriptarSenha(filter_input(INPUT_POST, 'senhaAtual'));
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');

        $usuarioDAO = new usuarioDAO();
        $usuario = $usuarioDAO->recuperarUsuario(obterUsuarioSessao()->get_email());
//        $this->visao->papel = $usuarioDAO->consultarPapel($_SESSION['email']);

        if ($usuario->get_senha() != $senha) {
            $this->mensagemErro('Senha incorreta');
        }

        if ($nome == "" || $sobreNome == "") {
            $this->mensagemErro('Nome e sobrenome são campos obrigatórios');
        }

        if ($novaSenha != "") {
            //Se quer atualizar a senha
            if ($novaSenha == $confSenha) {
                $usuario->set_senha($novaSenha);
            } else {
                $this->mensagemErro("Senhas não conferem");
            }
        } else {
            $usuario->set_senha($senha);
        }
        $usuario->set_PNome($nome)->set_UNome($sobreNome);
        $usuario->set_email($email);
        $usuario->set_dataNascimento($dataNascimento);

        //Se não quer alterar a senha
        if ($usuarioDAO->atualizar(obterUsuarioSessao()->get_email(), $usuario)) {
            atualizarUsuarioSessao($usuario);
            $this->mensagemSucesso("Alteração concluída com sucesso");
            //TODO arrumar um modo de atualizar o nome do usuário na parte superior direita do site quando ele altera o nome.
//            header('refresh: 2; url=http://localhost/controle-cead/index.php');
        } else {
            $this->mensagemErro("Erro ao inserir no banco de dados.");
        }
    }

}

$validarAlteracoesConta = new validarAlteracoesConta();
$validarAlteracoesConta->verificar();
?>
