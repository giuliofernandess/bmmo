<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

$newsId = (int) (postValue('news_id', 'int') ?? 0);

$newsTitle = postValue('news_title');
$newsSubtitle = postValue('news_subtitle');
$newsDescription = postValue('news_description');

$redirect = BASE_URL . 'pages/admin/news/index.php';

// Verificar se encontrou a notícia
$existingNews = $newsDAO->getById($newsId);
if (!$existingNews || $newsId <= 0) {
    redirectWithMessage('error', 'Notícia não encontrada.', $redirect);
}

validateRequiredFields([
    'Título' => $newsTitle,
    'Subtítulo' => $newsSubtitle,
    'Descrição' => $newsDescription,
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
    redirectWithMessage('success', 'Notícia editada com sucesso!', $redirect);
} else {
    redirectWithMessage('error', 'Erro ao editar a notícia. Tente novamente.', $redirect);
}
