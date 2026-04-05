<?php
require_once "../../../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

Auth::requireMusician();

require_once BASE_PATH ."helpers/getMusicianInfo.php";

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
      <h1 class="text-center mb-4"><?= $musicianName ?></h1>
      <form method="post" action="<?= BASE_URL ?>pages/musician/profile/actions/edit.php" enctype="multipart/form-data" class="row g-3">

        <!-- Instrumento -->
        <div class="col-md-6">
          <label for="instrument" class="form-label ps-2">Instrumento</label>
          <select name="instrument" id="instrument" class="form-select" disabled>
            <option value="<?= $instrumentName ?>"><?= $instrumentName ?></option>
          </select>
        </div>

        <!-- Grupo da Banda -->
        <div class="col-md-6">
          <label for="group" class="form-label ps-2">Grupo da Banda</label>
          <select name="band_group" id="band-group" class="form-select" disabled>
            <option value="<?= $groupName ?>"><?= $groupName ?></option>
          </select>
        </div>

        <!-- Contato do Músico -->
        <div class="col-md-6">
          <label for="musician-contact" class="form-label ps-2">Contato do Músico</label>
          <input type="text" name="musician_contact" id="musician-contact" value="<?= $musicianContact ?>" class="form-control" />
        </div>

        <!-- Responsável -->
        <div class="col-md-6">
          <label for="responsible-name" class="form-label ps-2">Responsável</label>
          <input type="text" name="responsible_name" id="responsible-name" placeholder="Nome do responsável"
            value="<?= $responsibleName ?>" class="form-control" />
        </div>

        <!-- Contato do Responsável -->
        <div class="col-md-6">
          <label for="responsible-contact" class="form-label ps-2">Contato do Responsável</label>
          <input type="text" name="responsible_contact" id="responsible-contact"
            placeholder="Contato do responsável"
            value="<?= $responsibleContact ?>" class="form-control" />
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

        <hr class="mt-5">

        <div class="d-flex flex-align-center justify-content-between">
          <h2 class="mb-4 text-primary">Alterar senha</h2>
          <i class="bi bi-caret-down-square-fill fs-3 text-primary cursor-pointer" id="form-toggle-icon" title="Alterar senha"></i>
        </div>

        <!-- Senhas -->
        <div class="is-hidden" id="edit-password-form-container">

          <input type="hidden" name="hash_password" value="<?= $password ?>">

          <div class="col-md-12 mb-3">
            <label for="actual-password" class="form-label ps-2">Senha atual</label>
            <input type="password" name="actual_password" id="actual-password" placeholder="Digite a senha atual" minlength="8"
              maxlength="20" class="form-control" />
          </div>
          <div class="col-md-12 mb-3">
            <label for="password" class="form-label ps-2">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite a nova senha" minlength="8"
              maxlength="20" class="form-control" />
          </div>
          <div class="col-md-12 mb-3">
            <label for="confirm-password" class="form-label ps-2">Confirmar Senha</label>
            <div>
              <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirme a nova senha"
                class="form-control" minlength="8" maxlength="20" />
            </div>
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
  <script src="<?= BASE_URL ?>assets/js/editPassword.js"></script>
  <script src="<?= BASE_URL ?>assets/js/mask.js"></script>
</body>

</html>