<?php
session_start();

if (!isset($_POST['day'], $_POST['dayProgramation'])) {
    echo "<script>alert('Dados incompletos.'); window.location.href = 'weeklySchedule.php';</script>";
    exit;
}

$groupId = $_POST['id'];
$day = $_POST['day'];
$dayProgramation = $_POST['dayProgramation'];

$allowedDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

if (!in_array($day, $allowedDays)) {
    echo "<script>alert('Dia inválido.'); window.history.back();</script>";
    exit;
}

require_once '../../../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.');  window.history.back();</script>";
    exit;
}

$sql = "UPDATE agenda SET `$day` = ? WHERE id = '$groupId'";

$stmt = $connect->prepare($sql);
if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.history.back();</script>";
    exit;
}

$stmt->bind_param("s", $dayProgramation);

if ($stmt->execute()) {
    echo "<script>alert('Dia editado com sucesso!'); window.location.href = '../../bandGroups.php';</script>";
} else {
    error_log("Erro na execução da query: " . $stmt->error);
    echo "<script>alert('Erro ao editar o dia.'); window.history.back();</script>";
}

$stmt->close();
$connect->close();

?>
