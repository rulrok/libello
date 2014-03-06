<?php
require_once APP_DIR . "modelo/comboboxes/ComboBoxDescritores.php";

$combobox = new ComboBoxDescritores();
$codigo = $combobox->montarDescritorPrimeiroNivel();
echo $codigo;