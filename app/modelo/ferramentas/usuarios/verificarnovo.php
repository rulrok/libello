<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Usuario.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";
include_once ROOT . 'app/modelo/ComboBoxPermissoes.php';
include_once ROOT . 'app/modelo/ComboBoxPapeis.php';

class verificarNovoUsuario extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $nome = $_POST['nome'];
            $sobreNome = $_POST['sobrenome'];
            $senha = md5($_POST['senha']);
            $confSenha = md5($_POST['confsenha']);
            $papel = $_POST['papel'];
            $email = isset($_POST['email']) ? $_POST['email'] : "";
            $dataNascimento = isset($_POST['dataNascimento']) ? $_POST['dataNascimento'] : "";

            $usuario = new Usuario();
            $usuario->set_PNome($nome);
            $usuario->set_UNome($sobreNome);
            $usuario->set_senha($senha);
            $usuario->set_papel($papel);
            $usuario->set_email($email);
            $usuario->set_dataNascimento($dataNascimento);

            if ($senha != $confSenha) :
                $this->mensagem->set_mensagem("Senhas não conferem");
                $this->mensagem->set_status(Mensagem::ERRO);
            else:
                if ($usuario->validarCampos()) :
                    if (count(usuarioDAO::consultar("email", "email = '" . $email . "'")) > 0):
                        $this->mensagem->set_mensagem("Email <i>" . $email . "</i> já está em uso!");
                        $this->mensagem->set_status(Mensagem::ERRO);
                    elseif (usuarioDAO::inserir($usuario)):
                        $permissoes = new PermissoesFerramenta();
                        $permissoes->set_controleCursos($_POST['permissoes_controle_de_cursos_e_polos']);
                        $permissoes->set_controleDocumentos($_POST['permissoes_controle_de_documentos']);
                        $permissoes->set_controleEquipamentos($_POST['permissoes_controle_de_equipamentos']);
                        $permissoes->set_controleLivros($_POST['permissoes_controle_de_livros']);
                        $permissoes->set_controleUsuarios($_POST['permissoes_controle_de_usuarios']);
                        $permissoes->set_controleViagens($_POST['permissoes_controle_de_viagens']);
                        usuarioDAO::cadastrarPermissoes($usuario, $permissoes);
                        $usuario = usuarioDAO::recuperarUsuario($usuario->get_email());
                        sistemaDAO::registrarCadastroUsuario($_SESSION['idUsuario'], $usuario->get_id());
                        $this->mensagem->set_mensagem("Cadastro realizado com sucesso");
                        $this->mensagem->set_status(Mensagem::SUCESSO);
                    else :
                        $this->mensagem->set_mensagem("Algum erro ocorreu ao inserir no banco de dados!");
                        $this->mensagem->set_status(Mensagem::ERRO);
                    endif;
                else:
                    $this->mensagem->set_mensagem("Algum campo está inválido");
                    $this->mensagem->set_status(Mensagem::ERRO);
                endif;
            endif;
        endif;
    }

}

$verificarNovoUsuario = new verificarNovoUsuario();
$verificarNovoUsuario->verificar();
?>
