<?php

session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'helpers/requestHelpers.php';

$presentationsDAO = new PresentationsDAO($conn);

Auth::requireRegency();

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('error', 'Metodo inválido para exclusao!', $redirect);
}

if (!isset($_POST['presentation_id']) || !is_numeric($_POST['presentation_id'])) {
    redirectWithMessage('error', 'Algo deu errado!', $redirect);
}

$presentationId = (int) $_POST['presentation_id'];

if ($presentationsDAO->delete($presentationId)) {
    redirectWithMessage('success', 'Apresentação excluída com sucesso!', $redirect);
} else {
    redirectWithMessage('error', 'Erro ao excluir apresentação!', $redirect);
}
