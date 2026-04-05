<?php

session_start();
require_once '../../../../config/config.php';

require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/Models/Presentation.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$presentationsDAO = new PresentationsDAO($conn);

Auth::requireRegency();

$name = postValueAny(['presentation_name', 'name']);
$date = postValueAny(['presentation_date', 'date']);
$hour = postValueAny(['presentation_hour', 'hour']);
$local = postValueAny(['presentation_location', 'local']);

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

validateRequiredFields([
    'Nome' => $name,
    'Data' => $date,
    'Hora' => $hour,
    'Local' => $local,
], $redirect);

try {
    $inputDate = new DateTime($date);
    $today = new DateTime('today');
} catch (Exception $e) {
    redirectWithMessage('error', 'Data inválida!', $redirect);
}

if ($inputDate < $today) {
    redirectWithMessage('error', 'A data não pode ser menor que hoje!', $redirect);
}

$bandGroups = $_POST['groups'] ?? [];
if (empty($bandGroups)) {
    redirectWithMessage('error', 'Selecione o(s) grupo(s) da banda!', $redirect);
}

$songs = $_POST['songs'] ?? [];
if (empty($songs)) {
    redirectWithMessage('error', 'Selecione ao menos uma música!', $redirect);
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
    redirectWithMessage('success', 'Apresentação inserida com sucesso!', $redirect);
} else {
    redirectWithMessage('error', 'Erro ao inserir apresentação!', $redirect);
}
