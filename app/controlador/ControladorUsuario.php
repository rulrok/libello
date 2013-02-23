<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorUsuario extends Controlador {

    public function acaoNovo() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->conteudo = "Reuel";
        $this->renderizar();
    }

}

?>
