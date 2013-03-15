<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorUsuario extends Controlador {

    public function acaoNovo($erro = false) {
        if ($erro == false) {
            $this->visao->nome = "";
            $this->visao->sobrenome = "";
            $this->visao->login = "";
            $this->visao->senha = "";
            $this->visao->confsenha = "";
            $this->visao->papel = "";
            $this->visao->email = "";
            $this->visao->dataNascimento = "";
        }
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->visao->mensagem_usuario = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $this->visao->nome = $_POST['nome'];
            $this->visao->sobrenome = $_POST['sobrenome'];
            $this->visao->login = $_POST['login'];
            $this->visao->senha = md5($_POST['senha']);
            $this->visao->confsenha = md5($_POST['confsenha']);
            $this->visao->papel = $_POST['papel'];
            $this->visao->email = isset($_POST['email']) ? $_POST['email'] : "";
            $this->visao->dataNascimento = isset($_POST['dataNascimento']) ? $_POST['dataNascimento'] : "";

            $usuario = new Usuario();
            $usuario->set_PNome($this->visao->nome);
            $usuario->set_UNome($this->visao->sobrenome);
            $usuario->set_login($this->visao->login);
            $usuario->set_senha($this->visao->senha);
            $usuario->set_papel($this->visao->papel);
            $usuario->set_email($this->visao->email);
            $usuario->set_dataNascimento($this->visao->dataNascimento);

            if ($usuario->validarCampos()) :
                if (count(usuarioDAO::consultar("login", "login = '" . $this->visao->login . "'")) > 0):
                    $this->visao->mensagem_usuario = "Login " . $this->visao->login . " já existe!";
                    $this->visao->login = "";
                    $this->acaoNovo(true);
                elseif (usuarioDAO::inserir($usuario)):
                    $this->visao->mensagem_usuario = "Cadastro realizado com sucesso";
                    $this->visao->nome = "";
                    $this->visao->sobrenome = "";
                    $this->visao->login = "";
                    $this->visao->senha = "";
                    $this->visao->confsenha = "";
                    $this->visao->papel = "";
                    $this->acaoNovo(false);
                else :
                    $this->visao->mensagem_usuario = "Algum erro ocorreu <br/>ao inserir no banco de dados!";
                    $this->acaoNovo(true);
                endif;
            else:
                $this->visao->mensagem_usuario = "Algum campo está inválido";
                $this->acaoNovo(true);

            endif;
        endif;


        return;
    }

    public function acaoGerenciar() {
        $this->renderizar();
    }

}

?>
