<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
$auth = new Auth();
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);
$presentationsDAO = new PresentationsDAO($conn);

$auth->requireRegency();

$redirect = BASE_URL . "pages/admin/musical-scores/index.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirectWithMessage($redirect, 'error', "Metodo invalido para exclusao da partitura.");
}
	
$musicId = filter_input(INPUT_POST, 'musical_score_id');

if (!$musicId) {
	redirectWithMessage($redirect, 'error', "Partitura inválida.");
}

if ($presentationsDAO->getById($musicId)) {
	redirectWithMessage($redirect, 'error', "Não é possível excluir a partitura, pois ela está associada a uma apresentação.");
}

$musicalScoreGeneralDelete = $musicalScoresDAO->delete($musicId);

if ($musicalScoreGeneralDelete) {
	redirectWithMessage($redirect, 'success', "Partitura excluída com sucesso.");
} else {
	redirectWithMessage($redirect, 'error', "Não foi possível deletar a partitura.");
}
