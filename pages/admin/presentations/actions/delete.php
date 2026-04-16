<?php

session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
$auth = new Auth();
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$presentationsDAO = new PresentationsDAO($conn);

$auth->requireRegency();

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage($redirect, 'error', 'Metodo inválido para exclusao!');
}

$presentationId = filter_input(INPUT_POST, 'presentation_id');

if ($presentationId <= 0) {
    redirectWithMessage($redirect, 'error', 'Algo deu errado!');
}

if ($presentationsDAO->delete($presentationId)) {
    redirectWithMessage($redirect, 'success', 'Apresentação excluída com sucesso!');
} else {
    redirectWithMessage($redirect, 'error', 'Erro ao excluir apresentação!');
}
