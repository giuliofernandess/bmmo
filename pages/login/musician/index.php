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
  <title>Login - Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>

  <!-- CSS da página -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/form.css">
  
</head>

<body class="d-flex flex-column min-vh-100" style="background: linear-gradient(to right, #eef2f3, #d9e9ff);">

  <!-- Toast de erro (aparece quando houver mensagem pendente) -->
  <?php include_once BASE_PATH . 'includes/errorToast.php'; ?>

  <!-- Header do site -->
  <?php include_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Formulário de login centralizado -->
  <main class="d-flex flex-column flex-grow-1 align-items-center justify-content-center px-3 py-5">

    <h1 class="text-center mb-5">Login - Músico</h1>

    <div class="container form-container" style="max-width: 420px;">

      <form action="<?= BASE_URL ?>pages/login/musician/actions/login.php" method="post">
        <!-- Campo login -->
        <div class="mb-3">
          <label for="login" class="form-label ps-2">Login</label>
          <input type="text" name="login" id="login" class="form-control rounded-pill" required />
        </div>

        <!-- Campo senha com botão de mostrar/esconder -->
        <div class="mb-4">
          <label for="password" class="form-label ps-2">Senha</label>
          <div>
            <input type="password" name="password" id="password" class="form-control rounded-pill"
                   minlength="8" maxlength="20" required />
            <i class="bi bi-eye-fill show-password" id="password-btn" onclick="showPassword()"></i>
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
