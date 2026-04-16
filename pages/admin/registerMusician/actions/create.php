<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
$auth = new Auth();
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);

$auth->requireRegency();

function isValidBirthDate(int $age, ?string $responsibleName, ?string $responsibleContact): bool
{
	if ($age < 7 || $age > 100) {
		return false;
	} elseif ($age < 18 && empty(trim((string) $responsibleName))) {
		return false;
	} elseif ($age < 18 && empty(trim((string) $responsibleContact))) {
		return false;
	} else {
		return true;
	}
}

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
$newPassword = filter_input(INPUT_POST, 'new_password');
$confirmNewPassword = filter_input(INPUT_POST, 'confirm_new_password');

$birth = DateTime::createFromFormat('Y-m-d', (string) $dateOfBirth);
$today = new DateTime();
$age = $today->diff($birth)->y;

$redirect = BASE_URL . 'pages/admin/registerMusician/index.php';

validateRequiredFields([
	'musician_name' => $musicianName,
	'musician_login' => $login,
	'musician_date_of_birth' => $dateOfBirth,
	'musician_instrument' => $instrument,
	'band_group' => $bandGroup,
	'musician_neighborhood' => $neighborhood,
	'new_password' => $newPassword,
	'confirm_new_password' => $confirmNewPassword,
], $redirect);


if (!$birth) {
	redirectWithMessage($redirect, 'error', 'Data de nascimento inválida.');
}

$imageFileName = null;

if (isset($_FILES['file'])) {
	$imageFileName = handleProfileImageUpload($_FILES['file'], $redirect);
}

if ($musiciansDAO->verifyLogin($login)) {
	redirectWithMessage($redirect, 'error', "Login já existe.");
}

if ($birth > $today) {
	redirectWithMessage($redirect, 'error', "Data de nascimento inválida.");
}

if (!isValidBirthDate($age, $responsibleName, $responsibleContact)) {
	redirectWithMessage($redirect, 'error', "Faltam informações do responsável.");
}

if ($newPassword !== $confirmNewPassword) {
	redirectWithMessage($redirect, 'error', "As senhas não conferem.");
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
