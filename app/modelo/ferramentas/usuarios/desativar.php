<?php

require_once APP_DIR . "modelo/Mensagem.php";

$id = fnDecrypt(filter_input(INPUT_GET, 'userID'));
$usuarioDAO = new usuarioDAO();
$email = $usuarioDAO->descobrirEmail($id);
$mensagem = new Mensagem();

if ($usuarioDAO->desativar($email)) {
    (new sistemaDAO())->registrarDesativacaoUsuario(obterUsuarioSessao()->get_idUsuario(), $id);
    $mensagem->set_mensagemSucesso("Usuário desativado com sucesso.");
} else {
    $mensagem->set_mensagem("Erro ao concluir a operação")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>