<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$subcategoriaID = fnDecrypt($_GET['subcategoriaID']);
$mensagem = new Mensagem();


if (imagensDAO::removerSubcategoria($subcategoriaID)) {
    $mensagem->set_mensagem("Subcategoria removida com sucesso.")->set_status(Mensagem::SUCESSO);
    imagensDAO::registrarRemocaoSubcategoria($subcategoriaID);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}

echo json_encode($mensagem);
?>