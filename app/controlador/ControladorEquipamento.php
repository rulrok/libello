<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorEquipamento extends Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {

        $this->renderizar();
    }

    public function acaoVerificarNovo() {

        $this->renderizar();
    }

}

?>
