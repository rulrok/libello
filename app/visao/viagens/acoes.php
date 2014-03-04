<?php

require_once BIBLIOTECA_DIR . "configuracoes.php";
require_once BIBLIOTECA_DIR . "dompdf/dompdf_config.inc.php";
require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
require_once APP_LOCATION . "modelo/dao/viagemDAO.php";


if (filter_input(INPUT_GET, 'alterar') == "alterarEstado") {
    $id_viagem = fnDecrypt($_REQUEST['idViagem']);
    $status = $_REQUEST['estadoViagem'];
    $retorno = (new viagemDAO())->atualizarEstadoViagem($id_viagem, $status);
    echo json_encode($retorno);
}

//if (filter_input(INPUT_GET, 'alterar') == "alterarDoc_entregue") {
//    $id_viagem = $_REQUEST['id_viagem'];
//    $doc_entregue = $_REQUEST['doc_entregue'];
//    $retorno = atualizaDoc_entregue($id_viagem, $doc_entregue);
//    echo json_encode($retorno);
//}
?>