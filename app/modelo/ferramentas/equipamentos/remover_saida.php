<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$saidaID = fnDecrypt(filter_input(INPUT_GET, 'saidaID'));
$mensagem = new Mensagem();

$equipamentoDAO = new equipamentoDAO();
if ($equipamentoDAO->removerSaida($saidaID)) {
    $mensagem->set_mensagemSucesso("Saída removida com sucesso.");
    $equipamentoDAO->registrarRemocaoSaida($saidaID);
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>