<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/MusicalScoresDAO.php";
require_once BASE_PATH . 'helpers/requestHelpers.php';

$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$musicalScoresDAO = new MusicalScoresDAO($conn);

Auth::requireRegency();

$groups = $bandGroupsDAO->getAll();
$instruments = $instrumentsDAO->getAll(false, true);
$instrumentsVoiceOff = $instrumentsDAO->getAll(true);

// Verifica se recebeu o id do músico
$musicId = isset($_GET['musicId']) ? (int) $_GET['musicId'] : null;

if (!$musicId) {
  redirectTo(BASE_URL . "pages/admin/musicalScores/index.php");
}

$musicalScores = $musicalScoresDAO->getById($musicId);

if (!$musicalScores) {
  echo "<div class='alert alert-warning m-4'>Partitura não encontrada.</div>";
  exit;
}

// Recebimento de variáveis
$music_name = trim($musicalScores->getMusicName());
$music_genre = trim($musicalScores->getMusicGenre());

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
    <form method="post" action="<?= BASE_URL ?>pages/admin/musicalScores/actions/edit.php" enctype="multipart/form-data" class="row g-3">

      <input type="hidden" name="musical_score_id" value="<?= $musicId ?>">

      <!-- Nome -->
      <div class="col-12 col-md-6 mb-3">
        <label for="musical-score-name" class="form-label fw-semibold">Nome</label>
        <input type="text" name="musical_score_name" id="musical-score-name" class="form-control" value="<?= $music_name ?>">
      </div>

      <!-- Gênero -->
      <div class="col-12 col-md-6 mb-3">
        <label for="musical-score-genre" class="form-label fw-semibold">Gênero</label>
        <select name="musical_score_genre" id="musical-score-genre" class="form-select">
          <option value="<?= $music_genre ?>"><?= $music_genre ?></option>
          <?php require_once BASE_PATH . "includes/optionsMusicalGenre.php"; ?>
        </select>
      </div>

      <!-- Grupo -->
      <div class="mb-3 col-12">
        <label class="form-label fw-semibold">Grupo da Banda</label><br>
        <?php foreach ($groups as $group) { ?>
          <?php $groupId = (int) ($group->getGroupId() ?? 0); ?>
          <input type="checkbox" class="form-check-input" name="musical_score_groups[]" value="<?= $groupId ?>"
            <?= $musicalScoresDAO->verifyGroup($musicId, $groupId) ? 'checked' : ''; ?>>
          <label class="form-check-label">
            <?= htmlspecialchars($group->getGroupName()) ?>
          </label><br>
        <?php } ?>
      </div>

      <!-- Instrumentos sem Vozes -->
      <div class="mb-4 col-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h3>Instrumentos sem Vozes</h3>
          <i class="bi bi-plus-square-fill fs-3 text-primary cursor-pointer" id="form-toggle-icon"
        title="Instrumentos sem Vozes"></i>
        </div>

        <div class="table-responsive is-hidden" id="musical-score-form-container">
          <table class="table table-bordered table-hover align-middle shadow-sm">

            <thead class="table-primary text-center">
              <tr>
                <th class="musical-score-voice-off-instrument-col">Instrumento</th>
                <th class="musical-score-voice-off-file-col">Adicionar Arquivo</th>
                <th class="musical-score-voice-off-delete-col">Excluir</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($instrumentsVoiceOff as $instrument) { ?>
                <?php $instrumentId = (int) ($instrument->getInstrumentId() ?? 0); ?>
                <?php $hasFile = $musicalScoresDAO->verifyInstrument($musicId, $instrumentId);

                $musicFile = $musicalScoresDAO->getFile($musicId, $instrumentId)
                  ?>



                <tr>
                  <td class="fw-semibold">
                    <?= htmlspecialchars(substr($instrument->getInstrumentName(), 3)); ?>
                  </td>

                  <td>
                    <input type="file" name="musical_score_instruments_voice_off[<?= $instrumentId ?>]"
                      class="form-control form-control-sm">
                  </td>

                    <td class=" d-flex align-items-center justify-content-center">
                      <?php if ($hasFile) { ?>
                        <button type="button"
                          class="btn btn-sm btn-danger d-flex align-items-center justify-content-center delete-instrument-file-button"
                          data-music-id="<?= (int) $musicId ?>" data-instrument-id="<?= $instrumentId ?>" data-voice-off="1">
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
              <?php foreach ($instruments as $instrument) { ?>
                <?php
                $instrumentId = (int) ($instrument->getInstrumentId() ?? 0);
                $hasFile = $musicalScoresDAO->verifyInstrument($musicId, $instrumentId);

                $musicFile = $musicalScoresDAO->getFile($musicId, $instrumentId)
                  ?>

                <tr>
                  <td class="fw-semibold">
                    <?= htmlspecialchars($instrument->getInstrumentName()); ?>
                  </td>

                  <td class="text-center">
                    <?php if ($hasFile) { ?>
                      <div class="file-cell">
                        <i class="bi bi-file-earmark-text text-secondary"></i>

                        <a class="file-link file-name" href="<?= BASE_URL . "uploads/musical-scores/{$musicFile}" ?>"
                          target="_blank">

                          <?= basename($musicFile) ?>
                        </a>
                      </div>
                    <?php } else { ?>
                      <span class="text-muted small">—</span>
                    <?php } ?>
                  </td>

                  <td>
                    <input type="file" name="musical_score_instruments[<?= $instrumentId ?>]"
                      class="form-control form-control-sm">
                  </td>

                  <td class=" d-flex align-items-center justify-content-center">
                    <?php if ($hasFile) { ?>
                      <button type="button"
                        class="btn btn-sm btn-danger d-flex align-items-center justify-content-center delete-instrument-file-button"
                        data-music-id="<?= (int) $musicId ?>" data-instrument-id="<?= $instrumentId ?>" data-voice-off="0">
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
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.delete-instrument-file-button').forEach((button) => {
        button.addEventListener('click', () => {
          const musicId = Number(button.dataset.musicId);
          const instrumentId = Number(button.dataset.instrumentId);
          const voiceOff = button.dataset.voiceOff === '1';

          deleteInstrumentFile(musicId, instrumentId, voiceOff);
        });
      });

      const deleteScoreButton = document.querySelector('.delete-musical-score-button');
      if (deleteScoreButton) {
        deleteScoreButton.addEventListener('click', () => {
          deleteMusicalScore(Number(deleteScoreButton.dataset.musicId));
        });
      }
    });

    function submitPost(url, fields) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = url;

      Object.entries(fields).forEach(([key, value]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = String(value);
        form.appendChild(input);
      });

      document.body.appendChild(form);
      form.submit();
    }

    function deleteInstrumentFile(musicId, instrumentId, voiceOff) {
      if (!confirmAction('Deseja excluir este arquivo?')) {
        return;
      }

      submitPost('<?= BASE_URL ?>pages/admin/musicalScores/actions/deleteinstrument.php', {
        music_id: musicId,
        instrument_id: instrumentId,
        voice_off: voiceOff ? '1' : '0'
      });
    }

    function deleteMusicalScore(musicId) {
      if (!confirmAction('Deseja excluir esta partitura?')) {
        return;
      }

      submitPost('<?= BASE_URL ?>pages/admin/musicalScores/actions/delete.php', {
        music_id: musicId
      });
    }
  </script>

  <script src="<?= BASE_URL ?>assets/js/confirmAction.js"></script>
  <script src="<?= BASE_URL ?>assets/js/showForm.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>