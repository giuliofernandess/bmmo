<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class Instruments
{
    /**
     * Retorna todos os instrumentos do banco, ordenados por id.
     *
     * @return array Array de instrumentos (cada instrumento é um array associativo)
     */

    public static function getAll(): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM instruments ORDER BY instrument_id";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $instrumentsList = [];

        while ($row = $result->fetch_assoc()) {
            $instrumentsList[] = $row;
        }

        $stmt->close();

        return $instrumentsList;
    }
}
