<?php

require_once APP_LOCATION . "modelo/dao/usuarioDAO.php";

if ($_SESSION['autenticado'] === true) {
    $idPapel = $_GET['idPapel'];
    $usuarios = usuarioDAO::consultar("idUsuario,concat(PNome,' ', UNome) as `Nome`", "idPapel = " . $idPapel);
    echo json_encode($usuarios);
} else {
    die("Acesso indevido");
}
?>
