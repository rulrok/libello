<?php

require_once APP_DIR . "modelo/Mensagem.php";

 
 $id = fnDecrypt($_REQUEST['i_idoficio']);
$mensagem = new Mensagem();

if ((new documentoDAO())->validarOficio($id)) {
    $mensagem->set_mensagemSucesso("Ofício gerado com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao gerar ofício");
}
echo json_encode($mensagem);
?>