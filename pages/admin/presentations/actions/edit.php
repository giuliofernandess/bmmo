<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Models/Presentation.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$presentationsDAO = new PresentationsDAO($conn);

$id = (int) (requestValue('presentation_id', 'int', 'post') ?? 0);
$redirect = BASE_URL . 'pages/admin/presentations/index.php';

$name = requestValue('presentation_name', 'string', 'post');
$date = requestValue('presentation_date', 'string', 'post');
$hour = requestValue('presentation_hour', 'string', 'post');
$local = requestValue('presentation_location', 'string', 'post');

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
