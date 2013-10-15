<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$baixaID = fnDecrypt($_GET['baixaID']);
$mensagem = new Mensagem();

if (livroDAO::removerBaixa($baixaID)) {
    $mensagem->set_mensagem("Baixa removida com sucesso.")->set_status(Mensagem::SUCESSO);
    livroDAO::registrarRemocaoBaixa($baixaID);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>