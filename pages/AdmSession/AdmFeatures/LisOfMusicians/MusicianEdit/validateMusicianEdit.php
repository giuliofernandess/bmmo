<?php
session_start();

$requiredFields = ['idMusician', 'instrument', 'telephone', 'responsible', 'contactOfResponsible', 'neighborhood', 'institution'];

$idMusician = (int)$_POST['idMusician'];
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
require_once '../../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.'); window.location.href = '../musicians.php';</script>";
    exit;
}

if (!empty($password)) {
    if ($password !== $confirmPassword) {
        echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
        exit;
    }

    // Hash da senha
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connect->prepare("UPDATE musicians SET login = ?, instrument = ?, bandGroup = ?, telephone = ?, responsible = ?, telephoneOfResponsible = ?, neighborhood = ?, institution = ?, password = ? WHERE idMusician = ?");
    if (!$stmt) {
        error_log("Erro na preparação da query: " . $connect->error);
        echo "<script>alert('Erro interno no servidor.'); window.location.href = '../musicians.php';</script>";
        exit;
    }

    $stmt->bind_param("sssssssssi", $login, $instrument, $bandGroup, $telephone, $responsible, $telephoneOfResponsible, $neighborhood, $institution, $password, $idMusician);
} else {
    $stmt = $connect->prepare("UPDATE musicians SET login = ?, instrument = ?, bandGroup = ?, telephone = ?, responsible = ?, telephoneOfResponsible = ?, neighborhood = ?, institution = ? WHERE idMusician = ?");
    if (!$stmt) {
        error_log("Erro na preparação da query: " . $connect->error);
        echo "<script>alert('Erro interno no servidor.'); window.location.href = '../musicians.php';</script>";
        exit;
    }

    $stmt->bind_param("ssssssssi", $login, $instrument, $bandGroup, $telephone, $responsible, $telephoneOfResponsible, $neighborhood, $institution, $idMusician);
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('O músico foi editado com sucesso!'); window.location.href = '../musicians.php';</script>";
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
