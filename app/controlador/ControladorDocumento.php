<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorDocumento extends Controlador {

    public function acaoNovo() {
        $this->renderizar();
    }

    public function acaoSair() {
        $this->visao->conteudo = "Reuel";
        $this->renderizar();
    }

}

?>
