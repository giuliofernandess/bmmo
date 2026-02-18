<?php
require_once "../../../../config/config.php";

require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/Instruments.php";

Auth::requireRegency();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon" />

  <!-- Bootstrap + CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicians.css">

  <title>Relação de músicos</title>
</head>

<body>
  <!-- Header -->
  <?php require_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="container mb-5 p-5">
    <h1 class="mb-4 text-center">Lista dos músicos BMMO</h1>

    <?php
    $groups = BandGroups::getAll();
    $instruments = Instruments::getAll();

    $filterName = $_GET['name'] ?? '';
    $filterGroup = isset($_GET['group']) ? (int) $_GET['group'] : 0;
    $filterInstrument = isset($_GET['instrument']) ? (int) $_GET['instrument'] : 0;
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
              <option value="0">Todos</option>
              <?php foreach ($groups as $group): ?>
                <option value="<?= $group['group_id'] ?>" <?= $filterGroup == $group['group_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($group['group_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Instrumento -->
          <div class="col-12 col-md-3">
            <label class="form-label fw-semibold">Instrumento</label>
            <select name="instrument" class="form-select">
              <option value="0">Todos</option>
              <?php foreach ($instruments as $inst): ?>
                <option value="<?= $inst['instrument_id'] ?>" <?= $filterInstrument == $inst['instrument_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($inst['instrument_name']) ?>
                </option>
              <?php endforeach; ?>
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

    require_once BASE_PATH . "app/Models/Musicians.php";

    $musiciansList = Musicians::getAll(
      $filterName,
      $filterGroup,
      $filterInstrument
    );

    if (empty($musiciansList)) {
      echo "<div class='no-musician'>Nenhum músico encontrado.</div>";
    } else {
      $instrument = '';

      // Itera sobre cada músico
      foreach ($musiciansList as $res) {

        // Dados do músico
        $musicianId = (int) $res['musician_id'];
        $musicianName = htmlspecialchars($res['musician_name'] ?? '', ENT_QUOTES, 'UTF-8');
        $bandGroup = htmlspecialchars($res['group_name'] ?? '', ENT_QUOTES, 'UTF-8');

        // Verificação de imagem
        $musicianImage = basename($res['profile_image'] ?? '');

        $imagePath = BASE_PATH . "uploads/musicians-images/{$musicianImage}";
        $imageUrl = BASE_URL . "uploads/musicians-images/{$musicianImage}";

        $image = (!empty($musicianImage) && file_exists($imagePath))
          ? $imageUrl
          : BASE_URL . "uploads/musicians-images/default.png";

        if ($instrument != htmlspecialchars($res['instrument_name'] ?? '', ENT_QUOTES, 'UTF-8')) {
          $instrument = htmlspecialchars($res['instrument_name'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$instrument</h2>";
          echo "<div class='row g-4 mt-3'>";
        } ?>


        <div class='col-12 col-md-6 col-lg-3 mb-5'>
          <div class='card musician-card border-0 shadow-sm'>
            <img src='<?= $image ?>' class='card-img-top' alt='Imagem de <?= $musicianName ?>'>
            <a href='Profile/musicianProfile.php?idMusician=<?= $musicianId ?>'
              class='card-body d-flex flex-column text-decoration-none'>
              <h4 class='card-title fw-semibold text-center mb-3'><?= $musicianName ?></h4>
              <p class="text-center text-dark-emphasis mb-3 fs-5"><?= $bandGroup ?></p>
              <button class='btn btn-outline-primary mt-auto w-100'>
                <i class='bi bi-person-lines-fill me-1'></i> Ver Perfil
              </button>
            </a>
          </div>
        </div>

      <?php }
    } ?>

  </main>


  <!-- Footer -->
  <?php require_once BASE_PATH . "includes/footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>