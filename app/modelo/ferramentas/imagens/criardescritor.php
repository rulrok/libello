<?php

require_once APP_DIR . 'modelo/vo/Descritor.php';

$idPai = (int) fnDecrypt(filter_input(INPUT_POST, 'idPai'));
$nome = filter_input(INPUT_POST, 'nome');
$nomeNormalizado = normalizarNomeDescritor($nome);

if (is_numeric($idPai) && !empty($nomeNormalizado)) {
    $imagensDAO = new imagensDAO();
    $descritor = new Descritor();
    $descritor->set_nome($nomeNormalizado);
    $imagensDAO->iniciarTransacao();
    if ($imagensDAO->cadastrarDescritor($descritor, $idPai)) {
        $ultimoId = $imagensDAO->consultarDescritor('idDescritor', "nome = :nome ORDER BY idDescritor DESC LIMIT 1", null, array(':nome' => [$nomeNormalizado, PDO::PARAM_STR]));
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