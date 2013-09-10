<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/configuracoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/dompdf/dompdf_config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");

$cont = new ControladorDocumentos();

if ($_GET['acao'] == "salvarOficio") {
    $idusuario = $_SESSION['idUsuario'];
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
        $idoficio = $_REQUEST['i_idoficio'];
        $cont->atualizarOficio($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    } else {
        $cont->salvarOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }
    echo json_encode("sucesso");
    //header("Location: ../menu.php");
}

if ($_GET['acao'] == "invalidarOficio") {
    $idoficio = $_POST['i_idOficio'];
    $resp = $cont->invalidarOficio($idoficio);
    echo json_encode($resp);
    header("Location: ../paginasAdm/gerenciarHistorico.php");
}

if ($_GET['acao'] == "deletarOficio") {
    $idoficio = $_POST['i_idOficio'];
    $cont->deletarOficio($idoficio);
    header("Location: ../paginasAdm/gerenciarHistorico.php");
}

if ($_GET['acao'] == "aproveitarOficio") {
    $idoficio = $_POST['i_idOficio'];
    $controleAproveitar = $_POST['i_controleAproveitar'];
    header("Location: ../paginasAdm/aproveitarOficio.php?idoficio=" . $idoficio . "&ctrl=" . $controleAproveitar);
}

if ($_GET['acao'] == "invalidarMemorando") {
    $idmemorando = $_POST['i_idMemorando'];
    invalidarMemorando($idmemorando);
    header("Location: ../paginasAdm/gerenciarHistorico.php");
}

if ($_GET['acao'] == "deletarMemorando") {
    $idmemorando = $_POST['i_idMemorando'];
    $cont->deletarMemorando($idmemorando);
    header("Location: ../paginasAdm/gerenciarHistorico.php");
}

if ($_GET['acao'] == "aproveitarMemorando") {
    $idmemorando= $_POST['i_idMemorando'];    
    $controleAproveitar = $_POST['i_controleAproveitarMem'];
    header("Location: ../paginasAdm/aproveitarMemorando.php?idmemorando=" . $idmemorando . "&ctrl=" . $controleAproveitar);
}

if ($_GET['acao'] == "salvarMemorando") {
    $idusuario = $_SESSION['idUsuario'];
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
        $idmemorando = $_REQUEST['i_idmemorando'];
        $cont->atualizarMemorando($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    } else {
        $cont->salvarMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }
    echo json_encode("sucesso");
    //header("Location: ../menu.php");
}
?>
