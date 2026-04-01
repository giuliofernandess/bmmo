<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';

Auth::requireRegency();

$redirect = BASE_URL . 'pages/admin/news/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Método invalido para exclusao.';
    header('Location: ' . $redirect);
    exit;
}

$newsId = (int) ($_POST['news_id'] ?? 0);

if ($newsId <= 0) {
    $_SESSION['error'] = 'Notícia invalida.';
    header('Location: ' . $redirect);
    exit;
}

$news = $newsDAO->getById($newsId);
if (!$news) {
    $_SESSION['error'] = 'Notícia não encontrada.';
    header('Location: ' . $redirect);
    exit;
}

if ($newsDAO->delete($newsId)) {
    if (!empty($news['news_image'])) {
        $uploadDir = BASE_PATH . 'uploads/news-images/';
        $path = $uploadDir . basename($news['news_image']);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    $_SESSION['success'] = 'Notícia removida com sucesso!';
} else {
    $_SESSION['error'] = 'Erro ao remover a notícia. Tente novamente.';
}

header('Location: ' . $redirect);
exit;
