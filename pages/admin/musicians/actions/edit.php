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
$musicianId = requestValue('musician_id', 'string', 'post');
$musicianLogin = requestValue('musician_login', 'string', 'post');
$instrument = requestValue('instrument', 'int', 'post');
$bandGroup = requestValue('band_group', 'int', 'post');
$musicianContact = requestValue('musician_contact', 'string', 'post');
$responsibleName = requestValue('responsible_name', 'string', 'post');
$responsibleContact = requestValue('responsible_contact', 'string', 'post');
$neighborhood = requestValue('neighborhood', 'string', 'post');
$institution = requestValue('institution', 'string', 'post');
$password = requestValue('password', 'string', 'post');
$confirmPassword = requestValue('confirm_password', 'string', 'post');

$redirect = BASE_URL . 'pages/admin/musicians/index.php';
$redirectSuccess = BASE_URL . 'pages/admin/musicians/musicianProfile/index.php' . "?musician_id=" . urlencode($musicianId);

validateRequiredFields([
	'id' => $musicianId,
	'login' => $musicianLogin,
	'instrument' => $instrument,
	'band_group' => $bandGroup,
	'neighborhood' => $neighborhood
], $redirect);

//Validação de imagem
$currentImage = $musiciansDAO->getProfileImage($musicianId);
$imageFileName = handleProfileImageUpload($_FILES['file'] ?? [], $redirect, $currentImage);

/* Valida senha */
if ($password !== $confirmPassword) {
	redirectWithMessage($redirect, 'error', "As senhas não conferem.");
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
            redirectWithMessage($redirect, 'error', "Erro ao editar a senha. Tente novamente.");
        }

    }

    redirectWithMessage($redirectSuccess, 'success', "Músico editado com sucesso!");
} else {
    redirectWithMessage($redirect, 'error', "Erro ao editar o músico. Tente novamente.");
}
