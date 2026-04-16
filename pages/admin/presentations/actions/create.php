<?php

session_start();
require_once '../../../../config/config.php';

require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
$auth = new Auth();
require_once BASE_PATH . 'app/Models/Presentation.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$presentationsDAO = new PresentationsDAO($conn);

$auth->requireRegency();

$presentationName = filter_input(INPUT_POST, 'presentation_name');
$presentationDate = filter_input(INPUT_POST, 'presentation_date');
$presentationHour = filter_input(INPUT_POST, 'presentation_hour');
$presentationLocation = filter_input(INPUT_POST, 'presentation_location');

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

validateRequiredFields([
    'presentation_name' => $presentationName,
    'presentation_date' => $presentationDate,
    'presentation_hour' => $presentationHour,
    'presentation_location' => $presentationLocation,
], $redirect);

try {
    $inputDate = new DateTime($presentationDate);
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
    'presentation_name' => $presentationName,
    'presentation_date' => $presentationDate,
    'presentation_hour' => $presentationHour,
    'local_of_presentation' => $presentationLocation,
    'groups' => $bandGroups,
    'songs' => $songs,
]);

if ($presentationsDAO->create($presentationInfo)) {
    redirectWithMessage($redirect, 'success', 'Apresentação inserida com sucesso!');
} else {
    redirectWithMessage($redirect, 'error', 'Erro ao inserir apresentação!');
}
