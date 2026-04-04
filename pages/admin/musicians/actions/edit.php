<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';

$musiciansDAO = new MusiciansDAO($conn);

Auth::requireRegency();

// Função auxiliar para tratar entrada
function postValue(string $key, string $type = 'string')
{
	if (!isset($_POST[$key]) || $_POST[$key] === '') {
		return null;
	}

	return $type === 'int'
		? (int) $_POST[$key]
		: trim($_POST[$key]);
}

function postValueAny(array $keys, string $type = 'string')
{
	foreach ($keys as $key) {
		$value = postValue($key, $type);
		if ($value !== null) {
			return $value;
		}
	}

	return null;
}

// Recebimento de variáveis pelo método POST
$musicianId = postValueAny(['musician_id', 'musician-id']);
$musicianLogin = postValueAny(['musician_login', 'login']);
$instrument = postValue('instrument', 'int');
$bandGroup = postValueAny(['band_group', 'group'], 'int');
$musicianContact = postValueAny(['musician_contact', 'contact']);
$responsibleName = postValueAny(['responsible_name', 'responsible']);
$responsibleContact = postValueAny(['responsible_contact', 'contact-of-responsible']);
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValueAny(['confirm_password', 'confirm-password']);

$redirect = BASE_URL . 'pages/admin/musicians/index.php';
$redirectSuccess = BASE_URL . 'pages/admin/musicians/musicianProfile/index.php' . "?musician_id=" . urlencode($musicianId);

//Validação de imagem
$currentImage = $musiciansDAO->getProfileImage($musicianId);

$imageFileName = $currentImage;

if (isset($_FILES['file']) && ($_FILES['file']['error'] ?? null) === UPLOAD_ERR_OK) {
	$fileTmpPath = $_FILES['file']['tmp_name'];
	$fileName = $_FILES['file']['name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];
	$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

	$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

	if (!in_array($fileExtension, $allowedExtensions)) {
		Message::set('error', "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.");
		header("Location: " . $redirect);
		exit;
	}

	if ($fileSize > 5 * 1024 * 1024) {
		Message::set('error', "Arquivo muito grande. Máximo permitido: 5MB.");
		header("Location: " . $redirect);
		exit;
	}

	$newFileName = uniqid('profile_', true) . '.' . $fileExtension;
	$uploadFileDir = BASE_PATH . 'uploads/musicians-images/';

	if (!is_dir($uploadFileDir)) {
		mkdir($uploadFileDir, 0755, true);
	}

	$destPath = $uploadFileDir . $newFileName;

	if (move_uploaded_file($fileTmpPath, $destPath)) {
		if ($currentImage && file_exists(BASE_PATH . 'uploads/musicians-images/' . $currentImage)) {
			unlink(BASE_PATH . 'uploads/musicians-images/' . $currentImage);
		}

		$imageFileName = $newFileName;
	} else {
		Message::set('error', "Erro ao enviar a imagem.");
		header("Location: " . $redirect);
		exit;
	}
}

/* Valida senha */
if ($password !== null || $confirmPassword !== null) {
	if ($password !== $confirmPassword) {
		Message::set('error', "As senhas não conferem.");
		header("Location: " . $redirect);
		exit;
	}
}

$musicianInfo = Musician::fromArray([
	'musician_id' => (int) $musicianId,
	'musician_login' => (string) $musicianLogin,
	'instrument' => (int) $instrument,
	'band_group' => (int) $bandGroup,
	'musician_contact' => $musicianContact,
	'responsible_name' => $responsibleName,
	'responsible_contact' => $responsibleContact,
	'neighborhood' => (string) $neighborhood,
	'institution' => $institution,
	'profile_image' => $imageFileName,
	'password' => (string) ($password ?? ''),
]);

if ($musiciansDAO->edit($musicianInfo)) {
	Message::set('success', "Músico editado com sucesso!");
} else {
	Message::set('error', "Erro ao editar o músico. Tente novamente.");
}

header("Location: " . $redirectSuccess);
exit;
