<?php
session_start();

if (!isset($_POST['idMusician']) || !filter_var($_POST['idMusician'], FILTER_VALIDATE_INT)) {
    echo "<script>alert('ID do músico inválido ou não enviado.'); window.location.href = 'musicians.php';</script>";
    exit;
}

$idMusician = (int)$_POST['idMusician'];

// Conexão com banco
require_once '../../../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.'); window.location.href = '../../musicians.php';</script>";
    exit;
}

// Prepara a query DELETE
$stmt = $connect->prepare("DELETE FROM musicians WHERE idMusician = ?");
if (!$stmt) {
    error_log("Erro na preparação da query: " . $connect->error);
    echo "<script>alert('Erro interno no servidor.'); window.location.href = '../../musicians.php';</script>";
    exit;
}

$stmt->bind_param("i", $idMusician);
$stmt->execute();

// Verifica se alguma linha foi afetada
if ($stmt->affected_rows > 0) {
    echo "<script>alert('Músico excluído com sucesso!'); window.location.href = '../../musicians.php';</script>";
} else {
    echo "<script>alert('[ERRO] Nenhum músico foi excluído. Verifique o ID informado.'); window.location.href = '../musicianEdit.php?idMusician=" . $idMusician . "';</script>";
}

$stmt->close();
$connect->close();
?>
