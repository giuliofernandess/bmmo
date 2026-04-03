<?php

session_start();
require_once '../../../../config/config.php';

require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/Models/Presentation.php';

$presentationsDAO = new PresentationsDAO($conn);

Auth::requireRegency();

$name = trim($_POST['presentation_name'] ?? $_POST['name'] ?? '');
$date = trim($_POST['presentation_date'] ?? $_POST['date'] ?? '');
$hour = trim($_POST['presentation_hour'] ?? $_POST['hour'] ?? '');
$local = trim($_POST['presentation_location'] ?? $_POST['local'] ?? '');

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

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
    'presentation_name' => $name,
    'presentation_date' => $date,
    'presentation_hour' => $hour,
    'local_of_presentation' => $local,
    'groups' => $bandGroups,
    'songs' => $songs,
]);

if ($presentationsDAO->create($presentationInfo)) {
    Message::set('success', 'Apresentação inserida com sucesso!');
} else {
    Message::set('error', 'Erro ao inserir apresentação!');
}

header('Location: ' . $redirect);
exit;
