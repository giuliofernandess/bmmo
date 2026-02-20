<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/MusicalScores.php";

Auth::requireRegency();

$groups = BandGroups::getAll();
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
  <!-- Toasts -->
  <?php require BASE_PATH . "includes/sucessToast.php"; ?>
  <?php require BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php require BASE_PATH . "includes/secondHeader.php"; ?>

  <!-- Main -->
  <main class="container mb-5 p-5">

    <!-- Título -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="mb-0">Lista de partituras</h1>
      <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="addIcon" onclick="showForm()"
        title="Adicionar Partitura"></i>
    </div>

    <!-- Formulário de adição de partitura-->
    <div class="bg-white p-4 rounded shadow-sm mb-4" style="display: none;" id="presentationForm">
      <h4 class="mb-3">Adicionar Partitura</h4>

      <form action="validateAddMusicalScore.php" method="post">

        <div class="mb-3">
          <label for="iname" class="form-label">Nome</label>
          <input type="text" name="name-add" id="iname" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="musical-genre" class="form-label">Gênero</label>
          <select name="musical-genre-add" id="musical-genre-add" class="form-select" required>
            <?php require BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Grupo da Banda</label><br>
          <?php foreach ($groups as $group): ?>
            <input type="checkbox" class="form-check-input" name="groups[]" value="<?= $group['group_id'] ?>">
            <label class="form-check-label"><?= $group['group_name'] ?></label><br>
          <?php endforeach; ?>
        </div>

        <div class="res mb-3"></div>

        <input type="submit" class="btn btn-outline-primary btn-lg rounded-pill w-100 mt-3" style="padding-top: 6px;"
          id="ibutton" value="Adicionar Partitura">

      </form>
    </div>

    <?php
    $filterName = trim($_GET['name-filter'] ?? '');
    $filterGroup = (int) ($_GET['group'] ?? 0);
    $filterGenre = trim($_GET['musical-genre-filter'] ?? '');
    ?>

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body">

        <!-- Formulário de filtro de partituras -->
        <form method="GET" class="row g-3 align-items-end">

          <!-- Nome -->
          <div class="col-12 col-md-4">
            <label class="form-label fw-semibold">Nome da partitura</label>
            <input type="text" name="name-filter" value="<?= htmlspecialchars($filterName) ?>" class="form-control"
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
            <select name="musical-genre-filter" id="musical-genre-filter" class="form-select" required>
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

    $musicsList = MusicalScores::getAll(
      $filterName,
      $filterGroup,
      $filterGenre
    );

    if (!empty($musicsList)) {
      $currentGenre = "";
      $lastName = "";

      // Itera sobre cada músico
      foreach ($musicsList as $res) {

        // Dados do músico
        $musicName = htmlspecialchars($res['music_name'] ?? '', ENT_QUOTES, 'UTF-8');
        $musicId = (int)$res['music_id'] ?? null;

        if ($currentGenre != htmlspecialchars($res['music_genre'] ?? '', ENT_QUOTES, 'UTF-8')) {
          if ($currentGenre != "") {
            echo "</div>";
          }

          $currentGenre = htmlspecialchars($res['music_genre'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$currentGenre</h2>";
          echo "<div class='row g-4'>";
        }

        if ($lastName != htmlspecialchars($res['music_name'] ?? '', ENT_QUOTES, 'UTF-8')) { ?>
          <div class='col-12 col-sm-6 col-lg-3'>
          <div class='card musician-card h-100 border-0 shadow-sm'>
            <a href="MusicalScoreDetails/musicalScoreDetails.php?musicId=<?= htmlspecialchars($musicId) ?>">
              <img src='<?= BASE_URL ?>assets/images/musical_score.jpg' class='card-img-top musical-score-img'
                alt='Capa de Partitura'>
            </a>
            <a href="MusicalScoreEdit/musicalScoreEdit.php?musicId=<?= htmlspecialchars($musicId) ?>"
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
        $lastName = htmlspecialchars($res['music_name'] ?? '', ENT_QUOTES,);
      }

      echo "</div>";
    } else {
      echo "<div class='no-musics'>Nenhuma partitura encontrada.</div>";
    }
    ?>
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