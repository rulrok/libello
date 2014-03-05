<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/ComboBoxPermissoes.php';
include_once APP_DIR . 'modelo/ComboBoxPapeis.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";

class ControladorUsuarios extends Controlador {

    public function acaoNovo() {
        $this->visao->comboPermissoes = ComboBoxPermissoes::montarTodasPermissoes();
        $this->visao->comboPapeis = ComboBoxPapeis::montarTodosPapeis();
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->renderizar();
    }

    public function acaoEditar() {
        if (filter_has_var(INPUT_GET, 'userID')) {
            $userID = fnDecrypt(filter_input(INPUT_GET, 'userID'));
            if ($userID != obterUsuarioSessao()->get_idUsuario()) { //!!! Impede que o usuário edite o próprio perfil, alterando assim sua permissões e papel. Uma violação de segurança.
                $usuarioDAO = new usuarioDAO();
                $this->visao->comboPermissoes = ComboBoxPermissoes::montarTodasPermissoes();
                $email = $usuarioDAO->descobrirEmail($userID);
                $usuario = $usuarioDAO->recuperarUsuario($email);
                $this->visao->nome = $usuario->get_PNome();
                $this->visao->sobrenome = $usuario->get_UNome();
                $this->visao->email = $usuario->get_email();
                $this->visao->dataNascimento = $usuario->get_dataNascimento();
                $this->visao->papel = $usuarioDAO->consultarPapel($email);
                $this->visao->idPapel = (int) (new papelDAO())->obterIdPapel($this->visao->papel);
                $this->visao->comboPapel = ComboBoxPapeis::montarTodosPapeis();
                $this->visao->permissoes = $usuarioDAO->obterPermissoes($userID);
                $this->visao->cpf = $usuario->get_cpf();
            } else {
                //TODO bolar um esquema de log para essas ações que aparentam ser uma tentativa de invasão do sistema
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
        $usuarioDAO = new usuarioDAO();
        $idUsuario = (int) obterUsuarioSessao()->get_idUsuario();
        $params = array(':idUsuario' => array($idUsuario, PDO::PARAM_INT));
        $this->visao->usuarios = $usuarioDAO->consultar("idUsuario,concat(PNome,' ',UNome),email,dataNascimento,cpf,nome", "idUsuario <> :idUsuario", $params);
        $i = 0;
        foreach ($this->visao->usuarios as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->usuarios[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->usuarios = (new usuarioDAO())->consultar("idUsuario, concat(PNome,' ',UNome),email,dataNascimento,nome");
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
