<?php

$id = fnDecrypt(filter_input(INPUT_POST, 'id'));
$novoNome = filter_input(INPUT_POST, 'novoNome');

if (!empty($id) && is_numeric($id) && !empty($novoNome)) {
    $imagensDAO = new imagensDAO();
    if ($imagensDAO->renomearDescritor($id, $novoNome)) {
        echo json_encode(['resposta' => true]);
    } else {
        echo json_encode(['resposta' => false]);
    }
} else {
    echo json_encode(['resposta' => false]);
}


