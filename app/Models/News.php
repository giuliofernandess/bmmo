<?php

// Classe de conexão POO
require_once BASE_PATH . 'app/Database/Database.php';

class News
{
    /**
     * Retorna todas as notícias do banco, ordenadas por data de publicação descendente.
     *
     * @return array Array de notícias (cada notícia é um array associativo)
     */
    public static function getAll(): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM news ORDER BY publication_date DESC";
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

        $sql = "SELECT * FROM news WHERE news_id != ? ORDER BY publication_date DESC LIMIT ?";
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

        return $newsList;
    }
}
