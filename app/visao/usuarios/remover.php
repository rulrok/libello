<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = $_GET['userID'];
$email = usuarioDAO::descobrirEmail($id);
$mensagem = new Mensagem();

if (usuarioDAO::remover($email)) {
    sistemaDAO::registrarExclusaoUsuario($_SESSION['idUsuario'], $id);
    $mensagem->set_mensagem("Usuário removido com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>