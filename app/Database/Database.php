<?php

class Database
{
    // Instância da conexão
    private static ?mysqli $connection = null;

    /**
     * Retorna a conexão ativa com o banco.
     * Se não existir, cria uma nova conexão.
     *
     * @return mysqli
     */
    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            // Conexão com MySQL
            self::$connection = new mysqli('localhost', 'root', '', 'bmmo');

            // Verifica erro de conexão
            if (self::$connection->connect_error) {
                die("Erro de conexão: " . self::$connection->connect_error);
            }

            // Configura charset UTF-8
            self::$connection->set_charset('utf8mb4');
        }

        return self::$connection;
    }

    /**
     * Fecha a conexão com o banco.
     * Opcional, normalmente não é necessário no final do script.
     */
    public static function closeConnection(): void
    {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}
