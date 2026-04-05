<?php
require_once "../../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . 'helpers/requestHelpers.php';

$musiciansDAO = new MusiciansDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);

Auth::requireRegency();

// Verifica se recebeu o id do músico
$musicianId = getValue('musician_id', 'int');

if (!$musicianId) {
  redirectTo(BASE_URL . "pages/admin/musicians/index.php");
}

$musicians = $musiciansDAO->getById($musicianId);

if (!$musicians) {
  echo "<div class='alert alert-warning m-4'>Músico não encontrado.</div>";
  exit;
}


//Recebimento de variáveis
$musician_login = trim($musicians->getMusicianLogin());
$musician_name = trim($musicians->getMusicianName());

//Instrumento + Grupo
$instrument = (int) $musicians->getInstrument();
$band_group = (int) $musicians->getBandGroup();

$musician_contact = trim((string) ($musicians->getMusicianContact() ?? ''));
$neighborhood = trim($musicians->getNeighborhood());
$institution = trim((string) ($musicians->getInstitution() ?? ''));
$responsible_name = trim((string) ($musicians->getResponsibleName() ?? ''));
$responsible_contact = trim((string) ($musicians->getResponsibleContact() ?? ''));

$instrumentsList = $instrumentsDAO->getAll();
$groupsList = $bandGroupsDAO->getAll();
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
</head>

<body class="musician-form-page">
  <!-- Toast de erro -->
  <?php include_once BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . "includes/secondHeader.php"; ?>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">

    <!-- Formulário -->
    <div class="container form-container">
      <h1 class="text-center mb-4">Editar Músico</h1>
      <form method="post" action="<?= BASE_URL ?>pages/admin/musicians/actions/edit.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome -->
        <div class="col-md-6">
          <label for="musician-name" class="form-label ps-2">Nome</label>
          <input type="text" name="musician_name" id="musician-name" value="<?= $musician_name ?>" class="form-control" disabled />
        </div>

        <!-- Login -->
        <div class="col-md-6">
          <label for="musician-login" class="form-label ps-2">Login *</label>
          <input type="text" name="musician_login" id="musician-login" value="<?= $musician_login ?>" class="form-control" required />
        </div>

        <!-- Instrumento -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento *</label>
          <select name="instrument" id="instrument" class="form-select" required>

            <?php
            // Itera sobre cada instrumento
            foreach ($instrumentsList as $instrumentEntity) {

              // Dados do instrumento
              $instrumentId = (int) ($instrumentEntity->getInstrumentId() ?? 0);
              $instrumentName = htmlspecialchars($instrumentEntity->getInstrumentName(), ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Options -->
              <option value="<?= htmlspecialchars($instrumentId) ?>" <?= $instrumentId === $instrument ? 'selected' : '' ?>>
                <?= $instrumentName ?>
              </option>

              <?php
            }
            ?>

          </select>
        </div>

        <!-- Grupo da Banda -->
        <div class="col-md-6">
          <label for="group" class="form-label ps-2">Grupo da Banda *</label>
          <select name="band_group" id="band-group" class="form-select" required>

            <?php
            // Itera sobre cada grupo
            foreach ($groupsList as $groupEntity) {

              // Dados do grupo
              $groupId = (int) ($groupEntity->getGroupId() ?? 0);
              $groupName = htmlspecialchars($groupEntity->getGroupName(), ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Options -->
              <option value="<?= htmlspecialchars($groupId) ?>" <?= $groupId === $band_group ? 'selected' : ''; ?>>
                <?= $groupName ?>
              </option>

              <?php
            }
            ?>

          </select>
        </div>

        <!-- Contato do Músico -->
        <div class="col-md-6">
          <label for="musician-contact" class="form-label ps-2">Contato do Músico</label>
          <input type="text" name="musician_contact" id="musician-contact" value="<?= $musician_contact ?>" class="form-control" />
        </div>

        <!-- Responsável -->
        <div class="col-md-6">
          <label for="responsible-name" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible_name" id="responsible-name" placeholder="Nome do responsável" value="<?= $responsible_name ?>"
            class="form-control" />
        </div>

        <!-- Contato do Responsável -->
        <div class="col-md-6">
          <label for="responsible-contact" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="responsible_contact" id="responsible-contact" placeholder="Contato do responsável"
            value="<?= $responsible_contact ?>" class="form-control" />
        </div>

        <!-- Bairro -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label ps-2">Bairro *</label>
          <select name="neighborhood" id="neighborhood" class="form-select" required>
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
          <label for="institution" class="form-label ps-2">Instituição em que atua</label>
          <input type="text" name="institution" id="institution"
            placeholder="Ex.: Escola, Faculdade, Trabalho e etc." 
            value="<?= $institution ?>" class="form-control" />
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
            <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirme a nova senha"
              class="form-control" minlength="8" maxlength="20" />
          </div>
        </div>

        <!-- Botão Editar -->
        <div class="col-12 mt-3">
          <input type='hidden' name='musician_id' value='<?= $musicianId ?>'>
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Editar Músico</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . "includes/footer.php"; ?>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script src="<?= BASE_URL ?>assets/js/mask.js"></script>
</body>

</html>