<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';

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

function postValueAny(array $keys, string $type = 'string')
{
    foreach ($keys as $key) {
        $value = postValue($key, $type);
        if ($value !== null) {
            return $value;
        }
    }

    return null;
}

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

/* Valida senha */
if ($password !== null || $confirmPassword !== null) {
    if ($password !== $confirmPassword) {
        Message::set('error', "As senhas não conferem.");
        header("Location: " . $redirect);
        exit;
    }
}

// Informações do músico via Model
$musicianInfo = Musician::fromArray([
    'musician_id' => (int) $musicianId,
    'musician_contact' => $musicianContact,
    'responsible_name' => $responsibleName,
    'responsible_contact' => $responsibleContact,
    'neighborhood' => (string) $neighborhood,
    'institution' => $institution,
    'password' => (string) ($password ?? ''),
]);

$musiciansDAO = new MusiciansDAO($conn);
if ($musiciansDAO->editOwnProfile($musicianInfo)) {
    Message::set('success', "Músico editado com sucesso!");
} else {
    Message::set('error', "Erro ao editar o músico. Tente novamente.");
}

// Redireciona de volta para a página musicians
header("Location: " . $redirect);
exit;

?>