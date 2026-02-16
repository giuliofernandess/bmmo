<?php
session_start();

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
  <title>Registrar Músico</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon" />

  <!-- CSS + Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/musicianRegister.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <?php if (isset($_SESSION['success'])) { ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
      <div class="toast align-items-center text-bg-success border-0 show" role="alert">
        <div class="d-flex">
          <div class="toast-body">
            <?= htmlspecialchars($_SESSION['success']) ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto"
            onclick="this.closest('.toast-container').remove()"></button>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php } ?>

  <?php if (isset($_SESSION['error'])) { ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
      <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
        <div class="d-flex">
          <div class="toast-body">
            <?= htmlspecialchars($_SESSION['error']) ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto"
            onclick="this.closest('.toast-container').remove()"></button>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php } ?>

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/secondHeader.php'; ?>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
    <div class="container login-container">
      <h1 class="text-center mb-4">Cadastrar Músico</h1>
      <form method="post" action="validateMusicianRegister.php" enctype="multipart/form-data" class="row g-3">

        <!-- Nome + Login + Nascimento -->
        <div class="col-md-12">
          <label for="name" class="form-label ps-2">Nome *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Nome do músico" required />
        </div>

        <div class="col-md-6">
          <label for="login" class="form-label ps-2">Login *</label>
          <input type="text" name="login" id="login" class="form-control" placeholder="Login do músico" required />
        </div>

        <div class="col-md-6">
          <label for="date-of-birth" class="form-label ps-2">Data de Nascimento *</label>
          <input type="date" name="date" id="date-of-birth" class="form-control" required />
        </div>

        <!-- Instrumento + Grupo -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento *</label>
          <select name="instrument" id="instrument" class="form-control select" required>
            <option value="">Selecione</option>

            <?php
            // Busca todas as notícias via POO
            $instrumentsList = Instruments::getAll();

            if (empty($instrumentsList)) {
              echo "<div class='no-news'>Nenhum instrumento encontrado.</div>";
            } else {
              // Itera sobre cada instrumento
              foreach ($instrumentsList as $res) {

                // Dados do instrumento
                $instrumentId = (int) $res['instrument_id'];
                $instrumentName = htmlspecialchars($res['instrument_name'] ?? '', ENT_QUOTES, 'UTF-8');
                ?>

                <!-- Options -->
                <option value="<?= htmlspecialchars($instrumentId) ?>"><?= htmlspecialchars($instrumentName) ?></option>

                <?php
              }
            }
            ?>

          </select>
        </div>

        <div class="col-md-6">
          <label for="band-group" class="form-label ps-2">Grupo da Banda *</label>
          <select name="group" id="band-group" class="form-control" required>
            <option value="">Selecione</option>

            <?php
            // Busca todas as notícias via POO
            $groupsList = BandGroups::getAll();

            if (empty($groupsList)) {
              echo "<div class='no-news'>Nenhum grupo da banda encontrado.</div>";
            } else {
              // Itera sobre cada grupo
              foreach ($groupsList as $res) {

                // Dados do grupo
                $groupId = (int) $res['group_id'];
                $groupName = htmlspecialchars($res['group_name'] ?? '', ENT_QUOTES, 'UTF-8');
                ?>

                <!-- Options -->
                <option value="<?= htmlspecialchars($groupId) ?>">
                  <?= htmlspecialchars($groupName) ?>
                </option>

                <?php
              }
            }
            ?>

          </select>
        </div>

        <!-- Contatos -->
        <div class="col-md-6">
          <label for="contact" class="form-label ps-2">Contato do Músico *</label>
          <input type="text" name="contact" id="contact" class="form-control" placeholder="(xx) xxxxx-xxxx" required />
        </div>

        <div class="col-md-6">
          <label for="responsible" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible" id="responsible" class="form-control"
            placeholder="Nome do responsável" />
        </div>

        <div class="col-md-6">
          <label for="contact-of-responsible" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="contact-of-responsible" id="contact-of-responsible" class="form-control"
            placeholder="(xx) xxxxx-xxxx" />
        </div>

        <!-- Bairro + Instituição -->
        <div class="col-md-6">
          <label for="neighborhood" class="form-label ps-2">Bairro *</label>
          <select name="neighborhood" id="neighborhood" class="form-control" required>
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
            <i class="bi bi-eye-fill show-password" id="password-btn" onclick="showPassword()"></i>
          </div>
        </div>

        <div class="col-md-6">
          <label for="confirm-password" class="form-label ps-2">Confirmar Senha *</label>
          <input type="password" name="confirm-password" id="confirm-password" class="form-control"
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
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Scripts -->
  <script src="<?= BASE_URL ?>assets/js/password.js"></script>
  <script src="<?= BASE_URL ?>assets/js/removeToast.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#contact").mask("(00) 00000-0000");
      $("#contact-of-responsible").mask("(00) 00000-0000");
    });
  </script>
</body>

</html>