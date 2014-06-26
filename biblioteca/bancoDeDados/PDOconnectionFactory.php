<?php
require_once __DIR__ . '/../configuracoes.php';

class PDOconnectionFactory {

    /**
     *
     * @var \PDO 
     */
    static $connection;

    private function __construct() {
        
    }

    /**
     * 
     * @return \PDO
     */
    public static function obterConexao() {

        try {
            static::$connection = new PDO('mysql:host=' . DATABASE_SERVER_IP . ';dbname=' . DATABASE_SERVER_DBNAME . ';port=' . DATABASE_SERVER_PORT
                    , DATABASE_SERVER_USER, DATABASE_SERVER_PASSWORD
                    , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            //print_r($e);
            die("Falha ao conectar-se ao banco de dados");
        }
        return static::$connection;
    }

}
