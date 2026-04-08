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
$musicName = filter_input(INPUT_POST, 'musical_score_name');
$musicGenre = filter_input(INPUT_POST, 'musical_score_genre');
$musicGroups = postArray('musical_score_groups');

validateRequiredFields([
	'name' => $musicName,
	'genre' => $musicGenre,
	'groups' => $musicGroups
], $redirect);

$musicalScore = MusicalScore::fromArray([
	'music_name' => $musicName,
	'music_genre' => $musicGenre,
	'music_groups' => $musicGroups,
]);

$musicalScoreAdd = $musicalScoresDAO->create($musicalScore);

$redirectSuccess = BASE_URL . "pages/admin/musicalScores/edit/index.php?" . "musical_score_id=" . urlencode($musicalScoreAdd);

if ($musicalScoreAdd !== false) {
	redirectWithMessage($redirectSuccess, 'success', "Partitura criada com sucesso!");
} else {
	redirectWithMessage($redirect, 'error', "Erro ao criar partitura.");
}
