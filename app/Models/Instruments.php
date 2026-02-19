<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class Instruments
{
    /**
     * Retorna todos os instrumentos do banco, ordenados por id.
     *
     * @param bool $instrumentsVoiceOff Booleano (true, false), define se vai ser imprimido os instrumentos sem vozes ou não. 
     * @return array Array de instrumentos (cada instrumento é um array associativo)
     */

    public static function getAll(bool $instrumentsVoiceOff = false): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM instruments";

        if (!$instrumentsVoiceOff)
            $sql .= " WHERE instrument_id <= 3 or instrument_id >= 10";            

        $sql .= " ORDER BY instrument_id";

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
