<?php

session_start();
require_once "../../../../../config/config.php";
require_once BASE_PATH . "app/Models/Presentations.php";

if (!isset($_GET['presentation_id']) || !is_numeric($_GET['presentation_id'])) {
    $_SESSION['error'] = "Algo deu errado!";
    header("Location:" . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
    exit;
} else {
    $id = intval($_GET['presentation_id']);
}

$deletePresentation = Presentations::deletePresentation($id);

if ($deletePresentation) {
    $_SESSION['success'] = "Apresentação excluida com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao excluir apresentação!";
}

// Redireciona para a página principal de apresentações
header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/Presentations/presentations.php");
exit;

?>