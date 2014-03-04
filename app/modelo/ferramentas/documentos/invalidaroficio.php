<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

$id = fnDecrypt($_REQUEST['i_idoficio']);
$mensagem = new Mensagem();
if ((new documentoDAO())->invalidarOficio($id)) {
    $mensagem->set_mensagemSucesso("Oficio invalidado com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>
