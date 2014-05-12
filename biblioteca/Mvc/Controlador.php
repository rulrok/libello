<?php

include_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Visao.php';
require_once APP_DIR . 'modelo/Mensagem.php';

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