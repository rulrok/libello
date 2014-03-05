<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/Enumeracao/Ferramenta.php';

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
