<?php

require_once APP_DIR . "modelo/dao/usuarioDAO.php";

if ($_SESSION['autenticado'] === true) {
    $idPapel = filter_input(INPUT_GET, 'idPapel');
    $usuarioDAO = new usuarioDAO();
    $usuarios = $usuarioDAO->consultar("idUsuario,concat(PNome,' ', UNome) as `Nome`", "idPapel = :idPapel", null, array(':idPapel' => [$idPapel, PDO::PARAM_INT]));
    echo json_encode($usuarios);
}
?>
