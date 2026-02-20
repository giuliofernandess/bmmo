<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class MusicalScores
{

    /**
     * Adiciona uma nova partitura ao database.
     * 
     * @param string $musicName String com o nome da partitura
     * @param string $musicGenre String com o gênero da partitura
     * @param array $musicGroups Array contendo os grupos selecionados
     * @return bool Booleano (true, false)
     */

    public static function addMusicalScore(
        string $musicName,
        string $musicGenre,
        array $musicGroups
    ): bool {

        $db = Database::getConnection();

        $db->begin_transaction();

        try {

            // Inserir partitura
            $stmt = $db->prepare(
                "INSERT INTO musical_scores (music_name, music_genre) VALUES (?, ?)"
            );

            $stmt->bind_param("ss", $musicName, $musicGenre);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir partitura.");
            }

            $musicId = $db->insert_id;

            $stmt->close();


            // Inserir grupos
            $stmtGroups = $db->prepare(
                "INSERT INTO musical_scores_groups (music_id, group_id) VALUES (?, ?)"
            );

            foreach ($musicGroups as $groupId) {

                $groupId = (int) $groupId;

                $stmtGroups->bind_param("ii", $musicId, $groupId);

                if (!$stmtGroups->execute()) {
                    throw new Exception("Erro ao vincular grupo.");
                }
            }

            $stmtGroups->close();


            // Commit final
            $db->commit();

            return true;

        } catch (\Exception $e) {

            $db->rollback();
            return false;
        }
    }
}
