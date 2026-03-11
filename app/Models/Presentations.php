<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class Presentations
{

    /**
     * Insere uma nova apresentação no banco de dados.
     * 
     * @return bool Booleano (true, false)
     */

    public static function createPresentation(array $presentationInfo): bool
    {
        $db = Database::getConnection();

        $db->begin_transaction();

        // Sanitização dos dados
        $name = htmlspecialchars(trim($presentationInfo['name']));
        $date = htmlspecialchars(trim($presentationInfo['date']));
        $hour = $presentationInfo['hour'];
        $local = htmlspecialchars(trim($presentationInfo['local']));

        // Inserção no bando de dados
        try {

            $stmt = $db->prepare("INSERT INTO presentations ('presentation_name', 'presentation_date', 'presentation_hour', 'local_of_presentation') VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $date, $hour, $local);

            $success = $stmt->execute();

            $db->commit();

            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Retorna todas as apresenações do banco, ordenadas por data de publicação descendente.
     *
     * @return array Array de apresenações (cada apresentação é um array associativo)
     */

    public static function getAll(): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM presentations ORDER BY presentation_date ASC, presentation_hour ASC";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $presentationsList = [];

        while ($res = $result->fetch_assoc()) {
            $presentationsList[] = $res;
        }

        $stmt->close();

        return $presentationsList;
    }
}
