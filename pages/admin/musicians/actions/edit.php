<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);

Auth::requireRegency();

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

validateRequiredFields([
	'Identificador do músico' => $musicianId,
	'Login' => $musicianLogin,
	'Instrumento' => $instrument,
	'Grupo da banda' => $bandGroup,
	'Bairro' => $neighborhood,
], $redirect);

//Validação de imagem
$currentImage = $musiciansDAO->getProfileImage($musicianId);
$imageFileName = handleProfileImageUpload($_FILES['file'] ?? [], $redirect, $currentImage);

/* Valida senha */
if ($password !== $confirmPassword) {
	redirectWithMessage('error', "As senhas não conferem.", $redirect);
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
	'profile_image' => $imageFileName
]);

$musiciansDAO = new MusiciansDAO($conn);
if ($musiciansDAO->edit($musicianInfo)) {

    if ($password !== null && $password !== null) {

        // Tenta atualizar a senha do usuário

        if (!$musiciansDAO->editPassword($musicianId, $password)) {
            redirectWithMessage('error', "Erro ao editar a senha. Tente novamente.", $redirect);
        }

    }

    redirectWithMessage('success', "Músico editado com sucesso!", $redirectSuccess);
} else {
    redirectWithMessage('error', "Erro ao editar o músico. Tente novamente.", $redirect);
}
