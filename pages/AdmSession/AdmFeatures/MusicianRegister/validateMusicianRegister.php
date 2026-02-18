<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Models/Musicians.php';

// Função auxiliar para tratar entrada
function postValue(string $key, string $type = 'string') {
    if (!isset($_POST[$key]) || $_POST[$key] === '') {
        return null;
    }

    return $type === 'int'
        ? (int) $_POST[$key]
        : trim($_POST[$key]);
}

// Recebimento de variáveis pelo método POST
$musicianName = postValue('name');
$login = postValue('login');
$dateOfBirth = postValue('date');
$instrument = postValue('instrument', 'int');
$bandGroup = postValue('group', 'int');
$musicianContact = postValue('contact');
$responsibleName = postValue('responsible');
$responsibleContact = postValue('contact-of-responsible');
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValue('confirm-password');

// Upload da imagem
$imageFileName = null;

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error'] = "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.";
        header("Location: musicianRegister.php");
        exit;
    }

    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 5MB.";
        header("Location: musicianRegister.php");
        exit;
    }

    $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
    $uploadDir = BASE_PATH . 'uploads/musicians-images/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $destPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $imageFileName = $newFileName;
    } else {
        $_SESSION['error'] = "Erro ao enviar a imagem.";
        header("Location: musicianRegister.php");
        exit;
    }
}

/* Valida senha */
if ($password !== $confirmPassword) {
        $_SESSION['error'] = "As senhas não conferem.";
        header("Location: musicianRegister.php");
        exit;
}

/* Valida login */
if (Musicians::verifyLogin($login)) {
        $_SESSION['error'] = "Login já existe.";
        header("Location: musicianRegister.php");
        exit;
}

/* Valida datas */
if (!Musicians::ageVerification($dateOfBirth)) {
        $_SESSION['error'] = "Data de nascimento inválida.";
        header("Location: musicianRegister.php");
        exit;
}

// Criação da notícia via Model
$musicianInfo = [
    'name' => $musicianName,
    'login' => $login,
    'birth' => $dateOfBirth,
    'instrument' => $instrument,
    'band_group' => $bandGroup,
    'musician_contact' => $musicianContact,
    'responsible_name' => $responsibleName,
    'responsible_contact' => $responsibleContact,
    'neighborhood' => $neighborhood,
    'institution' => $institution,
    'profile_image' => $imageFileName,
    'password' => $password,
];

if (Musicians::musicianRegister($musicianInfo)) {
    $_SESSION['success'] = "Músico criado com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao registrar o músico. Tente novamente.";
}

// Redireciona de volta para o formulário
header("Location: musicianRegister.php");
exit;
?>