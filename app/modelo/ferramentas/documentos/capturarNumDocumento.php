<?php

require_once BIBLIOTECA_DIR . 'configuracoes.php';
require_once BIBLIOTECA_DIR . 'controlador/ControladorDocumentos.php';

header('Cache-Control: no-cache');
header('Content-type: application/xml; charset="utf-8"', true);

$valor = $_REQUEST['valor'];
$documentoDAO = new documentoDAO();
if ($valor == 1) {
    $busca = $documentoDAO->consultar("oficio", "idOficio = (SELECT idOficio FROM oficio WHERE numOficio = (SELECT max(numOficio) FROM oficio WHERE numOficio > (-1)))");
    if ($busca != null) {
        $numOficio = $busca[0];
        $num = ($numOficio->getNumOficio() + 1);
    } else {
        $num = 1;
    }
}
if ($valor == 2) {
    $busca = $documentoDAO->consultar("memorando", "idMemorando = (SELECT idMemorando FROM memorando WHERE numMemorando = (SELECT max(numMemorando) FROM memorando WHERE numMemorando > (-1)))");
    if ($busca != null) {
        $numMem = $busca[0];
        $num = ($numMem->getNumMemorando() + 1);
    } else {
        $num = 1;
    }
}

echo( json_encode($num) );
?>
