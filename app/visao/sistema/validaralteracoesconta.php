<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class validarAlteracoesConta extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SERVER['REQUEST_METHOD'] = null;
            $nome = $_POST['nome'];
            $sobreNome = $_POST['sobrenome'];
            $email = $_SESSION['email'];
            $novaSenha= $_POST['senha'] == "" ? "" : md5($_POST['senha']);
            $confSenha = $_POST['confSenha'] == "" ? "" : md5($_POST['confSenha']);
            $senha = md5($_POST['senhaAtual']);
            $dataNascimento = $_POST['dataNascimento'];

            $usuario = usuarioDAO::recuperarUsuario($_SESSION['email']);
//            $this->visao->papel = usuarioDao::consultarPapel($_SESSION['email']);

            if ($usuario->get_senha() == $senha) {

                if ($nome != "" && $sobreNome != "") {

                    $usuario->set_PNome($nome);
                    $_SESSION['nome'] = $nome;
                    $usuario->set_UNome($sobreNome);
                    $_SESSION['sobrenome'] = $sobreNome;
                    $usuario->set_email($email);
                    $_SESSION['email'] = $email;
                    $usuario->set_dataNascimento($dataNascimento);
                    $_SESSION['dataNascimento'] = $dataNascimento;

                    if ($novaSenha!= "") {
                        //Se quer atualizar a senha
                        if ($novaSenha== $confSenha) {
                            $usuario->set_senha($this->visao->novaSenha);
                        } else {
                            $this->mensagem->set_mensagem("Senhas não conferem.");
                            $this->mensagem->set_status(Mensagem::ERRO);
                        }
                    }
                    //Se não quer alterar a senha
                    if (UsuarioDAO::atualizar($_SESSION['email'], $usuario)) {
                        $_SESSION['senha'] = $usuario->get_senha();
                        $this->mensagem->set_mensagem("Alteração concluída com sucesso");
                        $this->mensagem->set_status(Mensagem::SUCESSO);
                        //TODO arrumar um modo de atualizar o nome do usuário na parte superior direita do site quando ele altera o nome.
//                        header('refresh: 2; url=http://localhost/controle-cead/index.php');
                    } else {
                        $this->mensagem->set_mensagem("Erro ao inserir no banco de dados.");
                        $this->mensagem->set_status(Mensagem::ERRO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Preencha todos os campos obrigatórios");
                    $this->mensagem->set_status(Mensagem::INFO);
                }
            } else {
                $this->mensagem->set_mensagem("Senha incorreta");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        }
    }

}

$validarAlteracoesConta = new validarAlteracoesConta();
$validarAlteracoesConta->verificar();
?>
