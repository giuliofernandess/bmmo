<?php
require_once "../../../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/Models/Musicians.php";
require_once BASE_PATH . "app/Models/BandGroups.php";
require_once BASE_PATH . "app/Models/Instruments.php";

Auth::requireRegency();

// Verifica se recebeu o id do músico
$musicianId = isset($_GET["musicianId"]) ? (int) $_GET["musicianId"] : null;

if (!$musicianId) {
  header("Location: " . BASE_URL . "pages/AdmSession/AdmFeatures/ListOfMusicians/musicians.php");
  exit;
}

$musicians = Musicians::getById($musicianId);

if (!$musicians) {
  echo "<div class='alert alert-warning m-4'>Músico não encontrado.</div>";
  exit;
}


//Recebimento de variáveis
$musician_login = trim($musicians['musician_login'] ?? '');
$musician_name = trim($musicians['musician_name'] ?? '');

//Instrumento + Grupo
$instrument = (int) ($musicians['instrument'] ?? 0);
$band_group = (int) ($musicians['band_group'] ?? 0);

$instrument_name = trim($musicians['instrument_name'] ?? '');
$group_name = trim($musicians['group_name'] ?? '');

$musician_contact = trim($musicians['musician_contact'] ?? '');
$neighborhood = trim($musicians['neighborhood'] ?? '');
$institution = trim($musicians['institution'] ?? '');
$responsible_name = trim($musicians['responsible_name'] ?? '');
$responsible_contact = trim($musicians['responsible_contact'] ?? '');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicianEdit.css">
</head>

<body>
  <!-- Toast de erro -->
  <?php require BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php require BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">

    <!-- Formulário -->
    <div class="container login-container">
      <h1 class="text-center mb-4">Editar Músico</h1>
      <form method="post" action="validateMusicianEdit.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome -->
        <div class="col-md-6">
          <label for="name" class="form-label ps-2">Nome</label>
          <input type="text" name="name" id="name" value="<?= $musician_name ?>" class="form-control" disabled />
        </div>

        <!-- Login -->
        <div class="col-md-6">
          <label for="login" class="form-label ps-2">Login</label>
          <input type="text" name="login" id="login" value="<?= $musician_login ?>" class="form-control" />
        </div>

        <!-- Instrumento -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento</label>
          <select name="instrument" id="instrument" class="form-select">

            <?php
            // Busca todas os instrumentos via POO
            $instrumentsList = Instruments::getAll();

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

        <!-- Grupo da Banda -->
        <div class="col-md-6">
          <label for="group" class="form-label ps-2">Grupo da Banda</label>
          <select name="group" id="band-group" class="form-select">

            <?php
            // Busca todas os grupos via POO
            $groupsList = BandGroups::getAll();


            // Itera sobre cada grupo
            foreach ($groupsList as $groupItem) {

              // Dados do grupo
              $groupId = (int) $groupItem['group_id'];
              $groupName = htmlspecialchars($groupItem['group_name'] ?? '', ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Options -->
              <option value="<?= htmlspecialchars($groupId) ?>" <?= $groupId == $band_group ? 'selected' : ''; ?>>
                <?= $groupName ?>
              </option>

              <?php
            }
            ?>

          </select>
        </div>

        <!-- Contato do Músico -->
        <div class="col-md-6">
          <label for="contact" class="form-label ps-2">Contato do Músico</label>
          <input type="text" name="contact" id="contact" value="<?= $musician_contact ?>" class="form-control" />
        </div>

        <!-- Responsável -->
        <div class="col-md-6">
          <label for="responsible" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible" id="responsible" value="<?= $responsible_name ?>"
            class="form-control" />
        </div>

        <!-- Contato do Responsável -->
        <div class="col-md-6">
          <label for="contact-of-responsible" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="contact-of-responsible" id="contact-of-responsible"
            value="<?= $responsible_contact ?>" class="form-control" />
        </div>

        <!-- Bairro -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label ps-2">Bairro</label>
          <select name="neighborhood" id="neighborhood" class="form-select">
            <option value="<?= $neighborhood ?>"><?= $neighborhood ?></option>
            <option value="Boa Esperança">Boa Esperança</option>
            <option value="Centro">Centro</option>
            <option value="Croatá">Croatá</option>
            <option value="Curupira">Curupira</option>
            <option value="Novo Horizonte">Novo Horizonte</option>
            <option value="Placa de Ocara">Placa de Ocara</option>
            <option value="Placa José Pereira">Placa José Pereira</option>
            <option value="Prainha">Prainha</option>
            <option value="São Marcos">São Marcos</option>
            <option value="São Pedro">São Pedro</option>
            <option value="Sereno">Sereno</option>
            <option value="Outro">Outro</option>
          </select>
        </div>

        <!-- Instituição -->
        <div class="col-md-6">
          <label for="institution" class="form-label ps-2">Instituição</label>
          <input type="text" name="institution" id="institution" value="<?= $institution ?>" class="form-control" />
        </div>

        <!-- Upload -->
        <div class="col-md-6">
          <label for="file" class="form-label ps-2">Imagem do músico</label>
          <input type="file" name="file" id="file" accept="image/*" class="form-control" />
        </div>

        <!-- Senhas -->
        <div class="col-md-6">
          <label for="password" class="form-label ps-2">Senha</label>
          <input type="password" name="password" id="password" placeholder="Digite a nova senha" minlength="8"
            maxlength="20" class="form-control" />
        </div>
        <div class="col-md-6">
          <label for="confirm-password" class="form-label ps-2">Confirmar Senha</label>
          <div>
            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirme a nova senha"
              class="form-control" minlength="8" maxlength="20" />
            <i class="bi bi-eye-fill show-password" id="password-btn" onclick="showPassword()"></i>
          </div>
        </div>

        <!-- Botão Editar -->
        <div class="col-12 mt-3">
          <input type='hidden' name='musician-id' value='<?= $musicianId ?>'>
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Editar Músico</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php require BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/password.js"></script>
  <script src="<?= BASE_URL ?>assets/js/removeToast.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script src="<?= BASE_URL ?>assets/js/mask.js"></script>
</body>

</html>