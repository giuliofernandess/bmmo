<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/MusicalScoresDAO.php";
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musicalScoresDAO = new MusicalScoresDAO($conn);


Auth::requireMusician();

require_once BASE_PATH . "helpers/getMusicianInfo.php";

$filterName = filter_input(INPUT_GET, 'musical_score_name_filter');
$filterGenre = filter_input(INPUT_GET, 'musical_score_genre_filter');

$musicsList = $musicalScoresDAO->getAllByInstrument(
  $instrumentId,
  $bandGroupId,
  $filterName,
  $filterGenre
);

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

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body">

        <!-- Formulário de filtro de partituras -->
        <form method="GET" class="row g-3 align-items-end">

          <!-- Nome -->
          <div class="col-12 col-md-6">
            <label class="form-label fw-semibold">Nome da partitura</label>
            <input type="text" name="musical_score_name_filter" value="<?= htmlspecialchars($filterName) ?>" class="form-control"
              placeholder="Digite o nome da partitura">
          </div>

          <!-- Gênero -->
          <div class="col-12 col-md-4">
            <label class="form-label fw-semibold">Gênero</label>
            <select name="musical_score_genre_filter" id="musical-score-genre-filter" class="form-select">
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
    if (!empty($musicsList)) {
      $currentGenre = "";

      // Itera sobre cada partitura
      foreach ($musicsList as $music) {
        $musicGenre = htmlspecialchars($music->getMusicGenre(), ENT_QUOTES, 'UTF-8');
        $musicName = htmlspecialchars($music->getMusicName(), ENT_QUOTES, 'UTF-8');
        $musicId = (int) ($music->getMusicId() ?? 0);
        $musicFile = (string) ($musicalScoresDAO->getFile($musicId, $instrumentId) ?? '');

        if ($currentGenre !== $musicGenre) {
          if ($currentGenre !== "") {
            echo "</div>";
          }

          $currentGenre = $musicGenre;
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$currentGenre</h2>";
          echo "<div class='row g-4'>";
        } ?>

        <div class='col-12 col-sm-6 col-lg-3'>
          <div class='card musician-card h-100 border-0 shadow-sm'>
            <a href="<?= BASE_URL ?>uploads/musical-scores/<?= rawurlencode($musicFile) ?>" target="_blank">
              <img src='<?= BASE_URL ?>assets/images/musical_score.jpg' class='card-img-top musical-score-img'
                alt='Capa de Partitura'>
            </a>
            <div class='card-body d-flex flex-column text-decoration-none'>
              <h5 class='card-title fw-semibold text-center mb-3'><?= $musicName ?></h5>
              <a href="<?= BASE_URL ?>uploads/musical-scores/<?= rawurlencode($musicFile) ?>"
                download="<?= htmlspecialchars($musicFile) ?>" class="btn btn-outline-primary mt-auto w-100">
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