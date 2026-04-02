<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Models/Presentation.php';

$id = (int) ($_POST['id'] ?? 0);
$redirect = BASE_URL . 'pages/admin/presentations/index.php';

if ($id <= 0) {
    $_SESSION['error'] = 'Algo deu errado!';
    header('Location: ' . $redirect);
    exit;
}

$name = trim($_POST['name'] ?? '');
$date = trim($_POST['date'] ?? '');
$hour = trim($_POST['hour'] ?? '');
$local = trim($_POST['local'] ?? '');

if ($name === '' || $date === '' || $hour === '' || $local === '') {
    $_SESSION['error'] = 'Preencha todos os campos obrigatórios!';
    header('Location: ' . $redirect);
    exit;
}

try {
    $inputDate = new DateTime($date);
    $today = new DateTime('today');
} catch (Exception $e) {
    $_SESSION['error'] = 'Data inválida!';
    header('Location: ' . $redirect);
    exit;
}

if ($inputDate < $today) {
    $_SESSION['error'] = 'A data não pode ser menor que hoje!';
    header('Location: ' . $redirect);
    exit;
}

$bandGroups = $_POST['groups'] ?? [];
if (empty($bandGroups)) {
    $_SESSION['error'] = 'Selecione o(s) grupo(s) da banda!';
    header('Location: ' . $redirect);
    exit;
}

$songs = $_POST['songs'] ?? [];
if (empty($songs)) {
    $_SESSION['error'] = 'Selecione ao menos uma música!';
    header('Location: ' . $redirect);
    exit;
}

$presentationInfo = new Presentation();
$presentationInfo->setPresentationId($id);
$presentationInfo->setPresentationName($name);
$presentationInfo->setPresentationDate($date);
$presentationInfo->setPresentationHour($hour);
$presentationInfo->setLocalOfPresentation($local);
$presentationInfo->setGroups($bandGroups);
$presentationInfo->setSongs($songs);

if ($presentationsDAO->edit($presentationInfo)) {
    $_SESSION['success'] = 'Apresentação editada com sucesso!';
} else {
    $_SESSION['error'] = 'Erro ao editar apresentação!';
}

header('Location: ' . $redirect);
exit;
