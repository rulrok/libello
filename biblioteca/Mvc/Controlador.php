<?php

include_once BIBLIOTECA_DIR . 'Mvc/Visao.php';

abstract class Controlador {

    protected $visao;
    var $ferramenta;
    
    public function __construct() {
        $this->visao = new Visao();
    }

    public function renderizar() {
        $diretorio = strtolower(Mvc::pegarInstancia()->pegarControlador());
        $arquivo = strtolower(Mvc::pegarInstancia()->pegarAcao()) . ".php";
        $this->visao->renderizar($diretorio, $arquivo);
    }
    

    public abstract function idFerramentaAssociada();
}

?>
