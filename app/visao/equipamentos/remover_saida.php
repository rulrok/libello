<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$saidaID = fnDecrypt($_GET['saidaID']);
$mensagem = new Mensagem();

if (equipamentoDAO::removerSaida($saidaID)) {
    $mensagem->set_mensagem("Saída removida com sucesso.")->set_status(Mensagem::SUCESSO);
    equipamentoDAO::registrarRemocaoSaida($saidaID);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>