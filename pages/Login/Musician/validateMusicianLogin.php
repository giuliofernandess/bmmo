<?php
session_start();
require_once '../../../general-features/bdConnect.php';

// Valida se os campos foram enviados
if (!isset($_POST['login'], $_POST['password'])) {
    echo "<script>alert('Dados incompletos.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=musicianLogin.php'>";
    exit;
}

// Captação de dados
$login = trim($_POST['login']);
$password = trim($_POST['password']);

// Envio do SQL
$stmt = $connect->prepare("SELECT login, password, bandGroup FROM musicians WHERE login = ? and password = ?");
$stmt->bind_param("ss", $login, $password);
$stmt->execute();
$result = $stmt->get_result();

// Verificação de usuário
if ($result->num_rows > 0) {
    $res = $result->fetch_assoc();

    // Verificação de senha
    if ($password == $res['password']) {
        $_SESSION['login'] = $res['login'];
        $_SESSION['bandGroup'] = $res['bandGroup'];

        echo "<script>alert('Login concluído com sucesso!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=../../MusicianSession/musicianPage.php'>";
    } else {
        echo "<script>alert('Senha incorreta.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=musicianLogin.php'>";
    }
} else {
    echo "<script>alert('[ERRO] Músico não encontrado!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=musicianLogin.php'>";
}

$stmt->close();
?>
