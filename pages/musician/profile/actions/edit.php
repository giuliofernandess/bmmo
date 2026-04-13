<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';


$musicianId = filter_input(INPUT_POST, 'musician_id');
$musicianContact = filter_input(INPUT_POST, 'musician_contact');
$responsibleName = filter_input(INPUT_POST, 'responsible_name');
$responsibleContact = filter_input(INPUT_POST, 'responsible_contact');
$neighborhood = filter_input(INPUT_POST, 'neighborhood');
$institution = filter_input(INPUT_POST, 'institution');

$storedPasswordHash = filter_input(INPUT_POST, 'password_hash');
$currentPassword = filter_input(INPUT_POST, 'current_password');
$newPassword = filter_input(INPUT_POST, 'new_password');
$confirmNewPassword = filter_input(INPUT_POST, 'confirm_new_password');

$redirect = BASE_URL . "pages/musician/profile/edit/index.php";
$redirectSuccess = BASE_URL . "pages/musician/profile/index.php";

validateRequiredFields([
    'id' => $musicianId,
    'neighborhood' => $neighborhood,
], $redirect);

$isChangingPassword = !isEmptyRequiredValue($currentPassword) || !isEmptyRequiredValue($newPassword) || !isEmptyRequiredValue($confirmNewPassword);


if ($isChangingPassword) {
    validateRequiredFields([
        'current_password' => $currentPassword,
        'new_password' => $newPassword,
        'confirm_new_password' => $confirmNewPassword,
    ], $redirect, 'Para alterar a senha, preencha todos os campos');

    if (!password_verify((string) $currentPassword, (string) $storedPasswordHash)) {
        redirectWithMessage($redirect, 'error', "Senha atual incorreta.");
    }

    if ($newPassword !== $confirmNewPassword) {
        redirectWithMessage($redirect, 'error', "As senhas não conferem.");
    }
}


$musicianInfo = Musician::fromArray([
    'musician_id' => (int) $musicianId,
    'musician_contact' => $musicianContact,
    'responsible_name' => $responsibleName,
    'responsible_contact' => $responsibleContact,
    'neighborhood' => (string) $neighborhood,
    'institution' => $institution
]);

$musiciansDAO = new MusiciansDAO($conn);
if ($musiciansDAO->editOwnProfile($musicianInfo)) {

    if ($isChangingPassword) {

        
        if (!$musiciansDAO->editPassword($musicianId, $newPassword)) {
            redirectWithMessage($redirect, 'error', "Erro ao editar a senha. Tente novamente.");
        }

    }

    redirectWithMessage($redirectSuccess, 'success', "Músico editado com sucesso!");
} else {
    redirectWithMessage($redirect, 'error', "Erro ao editar o músico. Tente novamente.");
}
