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
        $instrument = (int)$musicInfo['instrument'] ?? null;
        $bandGroups = (int)$musicInfo['band_groups'] ?? null;
        $musicalGenre = htmlspecialchars(trim($musicInfo['musical_genre'] ?? null));
        $file = htmlspecialchars(trim($musicInfo['file'] ?? null));

        // Inserção no bando de dados
        try {

            $stmt = $db->prepare(
                "INSERT INTO musical_scores (music_name, instrument, band_groups, musical_genre, file) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("siiss", $musicName, $instrument, $bandGroups, $musicalGenre, $file);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            $db->close();
            return false;
        }
    }

    /**
     * Retorna todas as notícias do banco, ordenadas por data de publicação descendente.
     *
     * @return array Array de notícias (cada notícia é um array associativo)
     */

    public static function getAll(): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM news ORDER BY publication_date DESC, publication_hour DESC";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $newsList = [];

        while ($res = $result->fetch_assoc()) {
            $newsList[] = $res;
        }

        return $newsList;
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
