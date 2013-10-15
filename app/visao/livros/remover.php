<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = fnDecrypt($_GET['livroID']);
$mensagem = new Mensagem();
$novosDados = clone livroDAO::recuperarlivro($id);
$novosDados->set_quantidade(0);
$novosDados->set_numeroPatrimonio(null);
if (livroDAO::atualizar($id, $novosDados)) {
    $mensagem->set_mensagem("Livro removido com sucesso.")->set_status(Mensagem::SUCESSO);
    livroDAO::registrarExclusaoLivro($id);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>