<?php
session_start();
require_once "../../../../../config/config.php";
require_once BASE_PATH . "app/Models/Presentations.php";

$id = intval($_POST['id']);

if (empty($id)) {
    $_SESSION['error'] = "Algo deu errado!";
    header("Location:" . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
    exit;
}

$name = trim($_POST['name']);
$date = trim($_POST['date']);
$hour = trim($_POST['hour']);
$local = trim($_POST['local']);

$inputDate = new DateTime($date);
$today = new DateTime('today');

if ($inputDate < $today) {
    $_SESSION['error'] = "A data não pode ser menor que hoje!";
    header("Location:" . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
    exit;
}

$bandGroups = $_POST['groups'] ?? [];

if (empty($bandGroups)) {
    $_SESSION['error'] = "Selecione o(s) grupo(s) da banda!";
    header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
    exit;
}

$songs = $_POST['songs'] ?? [];

if (empty($songs)) {
    $_SESSION['error'] = "Selecione ao menos uma música!";
    header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
    exit;
}

$presentationInfo = [
    "id" => $id,
    "name" => $name,
    "date"=> $date,
    "hour"=> $hour,
    "local"=> $local,
    "groups"=> $bandGroups,
    "songs"=> $songs
];

$editPresentation = Presentations::editPresentation($presentationInfo);

if ($editPresentation) {
    $_SESSION['success'] = "Apresentação editada com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao inserir apresentação!";
}

// Redireciona para a página principal de apresentações
header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
exit;

$stmt = $connect->prepare("");
$stmt->bind_param("ssssssi", $name, $date, $hour, $local, $bandGroup, $songs, $id);

if ($stmt->execute()) {
    echo "<script>alert('Tocata editada com sucesso!'); window.location.href='../repertoire.php';</script>";
} else {
    echo "<script>alert('Erro ao editar.'); window.location.href='../repertoire.php';</script>";
}

?>
