<?php

require_once '../../../../../config/config.php';

require_once BASE_PATH . 'app/Models/Presentations.php';
require_once BASE_PATH . 'app/Auth/Auth.php';

Auth::requireRegency();

//Recebimento de variáveis
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
    "name" => $name,
    "date"=> $inputDate,
    "hour"=> $hour,
    "local"=> $local
];

$createPresentation = Presentations::createPresentation($presentationInfo);

if ($createPresentation) {
    $_SESSION['success'] = "Apresentação inserida com sucesso!";
    exit;
} else {
    $_SESSION['error'] = "Erro ao inserir apresentação!";
    exit;
}

// Redireciona para a página principal de partituras
header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
exit;

?>
