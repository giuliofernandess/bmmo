<?php
require_once "../../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/MusicalScores.php";

Auth::requireRegency();

$groups = BandGroups::getAll();

// Verifica se recebeu o id do músico
$musicId = isset($_GET["musicId"]) ? (int) $_GET["musicId"] : null;

if (!$musicId) {
  header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/musicalScores/musicalScores.php");
  exit;
}

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Partituras</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

</head>

<body>
  <!-- Header -->
  <?php require BASE_PATH . "includes/secondHeader.php"; ?>

  <!-- Footer -->
  <?php require BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/showForm.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>