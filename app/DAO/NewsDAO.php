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
     * Cria uma noticia.
     */
    public function create(object $entity): mixed
    {
        $db = $this->conn;

        if (!$entity instanceof News) {
            return false;
        }

        $newsTitle = $entity->getNewsTitle();
        $newsSubtitle = $entity->getNewsSubtitle();
        $newsImage = $entity->getNewsImage();
        $newsDescription = $entity->getNewsDescription();
        $publicationDate = $entity->getPublicationDate();
        $publicationHour = $entity->getPublicationHour();

        try {
            $stmt = $db->prepare(
                "INSERT INTO news (news_title, news_subtitle, news_image, news_description, publication_date, publication_hour) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "ssssss",
                $newsTitle,
                $newsSubtitle,
                $newsImage,
                $newsDescription,
                $publicationDate,
                $publicationHour
            );

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Lista noticias em ordem de publicacao (mais recentes primeiro).
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
        while ($row = $result->fetch_assoc()) {
            $newsList[] = News::fromArray($row);
        }

        $stmt->close();

        return $newsList;
    }

    /**
     * Busca uma noticia por ID.
     */
    public function getById(int $newsId): ?News
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

        return $data ? News::fromArray($data) : null;
    }

    /**
     * Atualiza uma noticia existente.
     */
    public function edit(object $entity): bool
    {
        $db = $this->conn;

        if (!$entity instanceof News) {
            return false;
        }

        $newsId = (int) ($entity->getNewsId() ?? 0);
        $newsTitle = $entity->getNewsTitle();
        $newsSubtitle = $entity->getNewsSubtitle();
        $newsImage = $entity->getNewsImage();
        $newsDescription = $entity->getNewsDescription();

        try {
            $stmt = $db->prepare(
                "UPDATE news SET news_title = ?, news_subtitle = ?, news_image = ?, news_description = ? WHERE news_id = ?"
            );
            $stmt->bind_param(
                "ssssi",
                $newsTitle,
                $newsSubtitle,
                $newsImage,
                $newsDescription,
                $newsId
            );

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remove uma noticia por ID.
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
     * Lista as ultimas noticias, excluindo a noticia atual.
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

        while ($row = $result->fetch_assoc()) {
            $newsList[] = News::fromArray($row);
        }

        $stmt->close();

        return $newsList;
    }
}
