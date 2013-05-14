<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorLivro extends Controlador {

    public function acaoNovo() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->renderizar();
    }
    
    public function acaoSaida() {
        $this->renderizar();
    }
    
    public function acaoRetorno() {
        $this->renderizar();
    }
    
    public function acaoRelatorios() {
        $this->renderizar();
    }

}

?>
