<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = fnDecrypt($_GET['userID']);
$email = usuarioDAO::descobrirEmail($id);
$mensagem = new Mensagem();

if (usuarioDAO::desativar($email)) {
    sistemaDAO::registrarDesativacaoUsuario(obterUsuarioSessao()->get_id(), $id);
    $mensagem->set_mensagem("Usuário desativado com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao concluir a operação")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>