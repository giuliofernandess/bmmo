<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
$auth = new Auth();
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/Models/MusicalScore.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);

$auth->requireRegency();

$allowedExtensions = ['pdf'];
$maxFileSize = 15 * 1024 * 1024;

function iniSizeToBytes(string $value): int
{
	$value = trim($value);
	if ($value === '') {
		return 0;
	}

	$unit = strtolower(substr($value, -1));
	$number = (float) $value;

	switch ($unit) {
		case 'g':
			$number *= 1024;
			// no break
		case 'm':
			$number *= 1024;
			// no break
		case 'k':
			$number *= 1024;
	}

	return (int) $number;
}

function buildSafeMusicalScoreFileName(string $originalName, array $allowedExtensions): ?string
{
	$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

	if (!in_array($extension, $allowedExtensions, true)) {
		return null;
	}

	return uniqid('score_', true) . '.' . $extension;
}


$musicId = filter_input(INPUT_POST, 'musical_score_id');
$musicName = filter_input(INPUT_POST, 'musical_score_name');
$musicGenre = filter_input(INPUT_POST, 'musical_score_genre');
$musicGroups = postArray('musical_score_groups');

$redirectSuccess = BASE_URL . "pages/admin/musical-scores/edit/index.php?" . "musical_score_id=" . urlencode($musicId);

$contentLength = isset($_SERVER['CONTENT_LENGTH']) ? (int) $_SERVER['CONTENT_LENGTH'] : 0;
$postMaxSize = iniSizeToBytes((string) ini_get('post_max_size'));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $postMaxSize > 0 && $contentLength > $postMaxSize) {
	redirectWithMessage($redirectSuccess, 'error', "Arquivo muito grande para o servidor. Reduza o tamanho do envio.");
}

validateRequiredFields([
	'musical_score_id' => $musicId,
	'musical_score_name' => $musicName,
	'musical_score_genre' => $musicGenre,
	'musical_score_groups' => $musicGroups
], $redirectSuccess);


$instrumentsVoiceOff = [];
$voiceOffInput = $_FILES['musical_score_instruments_voice_off'] ?? $_FILES['instrumentsVoiceOff'] ?? [];
$voiceOffNames = $voiceOffInput['name'] ?? [];
$voiceOffErrors = $voiceOffInput['error'] ?? [];
$voiceOffTmp = $voiceOffInput['tmp_name'] ?? [];
$voiceOffSizes = $voiceOffInput['size'] ?? [];

if (is_array($voiceOffNames)) {
foreach ($voiceOffNames as $instrumentId => $nameVoiceOff) {
	$errorCode = (int) ($voiceOffErrors[$instrumentId] ?? UPLOAD_ERR_NO_FILE);

	if ($errorCode === UPLOAD_ERR_INI_SIZE || $errorCode === UPLOAD_ERR_FORM_SIZE) {
		redirectWithMessage($redirectSuccess, 'error', "Arquivo muito grande. Máximo permitido: 15MB.");
	}

	if ($errorCode === UPLOAD_ERR_OK) {

		$tmp = $voiceOffTmp[$instrumentId] ?? '';
		$size = (int) ($voiceOffSizes[$instrumentId] ?? 0);
		$safeName = buildSafeMusicalScoreFileName((string) $nameVoiceOff, $allowedExtensions);

		if ($safeName === null) {
			redirectWithMessage($redirectSuccess, 'error', "Formato de arquivo inválido. Envie apenas PDF.");
		}

		if ($size > $maxFileSize) {
			redirectWithMessage($redirectSuccess, 'error', "Arquivo muito grande. Máximo permitido: 15MB.");
		}

		if (!move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $safeName)) {
			redirectWithMessage($redirectSuccess, 'error', "Erro ao enviar arquivo de instrumento sem voz.");
		}

		$instrumentsVoiceOff[$instrumentId] = $safeName;
	}
}
}


$instruments = [];
$instrumentInput = $_FILES['musical_score_instruments'] ?? $_FILES['instruments'] ?? [];
$instrumentNames = $instrumentInput['name'] ?? [];
$instrumentErrors = $instrumentInput['error'] ?? [];
$instrumentTmp = $instrumentInput['tmp_name'] ?? [];
$instrumentSizes = $instrumentInput['size'] ?? [];

if (is_array($instrumentNames)) {
foreach ($instrumentNames as $instrumentId => $name) {
	$errorCode = (int) ($instrumentErrors[$instrumentId] ?? UPLOAD_ERR_NO_FILE);

	if ($errorCode === UPLOAD_ERR_INI_SIZE || $errorCode === UPLOAD_ERR_FORM_SIZE) {
		redirectWithMessage($redirectSuccess, 'error', "Arquivo muito grande. Máximo permitido: 15MB.");
	}

	if ($errorCode === UPLOAD_ERR_OK) {

		$tmp = $instrumentTmp[$instrumentId] ?? '';
		$size = (int) ($instrumentSizes[$instrumentId] ?? 0);
		$safeName = buildSafeMusicalScoreFileName((string) $name, $allowedExtensions);

		if ($safeName === null) {
			redirectWithMessage($redirectSuccess, 'error', "Formato de arquivo inválido. Envie apenas PDF.");
		}

		if ($size > $maxFileSize) {
			redirectWithMessage($redirectSuccess, 'error', "Arquivo muito grande. Máximo permitido: 15MB.");
		}

		if (!move_uploaded_file($tmp, BASE_PATH . "uploads/musical-scores/" . $safeName)) {
			redirectWithMessage($redirectSuccess, 'error', "Erro ao enviar arquivo de instrumento com voz.");
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
	redirectWithMessage($redirectSuccess, 'success', "Partitura editada com sucesso!");
} else {
	redirectWithMessage($redirectSuccess, 'error', "Erro ao editar partitura.");
}
