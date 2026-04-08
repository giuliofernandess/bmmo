<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . "pages/admin/musicalScores/index.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirectWithMessage($redirect, 'error', 'Metodo invalido para exclusao do arquivo.');
}

$musicId = filter_input(INPUT_POST, 'musical_score_id');
$instrumentId = filter_input(INPUT_POST, 'instrument_id');
$voiceOffRaw = filter_input(INPUT_POST, 'voice_off');
$voiceOff = $voiceOffRaw !== null
	? filter_var($voiceOffRaw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
	: null;

if (!$musicId || !$instrumentId) {
	redirectWithMessage($redirect, 'error', 'Parâmetros inválidos para exclusão do arquivo.');
}

$currentFile = $musicalScoresDAO->getFile($musicId, $instrumentId);

if ($voiceOff === true) {
	$musicalScoreInstrumentDelete = $musicalScoresDAO->deleteMusicalScoreInstrument($musicId, $instrumentId, true);
} else {
	$musicalScoreInstrumentDelete = $musicalScoresDAO->deleteMusicalScoreInstrument($musicId, $instrumentId);
}

if ($musicalScoreInstrumentDelete) {
	if ($currentFile && file_exists(BASE_PATH . 'uploads/musical-scores/' . $currentFile)) {
		unlink(BASE_PATH . 'uploads/musical-scores/' . $currentFile);
	}

	redirectWithMessage(BASE_URL . "pages/admin/musicalScores/edit/index.php?musical_score_id={$musicId}", 'success', "Arquivo excluído com sucesso.");
} else {
	redirectWithMessage(BASE_URL . "pages/admin/musicalScores/edit/index.php?musical_score_id={$musicId}", 'error', "Não foi possível deletar o arquivo.");
}
