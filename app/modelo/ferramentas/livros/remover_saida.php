<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$saidaID = fnDecrypt(filter_input(INPUT_GET, 'saidaID'));
$mensagem = new Mensagem();
$livroDAO = new livroDAO();
if ($livroDAO->removerSaida($saidaID)) {
    $mensagem->set_mensagemSucesso("Saída removida com sucesso.");
    $livroDAO->registrarRemocaoSaida($saidaID);
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>