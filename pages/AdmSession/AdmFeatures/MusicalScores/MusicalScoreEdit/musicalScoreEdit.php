<?php
require_once "../../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/Instruments.php";
require_once BASE_PATH . "app/Models/MusicalScores.php";

Auth::requireRegency();

$groups = BandGroups::getAll();
$instruments = Instruments::getAll();
$instrumentsVoiceOff = Instruments::getAll(true);

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

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicalScoreEdit.css">
</head>

<body>
  <!-- Toasts -->
  <?php require BASE_PATH . "includes/sucessToast.php"; ?>
  <?php require BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php require BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="container mb-5 pt-5">

    <!-- Título -->
    <h1 class="mb-3">Edição de partituras</h1>

    <!-- Form -->
    <form method="post" action="validateMusicalScoreEdit.php" enctype="multipart/form-data" class="row g-3">

      <input type="hidden" name="id" value="<?= $musicId ?>">

      <!-- Nome -->
      <div class="col-12 col-md-6 mb-3">
        <label for="iname" class="form-label fw-semibold">Nome</label>
        <input type="text" name="name" id="iname" class="form-control" value="<?= $music_name ?>">
      </div>

      <!-- Gênero -->
      <div class="col-12 col-md-6 mb-3">
        <label for="igenre" class="form-label fw-semibold">Gênero</label>
        <select name="genre" id="igenre" class="form-select">
          <option value="<?= $music_genre ?>"><?= $music_genre ?></option>
          <?php require BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
        </select>
      </div>

      <!-- Grupo -->
      <div class="mb-3 col-12">
        <label class="form-label fw-semibold">Grupo da Banda</label><br>
        <?php foreach ($groups as $group): ?>
          <input type="checkbox" class="form-check-input" name="groups[]" value="<?= $group['group_id'] ?>"
            <?= MusicalScores::verifyGroup($musicId, $group['group_id']) ? 'checked' : ''; ?>>
          <label class="form-check-label">
            <?= $group['group_name'] ?>
          </label><br>
        <?php endforeach; ?>
      </div>

      <!-- Instrumentos sem Vozes -->
      <div class="mb-4 col-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h3>Instrumentos sem Vozes</h3>
          <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="addIcon" onclick="showForm()"
        title="Instrumentos sem Vozes"></i>
        </div>

        <div class="table-responsive" id="presentationForm" style="display: none;">
          <table class="table table-bordered table-hover align-middle shadow-sm">

            <thead class="table-primary text-center">
              <tr>
                <th style="width:40%">Instrumento</th>
                <th style="width:20%">Arquivo Atual</th>
                <th style="width:40%">Adicionar Arquivo</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($instrumentsVoiceOff as $instrument): ?>
                <?php $hasFile = MusicalScores::verifyInstrument($musicId, $instrument['instrument_id']);

                $musicFile = MusicalScores::getFile($musicId, $instrument['instrument_id'])
                  ?>



                <tr>
                  <td class="fw-semibold">
                    <?= substr($instrument['instrument_name'], 3); ?>
                  </td>

                  <td class="text-center">
                    <?php if ($hasFile): ?>
                      <div class="file-cell">
                        <i class="bi bi-file-earmark-text text-secondary"></i>

                        <a class="file-link file-name" href="<?= BASE_URL . "uploads/musical-scores/{$musicFile}" ?>"
                          target="_blank">

                          <?= basename($musicFile) ?>
                        </a>
                      </div>
                    <?php else: ?>
                      <span class="text-muted small">—</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <input type="file" name="instrumentsVoiceOff[<?= $instrument['instrument_id'] ?>]"
                      class="form-control form-control-sm">
                  </td>
                </tr>
              <?php endforeach ?>
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
                <th style="width:35%">Instrumento</th>
                <th style="width:25%">Arquivo Atual</th>
                <th style="width:40%">Adicionar Arquivo</th>
                <th style="width:10%">Excluir</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($instruments as $instrument): ?>
                <?php
                $hasFile = MusicalScores::verifyInstrument($musicId, $instrument['instrument_id']);

                $musicFile = MusicalScores::getFile($musicId, $instrument['instrument_id'])
                  ?>

                <tr>
                  <td class="fw-semibold">
                    <?= $instrument['instrument_name']; ?>
                  </td>

                  <td class="text-center">
                    <?php if ($hasFile): ?>
                      <div class="file-cell">
                        <i class="bi bi-file-earmark-text text-secondary"></i>

                        <a class="file-link file-name" href="<?= BASE_URL . "uploads/musical-scores/{$musicFile}" ?>"
                          target="_blank">

                          <?= basename($musicFile) ?>
                        </a>
                      </div>
                    <?php else: ?>
                      <span class="text-muted small">—</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <input type="file" name="instruments[<?= $instrument['instrument_id'] ?>]"
                      class="form-control form-control-sm">
                  </td>

                  <td class=" d-flex align-items-center justify-content-center">
                    <?php if ($hasFile): ?>
                      <a href="MusicalScoreDelete/validateMusicalScoreInstrumentDelete.php?music_id=<?= $musicId ?>&instrument_id=<?= $instrument['instrument_id'] ?>"
                        class="btn btn-sm btn-danger d-flex align-items-center justify-content-center"
                        onclick="return confirm('Deseja excluir este arquivo?');">
                        <i class="bi bi-trash"></i>
                      </a>
                    <?php else: ?>
                      <span class="text-muted small">—</span>
                    <?php endif; ?>
                  </td>

                </tr>
              <?php endforeach ?>
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
        <a href="MusicalScoreDelete/validateMusicalScoreGeneralDelete.php?music_id=<?= $musicId ?>"
          class="btn btn-danger" onclick="return confirm('Deseja excluir esta partitura?');">
          Excluir Partitura
        </a>
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