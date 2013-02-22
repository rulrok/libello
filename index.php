<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php

require 'Includes/Mvc/CarregadorAutomatico.php';
require 'Includes/Mvc/Mvc.php';

CarregadorAutomatico::registrar();
Mvc::pegarInstancia()->rodar();
?>


