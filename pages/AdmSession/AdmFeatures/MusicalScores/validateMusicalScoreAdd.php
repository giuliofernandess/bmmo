<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Models/MusicalScores.php';

// Recebe dados do formulário
$musicName = trim($_POST['name-add'] ?? '');
$musicGenre = trim($_POST['musical-genre-add'] ?? '');
$musicGroups = $_POST['groups'] ?? [];

// Validação rápida
if (empty($musicName) || empty($musicGenre)) {
    $_SESSION['error'] = "Nome e gênero são obrigatórios.";
    header("Location: musicalScores.php");
    exit;
}

$musicalScoreAdd = MusicalScores::musicalScoreAdd(
    $musicName,
    $musicGenre,
    $musicGroups
);

if ($musicalScoreAdd !== false) {
    $_SESSION['success'] = "Partitura criada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao criar partitura.";
}

// Redireciona para a página de inserção de instrumentos
header("Location: MusicalScoreEdit/musicalScoreEdit.php?musicId={$musicalScoreAdd}");
exit;
