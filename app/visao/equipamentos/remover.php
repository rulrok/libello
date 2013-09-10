<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = $_GET['equipamentoID'];
$mensagem = new Mensagem();

if (equipamentoDAO::remover($id)) {
    sistemaDAO::registrarExclusaoUsuario($_SESSION['idUsuario']);
    $mensagem->set_mensagem("Equipamento removido com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>