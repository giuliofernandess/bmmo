<?php

require_once BASE_PATH . 'app/Models/EntityInterface.php';
require_once BASE_PATH . 'app/Models/News.php';

class NewsDAO implements EntityInterface
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }
    /**
     * Cria uma notícia.
     */

    public function create(object $entity): mixed
    {
        $db = $this->conn;

        if (!$entity instanceof News) {
            return false;
        }

        $newsEntity = $entity;

        // Normaliza dados recebidos antes do INSERT.
        $title = $newsEntity->getNewsTitle();
        $subtitle = $newsEntity->getNewsSubtitle();
        $image = $newsEntity->getNewsImage();
        $description = $newsEntity->getNewsDescription();
        $date = $newsEntity->getPublicationDate();
        $hour = $newsEntity->getPublicationHour();

        // Persiste notícia no banco.
        try {

            $stmt = $db->prepare(
                "INSERT INTO news (news_title, news_subtitle, news_image, news_description, publication_date, publication_hour) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("ssssss", $title, $subtitle, $image, $description, $date, $hour);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Lista notícias em ordem de publicação (mais recentes primeiro).
     */

    public function getAll(array $filters = []): array
    {
        $db = $this->conn;

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

        $stmt->close();

        return $newsList;
    }

    /**
     * Busca uma notícia por ID.
     */
    public function getById(int $newsId): ?array
    {
        $db = $this->conn;

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
     * Atualiza uma notícia existente.
     */
    public function edit(object $entity): bool
    {
        $db = $this->conn;

        if (!$entity instanceof News) {
            return false;
        }

        $newsEntity = $entity;

        $newsId = (int) ($newsEntity->getNewsId() ?? 0);
        $title = $newsEntity->getNewsTitle();
        $subtitle = $newsEntity->getNewsSubtitle();
        $image = $newsEntity->getNewsImage();
        $description = $newsEntity->getNewsDescription();

        try {
            $stmt = $db->prepare(
                "UPDATE news SET news_title = ?, news_subtitle = ?, news_image = ?, news_description = ? WHERE news_id = ?"
            );
            $stmt->bind_param("ssssi", $title, $subtitle, $image, $description, $newsId);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remove uma notícia por ID.
     */
    public function delete(int $newsId): bool
    {
        $db = $this->conn;

        try {
            $stmt = $db->prepare("DELETE FROM news WHERE news_id = ?");
            $stmt->bind_param("i", $newsId);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Lista as últimas notícias, excluindo a notícia atual.
     */
    public function getLatestExcept(int $excludeId, int $limit = 2): array
    {
        $db = $this->conn;

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
