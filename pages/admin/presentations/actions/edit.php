<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Models/Presentation.php';

$presentationsDAO = new PresentationsDAO($conn);

$id = (int) ($_POST['id'] ?? 0);
$redirect = BASE_URL . 'pages/admin/presentations/index.php';

if ($id <= 0) {
    Message::set('error', 'Algo deu errado!');
    header('Location: ' . $redirect);
    exit;
}

$name = trim($_POST['name'] ?? '');
$date = trim($_POST['date'] ?? '');
$hour = trim($_POST['hour'] ?? '');
$local = trim($_POST['local'] ?? '');

if ($name === '' || $date === '' || $hour === '' || $local === '') {
    Message::set('error', 'Preencha todos os campos obrigatórios!');
    header('Location: ' . $redirect);
    exit;
}

try {
    $inputDate = new DateTime($date);
    $today = new DateTime('today');
} catch (Exception $e) {
    Message::set('error', 'Data inválida!');
    header('Location: ' . $redirect);
    exit;
}

if ($inputDate < $today) {
    Message::set('error', 'A data não pode ser menor que hoje!');
    header('Location: ' . $redirect);
    exit;
}

$bandGroups = $_POST['groups'] ?? [];
if (empty($bandGroups)) {
    Message::set('error', 'Selecione o(s) grupo(s) da banda!');
    header('Location: ' . $redirect);
    exit;
}

$songs = $_POST['songs'] ?? [];
if (empty($songs)) {
    Message::set('error', 'Selecione ao menos uma música!');
    header('Location: ' . $redirect);
    exit;
}

$presentationInfo = Presentation::fromArray([
    'presentation_id' => $id,
    'presentation_name' => $name,
    'presentation_date' => $date,
    'presentation_hour' => $hour,
    'local_of_presentation' => $local,
    'groups' => $bandGroups,
    'songs' => $songs,
]);

if ($presentationsDAO->edit($presentationInfo)) {
    Message::set('success', 'Apresentação editada com sucesso!');
} else {
    Message::set('error', 'Erro ao editar apresentação!');
}

header('Location: ' . $redirect);
exit;
