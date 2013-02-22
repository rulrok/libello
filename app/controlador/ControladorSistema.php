<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/novoControleCEAD/Includes/Mvc/Controlador.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $this->visao->titulo = "Blog Planeta Framework";
        $this->renderizar();
    }

}

?>
