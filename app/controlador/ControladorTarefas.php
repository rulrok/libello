<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';

class ControladorTarefas extends Controlador{
    
    function acaoGerenciar(){
        $this->renderizar();
    }
    
    function acaoNova(){
        $this->renderizar();
    }
}

?>
