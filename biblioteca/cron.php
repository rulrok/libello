<?php

/*
 * Este arquivo deve ser executado por uma versão do PHP superior a versão 5.3.0
 * 
 */

require_once 'configuracoes.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . 'bancoDeDados/PDOconnectionFactory.php';
require_once APP_DIR . 'modelo/Utils.php';

$conn = PDOconnectionFactory::obterConexao();
try {
//Tabela 1
    $sql1 = "DELETE FROM imagem_descritor_aux_inserir";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
} catch (Exception $e) {
    registrar_erro("Falha ao limpar tabela imagem_descritor_aux_inserir");
}
try {
//Tabela 2
    $sql2 = "DELETE FROM imagem_descritor_aux_remover";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
} catch (Exception $e) {
    registrar_erro("Falha ao limpar tabela imagem_descritor_aux_remover");
}

if (is_dir(APP_TEMP_ABSOLUTE_DIR)) {
    chdir(APP_TEMP_ABSOLUTE_DIR);
    foreach (scandir(APP_TEMP_ABSOLUTE_DIR, SCANDIR_SORT_ASCENDING) as $arquivo) {
        if ($arquivo == '.' || $arquivo == '..') {
            continue;
        }

        if (is_dir($arquivo)) {
            if (!rmdir_recursive($arquivo)) {
                registrar_erro("Falha ao remover diretório $arquivo pelo script cron");
            }
        } elseif (!unlink($arquivo)) {
            registrar_erro("Falha ao remover arquivo " . APP_TEMP_ABSOLUTE_DIR . $arquivo . " pelo script cron");
        }
    }
} else {
    registrar_erro("Diretório temporário não pôde ser lido pelo script cron");
}
