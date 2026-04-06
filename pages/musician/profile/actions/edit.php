<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

// Recebimento de variáveis pelo método POST
$musicianId = requestValue('musician_id', 'string', 'post');
$musicianContact = requestValue('musician_contact', 'string', 'post');
$responsibleName = requestValue('responsible_name', 'string', 'post');
$responsibleContact = requestValue('responsible_contact', 'string', 'post');
$neighborhood = requestValue('neighborhood', 'string', 'post');
$institution = requestValue('institution', 'string', 'post');

$hashPassword = requestValue('hash_password', 'string', 'post');
$password = requestValue('actual_password', 'string', 'post');
$newPassword = requestValue('password', 'string', 'post');
$confirmPassword = requestValue('confirm_password', 'string', 'post');

$redirect = BASE_URL . "pages/musician/profile/edit/index.php";
$redirectSuccess = BASE_URL . "pages/musician/profile/index.php";

validateRequiredFields([
    'id' => $musicianId,
    'neighborhood' => $neighborhood,
], $redirect);

$isChangingPassword = !isEmptyRequiredValue($password) || !isEmptyRequiredValue($newPassword) || !isEmptyRequiredValue($confirmPassword);

/* Valida senha somente quando houver tentativa de alteração */
if ($isChangingPassword) {
    validateRequiredFields([
        'actual_password' => $password,
        'new_password' => $newPassword,
        'confirm_password' => $confirmPassword,
    ], $redirect, 'Para alterar a senha, preencha todos os campos');

    if (!password_verify((string) $password, (string) $hashPassword)) {
        redirectWithMessage($redirect, 'error', "Senha atual incorreta.");
    }

    if ($newPassword !== $confirmPassword) {
        redirectWithMessage($redirect, 'error', "As senhas não conferem.");
    }
}

// Informações do músico via Model
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

        // Tenta atualizar a senha do usuário
        if (!$musiciansDAO->editPassword($musicianId, $newPassword)) {
            redirectWithMessage($redirect, 'error', "Erro ao editar a senha. Tente novamente.");
        }

    }

    redirectWithMessage($redirectSuccess, 'success', "Músico editado com sucesso!");
} else {
    redirectWithMessage($redirect, 'error', "Erro ao editar o músico. Tente novamente.");
}
