<?php

//Manter essas duas linhas durante a fase de desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!defined("APP_CONFIGS")) {
    define("APP_CONFIGS", "SETTED");

    define("APP_VERSION", "Alpha");

    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/");
    define("APP_LOCATION", ROOT . "app/");

    define("WEB_SERVER_FOLDER", "controle-cead/");
    define("WEB_SERVER_ADDRESS", "http://172.16.11.1:8888/" . WEB_SERVER_FOLDER);

    define("DATABASE_SERVER_IP", "127.0.0.1");
    define("DATABASE_SERVER_PORT", "3307");
    define("DATABASE_SERVER_DBNAME", "novo_controle_cead");
    define("DATABASE_SERVER_USER", "root");
    define("DATABASE_SERVER_PASSWORD", "root");

    define("SMTP_SERVER_IP", "200.131.224.99");
    define("SMTP_SERVER_PORT", "587");
    define("SMTP_SERVER_PASSWORD", "CeAd-N000");
    define("SMTP_SERVER_EMAIL", "cead-noreply@unifal-mg.edu.br");

    define('APP_TIME_ZONE', 'America/Sao_Paulo');

    define("BIBLIOTECA_DIR", ROOT . "biblioteca/");

    define("APP_TEMP_DIR", "privado/temp/");

    define("SECRET", md5("controleCEAD@2013"));
}
?>
