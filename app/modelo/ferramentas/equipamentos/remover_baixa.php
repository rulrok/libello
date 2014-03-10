<?php

require_once APP_DIR . "modelo/Mensagem.php";

$baixaID = fnDecrypt(filter_input(INPUT_GET, 'baixaID'));
$mensagem = new Mensagem();

$equipamentoDAO = new equipamentoDAO();
if ($equipamentoDAO->removerBaixa($baixaID)) {
    $mensagem->set_mensagemSucesso("Baixa removida com sucesso.");
    $equipamentoDAO->registrarRemocaoBaixa($baixaID);
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>