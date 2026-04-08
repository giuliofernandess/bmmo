<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . 'pages/admin/news/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage($redirect, 'error', 'Método invalido para exclusao.');
}

$newsId = filter_input(INPUT_POST, 'news_id');

if ($newsId <= 0) {
    redirectWithMessage($redirect, 'error', 'Notícia invalida.');
}

$news = $newsDAO->getById($newsId);
if (!$news) {
    redirectWithMessage($redirect, 'error', 'Notícia não encontrada.');
}

if ($newsDAO->delete($newsId)) {
    if (!empty($news->getNewsImage())) {
        $uploadDir = BASE_PATH . 'uploads/news-images/';
        $path = $uploadDir . basename($news->getNewsImage());
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    redirectWithMessage($redirect, 'success', 'Notícia removida com sucesso!');
} else {
    redirectWithMessage($redirect, 'error', 'Erro ao remover a notícia. Tente novamente.');
}
