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
	redirectWithMessage('error', "Metodo invalido para exclusao da partitura.", $redirect);
}
	
$musicId = (int) (postValue('music_id', 'int') ?? 0);

if (!$musicId) {
	redirectWithMessage('error', "Partitura inválida.", $redirect);
}

$musicalScoreGeneralDelete = $musicalScoresDAO->delete($musicId);

if ($musicalScoreGeneralDelete) {
	redirectWithMessage('success', "Partitura excluída com sucesso.", $redirect);
} else {
	redirectWithMessage('error', "Não foi possível deletar a partitura.", $redirect);
}
