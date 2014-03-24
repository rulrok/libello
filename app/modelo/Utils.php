<?php

function obterHoraAtual($formato = 'h:i:s') {
    date_default_timezone_set(APP_TIME_ZONE);
    return date($formato);
}

function obterDataAtual($formato = 'Y-m-j') {
    date_default_timezone_set(APP_TIME_ZONE);
    return date($formato);
}

function normalizarNomeDescritor($nome) {
    $nomeSemEspacos = rtrim(ltrim($nome));
    $nomeLowerCase = strtolower($nomeSemEspacos);
    $nomeNormalizado = ucfirst($nomeLowerCase);
    return $nomeNormalizado;
}

/**
 * Extrai a extensão do nome de um arquivo. Apenas com base na string passada,
 * nenhuma verificação de tipo é realmente feita no arquivo.
 * 
 * @param string $nomeArquivo
 */
function obterExtensaoArquivo($nomeArquivo){
     $i = strrpos($nomeArquivo, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($nomeArquivo) - $i;
    $ext = substr($nomeArquivo, $i + 1, $l);
    return $ext;
}