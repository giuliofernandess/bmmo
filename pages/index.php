<?php require_once '../config/config.php'; ?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMMO Online</title>

  <!-- Links -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo_banda.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/index.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <?php require_once BASE_PATH . 'includes/firstHeader.php'; ?>

  <!-- Card introdutório -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5 px-3 main-gradient">
    <div class="container text-center">
      <div class="mx-auto introduction-container p-4 p-md-5 shadow-lg">

        <img src="<?= BASE_URL ?>assets/images/logo_banda.png" width="120" height="120" alt="Logo"
          class="mb-3 introduction-logo img-fluid">

        <h1 class="fw-bold mb-3 introduction-title">
          Banda de Música Municipal de Ocara
        </h1>

        <p class="mx-auto mb-4 fs-6 fs-md-5" style="max-width: 700px; line-height: 1.6;">
          A <strong>Banda de Música Maestro Jairo Cláudio Silveira</strong> tem como objetivo proporcionar aos músicos a
          formação necessária ao desenvolvimento de suas potencialidades como elementos de auto-realização, preparação
          para o trabalho e para exercício constante de cidadania.
        </p>

        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
          <a href="Login/Musician/musicianLogin.php"
            class="btn btn-primary btn-lg rounded-pill px-4 w-100 w-md-auto btn-shine">
            Entrar como integrante
          </a>

          <a href="Login/Adm/admLogin.php"
            class="btn btn-outline-info btn-lg rounded-pill px-4 w-100 w-md-auto btn-shine">
            Entrar como Maestro
          </a>
        </div>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once BASE_PATH . 'includes/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>