<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class Presentations
{

    /**
     * Insere uma nova apresentação no banco de dados.
     * 
     * @param array $presentationInfo Array de informações da apresentação
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
                    throw new Exception("Erro ao vincular música.");
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
     * Insere uma nova apresentação no banco de dados.
     * 
     * @param array $presentationInfo Array de informações da apresentação
     * @return bool Booleano (true, false)
     */

    public static function editPresentation(array $presentationInfo): bool
    {
        $db = Database::getConnection();

        $db->begin_transaction();

        // Sanitização dos dados
        $presentationId = (int) $presentationInfo["id"];
        $name = trim($presentationInfo['name']);
        $date = $presentationInfo['date'];
        $hour = $presentationInfo['hour'];
        $local = trim($presentationInfo['local']);
        $musicGroups = $presentationInfo['groups'];
        $songGroups = $presentationInfo['songs'];

        // Inserção no bando de dados
        try {

            $stmt = $db->prepare("UPDATE presentations SET presentation_name = ?, presentation_date = ?, presentation_hour = ?, local_of_presentation = ? WHERE presentation_id = ?");
            $stmt->bind_param("ssssi", $name, $date, $hour, $local, $presentationId);

            $stmt->execute();

            $stmt->close();

            // Limpar grupos e músicas
            $stmtDeleteGroups = $db->prepare("DELETE FROM presentations_groups WHERE presentation_id = ?");
            $stmtDeleteGroups->bind_param("i", $presentationId);
            $stmtDeleteGroups->execute();
            $stmtDeleteGroups->close();

            $stmtDeleteSongs = $db->prepare("DELETE FROM presentations_songs WHERE presentation_id = ?");
            $stmtDeleteSongs->bind_param("i", $presentationId);
            $stmtDeleteSongs->execute();
            $stmtDeleteSongs->close();

            // Editar grupos
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
                    throw new Exception("Erro ao vincular música.");
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
     * Apaga uma partitura do banco de dados quando a data da mesma é menor que a data de hoje.
     *
     */

    public static function automaticallyDelete(): void
    {
        $db = Database::getConnection();

        $today = (new DateTime())->format('Y-m-d');

        $sql = "DELETE FROM presentations WHERE presentation_date < '$today'";
        $stmt = $db->prepare($sql);

        $stmt->execute();

        $stmt->close();
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

    /**
     * Retorna todas os grupos referidos a uma apresentação.
     * 
     * @param int $presentationId ID da apresentação
     * @return array Array contendo todos os nomes dos grupos relacionados a um id
     */

    public static function getPresentationGroups(int $presentationId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT pg.group_id, bg.group_name FROM presentations_groups AS pg 
        JOIN band_groups AS bg ON pg.group_id = bg.group_id
        WHERE pg.presentation_id = ?");
        $stmt->bind_param('i', $presentationId);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $groupsList = [];

        while ($res = $result->fetch_assoc()) {
            $groupsList[] = $res;
        }

        $stmt->close();

        return $groupsList;
    }

    /**
     * Retorna todas os grupos referidos a uma apresentação.
     * 
     * @param int $presentationId ID da apresentação
     * @return array Array contendo todos os nomes dos grupos relacionados a um id
     */

    public static function getPresentationSongs(int $presentationId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT ps.song_id, ms.music_name FROM presentations_songs AS ps 
        JOIN musical_scores AS ms ON ps.song_id = ms.music_id
        WHERE ps.presentation_id = ?");
        $stmt->bind_param('i', $presentationId);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $songsList = [];

        while ($res = $result->fetch_assoc()) {
            $songsList[] = $res;
        }

        $stmt->close();

        return $songsList;
    }
}
