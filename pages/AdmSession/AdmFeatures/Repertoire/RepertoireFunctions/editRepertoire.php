<?php
require_once '../../../../../general-features/bdConnect.php';

$id = intval($_POST['iid']);

if (empty($id)) {
    echo "<script>alert('[ERRO] Algo deu errado!'); window.history.back();</script>";
        exit;
}

$name = trim($_POST['name']);
$date = trim($_POST['date']);
$hour = trim($_POST['hour']);
$local = trim($_POST['local']);

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

$stmt = $connect->prepare("UPDATE `repertoire` SET `presentationName`= ?,`date`= ?,`hour`=?, `local`= ?,`bandGroup`= ?,`songs`= ? WHERE id = ?");
$stmt->bind_param("ssssssi", $name, $date, $hour, $local, $bandGroup, $songs, $id);

if ($stmt->execute()) {
    echo "<script>alert('Tocata editada com sucesso!'); window.location.href='../repertoire.php';</script>";
} else {
    echo "<script>alert('Erro ao editar.'); window.location.href='../repertoire.php';</script>";
}

$stmt->close();
$connect->close();

?>
