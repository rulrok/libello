<?php

if (!defined("APP_CONFIGS")) {
    define("APP_CONFIGS", "SETTED");

    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/");
    define("APP_LOCATION", ROOT."app/");

    define("WEB_SERVER_NAME", "http://localhost/controle-cead/");

    define("DATABASE_SERVER_IP", "127.0.0.1");
    define("DATABASE_SERVER_DBNAME", "novo_controle_cead");
    define("DATABASE_SERVER_USER", "root");
    define("DATABASE_SERVER_PASSWORD", "");
    
    define("SMTP_SERVER_IP", "200.131.224.99");
    define("SMTP_SERVER_PORT", "587");
    define("SMTP_SERVER_PASSWORD", "CeAd-N000");
    define("SMTP_SERVER_EMAIL", "cead-noreply@unifal-mg.edu.br");
    
    define("BIBLIOTECA_DIR",ROOT."biblioteca/");
}
?>
