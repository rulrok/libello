<?php

require_once APP_LIBRARY_DIR . "configuracoes.php";
require_once APP_LIBRARY_DIR . "dompdf/dompdf_config.inc.php";
require_once APP_LIBRARY_DIR . "seguranca/seguranca.php";
require_once APP_LIBRARY_DIR . "seguranca/criptografia.php";
require_once APP_DIR . "modelo/dao/viagemDAO.php";


if (filter_input(INPUT_GET, 'alterar') == "alterarEstado") {
            $rodrigo;
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