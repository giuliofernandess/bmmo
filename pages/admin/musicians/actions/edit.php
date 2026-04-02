<?php
session_start();
require_once "../../../../config/config.php";
require_once BASE_PATH . 'app/Auth/Auth.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/Models/Musician.php';

$musiciansDAO = new MusiciansDAO($conn);

Auth::requireRegency();

// Função auxiliar para tratar entrada
function postValue(string $key, string $type = 'string')
{
	if (!isset($_POST[$key]) || $_POST[$key] === '') {
		return null;
	}

	return $type === 'int'
		? (int) $_POST[$key]
		: trim($_POST[$key]);
}

// Recebimento de variáveis pelo método POST
$musicianId = postValue('musician-id');
$musicianLogin = postValue('login');
$instrument = postValue('instrument', 'int');
$bandGroup = postValue('group', 'int');
$musicianContact = postValue('contact');
$responsibleName = postValue('responsible');
$responsibleContact = postValue('contact-of-responsible');
$neighborhood = postValue('neighborhood');
$institution = postValue('institution');
$password = postValue('password');
$confirmPassword = postValue('confirm-password');

//Validação de imagem
$currentImage = $musiciansDAO->getProfileImage($musicianId);

$imageFileName = $currentImage;

if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
	$fileTmpPath = $_FILES['file']['tmp_name'];
	$fileName = $_FILES['file']['name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];
	$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

	$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

	if (!in_array($fileExtension, $allowedExtensions)) {
		Message::set('error', "Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.");
		header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/edit/index.php?musician_id={$musicianId}");
		exit;
	}

	if ($fileSize > 5 * 1024 * 1024) {
		Message::set('error', "Arquivo muito grande. Máximo permitido: 5MB.");
		header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/edit/index.php?musician_id={$musicianId}");
		exit;
	}

	$newFileName = uniqid('profile_', true) . '.' . $fileExtension;
	$uploadFileDir = BASE_PATH . 'uploads/musicians-images/';

	if (!is_dir($uploadFileDir)) {
		mkdir($uploadFileDir, 0755, true);
	}

	$destPath = $uploadFileDir . $newFileName;

	if (move_uploaded_file($fileTmpPath, $destPath)) {
		if ($currentImage && file_exists(BASE_PATH . 'uploads/musicians-images/' . $currentImage)) {
			unlink(BASE_PATH . 'uploads/musicians-images/' . $currentImage);
		}

		$imageFileName = $newFileName;
	} else {
		Message::set('error', "Erro ao enviar a imagem.");
		header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/edit/index.php?musician_id={$musicianId}");
		exit;
	}
}

/* Valida senha */
if (!empty($password) || !empty($confirmPassword)) {
	if ($password !== $confirmPassword) {
		Message::set('error', "As senhas não conferem.");
		header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/edit/index.php?musician_id={$musicianId}");
		exit;
	}
}

$musicianInfo = new Musician();
$musicianInfo->setMusicianId((int) $musicianId);
$musicianInfo->setMusicianLogin((string) $musicianLogin);
$musicianInfo->setInstrument((int) $instrument);
$musicianInfo->setBandGroup((int) $bandGroup);
$musicianInfo->setMusicianContact($musicianContact);
$musicianInfo->setResponsibleName($responsibleName);
$musicianInfo->setResponsibleContact($responsibleContact);
$musicianInfo->setNeighborhood((string) $neighborhood);
$musicianInfo->setInstitution($institution);
$musicianInfo->setProfileImage($imageFileName);
$musicianInfo->setPassword((string) ($password ?? ''));

if ($musiciansDAO->edit($musicianInfo)) {
	Message::set('success', "Músico editado com sucesso!");
} else {
	Message::set('error', "Erro ao editar o músico. Tente novamente.");
}

header("Location: " . BASE_URL . "pages/admin/musicians/musicianProfile/index.php?musician_id={$musicianId}");
exit;
