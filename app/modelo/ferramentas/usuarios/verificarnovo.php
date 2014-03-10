<?php

include_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Usuario.php";
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPermissoes.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPapeis.php';
include_once APP_DIR . 'modelo/validadorCPF.php';
include_once APP_DIR . "visao/verificadorFormularioAjax.php";
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
        try {
            $usuarioDAO->iniciarTransacao();
            if ($usuarioDAO->inserir($usuario)) {
                $id = $usuarioDAO->obterUltimoIdInserido();
                $usuario->set_idUsuario($id);
                $permissoes = new PermissoesFerramenta();
                $permissoes->set_controleCursos(filter_input(INPUT_POST, 'permissoes_controle_de_cursos_e_polos'));
                $permissoes->set_controleDocumentos(filter_input(INPUT_POST, 'permissoes_controle_de_documentos'));
                $permissoes->set_controleEquipamentos(filter_input(INPUT_POST, 'permissoes_controle_de_equipamentos'));
                $permissoes->set_controleLivros(filter_input(INPUT_POST, 'permissoes_controle_de_livros'));
                $permissoes->set_controleUsuarios(filter_input(INPUT_POST, 'permissoes_controle_de_usuarios'));
                $permissoes->set_controleViagens(filter_input(INPUT_POST, 'permissoes_controle_de_viagens'));
                $permissoes->set_tarefas(filter_input(INPUT_POST, 'permissoes_controle_de_viagens'));
                $permissoes->set_galeriaImagens(filter_input(INPUT_POST, 'permissoes_galeria_de_imagens'));

                if (!$usuarioDAO->cadastrarPermissoes($usuario, $permissoes)) {
                    throw new Exception("Erro ao cadastrar permissões");
                }
                $usuario = $usuarioDAO->recuperarUsuario($usuario->get_email());
//                (new sistemaDAO())->registrarCadastroUsuario(obterUsuarioSessao()->get_idUsuario(), $usuario->get_idUsuario());
                $usuarioDAO->encerrarTransacao();
                $this->mensagemSucesso("Cadastro realizado com sucesso");
            } else {
                $usuarioDAO->rollback();
                $this->mensagemErro("Erro ao cadastrar no banco");
            }
        } catch (Exception $e) {
            $usuarioDAO->rollback();
            $this->mensagemErro("Erro ao inserir. Nenhuma alteração foi feita");
        }
    }

}

$verificarNovoUsuario = new verificarNovoUsuario();
$verificarNovoUsuario->verificar();
?>
