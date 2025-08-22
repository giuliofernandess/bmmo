<?php
if (!isset($_POST['idMusician'])) {
    die("ID do músico não foi enviado.");
}

$idMusician = $_POST['idMusician'];

// Conexão com banco
$connect = new mysqli('localhost', 'root', '', 'bmmo');
if ($connect->connect_error) {
    die("Erro de conexão: " . $connect->connect_error);
}

// Prepara a query DELETE
$stmt = $connect->prepare("DELETE FROM musicians WHERE idMusician = ?");
$stmt->bind_param("i", $idMusician);
$stmt->execute();

// Verifica se alguma linha foi afetada
if ($stmt->affected_rows > 0) {
    echo "<script>alert('Músico excluído com sucesso!'); window.location.href = 'musicians.php';</script>";
} else {
    echo "<script>alert('[ERRO] Falha na exclusão!'); window.location.href = 'editMusician.php';</script>";
}

$stmt->close();
$connect->close();
?>
