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
    redirectWithMessage('error', 'Método invalido para exclusao.', $redirect);
}

$newsId = (int) (postValue('news_id', 'int') ?? 0);

if ($newsId <= 0) {
    redirectWithMessage('error', 'Notícia invalida.', $redirect);
}

$news = $newsDAO->getById($newsId);
if (!$news) {
    redirectWithMessage('error', 'Notícia não encontrada.', $redirect);
}

if ($newsDAO->delete($newsId)) {
    if (!empty($news->getNewsImage())) {
        $uploadDir = BASE_PATH . 'uploads/news-images/';
        $path = $uploadDir . basename($news->getNewsImage());
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    redirectWithMessage('success', 'Notícia removida com sucesso!', $redirect);
} else {
    redirectWithMessage('error', 'Erro ao remover a notícia. Tente novamente.', $redirect);
}
