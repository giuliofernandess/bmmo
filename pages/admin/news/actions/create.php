<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';

$newsDAO = new NewsDAO($conn);

$newsTitle = trim($_POST['news_title'] ?? $_POST['title'] ?? '');
$newsSubtitle = trim($_POST['news_subtitle'] ?? $_POST['subtitle'] ?? '');
$newsDescription = trim($_POST['news_description'] ?? $_POST['description'] ?? '');

$redirect = BASE_URL . 'pages/admin/news/index.php';

date_default_timezone_set('America/Sao_Paulo');
$currentDate = date('Y-m-d');
$currentHour = date('H:i:s');

if (empty($newsTitle) || empty($newsDescription)) {
    Message::set('error', 'Título e descrição são obrigatórios.');
    header('Location: ' . $redirect);
    exit;
}

$imageFileName = null;

$imageInput = $_FILES['news_image'] ?? $_FILES['file'] ?? null;

if ($imageInput === null || ($imageInput['error'] ?? null) !== UPLOAD_ERR_OK) {
    Message::set('error', 'A imagem é obrigatória para criar notícia.');
    header('Location: ' . $redirect);
    exit;
}

$fileTmpPath = $imageInput['tmp_name'];
$fileName = $imageInput['name'];
$fileSize = $imageInput['size'];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($fileExtension, $allowedExtensions, true)) {
    Message::set('error', 'Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.');
    header('Location: ' . $redirect);
    exit;
}

if ($fileSize > 5 * 1024 * 1024) {
    Message::set('error', 'Arquivo muito grande. máximo permitido: 5MB.');
    header('Location: ' . $redirect);
    exit;
}

$newFileName = uniqid('news_', true) . '.' . $fileExtension;
$uploadDir = BASE_PATH . 'uploads/news-images/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$destPath = $uploadDir . $newFileName;

if (!move_uploaded_file($fileTmpPath, $destPath)) {
    Message::set('error', 'Erro ao enviar a imagem.');
    header('Location: ' . $redirect);
    exit;
}

$imageFileName = $newFileName;

$newsInfo = News::fromArray([
    'news_title' => $newsTitle,
    'news_subtitle' => $newsSubtitle,
    'news_image' => (string) $imageFileName,
    'news_description' => $newsDescription,
    'publication_date' => $currentDate,
    'publication_hour' => $currentHour,
]);

if ($newsDAO->create($newsInfo)) {
    Message::set('success', 'Notícia criada com sucesso!');
} else {
    Message::set('error', 'Erro ao criar a notícia. Tente novamente.');
}

header('Location: ' . $redirect);
exit;
