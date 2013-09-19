<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = fnDecrypt($_GET['equipamentoID']);
$mensagem = new Mensagem();
$novosDados = clone equipamentoDAO::recuperarEquipamento($id);
$novosDados->set_quantidade(0);
$novosDados->set_numeroPatrimonio(null);
if (equipamentoDAO::atualizar($id, $novosDados)) {
    $mensagem->set_mensagem("Equipamento removido com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>