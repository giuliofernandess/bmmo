<?php

require_once BASE_PATH . 'app/Models/Instrument.php';

class InstrumentsDAO
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }
    /**
     * Retorna todos os instrumentos do banco, ordenados por id.
     *
     * @param bool $voiceOff Booleano que seleciona a consulta com in 
     * @param bool $musicalScore Booleano que verifica se o método vai ser chamado para uma partitura ou não
     * @return array Array de instrumentos (cada instrumento é um array associativo)
     */

    public function getAll(bool $voiceOff = false, bool $musicalScore = false): array
    {
        $db = $this->conn;

        $sql = "SELECT * FROM instruments";

        if ($voiceOff) {
            $sql .= " WHERE instrument_id IN (5,8,11,14,17,20)";
        } elseif ($musicalScore) {
            $sql .= " WHERE instrument_id >= 2";
        }

        $sql .= " ORDER BY instrument_id";

        $stmt = $db->prepare($sql);
        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $instrumentsList = [];

        while ($row = $result->fetch_assoc()) {
            $instrumentsList[] = Instrument::fromArray($row)->toArray();
        }

        $stmt->close();

        return $instrumentsList;
    }
}
