<?php

require_once APP_DIR . 'modelo/dao/imagensDAO.php';

$idDescritor = fnDecrypt(filter_input(INPUT_POST, 'idDescritor'));
$nivel = filter_input(INPUT_POST, 'nivel', FILTER_VALIDATE_INT);
$idNovoPai = fnDecrypt(filter_input(INPUT_POST, 'idNovoPai'));
$idAntigoPai = fnDecrypt(filter_input(INPUT_POST, 'idAntigoPai'));

if (is_numeric((int) $idDescritor) && is_numeric((int) $idAntigoPai) && is_numeric((int) $idNovoPai) && is_numeric($nivel)) {
    $imagensDAO = new imagensDAO();
    $sqlImagensRenomear = "SELECT idImagem FROM imagem WHERE descritor$nivel = :idDescritorExcluido";
    $paramsImagensRenomear = array(
        ':idDescritorExcluido' => [$idDescritor, PDO::PARAM_INT]
    );
    $imagensParaRenomearArquivo = $imagensDAO->executarSelect($sqlImagensRenomear, $paramsImagensRenomear);
    if ($imagensDAO->moverDescritor($idDescritor, $idNovoPai, $idAntigoPai)) {
        $imagensDAO->atualizarNomeArquivoImagens($imagensParaRenomearArquivo);
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}