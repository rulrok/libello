<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';
include_once __DIR__ . '/../modelo/dao/usuarioDAO.php';

class ControladorSistema extends Controlador {

    public function acaoInicial() {
        $this->renderizar();
    }

    public function acaoSair() {
        expulsaVisitante();
    }

    public function acaoNaoautenticado() {
        $this->renderizar();
    }

    public function acaoGerenciarconta($erro = false) {
        if ($erro == false) {
//            $this->visao->mensagem_usuario = null;
            $this->visao->nome = $_SESSION['nome'];
            $this->visao->sobrenome = $_SESSION['sobrenome'];
            $this->visao->email = $_SESSION['email'];
//            $this->visao->login = $_SESSION['login'];
            $this->visao->dataNascimento = $_SESSION['dataNascimento'];

            

            $this->visao->papel = usuarioDAO::consultarPapel($_SESSION['login']);
        } else {
            if ($this->visao->mensagem_usuario == NULL || $this->visao->mensagem_usuario == "") {
                $this->visao->mensagem_usuario = "Informações inválidas.";
                $this->visao->tipo_mensagem = "erro";
            }
        }

        $this->renderizar();
    }

    public function acaoValidarAlteracoesConta() {
        $this->renderizar();
    }

}

?>
