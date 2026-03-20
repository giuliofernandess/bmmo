<?php
require_once BASE_PATH . "app/Services/NewsService.php";
require_once BASE_PATH . "app/Repositories/NewsRepository.php";

class NewsController
{
    private NewsService $service;
    private NewsRepository $repo;

    public function __construct()
    {
        $this->service = new NewsService();
        $this->repo = new NewsRepository();
    }

    public function store()
    {
        session_start();

        try {
            $this->service->create($_POST, $_FILES);
            $_SESSION['success'] = "Notícia criada com sucesso";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/CreateNews/createNews.php");
    }

    public function index()
    {
        return $this->repo->getAll();
    }

    public function show($id)
    {
        return $this->repo->findById($id);
    }

    public function latestExcept($id)
    {
        return $this->repo->getLatestExcept($id);
    }
}
