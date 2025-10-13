<?php
session_start();
require_once '../../../general-features/bdConnect.php';

// Valida se os campos foram enviados
if (empty(($_POST['login']) and empty($_POST['password']))) {
    echo "<script>alert('Dados incompletos.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=admLogin.php'>";
    exit;
}

// Captação de dados
$loginAdm = trim($_POST['login']);
$passwordAdm = trim($_POST['password']);

// Envio do SQL
$stmt = $connect->prepare("SELECT login, password FROM regency WHERE login = ?");
$stmt->bind_param("s", $loginAdm);
$stmt->execute();
$result = $stmt->get_result();

// Verificação de usuário
if ($result->num_rows > 0) {
    $res = $result->fetch_assoc();

    // Verificação de senha
    if ($passwordAdm == $res['password']) {
        $_SESSION['login'] = $res['login'];

        echo "<script>alert('Login concluído com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=../../AdmSession/admPage.php'>";
    } else {
        echo "<script>alert('Senha incorreta.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=admLogin.php'>";
    }
} else {
    echo "<script>alert('[ERRO] Administrador não encontrado!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=admLogin.php'>";
}

$stmt->close();
?>