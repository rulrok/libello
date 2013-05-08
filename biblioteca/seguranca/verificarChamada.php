<?php

/*
 * Esse arquivo será incluso ao inicio de todos os demais arquivos,
 * via configuração apache, para evitar que os arquivos dentro da
 * pasta 'app' sejam chamados diretamente, sem o MVC como intermediário.
 */

require_once __DIR__ . '/seguranca.php';


if (substr_count('/var/www' . $_SERVER['REQUEST_URI'], APP_LOCATION) > 0) {
    if ($_SERVER['SCRIPT_FILENAME'] == '/var/www' . $_SERVER['PHP_SELF']) {
        //arquivo está sendo chamado diretamente
        expulsaVisitante();
    }
}
?>
