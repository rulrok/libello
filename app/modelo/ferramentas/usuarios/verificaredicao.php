<?php

namespace app\modelo\ferramentas\usuarios;

include_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Usuario.php";
include_once APP_DIR . 'modelo/validadorCPF.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPapeis.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPermissoes.php';
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class verificaredicao extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $userID = fnDecrypt(filter_input(INPUT_POST, 'userID'));
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');
        $email = filter_input(INPUT_POST, 'email');
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $idPapel = (int) filter_input(INPUT_POST, 'papel');
        $cpf = filter_input(INPUT_POST, 'cpf');
        $cpf = Modelo\validadorCPF::normalizarCPF($cpf); //Retira os pontos e o traço do CPF

        $usuarioDAO = new Modelo\usuarioDAO();

        $emailOriginal = $usuarioDAO->descobrirEmail($userID);
        $usuarioOriginal = $usuarioDAO->recuperarUsuario($emailOriginal);

        $erro_ocorrido = false;
        if (strcmp($email, $emailOriginal)) {
            registrar_erro("Tentativa de modificar email do usuário para ($email), o que não é permitido", $usuarioOriginal);
            $this->adicionarMensagemErro("Tentativa de alterar o email percebida.");
            $this->abortarExecucao();
        }

        if ($dataNascimento == '') {
            $dataNascimento = null;
        }

        if ($nome == '' || $sobreNome == '') {
            $this->adicionarMensagemErro("Nome e sobrenome são campos obrigatórios");
            $erro_ocorrido = true;
        }

        if ($idPapel == '' || !is_numeric($idPapel)) {
            $this->adicionarMensagemErro("Papel inválido");
            $erro_ocorrido = true;
        }

        if ($idPapel < obterUsuarioSessao()->get_idPapel()) {
            registrar_erro("Tentativa de alterar papel de usuário para um maior que o seu próprio (para valor $idPapel)", $usuarioOriginal);
            $this->adicionarMensagemErro("Alteração não permitida");
            $erro_ocorrido = true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->adicionarMensagemErro("Email inválido");
            $erro_ocorrido = true;
        }
        if (!Modelo\validadorCPF::validarCPF($cpf)) {
            $this->adicionarMensagemErro("CPF inválido");
            $erro_ocorrido = true;
        }

        if ($erro_ocorrido) {
            $this->abortarExecucao();
        }
        $usuario = new Modelo\Usuario();
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
                throw new \Exception("Falha ao atualizar dados do usuário");
            }

            $permissoes = new Modelo\PermissoesFerramenta();
            foreach (Modelo\Ferramenta::obterValores() as $ferramenta) {
                $nome = Modelo\Ferramenta::obterNome($ferramenta, true, '_');
                $nomeCampoFormulario = "permissoes_$nome";
                $permissoes->$nome = filter_input(INPUT_POST, $nomeCampoFormulario);
            }

            if (!$usuarioDAO->atualizarPermissoes($usuario, $permissoes)) {
                throw new \Exception("Falha ao atualizar permissões");
            }
            $usuarioDAO->encerrarTransacao();
        } catch (\Exception $e) {
            $usuarioDAO->rollback();
            $this->adicionarMensagemErro("Erro ao modificar. Nenhum alteração salva.");
            $this->abortarExecucao();
        }
        $idUsuario = $usuarioDAO->recuperarUsuario($usuario->get_email())->get_idUsuario();
//        $usuarioDAO->registrarAlteracaoUsuario(obterUsuarioSessao()->get_idUsuario(), $idUsuario);
//                $this->visao->permissoes = $usuarioDAO->obterPermissoes($usuarioDAO->recuperarUsuario($email)->get_id());
        $this->adicionarMensagemSucesso("Atualização concluída");
    }

}

?>
