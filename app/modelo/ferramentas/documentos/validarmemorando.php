<?php

require_once APP_DIR . "modelo/Mensagem.php";

 
 $id = fnDecrypt($_REQUEST['i_idmemorando']);
$mensagem = new Mensagem();

if ((new documentoDAO())->validarMemorando($id)) {
    $mensagem->set_mensagemSucesso("Memorando gerado com sucesso.");
} else {
    $mensagem->set_mensagemErro("Erro ao gerar memorando");
}
echo json_encode($mensagem);
?>
