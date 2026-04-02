<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/Models/News.php';

$newsDAO = new NewsDAO($conn);

$newsId = (int) ($_POST['id'] ?? 0);
$newsTitle = trim($_POST['title'] ?? '');
$newsSubtitle = trim($_POST['subtitle'] ?? '');
$newsDescription = trim($_POST['description'] ?? '');

$redirect = BASE_URL . 'pages/admin/news/index.php';

if ($newsId <= 0) {
    Message::set('error', 'Notícia invalida.');
    header('Location: ' . $redirect);
    exit;
}

if (empty($newsTitle) || empty($newsDescription)) {
    Message::set('error', 'Título e descrição são obrigatórios.');
    header('Location: ' . $redirect);
    exit;
}

$existingNews = $newsDAO->getById($newsId);
if (!$existingNews) {
    Message::set('error', 'Notícia não encontrada.');
    header('Location: ' . $redirect);
    exit;
}

$imageFileName = $existingNews['news_image'];

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
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

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        if (!empty($existingNews['news_image'])) {
            $oldPath = $uploadDir . basename($existingNews['news_image']);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }
        $imageFileName = $newFileName;
    } else {
        Message::set('error', 'Erro ao enviar a imagem.');
        header('Location: ' . $redirect);
        exit;
    }
}

$newsInfo = News::fromArray([
    'news_id' => $newsId,
    'news_title' => $newsTitle,
    'news_subtitle' => $newsSubtitle,
    'news_image' => (string) $imageFileName,
    'news_description' => $newsDescription,
]);

if ($newsDAO->edit($newsInfo)) {
    Message::set('success', 'Notícia editada com sucesso!');
} else {
    Message::set('error', 'Erro ao editar a notícia. Tente novamente.');
}

header('Location: ' . $redirect);
exit;
