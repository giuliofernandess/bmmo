<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
$auth = new Auth();

require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/MusicalScoresDAO.php";
require_once BASE_PATH . 'helpers/requestHelpers.php';

$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$musicalScoresDAO = new MusicalScoresDAO($conn);

$auth->requireRegency();

$groups = $bandGroupsDAO->getAll();
$instruments = $instrumentsDAO->getAll(false, true);
$instrumentsVoiceOff = $instrumentsDAO->getAll(true);


$musicId = filter_input(INPUT_GET, 'musical_score_id');

if (!$musicId) {
  redirectWithMessage(BASE_URL . "pages/admin/musical-scores/index.php");
}

$musicalScore = $musicalScoresDAO->getById($musicId);

if (!$musicalScore) {
  echo "<div class='alert alert-warning m-4'>Partitura não encontrada.</div>";
  exit;
}


$musicName = trim($musicalScore->getMusicName());
$musicGenre = trim($musicalScore->getMusicGenre());

$groupCheckedMap = [];
foreach ($groups as $group) {
  $groupId = (int) ($group->getGroupId() ?? 0);
  $groupCheckedMap[$groupId] = $musicalScoresDAO->verifyGroup($musicId, $groupId);
}

$voiceOffInstrumentsRows = [];
foreach ($instrumentsVoiceOff as $instrument) {
  $instrumentId = (int) ($instrument->getInstrumentId() ?? 0);

  $voiceOffInstrumentsRows[] = [
    'instrument_id' => $instrumentId,
    'instrument_name' => htmlspecialchars(substr((string) $instrument->getInstrumentName(), 3), ENT_QUOTES, 'UTF-8'),
    'has_file' => $musicalScoresDAO->verifyInstrument($musicId, $instrumentId)
  ];
}

$instrumentsRows = [];
foreach ($instruments as $instrument) {
  $instrumentId = (int) ($instrument->getInstrumentId() ?? 0);
  $hasFile = $musicalScoresDAO->verifyInstrument($musicId, $instrumentId);
  $musicFile = $hasFile ? $musicalScoresDAO->getFile($musicId, $instrumentId) : '';

  $instrumentsRows[] = [
    'instrument_id' => $instrumentId,
    'instrument_name' => htmlspecialchars((string) $instrument->getInstrumentName(), ENT_QUOTES, 'UTF-8'),
    'has_file' => $hasFile,
    'file_url' => $hasFile ? (BASE_URL . "uploads/musical-scores/{$musicFile}") : '',
    'file_name' => $hasFile ? basename((string) $musicFile) : ''
  ];
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

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicalScores.css">
</head>

<body>
  <!-- Toasts -->
  <?php include_once BASE_PATH . "includes/successToast.php"; ?>
  <?php include_once BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="container mb-5 pt-5">

    <!-- Título -->
    <h1 class="mb-3">Edição de partituras</h1>

    <!-- Form -->
    <form method="post" action="<?= BASE_URL ?>pages/admin/musical-scores/actions/edit.php" enctype="multipart/form-data" class="row g-3">

      <input type="hidden" name="musical_score_id" value="<?= $musicId ?>">

      <!-- Nome -->
      <div class="col-12 col-md-6 mb-3">
        <label for="musical-score-name" class="form-label fw-semibold">Nome *</label>
        <input type="text" name="musical_score_name" id="musical-score-name" class="form-control" value="<?= $musicName ?> " required>
      </div>

      <!-- Gênero -->
      <div class="col-12 col-md-6 mb-3">
        <label for="musical-score-genre" class="form-label fw-semibold">Gênero *</label>
        <select name="musical_score_genre" id="musical-score-genre" class="form-select" required>
          <option value="<?= $musicGenre ?>"><?= $musicGenre ?></option>
          <?php require_once BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
        </select>
      </div>

      <!-- Grupo -->
      <div class="mb-3 col-12">
        <label class="form-label fw-semibold">Grupo da Banda</label><br>
        <?php foreach ($groups as $group) { ?>
          <input type="checkbox" class="form-check-input" name="musical_score_groups[]" value="<?= (int) ($group->getGroupId() ?? 0) ?>"
            <?= !empty($groupCheckedMap[(int) ($group->getGroupId() ?? 0)]) ? 'checked' : ''; ?>>
          <label class="form-check-label">
            <?= htmlspecialchars($group->getGroupName()) ?>
          </label><br>
        <?php } ?>
      </div>

      <!-- Instrumentos sem Vozes -->
      <div class="mb-4 col-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h3>Instrumentos sem Vozes</h3>
          <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="musical-score-voice-off-form-toggle-icon"
        title="Instrumentos sem Vozes"></i>
        </div>

        <div class="table-responsive is-hidden" id="musical-score-voice-off-form-container">
          <table class="table table-bordered table-hover align-middle shadow-sm">

            <thead class="table-primary text-center">
              <tr>
                <th class="musical-score-voice-off-instrument-col">Instrumento</th>
                <th class="musical-score-voice-off-file-col">Adicionar Arquivo</th>
                <th class="musical-score-voice-off-delete-col">Excluir</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($voiceOffInstrumentsRows as $voiceOffRow) { ?>

                <tr>
                  <td class="fw-semibold">
                    <?= $voiceOffRow['instrument_name'] ?>
                  </td>

                  <td>
                    <input type="file" name="musical_score_instruments_voice_off[<?= $voiceOffRow['instrument_id'] ?>]"
                      class="form-control form-control-sm">
                  </td>

                    <td class=" d-flex align-items-center justify-content-center">
                      <?php if ($voiceOffRow['has_file']) { ?>
                        <button type="button"
                          class="btn btn-sm btn-danger d-flex align-items-center justify-content-center delete-instrument-file-button"
                          data-music-id="<?= (int) $musicId ?>" data-instrument-id="<?= $voiceOffRow['instrument_id'] ?>" data-voice-off="1">
                          <i class="bi bi-trash"></i>
                        </button>
                      <?php } else { ?>
                        <span class="text-muted small">—</span>
                      <?php } ?>
                    </td>

                </tr>
              <?php } ?>
            </tbody>

          </table>
        </div>
      </div>

      <!-- Instrumentos com Vozes -->
      <div class="mb-4 col-12">
        <h3 class="mb-3">Instrumentos com Vozes</h3>

        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle shadow-sm">

            <thead class="table-primary text-center">
              <tr>
                <th class="musical-score-instrument-col">Instrumento</th>
                <th class="musical-score-current-file-col">Arquivo Atual</th>
                <th class="musical-score-file-col">Adicionar Arquivo</th>
                <th class="musical-score-delete-col">Excluir</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($instrumentsRows as $instrumentRow) { ?>

                <tr>
                  <td class="fw-semibold">
                    <?= $instrumentRow['instrument_name'] ?>
                  </td>

                  <td class="text-center">
                    <?php if ($instrumentRow['has_file']) { ?>
                      <div class="file-cell">
                        <i class="bi bi-file-earmark-text text-secondary"></i>

                        <a class="file-link file-name" href="<?= $instrumentRow['file_url'] ?>"
                          target="_blank">

                          <?= $instrumentRow['file_name'] ?>
                        </a>
                      </div>
                    <?php } else { ?>
                      <span class="text-muted small">—</span>
                    <?php } ?>
                  </td>

                  <td>
                    <input type="file" name="musical_score_instruments[<?= $instrumentRow['instrument_id'] ?>]"
                      class="form-control form-control-sm">
                  </td>

                  <td class=" d-flex align-items-center justify-content-center">
                    <?php if ($instrumentRow['has_file']) { ?>
                      <button type="button"
                        class="btn btn-sm btn-danger d-flex align-items-center justify-content-center delete-instrument-file-button"
                        data-music-id="<?= (int) $musicId ?>" data-instrument-id="<?= $instrumentRow['instrument_id'] ?>" data-voice-off="0">
                        <i class="bi bi-trash"></i>
                      </button>
                    <?php } else { ?>
                      <span class="text-muted small">—</span>
                    <?php } ?>
                  </td>

                </tr>
              <?php } ?>
            </tbody>

          </table>
        </div>
      </div>

      <div class="col-12 col-md-6 d-grid">
        <button type="submit" class="btn btn-primary">
          Enviar Alterações
        </button>
      </div>

      <div class="col-12 col-md-6 d-grid">
        <button type="button" class="btn btn-danger delete-musical-score-button" data-music-id="<?= (int) $musicId ?>">
          Excluir Partitura
        </button>
      </div>

    </form>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/editMusicalScores.js"></script>
  <script src="<?= BASE_URL ?>assets/js/confirmAction.js"></script>
  <script src="<?= BASE_URL ?>assets/js/showForm.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>