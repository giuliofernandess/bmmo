<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

$newsId = filter_input(INPUT_POST, 'news_id');

$newsTitle = filter_input(INPUT_POST, 'news_title');
$newsSubtitle = filter_input(INPUT_POST, 'news_subtitle');
$newsDescription = filter_input(INPUT_POST, 'news_description');

$redirect = BASE_URL . 'pages/admin/news/index.php';


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
