<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';

class ControladorTarefas extends Controlador{
    public function idFerramentaAssociada() {
        return Ferramenta::TAREFAS;
    }

//put your code here
}

?>
