<?php
require_once BASE_PATH . "app/Models/News.php";
require_once BASE_PATH . "app/Repositories/NewsRepository.php";
require_once "UploadFileService.php";

class NewsService
{
    private NewsRepository $repo;

    public function __construct()
    {
        $this->repo = new NewsRepository();
    }

    public function create(array $data, array $files): bool
    {
        if (empty($data['title']) || empty($data['subtitle']) || empty($data['description'])) {
            throw new Exception("Dados incompletos");
        }

        $image = UploadFileService::uploadNewsImage($files);

        $news = new News();
        $news->setTitle($data['title']);
        $news->setSubtitle($data['subtitle'] ?? '');
        $news->setDescription($data['description']);
        $news->setImage($image);

        return $this->repo->save($news);
    }

    public function getAll(): array
    {
        return $this->repo->getAll();
    }

    public function findById(int $id): News|null
    {
        return $this->repo->findById($id);
    }

    public function getLatestExcept(int $id): array
    {
        return $this->repo->getLatestExcept($id);
    }
    
}
