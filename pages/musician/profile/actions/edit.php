<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

// Recebimento de variáveis pelo método POST
$musicianId = postValueAny(['musician_id', 'musician-id']);
$musicianContact = postValueAny(['musician_contact', 'contact']);
$responsibleName = postValueAny(['responsible_name', 'responsible']);
$responsibleContact = postValueAny(['responsible_contact', 'contact-of-responsible']);
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValueAny(['confirm_password', 'confirm-password']);

$redirect = BASE_URL . "pages/musician/profile/edit/index.php";
$redirectSuccess = BASE_URL . "pages/musician/profile/index.php";

/* Valida senha */
if ($password !== $confirmPassword) {
    redirectWithMessage('error', "As senhas não conferem.", $redirect);
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
