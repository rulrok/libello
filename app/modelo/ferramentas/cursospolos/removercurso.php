<?php

$id = (int) fnDecrypt(filter_input(INPUT_GET, 'cursoID'));
$mensagem = new Mensagem();
if ((new cursoDAO())->remover($id)) {
    (new sistemaDAO())->registrarExclusaoCurso(obterUsuarioSessao()->get_idUsuario());
    $mensagem->set_mensagemSucesso("Excluído com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>