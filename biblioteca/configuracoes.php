<?php

//Manter essas duas linhas durante a fase de desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!defined("APP_CONFIGS")) {
    define('APP_CONFIGS', "SETTED");

    define('APP_NAME', 'Controle-cead');

    define('APP_COPYRIGHT', 'Copyright &copy; 2012 - 2014');

    define('APP_VERSION', "Alpha");

    /**
     * O novo da pasta de contém este programa instalado
     */
    define('WEB_SERVER_FOLDER', "controle-cead");
    /**
     * Endereço pelo qual o acesso deverá ser feito ao programa
     */
    define('WEB_SERVER_ADDRESS', 'http://localhost/' . WEB_SERVER_FOLDER . '/');

    /**
     * Caminho completo até a pasta contendo o programa instalado
     */
    define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/" . WEB_SERVER_FOLDER . '/');


    define('DATABASE_SERVER_IP', "127.0.0.1");
    define('DATABASE_SERVER_PORT', "3306");
    define('DATABASE_SERVER_DBNAME', "novo_controle_cead");
    define('DATABASE_SERVER_USER', "root");
    define('DATABASE_SERVER_PASSWORD', "");

    define('SMTP_SERVER_IP', "200.131.224.99");
    define('SMTP_SERVER_PORT', "587");
    define('SMTP_SERVER_PASSWORD', "CeAd-N000");
    define('SMTP_SERVER_EMAIL', "cead-noreply@unifal-mg.edu.br");

    define('APP_TIME_ZONE', 'America/Sao_Paulo');

    /*
     * Endereço das pastas
     */

    define('APP_DIR', ROOT . "app/");
    define('BIBLIOTECA_DIR', ROOT . "biblioteca/");
    define('APP_PRIVATE_DIR', "privado/");
    define('APP_GALLERY_DIR', APP_PRIVATE_DIR . 'galerias/');
    define('APP_TEMP_DIR', APP_PRIVATE_DIR . 'temp/');

    /**
     * Variável para determinar o tamanho máximo de upload (em bytes) de um arquivo para o servidor.
     */
    define('APP_MAX_UPLOAD_SIZE', '4194304'); //4MB
    /**
     * Segredo padrão usado para criptografar/descriptografar textos e senhas pelo programa
     * !ATENÇÃO!
     * Se alterado após o primeiro uso do sistema, o funcionamento correto estará comprometido
     */
    define('SECRET', md5("controleCEAD@2013"));
}
?>
