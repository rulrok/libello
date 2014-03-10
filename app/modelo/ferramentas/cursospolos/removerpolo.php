<?php

$id = fnDecrypt(filter_input(INPUT_GET, 'poloID'));
$mensagem = new Mensagem();

if ((new poloDAO())->remover($id)) {
    (new sistemaDAO())->registrarExclusaoPolo(obterUsuarioSessao()->get_idUsuario());
    $mensagem->set_mensagemSucesso("Excluído com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>