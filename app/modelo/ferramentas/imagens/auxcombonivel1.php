<?php
require_once APP_DIR . "modelo/comboboxes/ComboBoxDescritores.php";
//TODO Mover isso para a classe ComboBoxDescritores
$combobox = new ComboBoxDescritores();
$codigo = $combobox->montarDescritorPrimeiroNivel();
echo $codigo;