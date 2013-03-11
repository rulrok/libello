<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $this->visao->usuario = $_SESSION['nome'];
        $this->visao->titulo = "Controle CEAD | Bem vindo ".$_SESSION['nome'];
        $this->visao->conteudo = $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/visao/inicial/homepage.php";
        $this->renderizar();
    }

    public function acaoHomepage() {
        $this->visao->usuario = "Reuel";
        $this->renderizar();
    }

}

?>
