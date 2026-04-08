<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Models/Presentation.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$presentationsDAO = new PresentationsDAO($conn);

$id = filter_input(INPUT_POST, 'presentation_id');
$redirect = BASE_URL . 'pages/admin/presentations/index.php';

$name = filter_input(INPUT_POST, 'presentation_name');
$date = filter_input(INPUT_POST, 'presentation_date');
$hour = filter_input(INPUT_POST, 'presentation_hour');
$local = filter_input(INPUT_POST, 'presentation_location');

validateRequiredFields([
    'Identificador da apresentação' => $id,
    'name' => $name,
    'date' => $date,
    'hour' => $hour,
    'location' => $local,
], $redirect);

try {
    $inputDate = new DateTime($date);
    $today = new DateTime('today');
} catch (Exception $e) {
    redirectWithMessage($redirect, 'error', 'Data inválida!');
}

if ($inputDate < $today) {
    redirectWithMessage($redirect, 'error', 'A data não pode ser menor que hoje!');
}

$bandGroups = postArray('groups');
if (empty($bandGroups)) {
    redirectWithMessage($redirect, 'error', 'Selecione o(s) grupo(s) da banda!');
}

$songs = postArray('songs');
if (empty($songs)) {
    redirectWithMessage($redirect, 'error', 'Selecione ao menos uma música!');
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
    redirectWithMessage($redirect, 'success', 'Apresentação editada com sucesso!');
} else {
    redirectWithMessage($redirect, 'error', 'Erro ao editar apresentação!');
}
