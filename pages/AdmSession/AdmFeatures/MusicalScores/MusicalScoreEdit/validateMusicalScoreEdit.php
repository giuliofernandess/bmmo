<?php
session_start();
require_once "../../../../../config/config.php";
require_once BASE_PATH . 'app/Models/MusicalScores.php';

// Recebe dados do formulário
$musicId = (int)$_POST['id'];
$musicName = trim($_POST['name'] ?? '');
$musicGenre = trim($_POST['genre'] ?? '');
$musicGroups = $_POST['groups'] ?? [];

// Validação de instrumentos sem vozes
$instruments = [];

foreach ($_FILES['instruments']['name'] as $instrumentId => $name) {

    if ($_FILES['instruments']['error'][$instrumentId] === UPLOAD_ERR_OK) {

        $tmp = $_FILES['instruments']['tmp_name'][$instrumentId];

        move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $name);

        $instruments[$instrumentId] = $name;
    }
}

$musicalScoreEdit = MusicalScores::MusicalScoreEdit(
    $musicId,
    $musicName,
    $musicGenre,
    $musicGroups,
    $instruments
);

if ($musicalScoreEdit !== false) {
    $_SESSION['success'] = "Partitura editada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao editar partitura.";
}

// Redireciona para a página de edição de instrumentos
header("Location: musicalScoreEdit.php?musicId={$musicId}");
exit;
