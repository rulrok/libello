<?php

require_once APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/enumeracao/ImagensCategoriaEnum.php";

$categoriaID = fnDecrypt($_GET['categoriaID']);
$mensagem = new Mensagem();

if ($categoriaID == ImagensCategoriaEnum::CATEGORIA_PADRAO_ID) {
    $mensagem->set_mensagem("Não é permitido remover a categoria padrão.<br/>Quando alguma categoria com subcategorias cadastradas é removida, todas elas são movidas para a categoria Padrão.")->set_status(Mensagem::INFO);
} else {
    if (imagensDAO::removerCategoria($categoriaID)) {
        $mensagem->set_mensagem("Categoria removida com sucesso.")->set_status(Mensagem::SUCESSO);
        imagensDAO::registrarRemocaoCategoria($categoriaID);
    } else {
        $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
    }
}
echo json_encode($mensagem);
?>