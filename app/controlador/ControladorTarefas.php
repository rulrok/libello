<?php

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/enumeracao/Ferramenta.php';

class ControladorTarefas extends Controlador{
    
    function acaoGerenciar(){
        $this->renderizar();
    }
    
    function acaoNova(){
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::TAREFAS;
    }
}

?>
