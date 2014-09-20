<?php

include_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Usuario.php";
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPermissoes.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPapeis.php';
include_once APP_DIR . 'modelo/validadorCPF.php';
include_once APP_DIR . 'modelo/Utils.php';
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/criptografia.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . 'PHPMailer/Email.php';

class verificarNovoUsuario extends verificadorFormularioAjax {

    public function _validar() {
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');
        $enviarSenha = filter_input(INPUT_POST, 'enviarSenha');
        if ($enviarSenha === null) {
            $senha = encriptarSenha(filter_input(INPUT_POST, 'senha'));
            $confSenha = encriptarSenha(filter_input(INPUT_POST, 'confsenha'));
        } else {
            $senhaAleatoria = gerarSenhaUsuario();
            $senha = $confSenha = encriptarSenha($senhaAleatoria);
        }
        $papel = filter_input(INPUT_POST, 'papel');
        $email = filter_input(INPUT_POST, 'email');
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $cpf = filter_input(INPUT_POST, 'cpf');
        $cpf = validadorCPF::normalizarCPF($cpf);

        $erro_ocorrido = false;
        if ($papel < obterUsuarioSessao()->get_idPapel()) {
            registrar_erro("Tentativa de cadastrar um usuário com um papel maior que o seu próprio");
            $this->adicionarMensagemErro("Cadastro não autorizado");
            $this->abortarExecucao();
        }

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
            $this->adicionarMensagemErro("Senhas não conferem");
            $erro_ocorrido = true;
        }
        $usuarioDAO = new usuarioDAO();

        if ($nome == '' || $sobreNome == '') {
            $this->adicionarMensagemErro("Nome e sobrenome são campos obrigatórios");
            $erro_ocorrido = true;
        }
        if ($senha == '') {
            $this->adicionarMensagemErro("Informe a senha");
            $erro_ocorrido = true;
        }
        if ($papel == '' || !is_numeric($papel)) {
            $this->adicionarMensagemErro("Papel inválido");
            $erro_ocorrido = true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->adicionarMensagemErro("Email inválido");
            $erro_ocorrido = true;
        }
        if (!validadorCPF::validarCPF($cpf)) {
            $this->adicionarMensagemErro("CPF inválido");
            $erro_ocorrido = true;
        }
        $paramEmail = array(':email' => [$email, PDO::PARAM_STR]);
        if (count($usuarioDAO->consultar("email", "email = :email", $paramEmail)) > 0) {
            $this->adicionarMensagemErro("Email <i>$email</i> já está em uso!");
            $erro_ocorrido = true;
        }
        $paramCpf = array(':cpf' => [$cpf, PDO::PARAM_STR]);
        if (count($usuarioDAO->consultar("cpf", "cpf = :cpf", $paramCpf)) > 0) {
            $this->adicionarMensagemErro("Cpf <i>$cpf</i> já está em uso!");
            $erro_ocorrido = true;
        }
        if ($erro_ocorrido) {
            $this->abortarExecucao();
        }

        $MailSender = new Email();
        if ($enviarSenha !== null) {
            $MailSender->definirAssunto("Nova senha temporária");
            $nomeAplicativo = APP_NAME;
            $link = WEB_SERVER_ADDRESS . 'logar/?email=' . $email;
            $mensagem = "<p>Seu cadastro foi concluído em <a href='$link' target='_blank'>$nomeAplicativo</a> e essa é sua senha para acesso: $senhaAleatoria </p>"
                    . "<p>Ao acessar pela primeira vez, lembre-se de alterar sua senha.</p>"
                    . "<br/>";
            $MailSender->definirMensagem($mensagem);
            $MailSender->definirDestinatario($email, "$nome $sobreNome");
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
                    throw new Exception("Erro ao cadastrar permissões", 40);
                }
                $usuario = $usuarioDAO->recuperarUsuario($usuario->get_email());
                $usuarioDAO->registrarCadastroUsuario(obterUsuarioSessao()->get_idUsuario(), $usuario->get_idUsuario());
                if ($enviarSenha !== null) {
                    $MailSender->enviar();
                    if (!$MailSender->emailFoiEnviado()) {
                        throw new Exception("Falha ao enviar email. Cadastro não realizado.", 41);
                    }
                }
                $usuarioDAO->encerrarTransacao();
                //Essa linha deve estar por último, ou o COMMIT não irá acontecer pelo banco de dados
                $this->adicionarMensagemSucesso("Cadastro realizado com sucesso");
            } else {
                throw new Exception("Erro ao cadastrar no banco", 42);
            }
        } catch (Exception $e) {
            $usuarioDAO->rollback();
            switch ($e->getCode()) {
                case 40:
                case 41:
                case 42:
                    $this->adicionarMensagemErro($e->getMessage());
                    break;
                default:
                    $this->adicionarMensagemErro("Erro ao inserir. Nenhuma alteração foi feita");
                    break;
            }
            $this->abortarExecucao();
        }
    }

}

//$verificarNovoUsuario = new verificarNovoUsuario();
//$verificarNovoUsuario->executar();
?>
