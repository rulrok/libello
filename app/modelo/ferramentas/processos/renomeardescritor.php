<?php

$id = fnDecrypt(filter_input(INPUT_POST, 'id'));
$novoNome = filter_input(INPUT_POST, 'novoNome');
$novoNome = rtrim($novoNome);
$novoNome = ltrim($novoNome);

if (!empty($id) && is_numeric($id) && !empty($novoNome)) {
    $imagensDAO = new imagensDAO();
    if ($imagensDAO->renomearDescritor($id, $novoNome)) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}
