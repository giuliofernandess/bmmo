<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../../../../../../config/config.php";
require_once BASE_PATH . 'app/Models/Musicians.php';

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
$musicianLogin = postValue('login');
$musicianName = postValue('name');
$login = postValue('login');
$instrument = postValue('instrument', 'int');
$bandGroup = postValue('group', 'int');
$musicianContact = postValue('contact');
$responsibleName = postValue('responsible');
$responsibleContact = postValue('contact-of-responsible');
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValue('confirm-password');

//Validação de imagem
$currentImage = Musicians::getProfileImage($musicianId);

$imageFileName = $currentImage;

if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    if ($currentImage && file_exists(BASE_PATH . 'uploads/musicians-images/' . $currentImage)) {
        unlink(BASE_PATH . 'uploads/musicians-images/' . $currentImage);
    }

    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error'] = "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.";
        header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/MusicianEdit/MusicianEdit.php?musicianId={$musicianId}");
        exit;
    }

    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['error'] = "Arquivo muito grande. Máximo permitido: 5MB.";
        header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/MusicianEdit/MusicianEdit.php?musicianId={$musicianId}");
        exit;
    }

    $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
    $uploadFileDir = BASE_PATH . 'uploads/musicians-images/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $destPath = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $imageFileName = $newFileName;
    } else {
        $_SESSION['error'] = "Erro ao enviar a imagem.";
        header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/MusicianEdit/MusicianEdit.php?musicianId={$musicianId}");
        exit;
    }
}

/* Valida senha */
if (!empty($password) || !empty($confirmPassword)) {
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "As senhas não conferem.";
        header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/MusicianEdit/musicianEdit.php?musicianId={$musicianId}");
        exit;
    }
}

// Criação da notícia via Model
$musicianInfo = [
    'id' => $musicianId,
    'login' => $musicianLogin,
    'instrument' => $instrument,
    'band_group' => $bandGroup,
    'musician_contact' => $musicianContact,
    'responsible_name' => $responsibleName,
    'responsible_contact' => $responsibleContact,
    'neighborhood' => $neighborhood,
    'institution' => $institution,
    'profile_image' => $imageFileName,
    'password' => $password
];

if (Musicians::musicianEdit($musicianInfo)) {
    $_SESSION['success'] = "Músico editado com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao editar o músico. Tente novamente.";
}

// Redireciona de volta para a página musicians
header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/Profile/musicianProfile.php?musicianId={$musicianId}");
exit;

?>