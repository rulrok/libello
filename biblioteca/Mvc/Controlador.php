<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/controle-cead/biblioteca/Mvc/Visao.php';
class Controlador {

    protected $visao;

    public function __construct() {
        $this->visao = new Visao();
    }

    public function renderizar() {
        $diretorio = strtolower(Mvc::pegarInstancia()->pegarControlador());
        $arquivo = strtolower(Mvc::pegarInstancia()->pegarAcao()) . ".php";

        $this->visao->renderizar($diretorio, $arquivo);
    }

}

?>
