<?php

$day = $_POST['day'];
$dayProgramation = $_POST['dayProgramation'];

// Conexão com banco
$connect = new mysqli('localhost', 'root', '', 'bmmo');
if ($connect->connect_error) {
    die("Erro de conexão: " . $connect->connect_error);
}

$sql = "UPDATE `agenda` SET `$day` = '$dayProgramation'";

$result = $connect->query($sql);

echo "<script>alert('Dia editado com sucesso!'); window.location.href = 'weeklySchedule.php';</script>";

?>
