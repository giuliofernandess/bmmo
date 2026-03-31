<?php
session_start();
require_once '../../../../config/config.php';
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';

Auth::requireRegency();

// Recebe dados do formulário
$musicName = trim($_POST['name-add'] ?? '');
$musicGenre = trim($_POST['musical-genre-add'] ?? '');
$musicGroups = $_POST['groups'] ?? [];

// Validação rápida
if (empty($musicName) || empty($musicGenre)) {
	$_SESSION['error'] = "Nome e gênero são obrigatórios.";
	header("Location: ../index.php");
	exit;
}

$musicalScoreAdd = $musicalScoresDAO->create([
	'music_name' => $musicName,
	'music_genre' => $musicGenre,
	'music_groups' => $musicGroups,
]);

if ($musicalScoreAdd !== false) {
	$_SESSION['success'] = "Partitura criada com sucesso!";
} else {
	$_SESSION['error'] = "Erro ao criar partitura.";

	header("Location: ../index.php");
	exit;
}

// Redireciona para a página de edição da partitura
header("Location: ../edit/index.php?musicId={$musicalScoreAdd}");
exit;
