<?php
session_start();

require_once "../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";

$musiciansDAO = new MusiciansDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);

Auth::requireRegency();

$selectedInstrument = 0;
$selectedBandGroup = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  
</head>

<body class="registerMusician-page d-flex flex-column min-vh-100">
  <!-- Toasts -->
  <?php include_once BASE_PATH . "includes/successToast.php"; ?>
  <?php include_once BASE_PATH . "includes/errorToast.php"; ?>

  <!-- Header -->
  <?php include_once BASE_PATH . 'includes/secondHeader.php'; ?>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
    <div class="container form-container">
      <h1 class="text-center mb-4">Cadastrar Músico</h1>
      <form method="post" action="<?= BASE_URL ?>pages/admin/musicians/actions/create.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome + Login + Nascimento -->
        <div class="col-md-12">
          <label for="musician-name" class="form-label ps-2">Nome *</label>
          <input type="text" name="musician_name" id="musician-name" class="form-control" placeholder="Nome do músico" required />
        </div>

        <div class="col-md-6">
          <label for="musician-login" class="form-label ps-2">Login *</label>
          <input type="text" name="musician_login" id="musician-login" class="form-control" placeholder="Login do músico" required />
        </div>

        <div class="col-md-6">
          <label for="musician-date-of-birth" class="form-label ps-2">Data de Nascimento *</label>
          <input type="date" name="date_of_birth" id="musician-date-of-birth" class="form-control" required />
        </div>

        <!-- Instrumento + Grupo -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento *</label>
          <select name="instrument" id="instrument" class="form-select select" required>
            <option value="">Selecione</option>

            <?php
            // Busca todas os instrumentos via POO
            $instrumentsList = $instrumentsDAO->getAll();

            // Itera sobre cada instrumento
            foreach ($instrumentsList as $instrument) {

              // Dados do instrumento
              $instrumentId = (int) ($instrument->getInstrumentId() ?? 0);
              $instrumentName = htmlspecialchars($instrument->getInstrumentName(), ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Options -->
              <option value="<?= $instrumentId ?>" <?= $instrumentId === $selectedInstrument ? 'selected' : '' ?>>
                <?= $instrumentName ?>
              </option>

              <?php
            }
            ?>

          </select>
        </div>

        <div class="col-md-6">
          <label for="band-group" class="form-label ps-2">Grupo da Banda *</label>
          <select name="band_group" id="band-group" class="form-select" required>
            <option value="">Selecione</option>

            <?php
            // Busca todas os grupos via POO
            $groupsList = $bandGroupsDAO->getAll();


            // Itera sobre cada grupo
            foreach ($groupsList as $group) {

              // Dados do grupo
              $groupId = (int) ($group->getGroupId() ?? 0);
              $groupName = htmlspecialchars($group->getGroupName(), ENT_QUOTES, 'UTF-8');
              ?>

              <!-- Options -->
              <option value="<?= $groupId ?>" <?= $groupId === $selectedBandGroup ? 'selected' : ''; ?>>
                <?= $groupName ?>
              </option>

              <?php
            }
            ?>

          </select>
        </div>

        <!-- Contatos -->
        <div class="col-md-6">
          <label for="musician-contact" class="form-label ps-2">Contato do Músico *</label>
          <input type="text" name="musician_contact" id="musician-contact" class="form-control" placeholder="(xx) xxxxx-xxxx" required />
        </div>

        <div class="col-md-6">
          <label for="responsible-name" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible_name" id="responsible-name" class="form-control"
            placeholder="Nome do responsável" />
        </div>

        <div class="col-md-6">
          <label for="responsible-contact" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="responsible_contact" id="responsible-contact" class="form-control"
            placeholder="(xx) xxxxx-xxxx" />
        </div>

        <!-- Bairro + Instituição -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label ps-2">Bairro *</label>
          <select name="neighborhood" id="neighborhood" class="form-select" required>
            <option value="">Selecione</option>
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

        <div class="col-md-6">
          <label for="institution" class="form-label ps-2">Instituição</label>
          <input type="text" name="institution" id="institution" class="form-control"
            placeholder="Escola, faculdade ou emprego" />
        </div>

        <!-- Upload -->
        <div class="col-md-6">
          <label for="file" class="form-label ps-2">Imagem do músico</label>
          <input type="file" name="file" id="file" accept="image/*" class="form-control" />
        </div>

        <!-- Senhas -->
        <div class="col-md-6">
          <label for="password" class="form-label ps-2">Senha *</label>
          <div>
            <input type="password" name="password" id="password" class="form-control rounded-pill"
              placeholder="Digite a senha" minlength="8" maxlength="20" required />
            <i class="bi bi-eye-fill show-password" id="password-btn"></i>
          </div>
        </div>

        <div class="col-md-6">
          <label for="confirm-password" class="form-label ps-2">Confirmar Senha *</label>
          <input type="password" name="confirm_password" id="confirm-password" class="form-control"
            placeholder="Confirme a senha" minlength="8" maxlength="20" required />
        </div>

        <!-- Botão -->
        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Cadastrar Músico</button>
        </div>

      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php include_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/password.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/mask.js"></script>
</body>

</html>