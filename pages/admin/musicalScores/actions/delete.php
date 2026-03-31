<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';

Auth::requireRegency();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$_SESSION['error'] = "Metodo invalido para exclusao da partitura.";
	header("Location: " . BASE_URL . "pages/admin/musicalScores/index.php");
	exit;
}

$musicId = isset($_POST['music_id']) ? (int) $_POST['music_id'] : null;

if (!$musicId) {
	header("Location: " . BASE_URL . "pages/admin/musicalScores/index.php");
	exit;
}

$musicalScoreGeneralDelete = $musicalScoresDAO->delete($musicId);

if ($musicalScoreGeneralDelete) {
	$_SESSION['success'] = "Partitura excluída com sucesso.";
} else {
	$_SESSION['error'] = "Não foi possível deletar a partitura.";
}

header("Location: " . BASE_URL . "pages/admin/musicalScores/index.php");
exit;
