<?php

require_once ROOT.'app/controlador/ControladorDocumentos.php';

header('Cache-Control: no-cache');
header('Content-type: application/xml; charset="utf-8"', true);

$valor = $_REQUEST['valor'];
$cont = new ControladorDocumentos();
if($valor == 1){   
    $valores = $cont->retornaNumOficio();   
}
if($valor == 2){   
    $valores = $cont->retornaNumMemorando();
}

echo( json_encode($valores) ); ?>