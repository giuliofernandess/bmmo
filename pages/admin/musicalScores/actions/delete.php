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
	redirectWithMessage($redirect, 'error', "Metodo invalido para exclusao da partitura.");
}
	
$musicId = (int) (requestValue('music_id', 'int', 'post') ?? 0);

if (!$musicId) {
	redirectWithMessage($redirect, 'error', "Partitura inválida.");
}

$musicalScoreGeneralDelete = $musicalScoresDAO->delete($musicId);

if ($musicalScoreGeneralDelete) {
	redirectWithMessage($redirect, 'success', "Partitura excluída com sucesso.");
} else {
	redirectWithMessage($redirect, 'error', "Não foi possível deletar a partitura.");
}
