<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Models/MusicalScores.php';

// Recebe dados do formulário
$musicName = trim($_POST['name'] ?? null);
$instrument = (int) $_POST['instrument'] ?? null;

$bandGroups = $_POST['band-group'] ?? [];

// Validação de grupos
if (empty($bandGroups)) {
    $_SESSION['error'] = "Selecione pelo menos um grupo.";
    header("Location: addMusicalScore.php");
    exit;
}

$stringBandGroups = implode(',', array_map('intval', $bandGroups));

$musicalGenre = trim($_POST['musical-genre'] ?? null);

// Validação de grupos
if (empty($bandGroups)) {
    $_SESSION['error'] = "Selecione pelo menos um grupo.";
    header("Location: addMusicalScore.php");
    exit;
}

// Validação simples do arquivo
$FileName = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['pdf'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error'] = "Extensão de arquivo inválida. Permitido apenas pdf.";
        header("Location: addMusicalScore.php");
        exit;
    }

    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 5MB.";
        header("Location: addMusicalScore.php");
        exit;
    }

    $newFileName = uniqid('music_', true) . '.' . $fileExtension;
    $uploadFileDir = BASE_PATH . 'uploads/musical-scores/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $destPath = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $FileName = $newFileName;
    } else {
        $_SESSION['error'] = "Erro ao enviar a imagem.";
        header("Location: addMusicalScore.php");
        exit;
    }
}

// Criação da notícia via Model
$musicInfo = [
    'music_name' => $musicName,
    'instrument' => $instrument,
    'band_groups' => $stringBandGroups,
    'musical_genre' => $musicalGenre,
    'file' => $FileName
];

if (MusicalScores::musicalScoreCreate($musicInfo)) {
    $_SESSION['success'] = "Partitura cadastrada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao cadastrar partitura. Tente novamente.";
}

// Redireciona de volta para o formulário
header("Location: addMusicalScore.php");
exit;
?>