<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$newsDAO = new NewsDAO($conn);

$newsTitle = postValue('news_title');
$newsSubtitle = postValue('news_subtitle');
$newsDescription = postValue('news_description');

$redirect = BASE_URL . 'pages/admin/news/index.php';

date_default_timezone_set('America/Sao_Paulo');
$currentDate = date('Y-m-d');
$currentHour = date('H:i:s');

validateRequiredFields([
    'Título' => $newsTitle,
    'Subtítulo' => $newsSubtitle,
    'Descrição' => $newsDescription,
], $redirect);

$imageFileName = null;

$imageInput = $_FILES['news_image'] ?? $_FILES['file'] ?? null;

if ($imageInput === null || ($imageInput['error'] ?? null) !== UPLOAD_ERR_OK) {
    redirectWithMessage('error', 'A imagem é obrigatória para criar notícia.', $redirect);
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
    redirectWithMessage('success', 'Notícia criada com sucesso!', $redirect);
} else {
    redirectWithMessage('error', 'Erro ao criar a notícia. Tente novamente.', $redirect);
}
