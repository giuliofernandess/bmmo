<?php
require_once '../../../../general-features/bdConnect.php';

$name = trim($_POST['name']);
$date = trim($_POST['date']);
$hour = trim($_POST['hour']);

$inputDate = new DateTime($date);
$today = new DateTime('today');

if ($inputDate < $today) {
    echo "<script>alert('[ERRO] A data não pode ser menor que hoje!'); window.history.back();</script>";
        exit;
}

if (isset($_POST['bandGroup']) && !empty($_POST['bandGroup']))  {
    $bandGroup = implode('-',$_POST['bandGroup']);
} else {
    echo "<script>alert('[ERRO] Você não selecionou o grupo da banda!');
    window.history.back()</script>";
}

if (isset($_POST['songs']) && !empty($_POST['songs']))  {
    $songs = implode('-',$_POST['songs']);
} else {
    echo "<script>alert('[ERRO] Você não selecionou nenhuma música!');
    window.history.back()</script>";
}

$stmt = $connect->prepare("INSERT INTO `repertoire` (`presentationName`, `date`, `hour`, `bandGroup`, `songs`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $date, $hour, $bandGroup, $songs);

if ($stmt->execute()) {
    echo "<script>alert('Tocata adicionada com sucesso!'); window.location.href='repertoire.php';</script>";
} else {
    echo "<script>alert('Erro ao adicionar.'); window.location.href='repertoire.php';</script>";
}

$stmt->close();
$connect->close();

?>
