<?php
session_start();
require_once "../../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';

Auth::requireRegency();

$musicianId = isset($_POST['musician_id']) ? (int) $_POST['musician_id'] : null;

if (!$musicianId) {
	header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/index.php?musician_id={$musicianId}");
	exit;
}

// Recebe a imagem do músico
$currentImage = $musiciansDAO->getProfileImage($musicianId);

$deleteMusician = $musiciansDAO->delete($musicianId);

if ($deleteMusician) {
	if ($currentImage && file_exists(BASE_PATH . 'uploads/musicians-images/' . $currentImage)) {
		unlink(BASE_PATH . 'uploads/musicians-images/' . $currentImage);
	}

	$_SESSION['success'] = "Músico excluído com sucesso.";
	header("Location: " . BASE_URL . "pages/admin/musicians/index.php");
} else {
	$_SESSION['error'] = "Não foi possível deletar o músico.";
	header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/index.php?musician_id={$musicianId}");
}
