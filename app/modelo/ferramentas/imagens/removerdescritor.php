<?php

$idDescritor = fnDecrypt(filter_input(INPUT_POST, 'idDescritor'));
$idDescritorSubstituto = fnDecrypt(filter_input(INPUT_POST, 'idDescritorSubstituto'));

$imagensDAO = new imagensDAO();
try {
    $imagensDAO->iniciarTransacao();

    $descritorExcluido = $imagensDAO->consultarDescritor('*', " idDescritor = $idDescritor")[0];

    $caminhoNovo = $imagensDAO->consultarCaminhoAteRaiz($idDescritorSubstituto);

    $paramsAtualizar = array(
        ':descritor1' => [$caminhoNovo[0]['idDescritor'], PDO::PARAM_INT]
        , ':descritor2' => [$caminhoNovo[1]['idDescritor'], PDO::PARAM_INT]
        , ':descritor3' => [$caminhoNovo[2]['idDescritor'], PDO::PARAM_INT]
        , ':descritor4' => [$caminhoNovo[3]['idDescritor'], PDO::PARAM_INT]
        , ':descritorExcluir' => [$idDescritor, PDO::PARAM_INT]
    );
    switch ($descritorExcluido['nivel']) {
        case '1':
            $sql = "UPDATE imagens_imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor1 = :descritorExcluir";
            break;
        case '2':
            $sql = "UPDATE imagens_imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor2 = :descritorExcluir";
            break;
        case '3':
            $sql = "UPDATE imagens_imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor3 = :descritorExcluir";
            break;
        case '4':
            $sql = "UPDATE imagens_imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor4 = :descritorExcluir";
            break;
    }

    $imagensDAO->executarQuery($sql, $paramsAtualizar);

    if ($descritorExcluido['pai'] != null) {
        $sqlAtualizaQtdFilhos = 'UPDATE imagens_descritor SET qtdFilhos = qtdFilhos - 1 WHERE idDescritor = :idDescritor';
        $paramsAtualizarQtdFilhos = array(
            ':idDescritor' => [$descritorExcluido['pai'], PDO::PARAM_INT]
        );
        $imagensDAO->executarQuery($sqlAtualizaQtdFilhos, $paramsAtualizarQtdFilhos);
    }
    $sqlRemover = 'DELETE FROM imagens_descritor WHERE idDescritor = :idDescritorRemover';
    $paramsRemover = array(
        ':idDescritorRemover' => [$idDescritor, PDO::PARAM_INT]
    );
    $imagensDAO->executarQuery($sqlRemover, $paramsRemover);
    $imagensDAO->encerrarTransacao();
} catch (Exception $e) {
    $imagensDAO->rollback();
}
