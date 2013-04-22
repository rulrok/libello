<?php

$id = $_GET['userID'];
$login = usuarioDAO::descobrirLogin($id);
$user = usuarioDAO::recuperarUsuario($login);
print_r($user);
?>
