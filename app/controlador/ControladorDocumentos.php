<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorDocumentos extends Controlador {

    public function acaoHistorico() {
        $this->renderizar();
    }

    public function acaoGeraroficio() {
        $this->renderizar();
    }
    public function acaoGerarrelatorio() {
        $this->renderizar();
    }

}

?>
