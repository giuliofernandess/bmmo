<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

$newsTitle = filter_input(INPUT_POST, 'news_title');
$newsSubtitle = filter_input(INPUT_POST, 'news_subtitle');
$newsDescription = filter_input(INPUT_POST, 'news_description');

$redirect = BASE_URL . 'pages/admin/news/index.php';

date_default_timezone_set('America/Sao_Paulo');
$currentDate = date('Y-m-d');
$currentHour = date('H:i:s');

validateRequiredFields([
    'title' => $newsTitle,
    'subtitle' => $newsSubtitle,
    'description' => $newsDescription,
], $redirect);

$imageFileName = null;

$imageInput = $_FILES['news_image'] ?? $_FILES['file'] ?? null;

if ($imageInput === null || ($imageInput['error'] ?? null) !== UPLOAD_ERR_OK) {
    redirectWithMessage($redirect, 'error', 'A imagem é obrigatória para criar notícia.');
}

$imageFileName = handleProfileImageUpload(
    $imageInput,
    $redirect,
    null,
    'news-images',
    'news_'
);

$newsInfo = News::fromArray([
    'news_title' => $newsTitle,
    'news_subtitle' => $newsSubtitle,
    'news_image' => (string) $imageFileName,
    'news_description' => $newsDescription,
    'publication_date' => $currentDate,
    'publication_hour' => $currentHour,
]);

if ($newsDAO->create($newsInfo)) {
    redirectWithMessage($redirect, 'success', 'Notícia criada com sucesso!');
} else {
    redirectWithMessage($redirect, 'error', 'Erro ao criar a notícia. Tente novamente.');
}
