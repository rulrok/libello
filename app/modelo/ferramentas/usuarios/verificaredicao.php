<?php

include_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Usuario.php";
include_once APP_DIR . 'modelo/validadorCPF.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPapeis.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPermissoes.php';
include_once APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarEdicaoUsuario extends verificadorFormularioAjax {

    public function _validar() {
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');
        $email = filter_input(INPUT_POST, 'email');
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $idPapel = (int) filter_input(INPUT_POST, 'papel');
        $cpf = filter_input(INPUT_POST, 'cpf');
        $cpf = validadorCPF::normalizarCPF($cpf); //Retira os pontos e o traço do CPF

        $usuarioDAO = new usuarioDAO();

        $usuarioOriginal = $usuarioDAO->recuperarUsuario($email);

        if ($dataNascimento == '') {
            $dataNascimento = null;
        }

        if ($nome == '' || $sobreNome == '') {
            $this->mensagemErro("Nome e sobrenome são campos obrigatórios");
        }

        if ($idPapel == '' || !is_numeric($idPapel)) {
            $this->mensagemErro("Papel inválido");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->mensagemErro("Email inválido");
        }
        if (!validadorCPF::validarCPF($cpf)) {
            $this->mensagemErro("CPF inválido");
        }

        $usuario = new Usuario();
        $usuario->set_PNome($nome);
        $usuario->set_UNome($sobreNome);
        $usuario->set_dataNascimento($dataNascimento);
        $usuario->set_email($email);
        $usuario->set_idPapel($idPapel);
        $usuario->set_senha($usuarioOriginal->get_senha());
        $usuario->set_cpf($cpf);

        try {
            $usuarioDAO->iniciarTransacao();
            if (!$usuarioDAO->atualizar($email, $usuario)) {
                throw new Exception("Falha ao atualizar dados do usuário");
            }
            $permissoes = new PermissoesFerramenta();
            $permissoes->set_controleCursos(filter_input(INPUT_POST, 'permissoes_controle_de_cursos_e_polos'));
            $permissoes->set_controleDocumentos(filter_input(INPUT_POST, 'permissoes_controle_de_documentos'));
            $permissoes->set_controleEquipamentos(filter_input(INPUT_POST, 'permissoes_controle_de_equipamentos'));
            $permissoes->set_controleLivros(filter_input(INPUT_POST, 'permissoes_controle_de_livros'));
            $permissoes->set_controleUsuarios(filter_input(INPUT_POST, 'permissoes_controle_de_usuarios'));
            $permissoes->set_controleViagens(filter_input(INPUT_POST, 'permissoes_controle_de_viagens'));
            $permissoes->set_tarefas(filter_input(INPUT_POST, 'permissoes_tarefas'));
            $permissoes->set_galeriaImagens(filter_input(INPUT_POST, 'permissoes_galeria_de_imagens'));

            if (!$usuarioDAO->atualizarPermissoes($usuario, $permissoes)) {
                throw new Exception("Falha ao atualizar permissões");
            }
            $usuarioDAO->encerrarTransacao();
        } catch (Exception $e) {
            $usuarioDAO->rollback();
            $this->mensagemErro("Erro ao modificar. Nenhum alteração salva.");
        }
        $idUsuario = $usuarioDAO->recuperarUsuario($usuario->get_email())->get_idUsuario();
        (new sistemaDAO())->registrarAlteracaoUsuario(obterUsuarioSessao()->get_idUsuario(), $idUsuario);

//                $this->visao->permissoes = $usuarioDAO->obterPermissoes($usuarioDAO->recuperarUsuario($email)->get_id());
        $this->mensagemSucesso("Atualização concluída");
    }

}

$verificarEdicaoUsuario = new verificarEdicaoUsuario();
$verificarEdicaoUsuario->verificar();
?>
