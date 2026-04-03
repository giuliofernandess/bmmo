<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';

$newsDAO = new NewsDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . 'pages/admin/news/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Message::set('error', 'Método invalido para exclusao.');
    header('Location: ' . $redirect);
    exit;
}

$newsId = (int) ($_POST['news_id'] ?? 0);

if ($newsId <= 0) {
    Message::set('error', 'Notícia invalida.');
    header('Location: ' . $redirect);
    exit;
}

$news = $newsDAO->getById($newsId);
if (!$news) {
    Message::set('error', 'Notícia não encontrada.');
    header('Location: ' . $redirect);
    exit;
}

if ($newsDAO->delete($newsId)) {
    if (!empty($news->getNewsImage())) {
        $uploadDir = BASE_PATH . 'uploads/news-images/';
        $path = $uploadDir . basename($news->getNewsImage());
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    Message::set('success', 'Notícia removida com sucesso!');
} else {
    Message::set('error', 'Erro ao remover a notícia. Tente novamente.');
}

header('Location: ' . $redirect);
exit;
