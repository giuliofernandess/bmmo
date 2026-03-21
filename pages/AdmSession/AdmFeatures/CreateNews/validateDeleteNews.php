<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Models/News.php';

$newsId = (int)($_GET['news_id'] ?? 0);

if ($newsId <= 0) {
    $_SESSION['error'] = "Notícia inválida.";
    header("Location: createNews.php");
    exit;
}

$news = News::getById($newsId);

if (!$news) {
    $_SESSION['error'] = "Notícia não encontrada.";
    header("Location: createNews.php");
    exit;
}

if (News::deleteNews($newsId)) {
    if (!empty($news['news_image'])) {
        $uploadDir = BASE_PATH . 'uploads/news-images/';
        $path = $uploadDir . basename($news['news_image']);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    $_SESSION['success'] = "Notícia removida com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao remover a notícia. Tente novamente.";
}

header("Location: createNews.php");
exit;
