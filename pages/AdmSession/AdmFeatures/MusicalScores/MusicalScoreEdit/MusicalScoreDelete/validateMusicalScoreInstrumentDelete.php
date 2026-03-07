<?php
session_start();
require_once "../../../../../../config/config.php";
require_once BASE_PATH . 'app/Models/MusicalScores.php';

$musicId = isset($_GET['music_id']) ? (int) $_GET['music_id'] : null;
$instrumentId = isset($_GET['instrument_id']) ? (int) $_GET['instrument_id'] : null;

if (!$musicId) {
    header("Location: " . BASE_URL . "pages/AdmSession/MusicalScores/MusicalScoresEdit/musicalScoreEdit.php?musicId={$musicId}");
    exit;
}

$currentFile = MusicalScores::getFile($musicId, $instrumentId);

$musicalScoreInstrumentDelete = MusicalScores::MusicalScoreInstrumentDelete($musicId, $instrumentId);

if ($musicalScoreInstrumentDelete) {
    if ($currentFile && file_exists(BASE_PATH . 'uploads/musical-scores/' . $currentFile)) {
        unlink(BASE_PATH . 'uploads/musical-scores/' . $currentFile);
    }

    $_SESSION['success'] = "Partitura excluído com sucesso.";
} else {
    $_SESSION['error'] = "Não foi possível deletar o partitura.";
}

header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/MusicalScores/MusicalScoreEdit/musicalScoreEdit.php?musicId={$musicId}");
exit;

?>