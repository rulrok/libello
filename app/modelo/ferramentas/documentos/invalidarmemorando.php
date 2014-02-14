<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

 $id = fnDecrypt($_REQUEST['i_idmemorando']);
$mensagem = new Mensagem();
if (documentoDAO::invalidarMemorando($id)) {
    $mensagem->set_mensagem("Memorando invalidado com sucesso.")->set_status(Mensagem::SUCESSO);
} else {
    $mensagem->set_mensagem("Erro ao excluir")->set_status(Mensagem::ERRO);
}
echo json_encode($mensagem);
?>
