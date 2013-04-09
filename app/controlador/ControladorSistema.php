<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once __DIR__ . '/../../biblioteca/seguranca/seguranca.php';
include_once __DIR__ . '/../modelo/dao/usuarioDAO.php';

class ControladorSistema extends Controlador {

    public function acaoInicial() {
        $this->renderizar();
    }

    public function acaoSair() {
        expulsaVisitante();
    }

    public function acaoNaoautenticado() {
        $this->renderizar();
    }

    public function acaoGerenciarconta($erro = false) {
        if ($erro == false) {
//            $this->visao->mensagem_usuario = null;
            $this->visao->nome = $_SESSION['nome'];
            $this->visao->sobrenome = $_SESSION['sobrenome'];
            $this->visao->email = $_SESSION['email'];
            $this->visao->login = $_SESSION['login'];
            $this->visao->dataNascimento = $_SESSION['dataNascimento'];

            $usuario = new Usuario();
            $usuario->set_login($_SESSION['login']);

            $usuarioDao = new usuarioDAO();

            $this->visao->papel = $usuarioDao->consultarPapel($usuario);
        } else {
            if ($this->visao->mensagem_usuario == NULL || $this->visao->mensagem_usuario == "") {
                $this->visao->mensagem_usuario = "Informações inválidas.";
            }
        }

        $this->renderizar();
    }

    public function acaoValidarAlteracoesConta() {
        $this->visao->mensagem_usuario = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SERVER['REQUEST_METHOD'] = null;
            $this->visao->nome = $_POST['nome'];
            $this->visao->sobrenome = $_POST['sobrenome'];
            $this->visao->email = $_POST['email'];
            $this->visao->login = $_SESSION['login'];
            $this->visao->novaSenha = $_POST['senha'] == "" ? "" : md5($_POST['senha']);
            $this->visao->confSenha = $_POST['confSenha'] == "" ? "" : md5($_POST['confSenha']);
            $this->visao->senha = md5($_POST['senhaAtual']);
            $this->visao->dataNascimento = $_POST['dataNascimento'];

            $usuario = usuarioDAO::recuperarUsuario($_SESSION['login']);
            $this->visao->papel = usuarioDao::consultarPapel($usuario);

            if ($usuario->get_senha() == $this->visao->senha) {

                if ($this->visao->nome != "" && $this->visao->sobrenome != "") {

                    $usuario->set_PNome($this->visao->nome);
                    $_SESSION['nome'] = $this->visao->nome;
                    $usuario->set_UNome($this->visao->sobrenome);
                    $_SESSION['sobrenome'] = $this->visao->sobrenome;
                    $usuario->set_email($this->visao->email);
                    $_SESSION['email'] = $this->visao->email;
                    $usuario->set_dataNascimento($this->visao->dataNascimento);
                    $_SESSION['dataNascimento'] = $this->visao->dataNascimento;

                    if ($this->visao->novaSenha != "") {
                        //Se quer atualizar a senha
                        if ($this->visao->novaSenha == $this->visao->confSenha) {
                            $usuario->set_senha($this->visao->novaSenha);
                        } else {
                            $this->visao->mensagem_usuario = "Senhas não conferem.";
                            $this->acaoGerenciarconta(true);
                        }
                    }
                    //Se não quer alterar a senha
                    if (UsuarioDAO::atualizar($_SESSION['login'], $usuario)) {
                        $this->visao->mensagem_usuario = "Alteração concluída com sucesso";
                        header('refresh: 2; url=http://localhost/controle-cead/index.php');
                        $this->acaoGerenciarconta(false);
                    } else {
                        $this->visao->mensagem_usuario = "Erro ao inserir no banco de dados.";
                        $this->acaoGerenciarconta(true);
                    }
                } else {
                    $this->visao->mensagem_usuario = "Preencha todos os campos obrigatórios";
                    $this->acaoGerenciarconta(true);
                }
            } else {
                $this->visao->mensagem_usuario = "Senha incorreta";
                $this->acaoGerenciarconta(true);
            }
        }
        return;
    }

}

?>
