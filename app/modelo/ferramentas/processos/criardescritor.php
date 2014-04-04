<?php

require_once APP_DIR . 'modelo/vo/Processos.php';

$idPai = (int) fnDecrypt(filter_input(INPUT_POST, 'idPai'));
$nome = filter_input(INPUT_POST, 'nome');
$nome = rtrim($nome);

if (is_numeric($idPai) && !empty($nome)) {
    $imagensDAO = new processosDAO();
    $descritor = new Processos();
    $descritor->set_nome($nome);
    $imagensDAO->iniciarTransacao();
    if ($imagensDAO->cadastrarProcessos($descritor, $idPai)) {
        $ultimoId = $imagensDAO->consultarProcessos('idDescritor', "nome = :nome ORDER BY idDescritor DESC LIMIT 1", null, array(':nome' => [$nome, PDO::PARAM_STR]));
        if ($ultimoId != null) {
            echo json_encode(['sucesso' => true, 'id' => fnEncrypt($ultimoId[0][0])]);
            $imagensDAO->encerrarTransacao();
        } else {
            $imagensDAO->rollback();
        }
    } else {
        $imagensDAO->rollback();
        echo json_encode(['sucesso' => false]);
    }
} else {
    echo json_encode(false);
}