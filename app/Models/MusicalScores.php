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

            return $musicId;

        } catch (\Exception $e) {

            $db->rollback();
            return false;
        }
    }

    /**
     * Retorna todos as partituras do banco, selecionados por grupos da banda, gênero ou os dois e * ordenados pelos mesmos.
     *
     * @param string $musicName nome da partitura
     * @param int $bandGroup grupo da banda
     * @param string $musicGenre gênero da partitura
     * @return array Array de músicos (cada músico é um array associativo)
     */

    public static function getAll(string $musicName = '', int $bandGroup = 0, string $musicGenre = ''): array
    {
        $db = Database::getConnection();

        $sql = "SELECT ms.*, msg.group_id 
            FROM musical_scores ms
            LEFT JOIN musical_scores_groups msg ON ms.music_id = msg.music_id";

        $conditions = [];
        $params = [];
        $types = "";

        if ($musicName !== '') {
            $conditions[] = "ms.music_name LIKE ?";
            $params[] = "%$musicName%";
            $types .= "s";
        }

        if ($musicGenre !== '') {
            $conditions[] = "ms.music_genre = ?";
            $params[] = $musicGenre;
            $types .= "s";
        }

        if ($bandGroup > 0) {
            $conditions[] = "msg.group_id = ?";
            $params[] = $bandGroup;
            $types .= "i";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY ms.music_genre, ms.music_name";

        $stmt = $db->prepare($sql);
        if (!$stmt) {
            return [];
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $musicsList = [];

        while ($row = $result->fetch_assoc()) {
            $musicsList[] = $row;
        }

        $stmt->close();

        return $musicsList;
    }

    /**
     * Retorna uma partitura específica pelo ID.
     *
     * @param int $musicId ID da partitura
     * @return array|null Array associativo com os dados ou null se não encontrado
     */
    public static function getById(int $musicId): ?array
    {
        $db = Database::getConnection();

        $sql = "SELECT ms.music_name, ms.music_genre, msg.music_id, msg.group_id, bg.group_id, bg.group_name 
        FROM musical_scores AS ms
        JOIN musical_scores_groups AS msg ON ms.music_id = msg.music_id
        JOIN band_groups AS bg ON msg.group_id = bg.group_id
        WHERE ms.music_id = ?"; 
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $musicId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;

    }

    /**
     * Verifica se existe determinado grupo de acordo com o id da música.
     *
     * @param int $musicId ID da partitura
     * @param int $groupId ID do grupo
     * @return bool Booleano(true, false)
     */
    public static function verifyGroup(int $musicId, int $groupId): ?bool
    {

        $db = Database::getConnection();

        $sql = "SELECT * FROM musical_scores_groups WHERE music_id = ? and group_id = ?"; 
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("ii", $musicId, $groupId);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if ($result -> num_rows == 0) {
            return false;
        } else {
            return true;
        }
        
    }
}
