<?php

require_once APP_DIR . 'modelo/vo/Descritor.php';

$idPai = fnDecrypt(filter_input(INPUT_POST, 'idPai'));
$nome = filter_input(INPUT_POST, 'nome');

if (!empty($idPai) && is_numeric($idPai) && !empty($nome)) {
    $imagensDAO = new imagensDAO();
    $descritor = new Descritor();
    $descritor->set_nome($nome);
    if ($imagensDAO->cadastrarDescritor($descritor,$idPai)) {
        echo json_encode(['resposta' => true]);
    } else {
        echo json_encode(['resposta' => false]);
    }
} else {
    echo json_encode(['resposta' => false]);
}