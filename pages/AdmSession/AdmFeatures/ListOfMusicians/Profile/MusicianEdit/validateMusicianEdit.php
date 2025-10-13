<?php
session_start();

$requiredFields = ['idMusician', 'instrument', 'telephone', 'responsible', 'contactOfResponsible', 'neighborhood', 'institution'];

$idMusician = (int) $_POST['idMusician'];
$login = trim($_POST['login']);
$instrument = trim($_POST['instrument']);
$bandGroup = trim($_POST['bandGroup']);
$telephone = trim($_POST['telephone']);
$responsible = trim($_POST['responsible']);
$telephoneOfResponsible = trim($_POST['contactOfResponsible']);
$neighborhood = trim($_POST['neighborhood']);
$institution = trim($_POST['institution']);
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Conexão com banco
require_once '../../../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.'); window.location.href = '../musicians.php';</script>";
    exit;
}

if ($password !== $confirmPassword) {
    echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
    exit;
}

$query = "SELECT image FROM musicians WHERE idMusician = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $idMusician);
$stmt->execute();
$result = $stmt->get_result();
$currentImage = $result->fetch_assoc()['image'];
$stmt->close();

$imageFileName = $currentImage;

if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Validação da imagem
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
    $uploadFileDir = '../../../../../../assets/images/musicians-images/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $destPath = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $imageFileName = $newFileName; // Atualizar com a nova imagem
    } else {
        die('Erro ao mover a imagem para o diretório.');
    }
}

// Atualizar no banco de dados
$stmt = $connect->prepare("UPDATE musicians SET login = ?, instrument = ?, bandGroup = ?, telephone = ?, responsible = ?, telephoneOfResponsible = ?, neighborhood = ?, institution = ?, image = ?, password = ? WHERE idMusician = ?");
if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.location.href = '../musicianProfile.php?idMusician={$idMusician}';</script>";
    exit;
}

$stmt->bind_param("ssssssssssi", $login, $instrument, $bandGroup, $telephone, $responsible, $telephoneOfResponsible, $neighborhood, $institution, $imageFileName, $password, $idMusician);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('O músico foi editado com sucesso!'); window.location.href = '../musicianProfile.php?idMusician={$idMusician}';</script>";
    } else {
        echo "<script>alert(' [ERRO] Nenhum dado editado!'); window.history.back();</script>";
    }

} else {
    error_log("Erro ao executar a query: " . $stmt->error);
    echo "<script>alert('Erro ao editar o músico.'); window.history.back();</script>";
}

$stmt->close();
$connect->close();

?>
