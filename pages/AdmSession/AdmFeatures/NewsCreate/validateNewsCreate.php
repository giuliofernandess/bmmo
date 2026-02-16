<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Models/News.php';

// Recebe dados do formulário
$newsTitle = trim($_POST['title'] ?? '');
$newsSubtitle = trim($_POST['subtitle'] ?? '');
$newsDescription = trim($_POST['description'] ?? '');

// Recebe data e hora
date_default_timezone_set('America/Sao_Paulo');
$currentDate = date('Y-m-d');
$currentHour = date('H:i:s');

// Validação rápida
if (empty($newsTitle) || empty($newsDescription)) {
    $_SESSION['error'] = "Título e descrição são obrigatórios.";
    header("Location: newsCreate.php");
    exit;
}

// Upload da imagem
$imageFileName = null;

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error'] = "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.";
        header("Location: newsCreate.php");
        exit;
    }

    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 5MB.";
        header("Location: newsCreate.php");
        exit;
    }

    $newFileName = uniqid('news_', true) . '.' . $fileExtension;
    $uploadDir = BASE_PATH . 'uploads/news-images/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $destPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $imageFileName = $newFileName;
    } else {
        $_SESSION['error'] = "Erro ao enviar a imagem.";
        header("Location: newsCreate.php");
        exit;
    }
}

// Criação da notícia via Model
$newsInfo = [
    'title' => $newsTitle,
    'subtitle' => $newsSubtitle,
    'image' => $imageFileName,
    'description' => $newsDescription,
    'date' => $currentDate,
    'hour' => $currentHour
];

if (News::newsCreate($newsInfo)) {
    $_SESSION['success'] = "Notícia criada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao criar a notícia. Tente novamente.";
}

// Redireciona de volta para o formulário
header("Location: newsCreate.php");
exit;
