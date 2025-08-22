<?php

$loginAdm = $_POST['login'];
$passwordAdm = $_POST['password'];

$connect = mysqli_connect('localhost', 'root', '', 'bmmo') or die('Erro de conexão'. mysqli_connect_error());

$sql = "SELECT * FROM `regency` WHERE `login` = '$loginAdm' and `password` = '$passwordAdm'";

$result = $connect->query($sql);

/* Tratamento de erros */
if (mysqli_num_rows($result) > 0) {
    session_start();

    $res = $result->fetch_array();
    $_SESSION['login'] = $res['login'];

    echo "<script type ='text/javascript'>
    alert('Login concluído com sucesso!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=admPage.php'>";

} else {
    echo "<script type ='text/javascript'>
    alert('[ERRO] Administrador não encontrado!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=admLogin.php'>";
}

?>
