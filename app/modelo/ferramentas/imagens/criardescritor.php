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
        $ultimoDescritor = $imagensDAO->consultarDescritor('idDescritor, nome, nivel', "nome = :nome AND pai = :pai ORDER BY idDescritor DESC LIMIT 1", null, array(':nome' => [$nomeNormalizado, PDO::PARAM_STR], ':pai' => [$idPai, PDO::PARAM_INT]));
        if (sizeof($ultimoDescritor) > 0) {
            echo json_encode(
                    [
                        'sucesso' => true
                        , 'id' => fnEncrypt($ultimoDescritor[0]['idDescritor'])
                        , 'nome' => $ultimoDescritor[0]['nome']
                        , 'nivel' => $ultimoDescritor[0]['nivel']
                    ]
            );
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