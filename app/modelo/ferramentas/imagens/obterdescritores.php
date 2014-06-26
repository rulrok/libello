<?php

require_once APP_DIR . "modelo/dao/imagensDAO.php";

$retorno = array();
if (filter_has_var(INPUT_POST, 'query')) {
    $imagensDAO = new imagensDAO();
    $query = filter_input(INPUT_POST, 'query');
    $resultado = $imagensDAO->consultarDescritor('DISTINCT nome', " nome LIKE '%$query%'");

    foreach ($resultado as $descritor) {
        $retorno[] = $descritor['nome'];
    }
}
$json = json_encode($retorno);
echo $json;
