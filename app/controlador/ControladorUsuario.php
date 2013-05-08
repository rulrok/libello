<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once ROOT . 'app/modelo/ComboBoxPermissoes.php';
include_once ROOT . 'app/modelo/ComboBoxPapeis.php';

class ControladorUsuario extends Controlador {

    public function acaoNovo($erro = false) {
        if ($erro == false) {
            $this->visao->nome = "";
            $this->visao->sobrenome = "";
//            $this->visao->login = "";
            $this->visao->senha = "";
            $this->visao->confsenha = "";
            $this->visao->papel = "";
            $this->visao->email = "";
            $this->visao->dataNascimento = "";
        }
        $this->visao->comboPermissoes = ComboBoxPermissoes::montarComboBoxPadrao();
        $this->visao->comboPapeis = ComboBoxPapeis::montarComboBoxPadrao();
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->visao->mensagem_usuario = null;
        $this->visao->tipo_mensagem = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $this->visao->nome = $_POST['nome'];
            $this->visao->sobrenome = $_POST['sobrenome'];
//            $this->visao->login = $_POST['login'];
            $this->visao->senha = md5($_POST['senha']);
            $this->visao->confsenha = md5($_POST['confsenha']);
            $this->visao->papel = $_POST['papel'];
            $this->visao->email = isset($_POST['email']) ? $_POST['email'] : "";
            $this->visao->dataNascimento = isset($_POST['dataNascimento']) ? $_POST['dataNascimento'] : "";

            $usuario = new Usuario();
            $usuario->set_PNome($this->visao->nome);
            $usuario->set_UNome($this->visao->sobrenome);
//            $usuario->set_login($this->visao->login);
            $usuario->set_senha($this->visao->senha);
            $usuario->set_papel($this->visao->papel);
            $usuario->set_email($this->visao->email);
            $usuario->set_dataNascimento($this->visao->dataNascimento);

            if ($usuario->validarCampos()) :
                if (count(usuarioDAO::consultar("email", "email = '" . $this->visao->email . "'")) > 0):
                    $this->visao->mensagem_usuario = "Email " . $this->visao->email . " está indisponível!";
                    $this->visao->tipo_mensagem = 'erro';
//                    $this->visao->login = "";
                    $this->acaoNovo(true);
                elseif (usuarioDAO::inserir($usuario)):
                    $permissoes = new PermissoesFerramenta();
                    $permissoes->set_controleCursos($_POST['permissoes_controle_de_cursos_e_polos']);
                    $permissoes->set_controleDocumentos($_POST['permissoes_controle_de_documentos']);
                    $permissoes->set_controleEquipamentos($_POST['permissoes_controle_de_equipamentos']);
                    $permissoes->set_controleLivros($_POST['permissoes_controle_de_livros']);
                    $permissoes->set_controleUsuarios($_POST['permissoes_controle_de_usuarios']);
                    $permissoes->set_controleViagens($_POST['permissoes_controle_de_viagens']);
                    usuarioDAO::cadastrarPermissoes($usuario, $permissoes);
                    $this->visao->mensagem_usuario = "Cadastro realizado com sucesso";
                    $this->visao->tipo_mensagem = 'sucesso';
                    $this->visao->nome = "";
                    $this->visao->sobrenome = "";
//                    $this->visao->login = "";
                    $this->visao->senha = "";
                    $this->visao->confsenha = "";
                    $this->visao->papel = "";
                    $this->acaoNovo(false);
                else :
                    $this->visao->mensagem_usuario = "Algum erro ocorreu <br/>ao inserir no banco de dados!";
                    $this->visao->tipo_mensagem = 'erro';
                    $this->acaoNovo(true);
                endif;
            else:
                $this->visao->mensagem_usuario = "Algum campo está inválido";
                $this->visao->tipo_mensagem = 'erro';
                $this->acaoNovo(true);

            endif;
        endif;


        return;
    }

    public function acaoEditar() {
        if (isset($_GET['userID'])) {
            $this->visao->comboPermissoes = ComboBoxPermissoes::montarComboBoxPadrao();
            $userID = $_GET['userID'];
            $email = usuarioDAO::descobrirEmail($userID);
            $usuario = usuarioDAO::recuperarUsuario($email);
            $this->visao->nome = $usuario->get_PNome();
            $this->visao->sobrenome = $usuario->get_UNome();
            $this->visao->email = $usuario->get_email();
            $this->visao->dataNascimento = $usuario->get_dataNascimento();
            $this->visao->papel = usuarioDAO::consultarPapel($email);
            $this->visao->idPapel = (int) papelDAO::obterIdPapel($this->visao->papel);
            $this->visao->comboPapel = ComboBoxPapeis::montarComboBoxPadrao();  
            $this->visao->permissoes = usuarioDAO::obterPermissoes($_GET['userID']);

            $this->renderizar();
        }
    }

    public function acaoVerificarEdicao() {
        
    }

    public function acaoConsultarpermissoes() {
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->renderizar();
    }

}

?>
