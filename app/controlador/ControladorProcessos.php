<?php
include_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Controlador.php';
include_once __DIR__ . '/../modelo/dao/processosDAO.php';

class ControladorProcessos extends Controlador {

    public function acaoProcessos() {
        $this->renderizar();
    }
    
    public function acaoTexto(){
        
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::PROCESSOS;
    }

}
