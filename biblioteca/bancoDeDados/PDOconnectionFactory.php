<?php

include_once __DIR__.'/../Configurations.php';

class PDOconnectionFactory {

    static $connection = null;

    private function __construct() {
        
    }

    public static function getConection() {

        if (self::$connection === null) {
            try {
                self::$connection = new PDO('mysql:host=' . DATABASE_SERVER_IP . ';dbname=' . DATABASE_SERVER_DBNAME, DATABASE_SERVER_USER, DATABASE_SERVER_PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                print_r($e);
                exit;
            }
        }
        return self::$connection;
    }

}

?>
