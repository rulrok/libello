<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/controle-cead/Includes/Mvc/Controlador.php';
class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $this->visao->titulo = "Blog Planeta Framework";        
        $this->renderizar();
    }

}

?>
