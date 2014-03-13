<?php

require_once APP_DIR . 'modelo/dao/imagensDAO.php';

$idDescritor = fnDecrypt(filter_input(INPUT_POST, 'idDescritor'));
$idNovoPai = fnDecrypt(filter_input(INPUT_POST, 'idNovoPai'));
$idAntigoPai = fnDecrypt(filter_input(INPUT_POST, 'idAntigoPai'));

if (is_numeric((int) $idDescritor) && is_numeric((int) $idAntigoPai) && is_numeric((int) $idNovoPai)) {
    $imagensDAO = new imagensDAO();
    if ($imagensDAO->moverDescritor($idDescritor, $idNovoPai, $idAntigoPai)) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}