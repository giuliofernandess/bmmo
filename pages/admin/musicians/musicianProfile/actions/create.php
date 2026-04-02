<?php
session_start();
require_once "../../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';

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

function isValidBirthDate(?string $age): bool
{
	if ($age < 7 && $age > 100) {
		return false;
	} else if ($age < 18 && empty($_POST['responsible'])) {
		return false;
	} else if ($age < 18 && empty($_POST['contact-of-responsible'])) {
		return false;
	} else {
		return true;
	}
}

// Recebimento de variáveis pelo método POST
$musicianName = postValue('name');
$login = postValue('login');

$dateOfBirth = postValue('date');
$birth = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
$today = new DateTime();
$age = $today->diff($birth)->y;

$instrument = postValue('instrument', 'int');
$bandGroup = postValue('group', 'int');
$musicianContact = postValue('contact');
$responsibleName = postValue('responsible');
$responsibleContact = postValue('contact-of-responsible');
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValue('confirm-password');

// Upload da imagem
$imageFileName = null;

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
	$fileTmpPath = $_FILES['file']['tmp_name'];
	$fileName = $_FILES['file']['name'];
	$fileSize = $_FILES['file']['size'];
	$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

	$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	if (!in_array($fileExtension, $allowedExtensions)) {
		$_SESSION['error'] = "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.";
		header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
		exit;
	}

	if ($fileSize > 5 * 1024 * 1024) {
		$_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 5MB.";
		header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
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
		$_SESSION['error'] = "Erro ao enviar a imagem.";
		header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
		exit;
	}
}

/* Valida senha */
if ($password !== $confirmPassword) {
	$_SESSION['error'] = "As senhas não conferem.";
	header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
	exit;
}

/* Valida login */
if ($musiciansDAO->verifyLogin($login)) {
	$_SESSION['error'] = "Login já existe.";
	header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
	exit;
}

/* Valida datas */
if (!isValidBirthDate($age)) {
	$_SESSION['error'] = "Data de nascimento inválida ou falta de informações do responsável.";
	header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
	exit;
}


$musicianInfo = new Musician();
$musicianInfo->setMusicianName((string) $musicianName);
$musicianInfo->setMusicianLogin((string) $login);
$musicianInfo->setDateOfBirth((string) $dateOfBirth);
$musicianInfo->setInstrument((int) $instrument);
$musicianInfo->setBandGroup((int) $bandGroup);
$musicianInfo->setMusicianContact($musicianContact);
$musicianInfo->setResponsibleName($responsibleName);
$musicianInfo->setResponsibleContact($responsibleContact);
$musicianInfo->setNeighborhood((string) $neighborhood);
$musicianInfo->setInstitution($institution);
$musicianInfo->setProfileImage($imageFileName);
$musicianInfo->setPassword((string) $password);

if ($musiciansDAO->create($musicianInfo)) {
	$_SESSION['success'] = "Músico criado com sucesso!";
} else {
	$_SESSION['error'] = "Erro ao registrar o músico. Tente novamente.";
}

header("Location: " . BASE_URL . "pages/admin/registerMusician/index.php");
exit;
