<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorViagens extends Controlador {

    public function acaoNova() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->renderizar();
    }
    
    

}

?>
