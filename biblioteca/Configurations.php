<?php

if (!defined("APP_CONFIGS")) {
    define("APP_CONFIGS", "SETTED");

    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/");
    define("APP_LOCATION", ROOT."app/");

    define("WEB_SERVER_NAME", "http://localhost/controle-cead/");

    define("DATABASE_SERVER_IP", "127.0.0.1");
    define("DATABASE_SERVER_DBNAME", "controleCead");
    define("DATABASE_SERVER_USER", "root");
    define("DATABASE_SERVER_PASSWORD", "");
    
    define("BIBLIOTECA_DIR",ROOT."biblioteca/");
}
?>
