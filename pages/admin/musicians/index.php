<?php

require_once "../../../config/config.php";

require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/Musician.php";

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);

Auth::requireRegency();

$groupsList = $bandGroupsDAO->getAll();
$instrumentsList = $instrumentsDAO->getAll();

$groupMap = [];
foreach ($groupsList as $group) {
  $groupMap[(int) ($group->getGroupId() ?? 0)] = (string) ($group->getGroupName() ?? '');
}

$instrumentMap = [];
foreach ($instrumentsList as $instrument) {
  $instrumentMap[(int) ($instrument->getInstrumentId() ?? 0)] = (string) ($instrument->getInstrumentName() ?? '');
}

$filterName = filter_input(INPUT_GET, 'musician_name_filter');
$filterGroup = filter_input(INPUT_GET, 'band_group_filter') ?? 0;
$filterInstrument = filter_input(INPUT_GET, 'instrument_filter') ?? 0;

$musiciansList = $musiciansDAO->getAll([
    'musician_name' => $filterName,
    'band_group' => $filterGroup,
    'instrument' => $filterInstrument
  ]);
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

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">

          <!-- Nome -->
          <div class="col-12 col-md-4">
            <label for="musician-name-filter" class="form-label fw-semibold">Nome do músico</label>
            <input type="text" name="musician_name_filter" id="musician-name-filter" value="<?= htmlspecialchars($filterName) ?>" class="form-control"
              placeholder="Digite o nome">
          </div>

          <!-- Grupo -->
          <div class="col-12 col-md-3">
            <label for="band-group-filter" class="form-label fw-semibold">Grupo da banda</label>
            <select name="band_group_filter" id="band-group-filter" class="form-select">
              <option value="0">Todos</option>
              <?php foreach ($groupsList as $group) { ?>
                <option value="<?= (int) ($group->getGroupId() ?? 0) ?>" <?= $filterGroup === (int) ($group->getGroupId() ?? 0) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($group->getGroupName()) ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <!-- Instrumento -->
          <div class="col-12 col-md-3">
            <label for="instrument-filter" class="form-label fw-semibold">Instrumento</label>
            <select name="instrument_filter" id="instrument-filter" class="form-select">
              <option value="0">Todos</option>
              <?php foreach ($instrumentsList as $instrument) { ?>
                <option value="<?= (int) ($instrument->getInstrumentId() ?? 0) ?>" <?= $filterInstrument === (int) ($instrument->getInstrumentId() ?? 0) ? 'selected' : '' ?>>
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
    if (empty($musiciansList)) {
      echo "<div class='no-musician'>Nenhum músico encontrado.</div>";
    } else {
      $instrument = '';

      
      foreach ($musiciansList as $data) {
        $musician = $data instanceof Musician ? $data : Musician::fromArray((array) $data);

        
        $musicianId = (int) ($musician->getMusicianId() ?? 0);
        $musicianName = htmlspecialchars($musician->getMusicianName(), ENT_QUOTES, 'UTF-8');
        $bandGroup = htmlspecialchars($groupMap[$musician->getBandGroup()] ?? '', ENT_QUOTES, 'UTF-8');

        
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
            <?php if ($image == $imageUrl) { ?>
              <div class='card-img-top' style='background-image: url("<?= $image ?>"); background-size: cover; background-position: top center;'></div>
            <?php } else { ?>
              <img src="<?= BASE_URL ?>uploads/musicians-images/default.png" alt="Imagem do músico" class="card-img-top">
            <?php } ?>
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