<?php
session_start();
require_once "../../../../../../config/config.php";
require_once BASE_PATH . 'app/Models/MusicalScores.php';

$musicId = isset($_GET['music_id']) ? (int) $_GET['music_id'] : null;

if (!$musicId) {
    header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/MusicalScores/musicalScores.php");
    exit;
}

$musicalScoreGeneralDelete = MusicalScores::MusicalScoreGeneralDelete($musicId);

if ($musicalScoreGeneralDelete) {
    $_SESSION['success'] = "Partitura excluída com sucesso.";
} else {
    $_SESSION['error'] = "Não foi possível deletar a partitura.";
}

header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/MusicalScores/musicalScores.php");
exit;

?>