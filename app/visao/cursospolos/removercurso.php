<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = $_GET['cursoID'];
$mensagem = new Mensagem();
if (cursoDAO::remover($id)) {
    sistemaDAO::registrarExclusaoCurso($_SESSION['idUsuario']);
    $mensagem->set_mensagem("Excluído com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>