<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Models/News.php';

$newsId = (int)($_POST['id'] ?? 0);
$newsTitle = trim($_POST['title'] ?? '');
$newsSubtitle = trim($_POST['subtitle'] ?? '');
$newsDescription = trim($_POST['description'] ?? '');

if ($newsId <= 0) {
    $_SESSION['error'] = "Notícia inválida.";
    header("Location: createNews.php");
    exit;
}

if (empty($newsTitle) || empty($newsDescription)) {
    $_SESSION['error'] = "Título e descrição são obrigatórios.";
    header("Location: createNews.php");
    exit;
}

$existingNews = News::getById($newsId);
if (!$existingNews) {
    $_SESSION['error'] = "Notícia não encontrada.";
    header("Location: createNews.php");
    exit;
}

$imageFileName = $existingNews['news_image'];

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error'] = "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.";
        header("Location: createNews.php");
        exit;
    }

    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 5MB.";
        header("Location: createNews.php");
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
        $_SESSION['error'] = "Erro ao enviar a imagem.";
        header("Location: createNews.php");
        exit;
    }
}

$newsInfo = [
    'id' => $newsId,
    'title' => $newsTitle,
    'subtitle' => $newsSubtitle,
    'image' => $imageFileName,
    'description' => $newsDescription
];

if (News::editNews($newsInfo)) {
    $_SESSION['success'] = "Notícia editada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao editar a notícia. Tente novamente.";
}

header("Location: createNews.php");
exit;
