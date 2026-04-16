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


$musicianId = filter_input(INPUT_POST, 'musician_id');
$musicianLogin = filter_input(INPUT_POST, 'musician_login');
$instrument = filter_input(INPUT_POST, 'musician_instrument');
$bandGroup = filter_input(INPUT_POST, 'band_group');
$musicianContact = filter_input(INPUT_POST, 'musician_contact');
$responsibleName = filter_input(INPUT_POST, 'responsible_name');
$responsibleContact = filter_input(INPUT_POST, 'responsible_contact');
$neighborhood = filter_input(INPUT_POST, 'neighborhood');
$institution = filter_input(INPUT_POST, 'institution');
$newPassword = filter_input(INPUT_POST, 'new_password');
$confirmNewPassword = filter_input(INPUT_POST, 'confirm_new_password');

$redirect = BASE_URL . 'pages/admin/musicians/index.php';
$redirectSuccess = BASE_URL . 'pages/admin/musicians/musicianProfile/index.php' . "?musician_id=" . urlencode($musicianId);

validateRequiredFields([
	'musician_id' => $musicianId,
	'musician_login' => $musicianLogin,
	'musician_instrument' => $instrument,
	'band_group' => $bandGroup,
	'musician_neighborhood' => $neighborhood
], $redirect);


$currentImage = $musiciansDAO->getProfileImage($musicianId);
$imageFileName = handleProfileImageUpload($_FILES['file'] ?? [], $redirect, $currentImage);


if ($newPassword !== $confirmNewPassword) {
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

	if ($newPassword !== null && $confirmNewPassword !== null) {

        

		if (!$musiciansDAO->editPassword($musicianId, $newPassword)) {
            redirectWithMessage($redirect, 'error', "Erro ao editar a senha. Tente novamente.");
        }

    }

    redirectWithMessage($redirectSuccess, 'success', "Músico editado com sucesso!");
} else {
    redirectWithMessage($redirect, 'error', "Erro ao editar o músico. Tente novamente.");
}
