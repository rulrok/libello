<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once ROOT . 'app/modelo/ComboBoxPermissoes.php';
include_once ROOT . 'app/modelo/ComboBoxPapeis.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";

class ControladorUsuarios extends Controlador {

    public function acaoNovo() {
        $this->visao->comboPermissoes = ComboBoxPermissoes::montarComboBoxPadrao();
        $this->visao->comboPapeis = ComboBoxPapeis::montarComboBoxPadrao();
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->renderizar();
    }

    public function acaoEditar() {
        if (isset($_GET['userID'])) {
            $userID = fnDecrypt($_GET['userID']);
            if ($userID != obterUsuarioSessao()->get_id()) { //!!! Impede que o usuário edite o próprio perfil, alterando assim sua permissões e papel. Uma violação de segurança.
                $this->visao->comboPermissoes = ComboBoxPermissoes::montarComboBoxPadrao();
                $email = usuarioDAO::descobrirEmail($userID);
                $usuario = usuarioDAO::recuperarUsuario($email);
                $this->visao->nome = $usuario->get_PNome();
                $this->visao->sobrenome = $usuario->get_UNome();
                $this->visao->email = $usuario->get_email();
                $this->visao->dataNascimento = $usuario->get_dataNascimento();
                $this->visao->papel = usuarioDAO::consultarPapel($email);
                $this->visao->idPapel = (int) papelDAO::obterIdPapel($this->visao->papel);
                $this->visao->comboPapel = ComboBoxPapeis::montarComboBoxPadrao();
                $this->visao->permissoes = usuarioDAO::obterPermissoes($userID);
            } else {
                die("Acesso indevido");
            }
        } else {
            die("Acesso indevido");
        }

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
        $this->visao->usuarios = usuarioDAO::consultar("idUsuario,concat(PNome,' ',UNome),email,dataNascimento,nome", "idUsuario <> " . obterUsuarioSessao()->get_id());
        $i = 0;
        foreach ($this->visao->usuarios as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->usuarios[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->usuarios = usuarioDAO::consultar("idUsuario, concat(PNome,' ',UNome),email,dataNascimento,nome");
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
