<?php
function ageAdmission($dateOfBirth, $yearOfAdmission) {
    $birth = new DateTime($dateOfBirth);
    $admissionDate = DateTime::createFromFormat('Y', $yearOfAdmission);
    if (!$admissionDate) return false;

    $ageAtAdmission = $admissionDate->diff($birth)->y;
    return $ageAtAdmission >= 12;
}

function ageVerification($dateOfBirth) {
    $birth = DateTime::createFromFormat('Y-m-d', $dateOfBirth);
    $today = new DateTime();
    if (!$birth) return false;

    return $birth < $today;
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

/* Valida senha */
if ($password !== $confirmPassword) {
    echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
    exit;
}

/* Valida datas */
if (!ageVerification($dateOfBirth)) {
    echo "<script>alert('Data de nascimento inválida!'); window.history.back();</script>";
    exit;
}

if (!ageAdmission($dateOfBirth, $bandGroup)) {
    echo "<script>alert('Idade na admissão inválida (mínimo 12 anos).'); window.history.back();</script>";
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $connect->prepare("INSERT INTO musicians (name, login, dateOfBirth, instrument, bandGroup, telephone, responsible, telephoneOfResponsible, neighborhood, institution, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.history.back();</script>";
    exit;
}

$stmt->bind_param(
    "sssssssssss",
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
