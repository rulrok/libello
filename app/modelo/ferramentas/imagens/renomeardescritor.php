<?php

$id = fnDecrypt(filter_input(INPUT_POST, 'id'));
$novoNome = filter_input(INPUT_POST, 'novoNome');
$novoNomeNormalizado = normalizarNomeDescritor($novoNome);

if (!empty($id) && is_numeric($id) && !empty($novoNomeNormalizado)) {
    $imagensDAO = new imagensDAO();
    if ($imagensDAO->renomearDescritor($id, $novoNomeNormalizado)) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}
