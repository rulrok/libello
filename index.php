<?php ob_start(); ?>
<?php
//Ignora a verificação do javascript caso uma requisição ajax esteja sendo feita por algum formulário.
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') :
    ?>
    <!DOCTYPE html>
    <noscript>
    <meta http-equiv="refresh" content="0;url=no-js.html" />
    </noscript>
<?php endif; ?>

<?php
require_once 'biblioteca/configuracoes.php';
require_once 'biblioteca/Mvc/CarregadorAutomatico.php';
require_once 'biblioteca/Mvc/Mvc.php';


CarregadorAutomatico::registrar();
Mvc::pegarInstancia()->rodar();
?>
