<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/Instruments.php";
require_once BASE_PATH . "app/Models/BandGroups.php";

Auth::requireRegency();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Adicionar Partitura</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon">

  <!-- Bootstrap + CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
</head>

<body>
  <!-- Toast de sucesso -->
  <?php require_once BASE_PATH . "includes/sucessToast.php"; ?>
  
  <!-- Toast de erro -->
  <?php require_once BASE_PATH . "includes/sucessToast.php"; ?>

  <!-- Header -->
  <?php require_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
    <div class="container login-container" style="max-width: 800px;">
      <h1 class="text-center mb-4">Criar Partitura</h1>
      <form method="post" action="validateAddMusicalScore.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome + Instrumento -->
        <div>
          <label for="name" class="form-label ps-2">Nome *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Nome da partitura" required />
        </div>

        <div>
          <label for="instrument" class="form-label ps-2">Instrumento *</label>
          <select name="instrument" id="instrument" class="form-control" required>
            <option value="0">Selecione</option>

            <?php
            // Busca todas os instrumentos via POO
            $instrumentsList = Instruments::getAll(true);

            // Itera sobre cada instrumento
            foreach ($instrumentsList as $instrumentItem) {

              // Dados do instrumento
              $instrumentId = (int) $instrumentItem['instrument_id'];
              $instrumentName = htmlspecialchars($instrumentItem['instrument_name'] ?? '', ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Options -->
              <option value="<?= htmlspecialchars($instrumentId) ?>" <?= $instrumentId == $instrument ? 'selected' : '' ?>>
                <?= $instrumentName ?>
              </option>

              <?php
            }
            ?>

          </select>
        </div>

        <!-- Grupo pertencente + Tipo de Música -->
        <div>
          <label for="group" class="form-label ps-2">Grupo da Banda *</label><br>

            <?php
            // Busca todas os grupos via POO
            $groupsList = BandGroups::getAll();


            // Itera sobre cada grupo
            foreach ($groupsList as $groupItem) {

              // Dados do grupo
              $groupId = (int) $groupItem['group_id'];
              $groupName = htmlspecialchars($groupItem['group_name'] ?? '', ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Checkboxs -->
              <input type="checkbox" name="band-group[]" class="ms-2" value="<?= htmlspecialchars($groupId) ?>"> <?= $groupName ?><br>

              <?php
            }
            ?>
        </div>

        <div>
          <label for="musical-genre" class="form-label ps-2">Categoria *</label>
          <select name="musical-genre" id="musical-genre" class="form-control" required>
            <option value="">Selecione</option>
            <option value="Carnaval">Carnaval</option>
            <option value="Datas Comemorativas">Datas Comemorativas</option>
            <option value="Dobrados">Dobrados</option>
            <option value="Festa Junina">Festa Junina</option>
            <option value="Hinos">Hinos</option>
            <option value="Infantil">Infantil</option>
            <option value="Internacionais">Internacionais</option>
            <option value="Medleys">Medleys</option>
            <option value="Nacionais">Nacionais</option>
            <option value="Natal">Natal</option>
            <option value="Religiosas">Religiosas</option>
            <option value="Outras">Outras</option>
          </select>
        </div>

        <!-- Arquivo -->
        <div>
          <label for="input-file" class="form-label ps-2">Arquivo *</label>
          <input type="file" name="file" id="input-file" class="form-control" accept="application/pdf" required>
        </div>

        <!-- Botão de adicionar -->
        <div>
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Adicionar Partitura</button>
        </div>

      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>

</html>