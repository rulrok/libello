<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/configuracoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/dompdf/dompdf_config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");

$cont = new ControladorDocumentos();

if ($_GET['acao'] == "salvarOficio") {
    $idusuario = $_SESSION['usuario']->get_id();
    $assunto = $_REQUEST['assunto'];
    $corpo = $_REQUEST['corpo'];
    $destino = $_REQUEST['destino'];
    $referencia = $_REQUEST['referencia'];
    $data = $_REQUEST['dia'] . '/' . $_REQUEST['mes'] . '/' . date('Y');
    $tipoSigla = $_REQUEST['sigla'];
    $remetente = $_REQUEST['remetente'];
    $cargo_remetente = $_REQUEST['cargo_remetente'];
    //Verifica se possui mais de um remetente e pega seu valor
    $remetente2 = '';
    $cargo_remetente2 = '';
    $i_remetente = $_REQUEST['i_remetente'];
    if($i_remetente == '1'){
        $remetente2 = $_REQUEST['remetente2'];
        $cargo_remetente2 = $_REQUEST['cargo_remetente2'];
    }
    $tratamento = $_REQUEST['tratamento'];
    $cargo_destino = $_REQUEST['cargo_destino'];
    //estadoEdicao - se for apenas salvar (sem gerar numeracao) 1, senão 0
    $estadoEdicao = 1;
    $numOficio = -1;  
    $booledit = $_GET['booledit'];
    if ($booledit == '1') {
        $idoficio = fnDecrypt($_REQUEST['i_idoficio']);
        $cont->atualizarOficio($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    } else {
        $cont->salvarOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }
    echo json_encode("sucesso");
    //header("Location: ../menu.php");
}

if ($_GET['acao'] == "invalidaroficio") {
    $idoficio = fnDecrypt($_REQUEST['i_idoficio']);
    $resp = $cont->invalidarOficio($idoficio);
    echo json_encode($resp);
}

if ($_GET['acao'] == "deletaroficio") {
    $idoficio = fnDecrypt($_REQUEST['i_idoficio']);
    $cont->deletarOficio($idoficio);
    echo json_encode('sucesso');
}

if ($_GET['acao'] == "invalidarmemorando") {
    $idmemorando = fnDecrypt($_REQUEST['i_idmemorando']);
    $cont->invalidarMemorando($idmemorando);
    echo json_encode('sucesso');
}

if ($_GET['acao'] == "deletarmemorando") {
    $idmemorando = fnDecrypt($_REQUEST['i_idmemorando']);
    $cont->deletarMemorando($idmemorando);
    echo json_encode('sucesso');
}

if ($_GET['acao'] == "salvarMemorando") {
    $idusuario = $_SESSION['usuario']->get_id();
    $numMemorando = -1;
    $tipoSigla = $_REQUEST['sigla'];
    $data = $_REQUEST['dia'] . '/' . $_REQUEST['mes'] . '/' . date('Y');
    $tratamento = $_REQUEST['tratamento'];
    $cargo_destino = $_REQUEST['cargo_destino'];
    $assunto = $_REQUEST['assunto'];    
    $corpo = $_REQUEST['corpo'];
    $remetente = $_REQUEST['remetente'];
    $cargo_remetente = $_REQUEST['cargo_remetente'];
    //Verifica se possui mais de um remetente e pega seu valor
    $remetente2 = '';
    $cargo_remetente2 = '';
    $i_remetente = $_REQUEST['i_remetente'];
    if($i_remetente == '1'){
        $remetente2 = $_REQUEST['remetente2'];
        $cargo_remetente2 = $_REQUEST['cargo_remetente2'];
    }
    //estadoEdicao - se for apenas salvar (sem gerar numeracao) 1, senão 0
    $estadoEdicao = 1;
    $booledit = $_GET['booledit'];
    if ($booledit == '1') {        
        $idmemorando = fnDecrypt($_REQUEST['i_idmemorando']);
        $cont->atualizarMemorando($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    } else {
        $cont->salvarMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }
    echo json_encode("sucesso");
    //header("Location: ../menu.php");
}
?>
