<?php
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");

header('Cache-Control: no-cache');
header('Content-type: application/xml; charset="utf-8"', true);

$valor = $_REQUEST['valor'];

if($valor == 1){   
    $valores = retornaNumOficio();   
}
if($valor == 2){   
    $valores = retornaNumMemorando();
}

echo( json_encode($valores) );