<?php

$name = trim($_POST['login']);
$musicalGenre = trim($_POST['musicalGenre']);
$bandGroup = trim($_POST['bandGroup']);

require_once '../../../../../../../assets/general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.'); window.location.href = '../listOfMusicalScores.php';</script>";
    exit;
}

$stmt = $connect->prepare("UPDATE musical_scores SET bandGroup = ?, MusicalGenre = ? WHERE name = ?");

if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.location.href = '../listOfMusicalScores.php';</script>";
        exit;
}

$stmt->bind_param("sss", $bandGroup, $musicalGenre, $name);


if ($stmt->execute()) {
    echo "<script>alert('A partitura foi editada com sucesso!'); window.location.href = '../listOfMusicalScores.php';</script>";
} else {
    error_log("Erro ao executar a query: " . $stmt->error);
    echo "<script>alert('Erro ao editar a partitura.'); window.history.back();</script>";
}

$stmt->close();
$connect->close();

?>
