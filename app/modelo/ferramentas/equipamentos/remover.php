<?php

require_once APP_DIR . "modelo/Mensagem.php";

$id = fnDecrypt(filter_input(INPUT_GET, 'equipamentoID'));
$mensagem = new Mensagem();
$equipamentoDAO = new equipamentoDAO();
$novosDados = clone $equipamentoDAO->recuperarEquipamento($id);
$novosDados->set_quantidade(0);
$novosDados->set_numeroPatrimonio(null);
if ($equipamentoDAO->atualizar($id, $novosDados)) {
    $mensagem->set_mensagemSucesso("Equipamento removido com sucesso.");
    $equipamentoDAO->registrarExclusaoEquipamento($id);
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>