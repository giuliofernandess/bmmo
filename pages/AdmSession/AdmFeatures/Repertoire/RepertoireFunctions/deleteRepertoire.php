<?php

require_once '../../../../../general-features/bdConnect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>alert('Houve um erro!'); window.history.back();</script>";
  exit;
} else {
    $id = intval($_GET['id']);
}

$stmt = $connect->prepare("DELETE FROM repertoire WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Tocata excluida com sucesso!'); window.location.href='../repertoire.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir.'); window.location.href='repertoire.php';</script>";
}

$stmt->close();
$connect->close();

?>
