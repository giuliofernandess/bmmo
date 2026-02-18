<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class BandGroups
{
    /**
     * Retorna todos os grupos da banda do banco, ordenados por id.
     *
     * @return array Array de grupos (cada grupo é um array associativo)
     */

    public static function getAll(): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM band_groups ORDER BY group_id";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $groupsList = [];

        while ($row = $result->fetch_assoc()) {
            $groupsList[] = $row;
        }

        $stmt->close();

        return $groupsList;
    }
}
