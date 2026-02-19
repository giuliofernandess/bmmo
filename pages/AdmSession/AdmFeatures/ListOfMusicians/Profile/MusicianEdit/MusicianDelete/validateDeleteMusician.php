<?php
session_start();
require_once "../../../../../../../config/config.php";
require_once BASE_PATH . 'app/Models/Musicians.php';

$musicianId = isset($_POST['musicianId']) ? (int) $_POST['musicianId'] : null;

if (!$musicianId) {
    header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/musicianProfile.php?musicianId={$musicianId}");
    exit;
}

//Recebe a imagem do músico
$currentImage = Musicians::getProfileImage($musicianId);

$deleteMusician = Musicians::deleteMusician($musicianId);

if ($deleteMusician) {
    if ($currentImage && file_exists(BASE_PATH . 'uploads/musicians-images/' . $currentImage)) {
        unlink(BASE_PATH . 'uploads/musicians-images/' . $currentImage);
    }

    $_SESSION['success'] = "Músico excluído com sucesso.";
    header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/musicians.php");
} else {
    $_SESSION['error'] = "Não foi possível deletar o músico.";
    header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/musicianProfile.php?musicianId={$musicianId}");
}

?>
