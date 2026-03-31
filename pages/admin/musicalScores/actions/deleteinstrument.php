<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';

Auth::requireRegency();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$_SESSION['error'] = 'Metodo invalido para exclusao do arquivo.';
	header("Location: " . BASE_URL . "pages/admin/musicalScores/index.php");
	exit;
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
	$_SESSION['error'] = 'Parâmetros inválidos para exclusão do arquivo.';
	header("Location: " . BASE_URL . "pages/admin/musicalScores/index.php");
	exit;
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

	$_SESSION['success'] = "Arquivo excluído com sucesso.";
} else {
	$_SESSION['error'] = "Não foi possível deletar o arquivo.";
}

header("Location: " . BASE_URL . "pages/admin/musicalScores/edit/index.php?musicId={$musicId}");
exit;
