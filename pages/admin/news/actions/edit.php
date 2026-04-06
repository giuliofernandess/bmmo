<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

$newsId = (int) (requestValue('news_id', 'int', 'post') ?? 0);

$newsTitle = requestValue('news_title', 'string', 'post');
$newsSubtitle = requestValue('news_subtitle', 'string', 'post');
$newsDescription = requestValue('news_description', 'string', 'post');

$redirect = BASE_URL . 'pages/admin/news/index.php';

// Verificar se encontrou a notícia
$existingNews = $newsDAO->getById($newsId);
if (!$existingNews || $newsId <= 0) {
    redirectWithMessage($redirect, 'error', 'Notícia não encontrada.');
}

validateRequiredFields([
    'title' => $newsTitle,
    'subtitle' => $newsSubtitle,
    'description' => $newsDescription,
], $redirect);

$imageFileName = $existingNews->getNewsImage();

$imageInput = $_FILES['news_image'] ?? $_FILES['file'] ?? null;

$imageFileName = handleProfileImageUpload(
    $imageInput ?? [],
    $redirect,
    $imageFileName,
    'news-images',
    'news_'
);

$newsInfo = News::fromArray([
    'news_id' => $newsId,
    'news_title' => $newsTitle,
    'news_subtitle' => $newsSubtitle,
    'news_image' => (string) $imageFileName,
    'news_description' => $newsDescription,
]);

if ($newsDAO->edit($newsInfo)) {
    redirectWithMessage($redirect, 'success', 'Notícia editada com sucesso!');
} else {
    redirectWithMessage($redirect, 'error', 'Erro ao editar a notícia. Tente novamente.');
}
