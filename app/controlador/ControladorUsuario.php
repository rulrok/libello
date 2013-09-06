<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once ROOT . 'app/modelo/ComboBoxPermissoes.php';
include_once ROOT . 'app/modelo/ComboBoxPapeis.php';

class ControladorUsuario extends Controlador {

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
            if ($_GET['userID'] != $_SESSION['usuario']->get_id()) { //!!! Impede que o usuário edite o próprio perfil, alterando assim sua permissões e papel. Uma violação de segurança.
                $this->visao->comboPermissoes = ComboBoxPermissoes::montarComboBoxPadrao();
                $userID = $_GET['userID'];
                $email = usuarioDAO::descobrirEmail($userID);
                $usuario = usuarioDAO::recuperarUsuario($email);
                $this->visao->nome = $usuario->get_PNome();
                $this->visao->sobrenome = $usuario->get_UNome();
                $this->visao->email = $usuario->get_email();
                $this->visao->dataNascimento = $usuario->get_dataNascimento();
                $this->visao->papel = usuarioDAO::consultarPapel($email);
                $this->visao->idPapel = (int) papelDAO::obterIdPapel($this->visao->papel);
                $this->visao->comboPapel = ComboBoxPapeis::montarComboBoxPadrao();
                $this->visao->permissoes = usuarioDAO::obterPermissoes($_GET['userID']);
            }
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicao() {

        $this->renderizar();
    }

    public function acaoConsultarpermissoes() {
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->usuarios = usuarioDAO::consultar("idUsuario,concat(PNome,' ',UNome),email,dataNascimento,nome", "idUsuario <> " . $_SESSION['usuario']->get_id());
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->usuarios = usuarioDAO::consultar("idUsuario, concat(PNome,' ',UNome),email,dataNascimento,nome");
        $this->renderizar();
    }

    public function acaoRestaurar() {
        $this->renderizar();
    }

}

?>
