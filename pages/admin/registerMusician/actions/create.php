<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);

Auth::requireRegency();

function isValidBirthDate(?string $age, ?string $responsibleName, ?string $responsibleContact): bool
{
	if ($age < 7 || $age > 100) {
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
$musicianName = filter_input(INPUT_POST, 'musician_name');
$login = filter_input(INPUT_POST, 'musician_login');

$dateOfBirth = filter_input(INPUT_POST, 'date_of_birth');
$instrument = filter_input(INPUT_POST, 'musician_instrument');
$bandGroup = filter_input(INPUT_POST, 'band_group');
$musicianContact = filter_input(INPUT_POST, 'musician_contact');
$responsibleName = filter_input(INPUT_POST, 'responsible_name');
$responsibleContact = filter_input(INPUT_POST, 'responsible_contact');
$neighborhood = filter_input(INPUT_POST, 'neighborhood');
$institution = filter_input(INPUT_POST, 'institution');
$newPassword = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirm_password');

$redirect = BASE_URL . 'pages/admin/registerMusician/index.php';

validateRequiredFields([
	'name' => $musicianName,
	'login' => $login,
	'date_of_birth' => $dateOfBirth,
	'musician_instrument' => $instrument,
	'band_group' => $bandGroup,
	'neighborhood' => $neighborhood,
	'password' => $newPassword,
	'confirm_password' => $confirmPassword,
], $redirect);

$birth = DateTime::createFromFormat('Y-m-d', (string) $dateOfBirth);
if ($birth === false) {
	redirectWithMessage($redirect, 'error', 'Data de nascimento inválida.');
}

$today = new DateTime();
$age = $today->diff($birth)->y;

// Upload da imagem
$imageFileName = null;

if (isset($_FILES['file'])) {
	$imageFileName = handleProfileImageUpload($_FILES['file'], $redirect);
}

/* Valida senha */
if ($newPassword !== $confirmPassword) {
	redirectWithMessage($redirect, 'error', "As senhas não conferem.");
}

/* Valida login */
if ($musiciansDAO->verifyLogin($login)) {
	redirectWithMessage($redirect, 'error', "Login já existe.");
}

/* Valida datas */
if (!isValidBirthDate($age, $responsibleName, $responsibleContact)) {
	redirectWithMessage($redirect, 'error', "Data de nascimento inválida ou falta de informações do responsável.");
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
	'password' => (string) $newPassword,
]);

if ($musiciansDAO->create($musicianInfo)) {
	redirectWithMessage($redirect, 'success', "Músico criado com sucesso!");
} else {
	redirectWithMessage($redirect, 'error', "Erro ao registrar o músico. Tente novamente.");
}
