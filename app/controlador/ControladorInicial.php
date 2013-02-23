<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $this->visao->titulo = "Controle CEAD | Página Inicial";
        $this->visao->conteudo = $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/visao/inicial/conteudoInicial.html";
        $this->renderizar();
    }

}

?>
