<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';

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

// Recebimento de variáveis pelo método POST
$musicianId = postValue('musician-id');
$musicianContact = postValue('contact');
$responsibleName = postValue('responsible');
$responsibleContact = postValue('contact-of-responsible');
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValue('confirm-password');

/* Valida senha */
if (!empty($password) || !empty($confirmPassword)) {
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "As senhas não conferem.";
        header("Location: " . BASE_URL . "pages/musician/profile/edit/index.php");
        exit;
    }
}

// Informações do músico via Model
$musicianInfo = [
    'id' => $musicianId,
    'musician_contact' => $musicianContact,
    'responsible_name' => $responsibleName,
    'responsible_contact' => $responsibleContact,
    'neighborhood' => $neighborhood,
    'institution' => $institution,
    'password' => $password
];

if ($musiciansDAO->editOwnProfile($musicianInfo)) {
    $_SESSION['success'] = "Músico editado com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao editar o músico. Tente novamente.";
}

// Redireciona de volta para a página musicians
header("Location: " . BASE_URL . "pages/musician/profile/index.php");
exit;

?>