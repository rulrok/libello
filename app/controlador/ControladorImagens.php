<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once APP_LOCATION . "modelo/ComboBoxPapeis.php";
require_once APP_LOCATION . "modelo/ComboBoxUsuarios.php";
include_once APP_LOCATION . 'modelo/ComboBoxPolo.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";

class ControladorImagens extends Controlador {

    public function acaoGerenciar() {
        $this->renderizar();
    }

    public function acaoCadastrar() {
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->renderizar();
    }

    public function acaoCategorias() {
        $this->renderizar();
    }
    
    public function acaoVerificarnova(){
        $this->renderizar();
    }
    
    public function acaoUpload_img(){
        $this->renderizar();
    }
    
    public function acaoProcessarimagem(){
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::GALERIA_IMAGENS;
    }

}

?>
