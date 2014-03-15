<?php

require_once APP_DIR . 'modelo/vo/Descritor.php';

$idPai = (int)fnDecrypt(filter_input(INPUT_POST, 'idPai'));
$nome = filter_input(INPUT_POST, 'nome');
$nome = rtrim($nome);

if (is_numeric($idPai) && !empty($nome)) {
    $imagensDAO = new imagensDAO();
    $descritor = new Descritor();
    $descritor->set_nome($nome);
    if ($imagensDAO->cadastrarDescritor($descritor,$idPai)) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}