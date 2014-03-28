<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPermissoes.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPapeis.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";

class ControladorUsuarios extends Controlador {

    public function acaoNovo() {
        $this->visao->comboPermissoes = ComboBoxPermissoes::montarTodasPermissoes();
        $this->visao->comboPapeis = ComboBoxPapeis::montarPapeisRestritos(obterUsuarioSessao()->get_idPapel());
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->renderizar();
    }

    public function acaoEditar() {
        if (!filter_has_var(INPUT_GET, 'userID')) {
            die("Acesso indevido");
        }
        $usuarioDAO = new usuarioDAO();

        $userID = fnDecrypt(filter_input(INPUT_GET, 'userID'));
        if ($userID == obterUsuarioSessao()->get_idUsuario()) { //!!! Impede que o usuário edite o próprio perfil, alterando assim sua permissões e papel. Uma violação de segurança.
            registrar_erro("Usuário tentou alterar seu próprio perfil através da página de edição de usuários do sistema (isso geraria problemas de segurança como alterar as próprias permissões)");
            die("Acesso indevido");
        }

        $emailOriginal = $usuarioDAO->descobrirEmail($userID);
        $usuarioOriginal = $usuarioDAO->recuperarUsuario($emailOriginal);
        //Importante: Verifica se o usuário não colou o id criptografado de algum outro usuário com papel superior ao dele
        //Esse id poderia ser obtido na tela de consultar usuários, por exemplo.
        if (obterUsuarioSessao()->get_idPapel() > $usuarioOriginal->get_idPapel()) {
            registrar_erro("Usuário tentou alterar um perfil de papel mais alto que o seu. (OBS: Papeis mais altos possuem valor numérico menor)", $usuarioOriginal);
            die("Você não tem permissão para fazer essa edição");
        }

        $this->visao->comboPermissoes = ComboBoxPermissoes::montarTodasPermissoes();
        $email = $usuarioDAO->descobrirEmail($userID);
        $usuario = $usuarioDAO->recuperarUsuario($email);
        $this->visao->userID = filter_input(INPUT_GET, 'userID');
        $this->visao->nome = $usuario->get_PNome();
        $this->visao->sobrenome = $usuario->get_UNome();
        $this->visao->email = $usuario->get_email();
        $this->visao->dataNascimento = $usuario->get_dataNascimento();
        $this->visao->papel = $usuarioDAO->consultarPapel($email);
        $this->visao->idPapel = (int) (new papelDAO())->obterIdPapel($this->visao->papel);
        $this->visao->comboPapel = ComboBoxPapeis::montarPapeisRestritos(obterUsuarioSessao()->get_idPapel());
        $this->visao->permissoes = $usuarioDAO->obterPermissoes($userID);
        $this->visao->cpf = $usuario->get_cpf();

        $this->renderizar();
    }

    public function acaoVerificarEdicao() {
        $this->renderizar();
    }

    public function acaoConsultarpermissoes() {
        $this->renderizar();
    }

    public function acaoDesativar() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $usuarioDAO = new usuarioDAO();
        $idUsuario = (int) obterUsuarioSessao()->get_idUsuario();
        $idPapelUsuario = (int) obterUsuarioSessao()->get_idPapel();
        $params = array(
            ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
            , ':idPapel' => [$idPapelUsuario, PDO::PARAM_INT]
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
        $this->visao->usuarios = (new usuarioDAO())->consultar("idUsuario, concat_ws(' ',PNome,UNome),email,dataNascimento,nome");
        $i = 0;
        foreach ($this->visao->usuarios as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->usuarios[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRestaurar() {
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_USUARIOS;
    }

}

?>
