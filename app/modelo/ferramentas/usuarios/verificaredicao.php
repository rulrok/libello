<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Usuario.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";
include_once ROOT . 'app/modelo/ComboBoxPermissoes.php';
include_once ROOT . 'app/modelo/ComboBoxPapeis.php';
include_once ROOT . 'app/modelo/validadorCPF.php';

class verificarEdicaoUsuario extends verificadorFormularioAjax {

    public function _validar() {
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');
        $email = filter_input(INPUT_POST, 'email');
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $idPapel = (int) filter_input(INPUT_POST, 'papel');
        $cpf = filter_input(INPUT_POST, 'cpf');
        $cpf = validadorCPF::normalizarCPF($cpf);

        $usuarioDAO = new usuarioDAO();

        $usuarioOriginal = $usuarioDAO->recuperarUsuario($email);

        $usuario = new Usuario();
        $usuario->set_PNome($nome);
        $usuario->set_UNome($sobreNome);
        $usuario->set_dataNascimento($dataNascimento);
        $usuario->set_email($email);
        $usuario->set_idPapel($idPapel);
        $usuario->set_senha($usuarioOriginal->get_senha());
        $usuario->set_cpf($cpf);

        if ($dataNascimento == '') {
            $dataNascimento = null;
        }
        $usuario->set_dataNascimento($dataNascimento);

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

        $usuarioDAO->atualizar($email, $usuario);

        try {
            $permissoes = new PermissoesFerramenta();
            $permissoes->set_controleCursos(filter_input(INPUT_POST, 'permissoes_controle_de_cursos_e_polos'));
            $permissoes->set_controleDocumentos(filter_input(INPUT_POST, 'permissoes_controle_de_documentos'));
            $permissoes->set_controleEquipamentos(filter_input(INPUT_POST, 'permissoes_controle_de_equipamentos'));
            $permissoes->set_controleLivros(filter_input(INPUT_POST, 'permissoes_controle_de_livros'));
            $permissoes->set_controleUsuarios(filter_input(INPUT_POST, 'permissoes_controle_de_usuarios'));
            $permissoes->set_controleViagens(filter_input(INPUT_POST, 'permissoes_controle_de_viagens'));
            $permissoes->set_tarefas(filter_input(INPUT_POST, 'permissoes_tarefas'));
            $permissoes->set_controlePagamentos(filter_input(INPUT_POST, 'permissoes_controle_de_pagamentos'));
            $permissoes->set_galeriaImagens(filter_input(INPUT_POST, 'permissoes_galeria_de_imagens'));
        } catch (Exception $e) {
            die($e);
        }
        if (!$usuarioDAO->atualizarPermissoes($usuario, $permissoes)) {
            $usuarioDAO->atualizar($email, $usuarioOriginal);
            $this->mensagemErro("Falha ao atualizar");
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
