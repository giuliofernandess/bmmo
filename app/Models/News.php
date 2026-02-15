<?php

require_once BASE_PATH . 'app/Database/Database.php';

class News
{
    public int $id;
    public string $title;
    public string $subtitle;
    public string $description;
    public string $image;
    public string $publicationDate;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['news_id'] ?? 0);
        $this->title = $data['news_title'] ?? '';
        $this->subtitle = $data['news_subtitle'] ?? '';
        $this->description = $data['news_description'] ?? '';
        $this->image = $data['news_image'] ?? '';
        $this->publicationDate = $data['publication_date'] ?? '';
    }

    // Métodos de Banco (SQL)

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

        while ($row = $result->fetch_assoc()) {
            $newsList[] = new News($row);
        }

        return $newsList;
    }

    public static function getById(int $id): ?News
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM news WHERE news_id = ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            return null;
        }

        return new News($row);
    }

    public static function getOtherNews(int $currentId, int $limit = 2): array
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM news WHERE news_id != ? ORDER BY publication_date DESC LIMIT ?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("ii", $currentId, $limit);
        $stmt->execute();

        $result = $stmt->get_result();

        $newsList = [];

        while ($row = $result->fetch_assoc()) {
            $newsList[] = new News($row);
        }

        return $newsList;
    }

    // Métodos auxiliares
    public function getSafeTitle(): string
    {
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }

    public function getSafeSubtitle(): string
    {
        return htmlspecialchars($this->subtitle, ENT_QUOTES, 'UTF-8');
    }

    public function getSafeDescription(): string
    {
        return nl2br(htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8'));
    }

    public function getSafeImage(): string
    {
        return htmlspecialchars(basename($this->image), ENT_QUOTES, 'UTF-8');
    }

    public function getFormattedDate(): string
    {
        if (empty($this->publicationDate)) {
            return '';
        }

        return date('d/m/Y', strtotime($this->publicationDate));
    }
}
