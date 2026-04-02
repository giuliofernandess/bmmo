<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';

Auth::requireRegency();

$allowedExtensions = ['pdf'];
$maxFileSize = 15 * 1024 * 1024;

function buildSafeMusicalScoreFileName(string $originalName, array $allowedExtensions): ?string
{
	$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

	if (!in_array($extension, $allowedExtensions, true)) {
		return null;
	}

	return uniqid('score_', true) . '.' . $extension;
}

// Recebe dados do formulário
$musicId = (int) ($_POST['id'] ?? 0);
$musicName = trim($_POST['name'] ?? '');
$musicGenre = trim($_POST['genre'] ?? '');
$musicGroups = $_POST['groups'] ?? [];

// Validação de instrumentos sem vozes
$instrumentsVoiceOff = [];
$voiceOffNames = $_FILES['instrumentsVoiceOff']['name'] ?? [];
$voiceOffErrors = $_FILES['instrumentsVoiceOff']['error'] ?? [];
$voiceOffTmp = $_FILES['instrumentsVoiceOff']['tmp_name'] ?? [];
$voiceOffSizes = $_FILES['instrumentsVoiceOff']['size'] ?? [];

if (is_array($voiceOffNames)) {
foreach ($voiceOffNames as $instrumentId => $nameVoiceOff) {

	if (($voiceOffErrors[$instrumentId] ?? null) === UPLOAD_ERR_OK) {

		$tmp = $voiceOffTmp[$instrumentId] ?? '';
		$size = (int) ($voiceOffSizes[$instrumentId] ?? 0);
		$safeName = buildSafeMusicalScoreFileName((string) $nameVoiceOff, $allowedExtensions);

		if ($safeName === null) {
			$_SESSION['error'] = "Formato de arquivo inválido. Envie apenas PDF.";
			header("Location: ../edit/index.php?musicId={$musicId}");
			exit;
		}

		if ($size > $maxFileSize) {
			$_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 15MB.";
			header("Location: ../edit/index.php?musicId={$musicId}");
			exit;
		}

		if (!move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $safeName)) {
			$_SESSION['error'] = "Erro ao enviar arquivo de instrumento sem voz.";
			header("Location: ../edit/index.php?musicId={$musicId}");
			exit;
		}

		$instrumentsVoiceOff[$instrumentId] = $safeName;
	}
}
}

// Validação de instrumentos com vozes
$instruments = [];
$instrumentNames = $_FILES['instruments']['name'] ?? [];
$instrumentErrors = $_FILES['instruments']['error'] ?? [];
$instrumentTmp = $_FILES['instruments']['tmp_name'] ?? [];
$instrumentSizes = $_FILES['instruments']['size'] ?? [];

if (is_array($instrumentNames)) {
foreach ($instrumentNames as $instrumentId => $name) {

	if (($instrumentErrors[$instrumentId] ?? null) === UPLOAD_ERR_OK) {

		$tmp = $instrumentTmp[$instrumentId] ?? '';
		$size = (int) ($instrumentSizes[$instrumentId] ?? 0);
		$safeName = buildSafeMusicalScoreFileName((string) $name, $allowedExtensions);

		if ($safeName === null) {
			$_SESSION['error'] = "Formato de arquivo inválido. Envie apenas PDF.";
			header("Location: ../edit/index.php?musicId={$musicId}");
			exit;
		}

		if ($size > $maxFileSize) {
			$_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 15MB.";
			header("Location: ../edit/index.php?musicId={$musicId}");
			exit;
		}

		if (!move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $safeName)) {
			$_SESSION['error'] = "Erro ao enviar arquivo de instrumento com voz.";
			header("Location: ../edit/index.php?musicId={$musicId}");
			exit;
		}

		$instruments[$instrumentId] = $safeName;
	}
}
}

$musicalScore = new MusicalScore();
$musicalScore->setMusicId($musicId);
$musicalScore->setMusicName($musicName);
$musicalScore->setMusicGenre($musicGenre);
$musicalScore->setMusicGroups($musicGroups);
$musicalScore->setInstrumentsVoiceOff($instrumentsVoiceOff);
$musicalScore->setInstruments($instruments);

$musicalScoreEdit = $musicalScoresDAO->edit($musicalScore);

if ($musicalScoreEdit !== false) {
	$_SESSION['success'] = "Partitura editada com sucesso!";
} else {
	$_SESSION['error'] = "Erro ao editar partitura.";
}

header("Location: ../edit/index.php?musicId={$musicId}");
exit;
