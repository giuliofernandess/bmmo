<?php
require_once '../../../../general-features/bdConnect.php';

$title = trim($_POST['newsTitle']);
$subTitle = trim($_POST['newsSubtitle']);
$text = trim($_POST['description']);
$currentDate = date('d-m-Y');

// Validação simples da imagem
$imageFileName = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        die('Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.');
    }

    if ($fileSize > 5 * 1024 * 1024) {
        die('Arquivo muito grande. Máximo permitido: 5MB.');
    }

    $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
    $uploadFileDir = '../../../../assets/news-images/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $destPath = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $imageFileName = $newFileName;
    } else {
        die('Erro ao mover a imagem para o diretório.');
    }
}

// Inserção segura com prepared statements
if ($imageFileName) {
    $stmt = $connect->prepare("INSERT INTO `news` (`title`, `subtitle`, `image`, `text`, `date`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $subTitle, $imageFileName, $text, $currentDate);
} else {
    $stmt = $connect->prepare("INSERT INTO `news` (`title`, `subtitle`, `text`, `date`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $subTitle, $text, $currentDate);
}

if ($stmt->execute()) {
    echo "<script>alert('Notícia inserida com sucesso!'); window.location.href='newsCreate.php';</script>";
} else {
    echo "<script>alert('Erro ao inserir notícia.'); window.location.href='newsCreate.php';</script>";
}

$stmt->close();
$connect->close();
?>
