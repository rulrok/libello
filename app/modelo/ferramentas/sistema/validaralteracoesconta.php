<?php

namespace app\modelo\ferramentas\sistema;

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/criptografia.php';

use \app\modelo as Modelo;

class validarAlteracoesConta extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $nome = filter_input(INPUT_POST, 'nome');
        $sobreNome = filter_input(INPUT_POST, 'sobrenome');

        //!!! Garantir que o usuario nao burlou o JS da página e alterou o email do campo apenas leitura !!!
        $email = obterUsuarioSessao()->get_email();

        $novaSenha = filter_input(INPUT_POST, 'senha') == "" ? "" : encriptarSenha(filter_input(INPUT_POST, 'senha'));
        $confSenha = filter_input(INPUT_POST, 'confSenha') == "" ? "" : encriptarSenha(filter_input(INPUT_POST, 'confSenha'));
        $senha = encriptarSenha(filter_input(INPUT_POST, 'senhaAtual'));
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');

        $usuarioDAO = new Modelo\usuarioDAO();
        $usuario = $usuarioDAO->recuperarUsuario(obterUsuarioSessao()->get_email());
//        $this->visao->papel = $usuarioDAO->consultarPapel($_SESSION['email']);

        $ocorreu_erro = false;
        if ($usuario->get_senha() != $senha) {
            $this->adicionarMensagemErro('Senha incorreta');
            $ocorreu_erro = true;
        }

        if ($nome == "" || $sobreNome == "") {
            $this->adicionarMensagemErro('Nome e sobrenome são campos obrigatórios');
            $ocorreu_erro = true;
        }

        if ($novaSenha != "") {
            //Se quer atualizar a senha
            if ($novaSenha == $confSenha) {
                $usuario->set_senha($novaSenha);
            } else {
                $this->adicionarMensagemErro("Senhas não conferem");
                $ocorreu_erro = true;
            }
        } else {
            $usuario->set_senha($senha);
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }
        $antigasIniciais = $usuario->get_iniciais();

        $usuario->set_PNome($nome)->set_UNome($sobreNome);
        $usuario->set_email($email);
        $usuario->set_dataNascimento($dataNascimento);

        //Se não quer alterar a senha
        if ($usuarioDAO->atualizar(obterUsuarioSessao()->get_email(), $usuario)) {
            $usuarioAtualizado = $usuarioDAO->recuperarUsuario(obterUsuarioSessao()->get_email());
            atualizarUsuarioSessao($usuarioAtualizado);
            $novasIniciais = $usuarioAtualizado->get_iniciais();
            if (strcmp($antigasIniciais, $novasIniciais)) {
                //Iniciais mudaram, devemos atualizar o nome dos arquivos
                $imagensDAO = new imagensDAO();
                $imagensDAO->atualizarSiglas(obterUsuarioSessao()->get_idUsuario());
            }
            $this->adicionarMensagemSucesso("Perfil salvo");
        } else {
            $this->adicionarMensagemErro("Erro ao inserir no banco de dados.");
        }
    }

}

//$validarAlteracoesConta = new validarAlteracoesConta();
//$validarAlteracoesConta->executar();
