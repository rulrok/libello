<?php

//Manter essas duas linhas durante a fase de desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!defined("APP_CONFIGS")) {
    define("APP_CONFIGS", "SETTED");

    define("APP_VERSION", "Alpha");

    define("WEB_SERVER_FOLDER", "controle-cead/");
    define("WEB_SERVER_ADDRESS", "http://localhost/" . WEB_SERVER_FOLDER);

    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/" . WEB_SERVER_FOLDER);
    define("APP_LOCATION", ROOT . "app/");


    define("DATABASE_SERVER_IP", "127.0.0.1");
    define("DATABASE_SERVER_PORT", "3306");
    define("DATABASE_SERVER_DBNAME", "novo_controle_cead");
    define("DATABASE_SERVER_USER", "root");
    define("DATABASE_SERVER_PASSWORD", "root");

    define("SMTP_SERVER_IP", "200.131.224.99");
    define("SMTP_SERVER_PORT", "587");
    define("SMTP_SERVER_PASSWORD", "CeAd-N000");
    define("SMTP_SERVER_EMAIL", "cead-noreply@unifal-mg.edu.br");

    define('APP_TIME_ZONE', 'America/Sao_Paulo');

    define("BIBLIOTECA_DIR", ROOT . "biblioteca/");

    define("APP_PRIVATE_DIR", ROOT . "privado/");
    define("APP_TEMP_DIR", APP_PRIVATE_DIR . "temp/");

    define("SECRET", md5("controleCEAD@2013"));
}
?>
