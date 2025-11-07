<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Maestro - Login</title>
  <link rel="shortcut icon" href="../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../assets/css/form.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark mb-auto"
    style="background: rgba(13, 110, 253, 0.95); backdrop-filter: blur(6px); box-shadow: 0 2px 15px rgba(0,0,0,0.15);">
    <div class="container-fluid px-3">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
        <span class="fw-bold">BMMO Online</span>
      </a>

      <!-- Botão hamburguer -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Itens do menu -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="../../Index/index.php">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../../Information/News/news.php">Notícias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../../Information/AboutTheBand/aboutTheBand.php">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main>
    <div class="d-flex flex-grow-1 align-items-center justify-content-center flex-column mx-3">
      <div class="container login-container">
        <form action="validateAdmLogin.php" method="post">
          <div class="mb-3">
            <label for="loginMusic" class="form-label ps-2">Login</label>
            <input type="text" name="login" id="loginMusic" class="form-control rounded-pill" required />
          </div>

          <div class="mb-4">
            <label for="passwordMusician" class="form-label ps-2">Senha</label>
            <div>
              <input type="password" name="password" id="passwordMusician" class="form-control rounded-pill"
                minlength="8" maxlength="20" required />
              <i class="bi bi-eye-fill show-password" id="passwordBtn" onclick="showPassword()"></i>
            </div>
          </div>

          <button type="submit"
            class="btn btn-primary btn-lg rounded-pill px-4 d-flex align-items-center justify-content-center">Acessar</button>
        </form>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../../general-features/footer.php'; ?>

  <script src="../../../js/password.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>

</html>