<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class MusicalScores
{
    /**
     * Insere uma nova partitura no banco de dados.
     * 
     * @return bool Booleano (true, false)
     */

    public static function musicalScoreCreate(array $musicInfo): bool
    {
        $db = Database::getConnection();

        // Sanitização dos dados
        $musicName = htmlspecialchars(trim($musicInfo['music_name'] ?? null));
        $instrument = (int) $musicInfo['instrument'] ?? null;
        $bandGroups = htmlspecialchars(($musicInfo['band_groups']));
        $musicalGenre = htmlspecialchars(trim($musicInfo['musical_genre'] ?? null));
        $file = htmlspecialchars(trim($musicInfo['file'] ?? null));

        // Inserção no bando de dados
        try {

            $stmt = $db->prepare(
                "INSERT INTO musical_scores (music_name, instrument, band_groups, musical_genre, file) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("sisss", $musicName, $instrument, $bandGroups, $musicalGenre, $file);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            $db->close();
            return false;
        }
    }

    /**
     * Retorna todas as partituras do banco, ordenadas por gênero e nome.
     *
     * @param string $musicName nome da música
     * @param string $bandGroup grupo da banda
     * @param string $musicalGenre gênero da música
     * @return array Array de partituras (cada partitura é um array associativo)
     */

    public static function getAll(string $musicianName = '', string $bandGroup = '', string $musicalGenre = ''): array
    {
        $db = Database::getConnection();

        $sql = "SELECT music_name, band_groups, musical_genre FROM musical_scores";
        $conditions = [];
        $params = [];
        $types = "";

        if ($musicianName !== '') {
            $conditions[] = "music_name LIKE ?";
            $params[] = "%$musicianName%";
            $types .= "s";
        }

        if ($bandGroup !== '') {
            $conditions[] = "FIND_IN_SET(?, band_groups)";
            $params[] = $bandGroup;
            $types .= "s";
        }

        if ($musicalGenre !== '') {
            $conditions[] = "musical_genre = ?";
            $params[] = $musicalGenre;
            $types .= "s";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY musical_genre, music_name";

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
        $musicalScores = [];

        while ($row = $result->fetch_assoc()) {
            $musicalScores[] = $row;
        }

        $stmt->close();

        return $musicalScores;
    }

    /**
     * Retorna uma notícia específica pelo ID.
     *
     * @param int $newsId ID da notícia
     * @return array|null Array associativo com os dados ou null se não encontrado
     */
    public static function getById(int $newsId): ?array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM news WHERE news_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $newsId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;
    }

    /**
     * Retorna as últimas N notícias, exceto a notícia passada por parâmetro.
     * Útil para “outras notícias” na página expandida.
     *
     * @param int $excludeId ID da notícia a excluir
     * @param int $limit Quantidade de notícias a retornar
     * @return array Array de notícias
     */
    public static function getLatestExcept(int $excludeId, int $limit = 2): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM news WHERE news_id != ? ORDER BY publication_date, publication_hour DESC LIMIT ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("ii", $excludeId, $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        $newsList = [];

        while ($res = $result->fetch_assoc()) {
            $newsList[] = $res;
        }

        $stmt->close();

        return $newsList;
    }
}
