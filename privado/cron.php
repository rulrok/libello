<?php

require_once '../biblioteca/configuracoes.php';
require_once BIBLIOTECA_DIR . 'bancoDeDados/PDOconnectionFactory.php';

$conn = PDOconnectionFactory::obterConexao();
try {
//Tabela 1
    $sql1 = "DELETE FROM imagem_descritor_aux_inserir";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
} catch (Exception $e) {
    error_log("Falha ao limpar tabela imagem_descritor_aux_inserir");
}
try {
//Tabela 2
    $sql2 = "DELETE FROM imagem_descritor_aux_remover";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
} catch (Exception $e) {
    error_log("Falha ao limpar tabela imagem_descritor_aux_remover");
}

if (is_dir(APP_TEMP_ABSOLUTE_DIR)) {
    chdir(APP_TEMP_ABSOLUTE_DIR);
    foreach (scandir(APP_TEMP_ABSOLUTE_DIR, SCANDIR_SORT_ASCENDING) as $arquivo) {
        if ($arquivo == '.' || $arquivo == '..') {
            continue;
        }
        if (!unlink($arquivo)) {
            error_log("Falha ao remover arquivo " . APP_TEMP_ABSOLUTE_DIR . $arquivo . " pelo script cron");
        }
    }
} else {
    error_log("Diretório temporário não pôde ser lido pelo script cron");
}