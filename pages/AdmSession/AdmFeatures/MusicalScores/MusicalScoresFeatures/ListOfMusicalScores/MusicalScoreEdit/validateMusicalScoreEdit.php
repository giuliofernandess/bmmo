<?php

require_once '../../../../../../../general-features/bdConnect.php';
if ($connect->connect_error) {
    error_log("Erro de conexão: " . $connect->connect_error);
    echo "<script>alert('Erro ao conectar com o banco de dados.'); window.history.back();</script>";
    exit;
}

$name = trim($_POST['name']);
$instrument = trim($_POST['instrument']);
$bandGroup = $_POST['bandGroup'];

$query = "SELECT file FROM musical_scores WHERE name = ? and instrument = ?";
$stmt = $connect -> prepare($query);
$stmt -> bind_param("ss", $name, $instrument);
$stmt -> execute();
$result = $stmt->get_result();
$currentFile = $result->fetch_assoc()['file'];
$stmt->close();

// Validação simples do arquivo
$FileName = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['pdf'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        die('Extensão de arquivo inválida. Permitido apenas pdf');
    }

    if ($fileSize > 5 * 1024 * 1024) {
        die('Arquivo muito grande. Máximo permitido: 5MB.');
    }

    $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
    $uploadFileDir = '../../../../../../assets/musical-scores/';

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $destPath = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $FileName = $newFileName;
    } else {
        die('Erro ao mover o arquivo para o diretório.');
    }
}

$hasBandGroupUpdate = !empty($bandGroup);
$hasFileUpdate = !empty($instrument) && !empty($newFileName);

if ($hasBandGroupUpdate || $hasFileUpdate) {
    if (!empty($bandGroup)) {
        $bandGroups = implode(' ',$bandGroup);

        $stmt = $connect -> prepare("UPDATE `musical_scores` SET bandGroup = ? WHERE name = ?");
        $stmt -> bind_param("ss", $bandGroups, $name);
        $stmt -> execute();

        $stmt->close();
    }

    if (!empty($instrument) && !empty($_FILES['file'])) {
        $stmt = $connect -> prepare("UPDATE `musical_scores` SET file = ? WHERE name = ? and instrument = ?");
        $stmt -> bind_param("sss", $newFileName, $name, $instrument);
        $stmt -> execute();

        $stmt->close();

        if ($currentFile && file_exists('../../../../../../../assets/musical-scores/' . $currentFile)) {
            unlink('../../../../../../../assets/musical-scores/' . $currentFile);
        }
    }

    echo "<script>alert('Atualizações feitas com sucesso com sucesso!'); window.location.href='../listOfMusicalScores.php';</script>";
} else {
    echo "<script>alert('Dados incompletos!'); window.history.back();</script>";
}

?>
