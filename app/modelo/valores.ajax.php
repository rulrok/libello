<?php
//define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
//require_once "blabla";
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/configuracoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");

//header('Cache-Control: no-cache');
//header('Content-type: application/xml; charset="utf-8"', true);

$valores ;
$valor = $_REQUEST['valor'];
$controlador = new ControladorDocumentos();

if($valor == 1){   
    //console.log("algo");
    $valores = $controlador->retornaNumOficio();   
}
if($valor == 2){   
    $valores = $controlador->retornaNumMemorando();
}

echo json_encode($valores) ;
?>