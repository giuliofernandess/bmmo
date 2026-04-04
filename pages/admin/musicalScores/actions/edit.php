<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);

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
$musicId = (int) ($_POST['musical_score_id'] ?? $_POST['id'] ?? 0);
$musicName = trim($_POST['musical_score_name'] ?? $_POST['name'] ?? '');
$musicGenre = trim($_POST['musical_score_genre'] ?? $_POST['genre'] ?? '');
$musicGroups = $_POST['musical_score_groups'] ?? $_POST['groups'] ?? [];

$redirectSuccess = BASE_URL . "pages/admin/musicalScores/edit/index.php?" . "musicId=" . urlencode($musicId);

// Validação de instrumentos sem vozes
$instrumentsVoiceOff = [];
$voiceOffInput = $_FILES['musical_score_instruments_voice_off'] ?? $_FILES['instrumentsVoiceOff'] ?? [];
$voiceOffNames = $voiceOffInput['name'] ?? [];
$voiceOffErrors = $voiceOffInput['error'] ?? [];
$voiceOffTmp = $voiceOffInput['tmp_name'] ?? [];
$voiceOffSizes = $voiceOffInput['size'] ?? [];

if (is_array($voiceOffNames)) {
foreach ($voiceOffNames as $instrumentId => $nameVoiceOff) {

	if (($voiceOffErrors[$instrumentId] ?? null) === UPLOAD_ERR_OK) {

		$tmp = $voiceOffTmp[$instrumentId] ?? '';
		$size = (int) ($voiceOffSizes[$instrumentId] ?? 0);
		$safeName = buildSafeMusicalScoreFileName((string) $nameVoiceOff, $allowedExtensions);

		if ($safeName === null) {
			Message::set('error', "Formato de arquivo inválido. Envie apenas PDF.");
			header("Location: " . $redirectSuccess);
			exit;
		}

		if ($size > $maxFileSize) {
			Message::set('error', "Arquivo muito grande. Máximo permitido: 15MB.");
			header("Location: " . $redirectSuccess);
			exit;
		}

		if (!move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $safeName)) {
			Message::set('error', "Erro ao enviar arquivo de instrumento sem voz.");
			header("Location: " . $redirectSuccess);
			exit;
		}

		$instrumentsVoiceOff[$instrumentId] = $safeName;
	}
}
}

// Validação de instrumentos com vozes
$instruments = [];
$instrumentInput = $_FILES['musical_score_instruments'] ?? $_FILES['instruments'] ?? [];
$instrumentNames = $instrumentInput['name'] ?? [];
$instrumentErrors = $instrumentInput['error'] ?? [];
$instrumentTmp = $instrumentInput['tmp_name'] ?? [];
$instrumentSizes = $instrumentInput['size'] ?? [];

if (is_array($instrumentNames)) {
foreach ($instrumentNames as $instrumentId => $name) {

	if (($instrumentErrors[$instrumentId] ?? null) === UPLOAD_ERR_OK) {

		$tmp = $instrumentTmp[$instrumentId] ?? '';
		$size = (int) ($instrumentSizes[$instrumentId] ?? 0);
		$safeName = buildSafeMusicalScoreFileName((string) $name, $allowedExtensions);

		if ($safeName === null) {
			Message::set('error', "Formato de arquivo inválido. Envie apenas PDF.");
			header("Location: " . $redirectSuccess);
			exit;
		}

		if ($size > $maxFileSize) {
			Message::set('error', "Arquivo muito grande. Máximo permitido: 15MB.");
			header("Location: " . $redirectSuccess);
			exit;
		}

		if (!move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $safeName)) {
			Message::set('error', "Erro ao enviar arquivo de instrumento com voz.");
			header("Location: " . $redirectSuccess);
			exit;
		}

		$instruments[$instrumentId] = $safeName;
	}
}
}

$musicalScore = MusicalScore::fromArray([
	'music_id' => $musicId,
	'music_name' => $musicName,
	'music_genre' => $musicGenre,
	'music_groups' => $musicGroups,
	'instruments_voice_off' => $instrumentsVoiceOff,
	'instruments' => $instruments,
]);

$musicalScoreEdit = $musicalScoresDAO->edit($musicalScore);

if ($musicalScoreEdit !== false) {
	Message::set('success', "Partitura editada com sucesso!");
} else {
	Message::set('error', "Erro ao editar partitura.");
}

header("Location: " . $redirectSuccess);
exit;
