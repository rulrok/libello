<?php

if (!defined("ROOT")) {
    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/controle-cead",true);
}
require_once 'biblioteca/Mvc/CarregadorAutomatico.php';
require_once 'biblioteca/Mvc/Mvc.php';


CarregadorAutomatico::registrar();
Mvc::pegarInstancia()->rodar();
?>


