<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = $_GET['poloID'];
$mensagem = new Mensagem();

if (poloDAO::remover($id)) {
    sistemaDAO::registrarExclusaoPolo($_SESSION['idUsuario']);
    $mensagem->set_mensagem("Excluído com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>