<?php

namespace app\controlador;

include_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/dao/usuarioDAO.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPermissoes.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPapeis.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . "seguranca/criptografia.php";

use \app\modelo as Modelo;
use \app\mvc as MVC;

class ControladorUsuarios extends MVC\Controlador {

    public function acaoNovo() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->comboPermissoes = Modelo\ComboBoxPermissoes::montarTodasPermissoesRadio();
        $this->visao->comboPapeis = Modelo\ComboBoxPapeis::montarPapeisRestritos(obterUsuarioSessao()->get_idPapel());
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        if (!filter_has_var(INPUT_GET, 'userID')) {
            die("Acesso indevido");
        }
        $usuarioDAO = new Modelo\usuarioDAO();

        $userID = fnDecrypt(filter_input(INPUT_GET, 'userID'));
        if ($userID == obterUsuarioSessao()->get_idUsuario()) { //!!! Impede que o usuário edite o próprio perfil, alterando assim sua permissões e papel. Uma violação de segurança.
            registrar_erro("Usuário tentou alterar seu próprio perfil através da página de edição de usuários do sistema (isso geraria problemas de segurança como alterar as próprias permissões)");
            $this->adicionarMensagemAlerta("Você não possui permissão para executar essa ação.<br/>Essa ação será registrada!.", true);
            $this->abortarExecucao();
        }

        $emailOriginal = $usuarioDAO->descobrirEmail($userID);
        $usuarioOriginal = $usuarioDAO->recuperarUsuario($emailOriginal);
        //Importante: Verifica se o usuário não colou o id criptografado de algum outro usuário com papel superior ao dele
        //Esse id poderia ser obtido na tela de consultar usuários, por exemplo.
        if (obterUsuarioSessao()->get_idPapel() > $usuarioOriginal->get_idPapel()) {
            registrar_erro("Usuário tentou alterar um perfil de papel mais alto que o seu. (OBS: Papeis mais altos possuem valor numérico menor)", $usuarioOriginal);
            $this->adicionarMensagemAlerta("Você não possui permissão para executar essa ação.<br/>Essa ação será registrada!.", true);
            $this->abortarExecucao();
        }

        $this->visao->comboPermissoes = Modelo\ComboBoxPermissoes::montarTodasPermissoesRadio();
        $email = $usuarioDAO->descobrirEmail($userID);
        $usuario = $usuarioDAO->recuperarUsuario($email);
        $this->visao->userID = filter_input(INPUT_GET, 'userID');
        $this->visao->nome = $usuario->get_PNome();
        $this->visao->sobrenome = $usuario->get_UNome();
        $this->visao->email = $usuario->get_email();
        $this->visao->dataNascimento = $usuario->get_dataNascimento();
        $this->visao->papel = $usuarioDAO->consultarPapel($email);
        $this->visao->idPapel = (int) (new Modelo\papelDAO())->obterIdPapel($this->visao->papel);
        $this->visao->comboPapel = Modelo\ComboBoxPapeis::montarPapeisRestritos(obterUsuarioSessao()->get_idPapel());
        $this->visao->permissoes = $usuarioDAO->obterPermissoes($userID);
        $this->visao->cpf = $usuario->get_cpf();

        $this->renderizar();
    }

    public function acaoVerificarEdicao() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoConsultarpermissoes() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoDesativar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $usuarioDAO = new Modelo\usuarioDAO();
        $userID = fnDecrypt(filter_input(INPUT_GET, 'userID'));
        if ($userID == obterUsuarioSessao()->get_idUsuario()) {
            registrar_erro("Usuário tentou desativar seu próprio perfil através da página de edição de usuários do sistema");
            $this->adicionarMensagemAlerta("Você não possui permissão para executar essa ação.<br/>Essa ação será registrada!.", true);
            $this->abortarExecucao();
        }

        $emailOriginal = $usuarioDAO->descobrirEmail($userID);
        $usuarioOriginal = $usuarioDAO->recuperarUsuario($emailOriginal);
        //Importante: Verifica se o usuário não colou o id criptografado de algum outro usuário com papel superior ao dele
        //Esse id poderia ser obtido na tela de consultar usuários, por exemplo.
        if (obterUsuarioSessao()->get_idPapel() > $usuarioOriginal->get_idPapel()) {
            registrar_erro("Usuário tentou desativar um perfil de papel mais alto que o seu. (OBS: Papeis mais altos possuem valor numérico menor)", $usuarioOriginal);
            $this->adicionarMensagemAlerta("Você não possui permissão para executar essa ação.<br/>Essa ação será registrada!", true);
            $this->abortarExecucao();
        }
        $this->renderizar();
    }

    public function acaoAtivar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $usuarioDAO = new Modelo\usuarioDAO();
        $userID = fnDecrypt(filter_input(INPUT_GET, 'userID'));

        $emailOriginal = $usuarioDAO->descobrirEmail($userID);
        $usuarioOriginal = $usuarioDAO->recuperarUsuario($emailOriginal, true);
        //Importante: Verifica se o usuário não colou o id criptografado de algum outro usuário com papel superior ao dele
        //Esse id poderia ser obtido na tela de consultar usuários, por exemplo.
        if (obterUsuarioSessao()->get_idPapel() > $usuarioOriginal->get_idPapel()) {
            registrar_erro("Usuário tentou desativar um perfil de papel mais alto que o seu. (OBS: Papeis mais altos possuem valor numérico menor)", $usuarioOriginal);
            $this->adicionarMensagemAlerta("Você não possui permissão para executar essa ação.<br/>Essa ação será registrada!", true);
            $this->abortarExecucao();
        }
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $usuarioDAO = new Modelo\usuarioDAO();
        $idUsuario = (int) obterUsuarioSessao()->get_idUsuario();
        $idPapelUsuario = (int) obterUsuarioSessao()->get_idPapel();
        $params = array(
            ':idUsuario' => [$idUsuario, \PDO::PARAM_INT]
            , ':idPapel' => [$idPapelUsuario, \PDO::PARAM_INT]
        );
        $this->visao->usuarios = $usuarioDAO->consultar("idUsuario,concat_ws(' ',PNome,UNome),email,dataNascimento,cpf,nome", "idUsuario <> :idUsuario AND idPapel >= :idPapel", $params);
        $i = 0;
        foreach ($this->visao->usuarios as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->usuarios[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->usuarios = (new Modelo\usuarioDAO())->consultar("idUsuario, concat_ws(' ',PNome,UNome),email,dataNascimento,nome");
        $i = 0;
        foreach ($this->visao->usuarios as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->usuarios[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRestaurar() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $usuarioDAO = new Modelo\usuarioDAO();
        $this->visao->usuarios = $usuarioDAO->consultar("idUsuario,concat_ws(' ',PNome,UNome),email,dataNascimento,cpf,nome", " ativo = 0 ", null, true);
        $i = 0;
        foreach ($this->visao->usuarios as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->usuarios[$i++] = $value;
        }
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::CONTROLE_USUARIOS;
    }

}

?>
