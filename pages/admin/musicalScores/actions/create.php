<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';

Auth::requireRegency();

// Recebe dados do formulário
$musicName = trim($_POST['name-add'] ?? '');
$musicGenre = trim($_POST['musical-genre-add'] ?? '');
$musicGroups = $_POST['groups'] ?? [];

// Validação rápida
if (empty($musicName) || empty($musicGenre)) {
	Message::set('error', "Nome e gênero são obrigatórios.");
	header("Location: ../index.php");
	exit;
}

$musicalScore = new MusicalScore();
$musicalScore->setMusicName($musicName);
$musicalScore->setMusicGenre($musicGenre);
$musicalScore->setMusicGroups($musicGroups);

$musicalScoreAdd = $musicalScoresDAO->create($musicalScore);

if ($musicalScoreAdd !== false) {
	Message::set('success', "Partitura criada com sucesso!");
} else {
	Message::set('error', "Erro ao criar partitura.");

	header("Location: ../index.php");
	exit;
}

// Redireciona para a página de edição da partitura
header("Location: ../edit/index.php?musicId={$musicalScoreAdd}");
exit;
