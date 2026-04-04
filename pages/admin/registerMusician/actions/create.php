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

function isValidBirthDate(?string $age, ?string $responsibleName, ?string $responsibleContact): bool
{
	if ($age < 7 && $age > 100) {
		return false;
	} elseif ($age < 18 && $responsibleName === null) {
		return false;
	} elseif ($age < 18 && $responsibleContact === null) {
		return false;
	} else {
		return true;
	}
}

// Recebimento de variáveis pelo método POST
$musicianName = postValueAny(['musician_name', 'name']);
$login = postValueAny(['musician_login', 'login']);

$dateOfBirth = postValueAny(['date_of_birth', 'date']);
$birth = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
$today = new DateTime();
$age = $today->diff($birth)->y;

$instrument = postValue('instrument', 'int');
$bandGroup = postValueAny(['band_group', 'group'], 'int');
$musicianContact = postValueAny(['musician_contact', 'contact']);
$responsibleName = postValueAny(['responsible_name', 'responsible']);
$responsibleContact = postValueAny(['responsible_contact', 'contact-of-responsible']);
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValueAny(['confirm_password', 'confirm-password']);

$redirect = BASE_URL . 'pages/admin/registerMusician/index.php';

// Upload da imagem
$imageFileName = null;

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
	$fileTmpPath = $_FILES['file']['tmp_name'];
	$fileName = $_FILES['file']['name'];
	$fileSize = $_FILES['file']['size'];
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
	$uploadDir = BASE_PATH . 'uploads/musicians-images/';

	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0755, true);
	}

	$destPath = $uploadDir . $newFileName;

	if (move_uploaded_file($fileTmpPath, $destPath)) {
		$imageFileName = $newFileName;
	} else {
		Message::set('error', "Erro ao enviar a imagem.");
		header("Location: " . $redirect);
		exit;
	}
}

/* Valida senha */
if ($password !== $confirmPassword) {
	Message::set('error', "As senhas não conferem.");
	header("Location: " . $redirect);
	exit;
}

/* Valida login */
if ($musiciansDAO->verifyLogin($login)) {
	Message::set('error', "Login já existe.");
	header("Location: " . $redirect);
	exit;
}

/* Valida datas */
if (!isValidBirthDate($age, $responsibleName, $responsibleContact)) {
	Message::set('error', "Data de nascimento inválida ou falta de informações do responsável.");
	header("Location: " . $redirect);
	exit;
}


$musicianInfo = Musician::fromArray([
	'musician_name' => (string) $musicianName,
	'musician_login' => (string) $login,
	'date_of_birth' => (string) $dateOfBirth,
	'instrument' => (int) $instrument,
	'band_group' => (int) $bandGroup,
	'musician_contact' => $musicianContact,
	'responsible_name' => $responsibleName,
	'responsible_contact' => $responsibleContact,
	'neighborhood' => (string) $neighborhood,
	'institution' => $institution,
	'profile_image' => $imageFileName,
	'password' => (string) $password,
]);

if ($musiciansDAO->create($musicianInfo)) {
	Message::set('success', "Músico criado com sucesso!");
} else {
	Message::set('error', "Erro ao registrar o músico. Tente novamente.");
}

header("Location: " . $redirect);
exit;
