<?php

class PDOconnectionFactory {

    static $connection = null;

    private function __construct() {
        
    }

    public static function getConection() {

        if (self::$connection === null) {
            try {
                self::$connection = new PDO('mysql:host=127.0.0.1;dbname=controleCead', 'root', '');
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
