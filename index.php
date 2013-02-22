<?php

require 'biblioteca/Mvc/CarregadorAutomatico.php';
require 'biblioteca/Mvc/Mvc.php';

CarregadorAutomatico::registrar();
Mvc::pegarInstancia()->rodar();
?>


