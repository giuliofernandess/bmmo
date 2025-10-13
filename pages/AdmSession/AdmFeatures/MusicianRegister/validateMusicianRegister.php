<?php

function ageVerification($dateOfBirth)
{
    $birth = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
    $today = new DateTime();
    if (!$birth)
        return false;

    return $birth < $today;
}

function verifyLogin($login, $connect)
{
    $stmt = $connect->prepare("SELECT `login` FROM musicians WHERE login = ?");
    if (!$stmt) {
        error_log("Erro na preparação da query: " . $connect->error);
        echo "<script>alert('Erro interno no servidor.'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param("s", $login);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

$name = trim($_POST['name'] ?? '');
$login = trim($_POST['login'] ?? '');
$dateOfBirth = trim($_POST['dateOfBirth'] ?? '');
$instrument = trim($_POST['instrument'] ?? '');
$bandGroup = trim($_POST['bandGroup'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$responsible = trim($_POST['responsible'] ?? '');
$contactOfResponsible = trim($_POST['contactOfResponsible'] ?? '');
$neighborhood = trim($_POST['neighborhood'] ?? '');
$institution = trim($_POST['institution'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

require_once '../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar ao banco de dados.'); window.history.back();</script>";
    exit;
}

// Validação simples da imagem
$imageFileName = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        die('Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.');
    }

    if ($fileSize > 5 * 1024 * 1024) {
        die('Arquivo muito grande. Máximo permitido: 5MB.');
    }

    $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
    $uploadFileDir = '../../../../assets/images/musicians-images/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $destPath = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $imageFileName = $newFileName;
    } else {
        die('Erro ao mover a imagem para o diretório.');
    }
}

/* Valida senha */
if ($password !== $confirmPassword) {
    echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
    exit;
}

/* Valida login */
if (verifyLogin($login, $connect)) {
    echo "<script>alert('Login já existe!'); window.history.back();</script>";
    exit;
}

/* Valida datas */
if (!ageVerification($dateOfBirth)) {
    echo "<script>alert('Data de nascimento inválida!'); window.history.back();</script>";
    exit;
}

$stmt = $connect->prepare("INSERT INTO musicians (name, login, dateOfBirth, instrument, bandGroup, telephone, responsible, telephoneOfResponsible, neighborhood, institution, image, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.history.back();</script>";
    exit;
}

$stmt->bind_param(
    "ssssssssssss",
    $name,
    $login,
    $dateOfBirth,
    $instrument,
    $bandGroup,
    $telephone,
    $responsible,
    $contactOfResponsible,
    $neighborhood,
    $institution,
    $imageFileName,
    $password
);

if ($stmt->execute()) {
    echo "<script>alert('Músico cadastrado com sucesso!'); window.location.href = 'musicianRegister.php';</script>";
} else {
    error_log("Erro ao inserir músico: " . $stmt->error);
    echo "<script>alert('Erro ao cadastrar músico.'); window.history.back();</script>";
}

$stmt->close();
$connect->close();
?>