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
	redirectWithMessage('error', 'Metodo invalido para exclusao do arquivo.', $redirect);
}

$musicId = filter_input(INPUT_POST, 'music_id', FILTER_VALIDATE_INT);
$instrumentId = filter_input(INPUT_POST, 'instrument_id', FILTER_VALIDATE_INT);
$voiceOff = filter_input(
	INPUT_POST,
	'voice_off',
	FILTER_VALIDATE_BOOLEAN,
	['flags' => FILTER_NULL_ON_FAILURE]
);

if (!$musicId || !$instrumentId) {
	redirectWithMessage('error', 'Parâmetros inválidos para exclusão do arquivo.', $redirect);
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

	redirectWithMessage('success', "Arquivo excluído com sucesso.", BASE_URL . "pages/admin/musicalScores/edit/index.php?musicId={$musicId}");
} else {
	redirectWithMessage('error', "Não foi possível deletar o arquivo.", BASE_URL . "pages/admin/musicalScores/edit/index.php?musicId={$musicId}");
}
