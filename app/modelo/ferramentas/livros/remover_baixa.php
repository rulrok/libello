<?php

require_once APP_DIR . "modelo/Mensagem.php";

$baixaID = fnDecrypt(filter_input(INPUT_GET, 'baixaID'));
$mensagem = new Mensagem();

$livroDAO = new livroDAO();
if ($livroDAO->removerBaixa($baixaID)) {
    $mensagem->set_mensagemSucesso("Baixa removida com sucesso.");
    $livroDAO->registrarRemocaoBaixa($baixaID);
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>