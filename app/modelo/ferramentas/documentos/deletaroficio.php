<?php

require_once APP_DIR . "modelo/Mensagem.php";

 $id = fnDecrypt($_REQUEST['i_idoficio']);
$mensagem = new Mensagem();
if ((new documentoDAO())->deleteOficio($id)) {
    $mensagem->set_mensagemSucesso("Oficio removido com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>