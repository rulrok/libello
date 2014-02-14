<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Usuario.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";
include_once ROOT . 'app/modelo/ComboBoxPermissoes.php';
include_once ROOT . 'app/modelo/ComboBoxPapeis.php';

class verificarEdicaoUsuario extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $nome = $_POST['nome'];
            $sobreNome = $_POST['sobrenome'];
            $email = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
//            $this->visao->papel = Papel::get_nome_papel($_POST['papel']);
            $idPapel = (int) $_POST['papel'];


            $usuario = new Usuario();
            $usuario->set_PNome($nome);
            $usuario->set_UNome($sobreNome);
            $usuario->set_dataNascimento($dataNascimento);
            $usuario->set_email($email);
            $usuario->set_papel($idPapel);
            $usuario->set_senha(usuarioDAO::recuperarUsuario($email)->get_senha());

            if ($usuario->validarCampos()) {

                usuarioDAO::atualizar($email, $usuario);

                try {
                    $permissoes = new PermissoesFerramenta();
                    $teste = print_r($_POST, true);
                    $permissoes->set_controleCursos($_POST['permissoes_controle_de_cursos_e_polos']);
                    $permissoes->set_controleDocumentos($_POST['permissoes_controle_de_documentos']);
                    $permissoes->set_controleEquipamentos($_POST['permissoes_controle_de_equipamentos']);
                    $permissoes->set_controleLivros($_POST['permissoes_controle_de_livros']);
                    $permissoes->set_controleUsuarios($_POST['permissoes_controle_de_usuarios']);
                    $permissoes->set_controleViagens($_POST['permissoes_controle_de_viagens']);
                    $permissoes->set_tarefas($_POST['permissoes_tarefas']);
                    $permissoes->set_controlePagamentos($_POST['permissoes_controle_de_pagamentos']);
                    $permissoes->set_galeriaImagens($_POST['permissoes_galeria_de_imagens']);
                } catch (Exception $e) {
                    die($e);
                }
                usuarioDAO::atualizarPermissoes($usuario, $permissoes);
                $usuario = usuarioDAO::recuperarUsuario($usuario->get_email());
                sistemaDAO::registrarAlteracaoUsuario(obterUsuarioSessao()->get_id(), $usuario->get_id());

//                $this->visao->permissoes = usuarioDAO::obterPermissoes(usuarioDAO::recuperarUsuario($email)->get_id());
                $this->mensagem->set_mensagem("Atualização concluída");
                $this->mensagem->set_status(Mensagem::SUCESSO);
            } else {
                $this->mensagem->set_mensagem("Dados inconsistentes");
                $this->mensagem->set_status(Mensagem::ERRO);
            }

        endif;
    }

}

$verificarEdicaoUsuario = new verificarEdicaoUsuario();
$verificarEdicaoUsuario->verificar();
?>
