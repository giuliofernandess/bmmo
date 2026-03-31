<?php

session_start();
require_once '../../../../config/config.php';

require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Auth/Auth.php';

Auth::requireRegency();

$name = trim($_POST['name'] ?? '');
$date = trim($_POST['date'] ?? '');
$hour = trim($_POST['hour'] ?? '');
$local = trim($_POST['local'] ?? '');

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

if ($name === '' || $date === '' || $hour === '' || $local === '') {
    $_SESSION['error'] = 'Preencha todos os campos obrigatorios!';
    header('Location: ' . $redirect);
    exit;
}

try {
    $inputDate = new DateTime($date);
    $today = new DateTime('today');
} catch (Exception $e) {
    $_SESSION['error'] = 'Data invalida!';
    header('Location: ' . $redirect);
    exit;
}

if ($inputDate < $today) {
    $_SESSION['error'] = 'A data nao pode ser menor que hoje!';
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
    $_SESSION['error'] = 'Selecione ao menos uma musica!';
    header('Location: ' . $redirect);
    exit;
}

$presentationInfo = [
    'name' => $name,
    'date' => $date,
    'hour' => $hour,
    'local' => $local,
    'groups' => $bandGroups,
    'songs' => $songs,
];

if ($presentationsDAO->create($presentationInfo)) {
    $_SESSION['success'] = 'Apresentacao inserida com sucesso!';
} else {
    $_SESSION['error'] = 'Erro ao inserir apresentacao!';
}

header('Location: ' . $redirect);
exit;
