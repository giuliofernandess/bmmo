<?php
session_start();
require_once '../../../config/config.php';
require_once BASE_PATH . 'utilities/bdConnect.php';

// Valida se os campos foram enviados
if (!isset($_POST['login'], $_POST['password'])) {
    $_SESSION['error'] = "Preencha todos os campos.";
    exit;
}

// Captação de dados
$loginAdm = trim($_POST['login']);
$passwordAdm = trim($_POST['password']);

// Envio do SQL
$stmt = $connect->prepare("SELECT regency_login, password FROM regency WHERE regency_login = ?");
$stmt->bind_param("s", $loginAdm);
$stmt->execute();
$result = $stmt->get_result();

// Verificação de usuário
if ($result->num_rows > 0) {
    $res = $result->fetch_assoc();

    // Verificação de senha
    if ($passwordAdm == $res['password']) {
        $_SESSION['login'] = $res['regency_login'];

        header("Location: ../../AdmSession/admPage.php");
        exit;
    } else {
        $_SESSION['error'] = "Login ou senha inválidos.";
        header("Location: admLogin.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Login ou senha inválidos.";
    header("Location: admLogin.php");
    exit;
}

$stmt->close();
?>
