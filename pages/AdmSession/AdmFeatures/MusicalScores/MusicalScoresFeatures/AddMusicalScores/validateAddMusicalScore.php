<?php
require_once 'bdConnect.php';

$name = trim($_POST['name']);
$instrument = trim($_POST['instrument']);
$bandGroup = trim($_POST['bandGroup']);
$musicalGenre = trim($_POST['musicalGenre']);

// Validação simples da imagem
$imageFileName = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['pdf'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        die('Extensão de arquivo inválida. Permitido apenas pdf');
    }

    if ($fileSize > 5 * 1024 * 1024) {
        die('Arquivo muito grande. Máximo permitido: 5MB.');
    }

    $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
    $uploadFileDir = '../../../../../../assts/musical-scores/';

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

$stmt = $connect->prepare("INSERT INTO `musical_scores` (`name`, `instrument`, `file`, `bandGroup`, `musicalGenre`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $instrument, $imageFileName, $bandGroup, $musicalGenre);

if ($stmt->execute()) {
    echo "<script>alert('Partitura adicionada com sucesso!'); window.location.href='addMusicalScore.php';</script>";
} else {
    echo "<script>alert('Erro ao adicionar.'); window.location.href='newsCreate.php';</script>";
}

$stmt->close();
$connect->close();
?>
