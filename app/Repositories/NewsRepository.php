<?php
require_once BASE_PATH . 'app/Database/Database.php';

class NewsRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function save(News $news): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO news 
            (news_title, news_subtitle, news_image, news_description, publication_date, publication_hour) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssss",
            $news->getTitle(),
            $news->getSubtitle(),
            $news->getImage(),
            $news->getDescription(),
            $news->getDate(),
            date('H:i:s')
        );

        return $stmt->execute();
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT * FROM news ORDER BY publication_date DESC");

        $list = [];

        while ($row = $result->fetch_assoc()) {
            $news = new News();
            $news->hydrate($row);
            $list[] = $news;
        }

        return $list;
    }

    public function findById(int $id): ?News
    {
        $stmt = $this->db->prepare("SELECT * FROM news WHERE news_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $res = $stmt->get_result()->fetch_assoc();

        if (!$res)
            return null;

        $news = new News();
        $news->hydrate($res);

        return $news;
    }

    public function getLatestExcept(int $excludeId, int $limit = 2): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM news WHERE news_id != ? ORDER BY publication_date DESC LIMIT ?"
        );

        $stmt->bind_param("ii", $excludeId, $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        $list = [];

        while ($row = $result->fetch_assoc()) {
            $news = new News();
            $news->hydrate($row);
            $list[] = $news;
        }

        return $list;
    }
}
