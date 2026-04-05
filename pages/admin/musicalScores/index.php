<?php
require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . "app/DAO/MusicalScoresDAO.php";

$bandGroupsDAO = new BandGroupsDAO($conn);
$musicalScoresDAO = new MusicalScoresDAO($conn);

Auth::requireRegency();

$groups = $bandGroupsDAO->getAll();
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
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicalScores.css">

</head>

<body>
  <!-- Toasts -->
  <?php include_once BASE_PATH . "includes/successToast.php"; ?>
  <?php include_once BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

  <!-- Main -->
  <main class="container mb-5 p-5">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="mb-0">Lista de partituras</h1>
      <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="form-toggle-icon"
        title="Adicionar Partitura"></i>
    </div>

    <!-- Formulário de adição de partitura-->
    <div class="bg-white p-4 rounded shadow-sm mb-4 is-hidden" id="musical-score-form-container">
      <h4 class="mb-3">Adicionar Partitura</h4>

      <form id="musical-score-form-element" action="<?= BASE_URL ?>pages/admin/musicalScores/actions/create.php" method="post">

        <div class="mb-3">
          <label for="musical-score-name" class="form-label">Nome *</label>
          <input type="text" name="musical_score_name" id="musical-score-name" class="form-control" placeholder="Nome da partitura" required>
        </div>

        <div class="mb-3">
          <label for="musical-score-genre" class="form-label">Gênero *</label>
          <select name="musical_score_genre" id="musical-score-genre" class="form-select" required>
            <?php require BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Grupo da Banda</label><br>
          <?php foreach ($groups as $group) { ?>
            <?php $groupId = (int) ($group->getGroupId() ?? 0); ?>
            <input type="checkbox" class="form-check-input" name="musical_score_groups[]" value="<?= $groupId ?>">
            <label class="form-check-label"><?= htmlspecialchars($group->getGroupName()) ?></label><br>
          <?php } ?>
        </div>

        <div class="res mb-3"></div>

        <input type="submit" class="btn btn-primary btn-lg w-100 mt-3 fw-bold"
                    id="musical-score-submit" value="Adicionar Partitura">

      </form>
    </div>

    <?php
    $filterName = trim($_GET['musical_score_name_filter'] ?? '');
    $filterGroup = (int)($_GET['band_group_filter'] ?? 0);
    $filterGenre = trim($_GET['musical_score_genre_filter'] ?? '');
    ?>

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body">

        <!-- Formulário de filtro de partituras -->
        <form method="GET" class="row g-3 align-items-end">

          <!-- Nome -->
          <div class="col-12 col-md-4">
            <label class="form-label fw-semibold">Nome da partitura</label>
            <input type="text" name="musical_score_name_filter" value="<?= htmlspecialchars($filterName) ?>" class="form-control"
              placeholder="Nome da partitura">
          </div>

          <!-- Grupo -->
          <div class="col-12 col-md-3">
            <label class="form-label fw-semibold">Grupo da banda</label>
            <select name="band_group_filter" class="form-select">
              <option value="">Todos</option>
              <?php foreach ($groups as $group) { ?>
                <?php $groupId = (int) ($group->getGroupId() ?? 0); ?>
                <option value="<?= $groupId ?>" <?= $filterGroup === $groupId ? 'selected' : '' ?>>
                  <?= htmlspecialchars($group->getGroupName()) ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <!-- Gênero -->
          <div class="col-12 col-md-3">
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

    $musicsList = $musicalScoresDAO->getAll([
        'music_name' => $filterName,
        'band_group' => $filterGroup,
        'music_genre' => $filterGenre
      ]);

    if (!empty($musicsList)) {
      $currentGenre = "";
      $lastName = "";

      // Itera sobre cada partitura
      foreach ($musicsList as $music) {

        // Dados do partitura
        $musicName = htmlspecialchars($music->getMusicName(), ENT_QUOTES, 'UTF-8');
        $musicId = (int) ($music->getMusicId() ?? 0);
        $musicGenre = htmlspecialchars($music->getMusicGenre(), ENT_QUOTES, 'UTF-8');

        if ($currentGenre !== $musicGenre) {
          if ($currentGenre !== "") {
            echo "</div>";
          }

          $currentGenre = $musicGenre;
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$currentGenre</h2>";
          echo "<div class='row g-4'>";
        }

        if ($lastName !== $musicName) { ?>
          <div class='col-12 col-sm-6 col-lg-3'>
            <div class='card musician-card h-100 border-0 shadow-sm'>
              <img src='<?= BASE_URL ?>assets/images/musical_score.jpg' class='card-img-top musical-score-img'
                alt='Capa de Partitura'>
              <a href="<?= BASE_URL ?>pages/admin/musicalScores/edit/index.php?musicId=<?= $musicId ?>"
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
    } else {
      echo "<div class='no-musics'>Nenhuma partitura encontrada.</div>";
    }
    ?>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/showForm.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>