<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . "pages/admin/musicalScores/index.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	Message::set('error', "Metodo invalido para exclusao da partitura.");
	header("Location: " . $redirect);
	exit;
}
	
$musicId = isset($_POST['music_id']) ? (int) $_POST['music_id'] : null;

if (!$musicId) {
	header("Location: " . $redirect);
	exit;
}

$musicalScoreGeneralDelete = $musicalScoresDAO->delete($musicId);

if ($musicalScoreGeneralDelete) {
	Message::set('success', "Partitura excluída com sucesso.");
} else {
	Message::set('error', "Não foi possível deletar a partitura.");
}

header("Location: " . $redirect);
exit;
