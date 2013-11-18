<?php

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
?>
