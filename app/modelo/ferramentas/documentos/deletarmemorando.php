<?php

require_once APP_DIR . "modelo/Mensagem.php";

$id = fnDecrypt($_REQUEST['i_idmemorando']);
$mensagem = new Mensagem();
if ((new documentoDAO())->deleteMemorando($id)) {
    $mensagem->set_mensagemSucesso("Memorando removido com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>
