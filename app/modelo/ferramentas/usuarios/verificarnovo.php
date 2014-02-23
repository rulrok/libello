<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Usuario.php";
include_once APP_LOCATION . 'modelo/ComboBoxPermissoes.php';
include_once APP_LOCATION . 'modelo/ComboBoxPapeis.php';
include_once APP_LOCATION . 'modelo/validadorCPF.php';
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";
require_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';

class verificarNovoUsuario extends verificadorFormularioAjax {

    public function _validar() {
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');
        $senha = encriptarSenha(filter_input(INPUT_POST, 'senha'));
        $confSenha = encriptarSenha(filter_input(INPUT_POST, 'confsenha'));
        $papel = filter_input(INPUT_POST, 'papel');
        $email = filter_input(INPUT_POST, 'email');
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $cpf = filter_input(INPUT_POST, 'cpf');

        $usuario = new Usuario();
        $usuario->set_PNome($nome)->set_UNome($sobreNome);
        $usuario->set_senha($senha);
        $usuario->set_idPapel($papel);
        $usuario->set_email($email);
        $usuario->set_cpf($cpf);
        //Opcional
        if ($dataNascimento == '') {
            $dataNascimento = null;
        }
        $usuario->set_dataNascimento($dataNascimento);

        if ($senha != $confSenha) {
            $this->mensagemErro("Senhas não conferem");
        }
        $usuarioDAO = new usuarioDAO();

        if ($nome == '' || $sobreNome == '') {
            $this->mensagemErro("Nome e sobrenome são campos obrigatórios");
        }
        if ($senha == '') {
            $this->mensagemErro("Informe a senha");
        }
        if ($papel == '' || !is_numeric($papel)) {
            $this->mensagemErro("Papel inválido");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->mensagemErro("Email inválido");
        }
        if (!validadorCPF::validarCPF($cpf)) {
            $this->mensagemErro("CPF inválido");
        }
        $param = array(':email' => array($email, PDO::PARAM_STR));
        if (count($usuarioDAO->consultar("email", "email = :email", $param)) > 0) {
            $this->mensagemErro("Email <i>$email</i> já está em uso!");
        }
        if ($usuarioDAO->inserir($usuario)):
            $permissoes = new PermissoesFerramenta();
            $permissoes->set_controleCursos($_POST['permissoes_controle_de_cursos_e_polos']);
            $permissoes->set_controleDocumentos($_POST['permissoes_controle_de_documentos']);
            $permissoes->set_controleEquipamentos($_POST['permissoes_controle_de_equipamentos']);
            $permissoes->set_controleLivros($_POST['permissoes_controle_de_livros']);
            $permissoes->set_controleUsuarios($_POST['permissoes_controle_de_usuarios']);
            $permissoes->set_controleViagens($_POST['permissoes_controle_de_viagens']);

            $usuarioDAO->cadastrarPermissoes($usuario, $permissoes);
            $usuario = $usuarioDAO->recuperarUsuario($usuario->get_email());
            (new sistemaDAO())->registrarCadastroUsuario($_SESSION['idUsuario'], $usuario->get_idUsuario());
            $this->mensagemSucesso("Cadastro realizado com sucesso");
        else :
            $this->mensagemErro("Erro ao cadastrar no banco");
        endif;
    }

}

$verificarNovoUsuario = new verificarNovoUsuario();
$verificarNovoUsuario->verificar();
?>
