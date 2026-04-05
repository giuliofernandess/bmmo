<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . "pages/admin/musicalScores/index.php";

// Recebe dados do formulário
$musicName = postValueAny(['musical_score_name', 'name-add']) ?? '';
$musicGenre = postValueAny(['musical_score_genre', 'musical-genre-add']) ?? '';
$musicGroups = $_POST['musical_score_groups'] ?? $_POST['groups'] ?? [];

validateRequiredFields([
	'Nome' => $musicName,
	'Gênero' => $musicGenre,
], $redirect);

$musicalScore = MusicalScore::fromArray([
	'music_name' => $musicName,
	'music_genre' => $musicGenre,
	'music_groups' => $musicGroups,
]);

$musicalScoreAdd = $musicalScoresDAO->create($musicalScore);

$redirectSuccess = BASE_URL . "pages/admin/musicalScores/edit/index.php?" . "musicId=" . urlencode($musicalScoreAdd);

if ($musicalScoreAdd !== false) {
	redirectWithMessage('success', "Partitura criada com sucesso!", $redirectSuccess);
} else {
	redirectWithMessage('error', "Erro ao criar partitura.", $redirect);
}
