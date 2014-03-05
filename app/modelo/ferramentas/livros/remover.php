<?php

require_once APP_DIR . "modelo/Mensagem.php";

$id = fnDecrypt(filter_input(INPUT_GET, 'livroID'));
$mensagem = new Mensagem();
$livroDAO = new livroDAO();
$novosDados = clone $livroDAO->recuperarlivro($id);
$novosDados->set_quantidade(0);
$novosDados->set_numeroPatrimonio(null);
if ($livroDAO->atualizar($id, $novosDados)) {
    $mensagem->set_mensagemSucesso("Livro removido com sucesso.");
    $livroDAO->registrarExclusaoLivro($id);
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>