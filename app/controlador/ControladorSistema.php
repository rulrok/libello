<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorSistema extends Controlador {

    public function acaoInicial() {
        $this->renderizar();
    }

    public function acaoSair() {
        $this->renderizar();
    }

}

?>
