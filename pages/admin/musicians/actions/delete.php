<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . "pages/admin/musicians/index.php";
$musicianId = (int) (requestValue('musician_id', 'int', 'post') ?? 0);

if (!$musicianId) {
	redirectWithMessage($redirect, 'error', 'Músico inválido.');
}

$redirectError = BASE_URL . "pages/admin/musicians/musicianProfile/index.php" . "?musician_id=" . urlencode((string) $musicianId);

// Recebe a imagem do músico
$currentImage = $musiciansDAO->getProfileImage($musicianId);

$deleteMusician = $musiciansDAO->delete($musicianId);

if ($deleteMusician) {
	if ($currentImage && file_exists(BASE_PATH . 'uploads/musicians-images/' . $currentImage)) {
		unlink(BASE_PATH . 'uploads/musicians-images/' . $currentImage);
	}

	redirectWithMessage($redirect, 'success', "Músico excluído com sucesso.");
} else {
	redirectWithMessage($redirectError, 'error', "Não foi possível deletar o músico.");
}
