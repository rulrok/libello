<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorEquipamento extends Controlador {

    public function acaoNovo() {
        $this->renderizar();
    }

    public function acaoSair() {
        $this->visao->conteudo = "Reuel";
        $this->renderizar();
    }

}

?>
