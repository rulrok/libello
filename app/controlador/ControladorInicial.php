<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/app/modelo/Menu.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $this->visao->usuario = $_SESSION['nome'];
        $this->visao->papel = usuarioDAO::consultarPapel($_SESSION['email']);
        $this->visao->titulo = "Controle CEAD";
        $this->visao->conteudo = $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/visao/inicial/homepage.php";
        $this->visao->menu = Menu::montarMenuNavegacao();
        $this->renderizar();
    }

    public function acaoHomepage() {
        $this->visao->usuario = $_SESSION['nome'];
        $this->renderizar();
    }

    public function acao404(){
        $this->renderizar();
    }
}

?>
