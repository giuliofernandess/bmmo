<?php

function ageAdmission($dateOfBirth, $yearOfAdmission) {
    $birth = new DateTime($dateOfBirth);
    $today = new DateTime();

    $admissionDate = DateTime::createFromFormat('Y', $yearOfAdmission);
    $ageAtAdmission = $admissionDate->diff($birth)->y;

    if ($ageAtAdmission >= 12) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function ageVerification($dateOfBirth) {
    $birth = new DateTime($dateOfBirth);
    $today = new DateTime();

    if ($birth < $today) {
        return TRUE;
    } else {
        return FALSE;
    }

}

/* Captação de variáveis, conexão e comando sql */
$name = $_POST['name'];
$dateOfBirth = $_POST['dateOfBirth'];
$instrument = $_POST['instrument'];
$yearOfAdmission = $_POST['yearOfAdmission'];
$telephone = $_POST['telephone'];
$responsible = $_POST['responsible'];
$contactOfResponsible = $_POST['contactOfResponsible'];
$neighborhood = $_POST['neighborhood'];
$institution = $_POST['institution'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$connect = mysqli_connect('localhost', 'root', '', 'bmmo') or die('Erro de conexão'. mysqli_connect_error());

/* Tratamento de erros */
if ($password != $confirmPassword) {
    echo "<script type ='text/javascript'>
    alert('[ERRO] Senhas não conferem!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=musicianRegister.php'>";
    
} elseif(ageVerification($dateOfBirth) == FALSE) {
    echo "<script type ='text/javascript'>
    alert('[ERRO] Data de nascimento inválida!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=musicianRegister.php'>";

} elseif(ageAdmission($dateOfBirth, $yearOfAdmission) == FALSE) {
    echo "<script type ='text/javascript'>
    alert('[ERRO] Data de admissão inválida!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=musicianRegister.php'>";

} else {
    $sql = "INSERT INTO `musicians`(`name`, `dateOfBirth`, `instrument`, `yearOfAdmission`, `telephone`, `responsible`, `telephoneOfResponsible`, `neighborhood`, `institution`, `password`) VALUES ('$name', '$dateOfBirth','$instrument', '$yearOfAdmission', '$telephone',  '$responsible', '$contactOfResponsible', '$neighborhood', '$institution', '$password')";
    
    $result = $connect->query($sql);

    echo "<script type ='text/javascript'>
    alert('Músico cadastrado com sucesso!');
    </script>";

    echo "<meta http-equiv='refresh' content='0; url=musicianRegister.php'>";
}

?>
