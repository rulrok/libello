<?php

namespace app\controlador;

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/enumeracao/Ferramenta.php';

use \app\modelo as Modelo;

class ControladorTarefas extends Controlador {

    function acaoGerenciar() {
        $this->renderizar();
    }

    function acaoNova() {
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::TAREFAS;
    }

}

?>
