<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/configuracoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/dompdf/dompdf_config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/modelo/dao/viagemDAO.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/criptografia.php");


if($_GET['acao'] == "alterarEstado"){
    $id_viagem = fnDecrypt($_REQUEST['idViagem']);
    $status = $_REQUEST['estadoViagem'];
    $retorno = viagemDAO::atualizarEstadoViagem($id_viagem, $status);
    echo json_encode($retorno);
}

if($_GET['acao'] == "alterarDoc_entregue"){
    $id_viagem = $_REQUEST['id_viagem'];
    $doc_entregue = $_REQUEST['doc_entregue'];    
    $retorno = atualizaDoc_entregue($id_viagem, $doc_entregue);
    echo json_encode($retorno);
}


?>