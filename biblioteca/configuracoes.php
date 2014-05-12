<?php

/*
 * Justificativa para usar defines ao invés de variáveis para o arquivo de configuração:
 * http://stackoverflow.com/questions/1225082/define-vs-variable-in-php 
 */
if (!defined("APP_CONFIGS")) {
    define('APP_CONFIGS', "SETTED");

    define('APP_NAME', 'Libello');

    define('APP_DESCRIPTION', 'Gestor CEAD');
    
    define('APP_COPYRIGHT', 'Copyright &copy; 2012 - 2014');

    define('APP_VERSION', "Alpha");

    define('APP_ADMIN_EMAIL', 'a11021@bcc.unifal-mg.edu.br');

    define('APP_SUPPORT_EMAIL', 'suporte@orglibello.unifal-mg.edu.br');
   
    /**
     * O novo da pasta de contém este programa instalado
     */
    define('WEB_SERVER_FOLDER', "libello");
    /**
     * Endereço pelo qual o acesso deverá ser feito ao programa
     */
    define('WEB_SERVER_ADDRESS', 'http://localhost/' . WEB_SERVER_FOLDER . '/');

    define('DATABASE_SERVER_IP', "127.0.0.1");
    define('DATABASE_SERVER_PORT', "3306");
    define('DATABASE_SERVER_DBNAME', "novo_controle_cead");
    define('DATABASE_SERVER_USER', "root");
    define('DATABASE_SERVER_PASSWORD', "");

    define('SMTP_SERVER_IP', "200.131.224.99");
    define('SMTP_SERVER_PORT', "587");
    define('SMTP_SERVER_PASSWORD', "CeAd-N000");
    define('SMTP_SERVER_EMAIL', "cead-noreply@unifal-mg.edu.br");
    define('SMTP_SEND_FROM', "CEAD - NOREPLY");
    define('SMTP_SECURE_MODE', "tls");
    define('SMTP_CHARSET', "UTF-8");

    define('APP_TIME_ZONE', 'America/Sao_Paulo');
    date_default_timezone_set(APP_TIME_ZONE);

    /*
     * Endereço das pastas
     */

    /**
     * Caminho completo até a pasta contendo o programa instalado.
     */
    if (!isset($_SERVER['DOCUMENT_ROOT']) || empty($_SERVER['DOCUMENT_ROOT'])) {
        //Diretório onde os sites estão armazenados. Necessário para poder executar
        //o arquivo cron.php, que precisa deste arquivo de configurações.
        //
        //Quando uma página é requisitada através de um servidor web (pelo navegador),
        //$_SERVER['DOCUMENT_ROOT'] possui o caminho já. Quando executado pelo cron ou
        //linha de comando, não necessariamente.
        $_SERVER['DOCUMENT_ROOT'] = "/var/www";
    }
    define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/" . WEB_SERVER_FOLDER . '/');

    define('APP_DIR', ROOT . "app/");

    define('APP_LIBRARY_DIR', "biblioteca/");
    define('APP_LIBRARY_ABSOLUTE_DIR', ROOT . APP_LIBRARY_DIR);
    //Pasta privada - Configurações de acesso devem ser feitas via apache/nginx
    define('APP_PRIVATE_DIR', "privado/");
    define('APP_PRIVATE_ABSOLUTE_DIR', ROOT . APP_PRIVATE_DIR);
    //Galerias
    define('APP_GALLERY_DIR', APP_PRIVATE_DIR . 'galerias/');
    define('APP_GALLERY_ABSOLUTE_DIR', APP_PRIVATE_ABSOLUTE_DIR . 'galerias/');
    //Pasta temporária para uso geral
    define('APP_TEMP_DIR', APP_PRIVATE_DIR . 'temp/');
    define('APP_TEMP_ABSOLUTE_DIR', APP_PRIVATE_ABSOLUTE_DIR . 'temp/');

    /**
     * Variável para determinar o tamanho máximo de upload (em bytes) de um arquivo para o servidor.
     * Atualmente definido para 4MB (Medida base: 1024)
     */
    define('APP_MAX_UPLOAD_SIZE', '4194304'); //4MB
    /**
     * Segredo padrão usado para criptografar/descriptografar textos e senhas pelo programa
     */
    define('SECRET', md5("controleCEAD@2013"));
}


//Manter essas duas linhas durante a fase de desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

ini_set("log_errors", 1);
ini_set("error_log", APP_PRIVATE_ABSOLUTE_DIR . "php-error.log");
