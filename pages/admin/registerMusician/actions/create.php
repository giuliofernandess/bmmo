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
$musicianName = postValueAny(['musician_name', 'name']);
$login = postValueAny(['musician_login', 'login']);

$dateOfBirth = postValueAny(['date_of_birth', 'date']);
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

validateRequiredFields([
	'Nome' => $musicianName,
	'Login' => $login,
	'Data de nascimento' => $dateOfBirth,
	'Instrumento' => $instrument,
	'Grupo da banda' => $bandGroup,
	'Bairro' => $neighborhood,
	'Senha' => $password,
	'Confirmação de senha' => $confirmPassword,
], $redirect);

$birth = DateTime::createFromFormat('Y-m-d', (string) $dateOfBirth);
if ($birth === false) {
	redirectWithMessage('error', 'Data de nascimento inválida.', $redirect);
}

$today = new DateTime();
$age = $today->diff($birth)->y;

// Upload da imagem
$imageFileName = null;

if (isset($_FILES['file'])) {
	$imageFileName = handleProfileImageUpload($_FILES['file'], $redirect);
}

/* Valida senha */
if ($password !== $confirmPassword) {
	redirectWithMessage('error', "As senhas não conferem.", $redirect);
}

/* Valida login */
if ($musiciansDAO->verifyLogin($login)) {
	redirectWithMessage('error', "Login já existe.", $redirect);
}

/* Valida datas */
if (!isValidBirthDate($age, $responsibleName, $responsibleContact)) {
	redirectWithMessage('error', "Data de nascimento inválida ou falta de informações do responsável.", $redirect);
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
	redirectWithMessage('success', "Músico criado com sucesso!", $redirect);
} else {
	redirectWithMessage('error', "Erro ao registrar o músico. Tente novamente.", $redirect);
}
