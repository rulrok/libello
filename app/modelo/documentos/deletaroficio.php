<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

 $id = fnDecrypt($_REQUEST['i_idoficio']);
$mensagem = new Mensagem();
if (documentoDAO::deleteOficio($id)) {
    $mensagem->set_mensagem("Oficio removido com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>
