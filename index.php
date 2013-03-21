<?php
    require_once 'biblioteca/Configurations.php';
require_once 'biblioteca/Mvc/CarregadorAutomatico.php';
require_once 'biblioteca/Mvc/Mvc.php';


CarregadorAutomatico::registrar();
Mvc::pegarInstancia()->rodar();
?>


