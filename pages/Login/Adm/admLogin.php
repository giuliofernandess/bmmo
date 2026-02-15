<?php require_once '../../../config/config.php'; ?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Maestro</title>

  <!-- Links -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Formulário de login -->
  <main class="d-flex flex-grow-1 align-items-center justify-content-center flex-column mx-3">
    <div class="container login-container">
      <form action="validateAdmLogin.php" method="post">
        <div class="mb-3">
          <label for="loginMusic" class="form-label ps-2">Login</label>
          <input type="text" name="login" id="loginMusic" class="form-control rounded-pill" required />
        </div>

        <div class="mb-4">
          <label for="passwordMusician" class="form-label ps-2">Senha</label>
          <div>
            <input type="password" name="password" id="passwordMusician" class="form-control rounded-pill" minlength="8"
              maxlength="20" required />
            <i class="bi bi-eye-fill show-password" id="passwordBtn" onclick="showPassword()"></i>
          </div>
        </div>

        <button type="submit"
          class="btn btn-primary btn-lg rounded-pill px-4 d-flex align-items-center justify-content-center">Acessar</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <script src="<?= BASE_URL ?>assets/js/password.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>

</html>