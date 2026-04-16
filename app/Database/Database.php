<?php

class Database
{
    private ?mysqli $connection = null;

    





    public function getConnection(): mysqli
    {
        if ($this->connection === null) {
            $this->connection = new mysqli('localhost', 'root', '', 'bmmo');

            if ($this->connection->connect_error) {
                die("Erro de conexão: " . $this->connection->connect_error);
            }

            $this->connection->set_charset('utf8mb4');
        }

        return $this->connection;
    }
}
