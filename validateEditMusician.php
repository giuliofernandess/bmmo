<?php

// Dados do formulário
$idMusician = $_POST['idMusician'];
$instrument = $_POST['instrument'];
$telephone = $_POST['telephone'];
$responsible = $_POST['responsible'];
$telephoneOfResponsible = $_POST['contactOfResponsible'];
$neighborhood = $_POST['neighborhood'];
$institution = $_POST['institution'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$connect = mysqli_connect('localhost', 'root', '', 'bmmo') or die('Erro de conexão: ' . mysqli_connect_error());

if (!empty($password)) {
    if ($password == $confirmPassword) {
        $sql = "UPDATE `musicians` SET `instrument`='$instrument', `telephone`='$telephone', `responsible`='$responsible,`telephoneOfResponsible`='$telephoneOfResponsible', `institution`='$institution', `password`='$password' WHERE `idMusician` = '$idMusician'";

        $result = $connect->query($sql);

        echo "<script type ='text/javascript'>
        alert('O músico foi editado!');
        </script>";

        echo "<meta http-equiv='refresh' content='0; url=musicians.php'>";
    } else {
        echo "<script type ='text/javascript'>
        alert('[ERRO] Senhas não conferem!');
        </script>";

        echo "<meta http-equiv='refresh' content='0; url=editMusician.php'>";
    }
} else {
    $sql = "UPDATE `musicians` SET `instrument`='$instrument', `telephone`='$telephone', `responsible`='$responsible',`telephoneOfResponsible`='$telephoneOfResponsible', `institution`='$institution' WHERE `idMusician` = '$idMusician'";

    $result = $connect->query($sql);

    echo "<script type ='text/javascript'>
    alert('O músico foi editado!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=musicians.php'>";
}

?>
