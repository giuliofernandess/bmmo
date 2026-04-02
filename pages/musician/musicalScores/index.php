<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/MusicalScoresDAO.php";

$musicalScoresDAO = new MusicalScoresDAO($conn);


Auth::requireMusician();

require_once BASE_PATH . "includes/getMusicianInfo.php";

$instrumentId = (int) $musicianInfo["instrument"];
$groupId = (int) $musicianInfo["band_group"];

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL . "assets/css/musicalScores.css"; ?>">

</head>

<body>
  <!-- Header -->
  <?php require_once BASE_PATH . "includes/secondHeader.php"; ?>

  <!-- Main -->
  <main class="container mb-5 p-5">
    <h1 class="my-4">Partituras</h1>

    <?php
    $filterName = trim($_GET['name-filter'] ?? '');
    $filterGenre = trim($_GET['musical-genre-filter'] ?? '');
    ?>

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body">

        <!-- Formulário de filtro de partituras -->
        <form method="GET" class="row g-3 align-items-end">

          <!-- Nome -->
          <div class="col-12 col-md-6">
            <label class="form-label fw-semibold">Nome da partitura</label>
            <input type="text" name="name-filter" value="<?= htmlspecialchars($filterName) ?>" class="form-control"
              placeholder="Digite o nome da partitura">
          </div>

          <!-- Gênero -->
          <div class="col-12 col-md-4">
            <label class="form-label fw-semibold">Gênero</label>
            <select name="musical-genre-filter" id="musical-genre-filter" class="form-select">
              <?php require BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
            </select>
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

    $musicsList = $musicalScoresDAO->getAllByInstrument(
      $instrumentId,
      $groupId,
      $filterName,
      $filterGenre
    );

    if (!empty($musicsList)) {
      $currentGenre = "";

      // Itera sobre cada partitura
      foreach ($musicsList as $res) {

        if ($currentGenre != htmlspecialchars($res['music_genre'] ?? '', ENT_QUOTES, 'UTF-8')) {
          if ($currentGenre != "") {
            echo "</div>";
          }

          $currentGenre = htmlspecialchars($res['music_genre'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$currentGenre</h2>";
          echo "<div class='row g-4'>";
        } ?>

        <div class='col-12 col-sm-6 col-lg-3'>
          <div class='card musician-card h-100 border-0 shadow-sm'>
            <a href="<?= BASE_URL ?>uploads/musical-scores/<?= $res['file'] ?>" target="_blank">
              <img src='<?= BASE_URL ?>assets/images/musical_score.jpg' class='card-img-top musical-score-img'
                alt='Capa de Partitura'>
            </a>
            <div class='card-body d-flex flex-column text-decoration-none'>
              <h5 class='card-title fw-semibold text-center mb-3'><?= htmlspecialchars($res['music_name']) ?></h5>
              <a href="<?= BASE_URL ?>uploads/musical-scores/<?= rawurlencode($res['file']) ?>"
                download="<?= htmlspecialchars($res['file']) ?>" class="btn btn-outline-primary mt-auto w-100">
                <i class="bi bi-download me-1"></i> Baixar Partitura
              </a>
            </div>
          </div>
        </div>

        <?php
      }
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