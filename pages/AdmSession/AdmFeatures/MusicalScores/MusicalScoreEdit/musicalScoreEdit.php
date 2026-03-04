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

$musicalScores = MusicalScores::getById($musicId);

if (!$musicalScores) {
  echo "<div class='alert alert-warning m-4'>Partitura não encontrada.</div>";
  exit;
}

// Recebimento de variáveis
$music_name = trim($musicalScores['music_name'] ?? '');
$music_genre = trim($musicalScores['music_genre'] ?? '');
$group_name = trim($musicalScores['group_name'] ?? '');

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

  <main class="container mb-5 p-5">
    <!-- Título -->
    <h1 class="mb-3">Edição de partituras</h1>

    <!-- Form -->
    <form method="post" action="validateMusicalScoreEdit.php" enctype="multipart/form-data" class="row g-3">

      <!-- Nome -->
      <div class="col-12 col-md-4 mb-3">
        <label for="iname" class="form-label">Nome</label>
        <input type="text" name="name" id="iname" class="form-control" value="<?= $music_name ?>">
      </div>

      <!-- Gênero -->
      <div class="col-12 col-md-4 mb-3">
        <label for="igenre" class="form-label fw-semibold">Gênero</label>
        <select name="genre" id="igenre" class="form-select">
          <option value="<?= $music_genre ?>"><?= $music_genre ?></option>
          <?php require BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
        </select>
      </div> 

      <!-- Grupo -->
      <div class="col-12 col-md-3">
        <label class="form-label fw-semibold">Grupo da banda</label>
        <select name="group" class="form-select">
          <option value="<?= $group_name ?>"><?= $group_name ?></option>
          <?php foreach ($groups as $group): ?>
            <option value="<?= $group['group_id'] ?>" <?= $filterGroup == $group['group_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($group['group_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

    </form>
  </main>

  <!-- Footer -->
  <?php require BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/showForm.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>