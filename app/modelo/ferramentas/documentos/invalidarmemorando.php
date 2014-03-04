<?php

require_once APP_LOCATION . "modelo/Mensagem.php";

 $id = fnDecrypt($_REQUEST['i_idmemorando']);
$mensagem = new Mensagem();
if ((new documentoDAO())->invalidarMemorando($id)) {
    $mensagem->set_mensagemSucesso("Memorando invalidado com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao excluir");
}
echo json_encode($mensagem);
?>
