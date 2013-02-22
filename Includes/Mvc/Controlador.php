<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/novoControleCEAD/Includes/Mvc/Visao.php';
class Controlador {

    protected $visao;

    public function __construct() {
        $this->visao = new Visao();
    }

    public function renderizar() {
        $diretorio = strtolower(Visao::pegarInstancia()->pegarControlador());
        $arquivo = strtolower(Visao::pegarInstancia()->pegarAcao()) . ".php";

        $this->visao->renderizar($diretorio, $arquivo);
    }

}

?>
