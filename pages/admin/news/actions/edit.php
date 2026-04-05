<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

$newsId = (int) (postValueAny(['news_id', 'id'], 'int') ?? 0);
$newsTitle = postValueAny(['news_title', 'title']);
$newsSubtitle = postValueAny(['news_subtitle', 'subtitle']);
$newsDescription = postValueAny(['news_description', 'description']);

$redirect = BASE_URL . 'pages/admin/news/index.php';

if ($newsId <= 0) {
    redirectWithMessage('error', 'Notícia invalida.', $redirect);
}

validateRequiredFields([
    'Identificador da notícia' => $newsId,
    'Título' => $newsTitle,
    'Subtítulo' => $newsSubtitle,
    'Descrição' => $newsDescription,
], $redirect);

$existingNews = $newsDAO->getById($newsId);
if (!$existingNews) {
    redirectWithMessage('error', 'Notícia não encontrada.', $redirect);
}

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
