<?php
// Carrega configuração do projeto (BASE_URL e BASE_PATH)
require_once '../../../config/config.php';

// Inicia sessão para capturar mensagens de erro
session_start();
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Maestro</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  
</head>

<body class="d-flex flex-column min-vh-100 login-page">

  <!-- Toast de erro (aparece quando houver mensagem pendente) -->
  <?php include_once BASE_PATH . 'includes/errorToast.php'; ?>

  <!-- Header do site -->
  <?php include_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Formulário de login centralizado -->
  <main class="d-flex flex-column flex-grow-1 align-items-center justify-content-center px-3 py-5">

    <h1 class="text-center mb-5">Login - Maestro</h1>

    <div class="container form-container login-container">

      <form action="<?= BASE_URL ?>pages/login/actions/login.php" method="post">

        <input type="hidden" name="type" value="admin">

        <!-- Campo login -->
        <div class="mb-3">
          <label for="user-login" class="form-label ps-2">Login *</label>
          <input type="text" name="user_login" id="user-login" class="form-control rounded-pill" required />
        </div>

        <!-- Campo senha com botão de mostrar/esconder -->
        <div class="mb-4">
          <label for="user-password" class="form-label ps-2">Senha *</label>
          <div>
            <input type="password" name="user_password" id="user-password" class="form-control rounded-pill"
                   minlength="8" maxlength="20" required />
            <i class="bi bi-eye-fill show-password" id="password-toggle-button"></i>
          </div>
        </div>

        <!-- Botão de envio -->
        <button type="submit"
          class="btn btn-primary btn-lg rounded-pill w-100 d-flex align-items-center justify-content-center">
          Acessar
        </button>
      </form>

    </div>
  </main>

  <!-- Footer do site -->
  <?php include_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Script para mostrar/esconder senha -->
  <script src="<?= BASE_URL ?>assets/js/password.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
          crossorigin="anonymous"></script>
</body>
</html>
