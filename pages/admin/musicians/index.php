<?php
require_once "../../../config/config.php";

require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";

$musiciansDAO = new MusiciansDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);

Auth::requireRegency();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musiciansList.css">

  <title>Relação de músicos</title>
</head>

<body>
  <!-- Toast de sucesso -->
  <?php include_once BASE_PATH . "includes/successToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="container mb-5 p-5">
    <h1 class="mb-4 text-center">Lista dos músicos BMMO</h1>

    <?php
    $groupsList = $bandGroupsDAO->getAll();
    $instrumentsList = $instrumentsDAO->getAll();

    $groupMap = [];
    foreach ($groupsList as $group) {
      $groupMap[(int) ($group->getGroupId() ?? 0)] = $group->getGroupName();
    }

    $instrumentMap = [];
    foreach ($instrumentsList as $instrument) {
      $instrumentMap[(int) ($instrument->getInstrumentId() ?? 0)] = $instrument->getInstrumentName();
    }

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
              <?php foreach ($groupsList as $group) { ?>
                <?php $groupId = (int) ($group->getGroupId() ?? 0); ?>
                <option value="<?= $groupId ?>" <?= $filterGroup === $groupId ? 'selected' : '' ?>>
                  <?= htmlspecialchars($group->getGroupName()) ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <!-- Instrumento -->
          <div class="col-12 col-md-3">
            <label class="form-label fw-semibold">Instrumento</label>
            <select name="instrument" class="form-select">
              <option value="0">Todos</option>
              <?php foreach ($instrumentsList as $instrument) { ?>
                <?php $instrumentId = (int) ($instrument->getInstrumentId() ?? 0); ?>
                <option value="<?= $instrumentId ?>" <?= $filterInstrument === $instrumentId ? 'selected' : '' ?>>
                  <?= htmlspecialchars($instrument->getInstrumentName()) ?>
                </option>
              <?php } ?>
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

    $musiciansList = $musiciansDAO->getAll([
        'musician_name' => $filterName,
        'band_group' => $filterGroup,
        'instrument' => $filterInstrument
      ]);

    if (empty($musiciansList)) {
      echo "<div class='no-musician'>Nenhum músico encontrado.</div>";
    } else {
      $instrument = '';

      // Itera sobre cada músico
      foreach ($musiciansList as $musician) {

        // Dados do músico
        $musicianId = (int) ($musician->getMusicianId() ?? 0);
        $musicianName = htmlspecialchars($musician->getMusicianName(), ENT_QUOTES, 'UTF-8');
        $bandGroup = htmlspecialchars($groupMap[$musician->getBandGroup()] ?? '', ENT_QUOTES, 'UTF-8');

        // Verificação de imagem
        $musicianImage = basename((string) ($musician->getProfileImage() ?? ''));

        $imagePath = BASE_PATH . "uploads/musicians-images/{$musicianImage}";
        $imageUrl = BASE_URL . "uploads/musicians-images/{$musicianImage}";

        $image = (!empty($musicianImage) && file_exists($imagePath))
          ? $imageUrl
          : BASE_URL . "uploads/musicians-images/default.png";

        $instrumentName = htmlspecialchars($instrumentMap[$musician->getInstrument()] ?? '', ENT_QUOTES, 'UTF-8');

        if ($instrument !== $instrumentName) {
          if ($instrument !== '') {
            echo "</div>";
          }

          $instrument = $instrumentName;
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$instrument</h2>";
          echo "<div class='row g-4 mt-3'>";
        } ?>


        <div class='col-12 col-md-6 col-lg-3 mb-5'>
          <div class='card musician-card border-0 shadow-sm'>
            <img src='<?= $image ?>' class='card-img-top' alt='Imagem de <?= $musicianName ?>'>
            <a href='musicianProfile/index.php?musician_id=<?= $musicianId ?>'
              class='card-body d-flex flex-column text-decoration-none'>
              <h4 class='card-title fw-semibold text-center mb-3'><?= $musicianName ?></h4>
              <p class="text-center text-dark-emphasis mb-3 fs-5"><?= $bandGroup ?></p>
              <button class='btn btn-outline-primary mt-auto w-100'>
                <i class='bi bi-person-lines-fill me-1'></i> Ver Perfil
              </button>
            </a>
          </div>
        </div>

      <?php
      }
      echo "</div>";
    } ?>

  </main>


  <!-- Footer -->
  <?php include_once BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>