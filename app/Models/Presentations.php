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
        $name = trim($presentationInfo['name']);
        $date = $presentationInfo['date'];
        $hour = $presentationInfo['hour'];
        $local = trim($presentationInfo['local']);
        $musicGroups = $presentationInfo['groups'];
        $songGroups = $presentationInfo['songs'];

        // Inserção no bando de dados
        try {

            $stmt = $db->prepare("INSERT INTO presentations (presentation_name, presentation_date, presentation_hour, local_of_presentation) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $date, $hour, $local);

            $stmt->execute();

            $presentationId = $db->insert_id;

            $stmt->close();

            // Inserir grupos
            $stmtGroups = $db->prepare(
                "INSERT INTO presentations_groups (presentation_id, group_id) VALUES (?, ?)"
            );

            $stmtGroups->bind_param("ii", $presentationId, $groupId);

            foreach ($musicGroups as $group => $groupId) {

                $groupId = (int) $groupId;

                if (!$stmtGroups->execute()) {
                    throw new Exception("Erro ao vincular grupo.");
                }
            }

            $stmtGroups->close();

            //Inserir Músicas
            $stmtSongs = $db->prepare(
                "INSERT INTO presentations_songs (presentation_id, song_id) VALUES (?, ?)"
            );

            $stmtSongs->bind_param("ii", $presentationId, $songId);

            foreach ($songGroups as $song => $songId) {

                $songId = (int) $songId;

                if (!$stmtSongs->execute()) {
                    throw new Exception("Erro ao vincular grupo.");
                }
            }

            $stmtSongs->close();

            $db->commit();

            return true;
        } catch (\Exception $e) {
            $db->rollback();
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
