<?php

session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';

Auth::requireRegency();

$redirect = BASE_URL . 'pages/admin/presentations/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Message::set('error', 'Metodo inválido para exclusao!');
    header('Location: ' . $redirect);
    exit;
}

if (!isset($_POST['presentation_id']) || !is_numeric($_POST['presentation_id'])) {
    Message::set('error', 'Algo deu errado!');
    header('Location: ' . $redirect);
    exit;
}

$id = (int) $_POST['presentation_id'];

if ($presentationsDAO->delete($id)) {
    Message::set('success', 'Apresentação excluída com sucesso!');
} else {
    Message::set('error', 'Erro ao excluir apresentação!');
}

header('Location: ' . $redirect);
exit;
