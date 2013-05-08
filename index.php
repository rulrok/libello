<!DOCTYPE html>
<noscript>
    <meta http-equiv="refresh" content="0;url=no-js.html" />
</noscript>

<?php
require_once 'biblioteca/Configurations.php';
require_once 'biblioteca/Mvc/CarregadorAutomatico.php';
require_once 'biblioteca/Mvc/Mvc.php';


CarregadorAutomatico::registrar();
Mvc::pegarInstancia()->rodar();
?>
