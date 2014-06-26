<?php

$imagensDAO = new imagensDAO();
if (filter_has_var(INPUT_GET, 'completa') && filter_input(INPUT_GET, 'completa')) {
    if (filter_has_var(INPUT_GET, 'descritorExcluir')) {
        $descritorExcluido = fnDecrypt(filter_input(INPUT_GET, 'descritorExcluir'));
    } else {
        $descritorExcluido = null;
    }
    $arvore = $imagensDAO->arvoreDescritores(true, $descritorExcluido);
} else {
    $arvore = $imagensDAO->arvoreDescritores();
}

print_r(json_encode($arvore));