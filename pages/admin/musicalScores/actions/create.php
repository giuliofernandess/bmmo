<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . "pages/admin/musicalScores/index.php";

// Recebe dados do formulário
$musicName = trim($_POST['musical_score_name'] ?? $_POST['name-add'] ?? '');
$musicGenre = trim($_POST['musical_score_genre'] ?? $_POST['musical-genre-add'] ?? '');
$musicGroups = $_POST['musical_score_groups'] ?? $_POST['groups'] ?? [];

// Validação rápida
if (empty($musicName) || empty($musicGenre)) {
	Message::set('error', "Nome e gênero são obrigatórios.");
	header("Location: " . $redirect);
	exit;
}

$musicalScore = MusicalScore::fromArray([
	'music_name' => $musicName,
	'music_genre' => $musicGenre,
	'music_groups' => $musicGroups,
]);

$musicalScoreAdd = $musicalScoresDAO->create($musicalScore);

$redirectSuccess = BASE_URL . "pages/admin/musicalScores/edit/index.php?" . "musicId=" . urlencode($musicalScoreAdd);

if ($musicalScoreAdd !== false) {
	Message::set('success', "Partitura criada com sucesso!");
} else {
	Message::set('error', "Erro ao criar partitura.");

	header("Location: " . $redirect);
	exit;
}

// Redireciona para a página de edição da partitura
header("Location: " . $redirectSuccess);
exit;
