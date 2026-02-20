<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/MusicalScores.php";

Auth::requireRegency();
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Partituras</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/listOfMusicalScores.css">

</head>

<body>
  <!-- Header -->
  <?php require_once BASE_PATH . "includes/secondHeader.php"; ?>

  <!-- Main -->
  <main class="container mb-5 p-5">
    <h1 class="mt-4 text-center">Lista de Partituras</h1>

    <?php
    $groups = BandGroups::getAll();

    $filterName = trim($_GET['name'] ?? '');
    $filterGroup = trim($_GET['group'] ?? '');
    $filterGenre = trim($_GET['musical-genre'] ?? '');
    ?>

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">

          <!-- Nome -->
          <div class="col-12 col-md-4">
            <label class="form-label fw-semibold">Nome do músico</label>
            <input type="text" name="name" value="<?= htmlspecialchars($filterName) ?>" class="form-control"
              placeholder="Digite o nome">
          </div>

          <!-- Grupo -->
          <div class="col-12 col-md-3">
            <label class="form-label fw-semibold">Grupo da banda</label>
            <select name="group" class="form-select">
              <option value="">Todos</option>
              <?php foreach ($groups as $group): ?>
                <option value="<?= $group['group_id'] ?>" <?= $filterGroup == $group['group_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($group['group_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Gênero -->
          <div class="col-12 col-md-3">
            <label class="form-label fw-semibold">Gênero</label>
            <?php require_once BASE_PATH . "includes/selectMusicalGenre.php"; ?>
          </div>

          <!-- Botão submit -->
          <div class="col-12 col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-search me-1"></i> Filtrar
            </button>
          </div>

        </form>
      </div>
    </div>

    <?php
    $musicsList = MusicalScores::getAll(
      $filterName,
      $filterGroup,
      $filterGenre
    );

    if (!empty($musicsList)) {
      $currentGenre = "";
      $lastName = "";

      echo "<div class='row g-4'>";

      // Itera sobre cada músico
      foreach ($musicsList as $res) {

        // Dados do músico
        $musicName = htmlspecialchars($res['music_name'] ?? '', ENT_QUOTES, 'UTF-8');

        if ($currentGenre != htmlspecialchars($res['musical_genre'] ?? '', ENT_QUOTES, 'UTF-8')) {
          if ($currentGenre != "") {
            echo "</div>";
          }

          $currentGenre = htmlspecialchars($res['musical_genre'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$currentGenre</h2>";
          echo "<div class='row g-4'>";
        }

        if ($lastName != $musicName) {
          ?>
          <div class='col-12 col-sm-6 col-lg-3'>
            <div class='card musician-card h-100 border-0 shadow-sm'>
              <a href="MusicalScoreDetails/musicalScoreDetails.php?musicName=<?= htmlspecialchars($musicName) ?> ">
                <img src='<?= BASE_URL ?>assets/images/musical_score.jpg' class='card-img-top musical-score-img'
                  alt='Capa de Partitura'>
              </a>
              <a href="MusicalScoreEdit/musicalScoreEdit.php?musicName=<?= htmlspecialchars($musicName) ?> "
                class='card-body d-flex flex-column text-decoration-none'>
                <h5 class='card-title fw-semibold text-center mb-3'><?= htmlspecialchars($musicName) ?></h5>
                <button class='btn btn-outline-primary mt-auto w-100'>
                  <i class='bi bi-person-lines-fill me-1'></i> Editar Partitura
                </button>
              </a>
            </div>
          </div>
          <?php
        }

        $lastName = $musicName;
      }

      echo "</div>";
      echo "</div>";
    } else {
      echo "<div class='no-musics'>Nenhuma partitura encontrada.</div>";
    }
    ?>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . "includes/footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>