<?php
session_start();

if (!isset($_POST['idMusician']) || !filter_var($_POST['idMusician'], FILTER_VALIDATE_INT)) {
    echo "<script>alert('ID do músico inválido ou não enviado.'); window.history.back()</script>";
    exit;
}

$idMusician = (int) $_POST['idMusician'];

// Conexão com banco
require_once '../../../../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.'); window.history.back()</script>";
    exit;
}

$query = "SELECT bandGroup, image FROM musicians WHERE idMusician = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $idMusician);
$stmt->execute();
$result = $stmt->get_result();
$musician = $result->fetch_assoc();
$stmt->close();

if (!$musician) {
    echo "<script>alert('Músico não encontrado.'); window.history.back()</script>";
    exit;
}

$bandGroup = $musician['bandGroup'];
$currentImage = $musician['image'];

$stmt = $connect->prepare("DELETE FROM musicians WHERE idMusician = ?");
if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.history.back()</script>";
    exit;
}

$stmt->bind_param("i", $idMusician);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    if ($currentImage && file_exists('../../../../../../../assets/images/musicians-images/' . $currentImage)) {
        unlink('../../../../../../../assets/images/musicians-images/' . $currentImage);
    }

    echo "<script>alert('Músico excluído com sucesso!'); window.location.href = '../../../musicians.php?bandGroup=$bandGroup';</script>";
} else {
    echo "<script>alert('Nenhum músico foi excluído. Verifique o ID informado.'); window.history.back()</script>";
}

$stmt->close();
$connect->close();
?>
