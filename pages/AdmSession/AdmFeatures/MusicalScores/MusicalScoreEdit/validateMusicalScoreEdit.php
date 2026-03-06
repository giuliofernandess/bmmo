<?php
session_start();
require_once "../../../../../config/config.php";
require_once BASE_PATH . 'app/Models/MusicalScores.php';

// Recebe dados do formulário
$musicId = (int)$_POST['id'];
$musicName = trim($_POST['name'] ?? '');
$musicGenre = trim($_POST['genre'] ?? '');
$musicGroups = $_POST['groups'] ?? [];

$editMusicalScore = MusicalScores::editMusicalScore(
    $musicId,
    $musicName,
    $musicGenre,
    $musicGroups
);

if ($editMusicalScore !== false) {
    $_SESSION['success'] = "Partitura editada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao editar partitura.";
}

// Redireciona para a página de edição de instrumentos
header("Location: musicalScoreEdit.php?musicId={$musicId}");
exit;
