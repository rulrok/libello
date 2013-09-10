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
            $this->visao->nome = $_SESSION['usuario']->get_PNome();
            $this->visao->sobrenome = $_SESSION['usuario']->get_UNome();
            $this->visao->email = $_SESSION['usuario']->get_email();
            $this->visao->dataNascimento = $_SESSION['usuario']->get_dataNascimento();

            

            $this->visao->papel = usuarioDAO::consultarPapel($_SESSION['usuario']->get_email());
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
