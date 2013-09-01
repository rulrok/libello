<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/Configurations.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/dompdf/dompdf_config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");

$cont = new ControladorDocumentos();

if ($_GET['acao'] == "salvarOficio") {
    $idusuario = $_SESSION['idUsuario'];
    $assunto = $_POST['assunto'];
    $corpo = $_POST['corpo'];
    $destino = $_POST['destino'];
    $referencia = $_POST['referencia'];
    $data = $_POST['dia'] . '/' . $_POST['mes'] . '/' . date('Y');
    $tipoSigla = $_POST['sigla'];
    $remetente = $_POST['remetente'];
    $cargo_remetente = $_POST['cargo_remetente'];
    //Verifica se possui mais de um remetente e pega seu valor
    $remetente2 = '';
    $cargo_remetente2 = '';
    $i_remetente = $_POST['i_remetente'];
    if($i_remetente == '1'){
        $remetente2 = $_POST['remetente2'];
        $cargo_remetente2 = $_POST['cargo_remetente2'];
    }
    $tratamento = $_POST['tratamento'];
    $cargo_destino = $_POST['cargo_destino'];
    //estadoEdicao - se for apenas salvar (sem gerar numeracao) 1, senão 0
    $estadoEdicao = 1;
    $numOficio = -1;  
    $booledit = $_GET['booledit'];
    if ($booledit == '1') {
        $idoficio = $_POST['i_idoficio'];
        $cont->atualizarOficio($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    } else {
        $cont->salvarOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }
    header("Location: ../menu.php");
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
    $idusuario = get_idusuario();
    $numMemorando = -1;
    $tipoSigla = $_POST['sigla'];
    $data = $_POST['dia'] . '/' . $_POST['mes'] . '/' . date('Y');
    $tratamento = $_POST['tratamento'];
    $cargo_destino = $_POST['cargo_destino'];
    $assunto = $_POST['assunto'];    
    $corpo = $_POST['corpo'];
    $remetente = $_POST['remetente'];
    $cargo_remetente = $_POST['cargo_remetente'];
    //Verifica se possui mais de um remetente e pega seu valor
    $remetente2 = '';
    $cargo_remetente2 = '';
    $i_remetente = $_POST['i_remetente'];
    if($i_remetente == '1'){
        $remetente2 = $_POST['remetente2'];
        $cargo_remetente2 = $_POST['cargo_remetente2'];
    }
    //estadoEdicao - se for apenas salvar (sem gerar numeracao) 1, senão 0
    $estadoEdicao = 1;
    $booledit = $_GET['booledit'];
    if ($booledit == '1') {        
        $idmemorando = $_POST['i_idmemorando'];
        $cont->atualizarMemorando($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    } else {
        $cont->salvarMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }
    header("Location: ../menu.php");
}
?>
