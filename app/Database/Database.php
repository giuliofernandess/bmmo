<?php

class Database
{
    
    private static ?mysqli $connection = null;

    





    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            
            self::$connection = new mysqli('localhost', 'root', '', 'bmmo');

            
            if (self::$connection->connect_error) {
                die("Erro de conexão: " . self::$connection->connect_error);
            }

            
            self::$connection->set_charset('utf8mb4');
        }

        return self::$connection;
    }
}
