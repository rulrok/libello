<?php

require_once BIBLIOTECA_DIR . 'configuracoes.php';
require_once APP_DIR . 'controlador/ControladorDocumentos.php';

//header('Cache-Control: no-cache');
//header('Content-type: application/xml; charset="utf-8"', true);

$valor = $_REQUEST['valor'];
$documentoDAO = new documentoDAO();
if ($valor == 1) {
    $busca = $documentoDAO->consultar("documento_oficio", "idOficio = (SELECT idOficio FROM documento_oficio WHERE numOficio = (SELECT max(numOficio) FROM documento_oficio WHERE numOficio > (-1)))");
    if ($busca != null) {
        $numOficio = $busca[0];
        $num = ($numOficio->get_numOficio() + 1);
    } else {
        $num = 1;
    }
}
if ($valor == 2) {
    $busca = $documentoDAO->consultar("documento_memorando", "idMemorando = (SELECT idMemorando FROM documento_memorando WHERE numMemorando = (SELECT max(numMemorando) FROM documento_memorando WHERE numMemorando > (-1)))");
    if ($busca != null) {
        $numMem = $busca[0];
        $num = ($numMem->get_numMemorando() + 1);
    } else {
        $num = 1;
    }
}
echo $num;die();
echo( json_encode($num) );
?>
