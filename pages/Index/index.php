<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMMO Online</title>

  <!-- Links -->
  <link rel="shortcut icon" href="../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark"
    style="background: rgba(13, 110, 253, 0.95); backdrop-filter: blur(6px); box-shadow: 0 2px 15px rgba(0,0,0,0.15);">
    <div class="container-fluid px-3">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
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
            <a class="nav-link text-white" href="#">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../Information/News/news.php">Notícias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../Information/AboutTheBand/aboutTheBand.php">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="container introduction-container text-center">
      <img src="../../assets/images/logo_banda.png" width="100" height="100" alt="Logo" class="mb-3">
      <h1 class="fw-bold">Banda de Música Municipal de Ocara</h1>
      <p>
        A <strong>Banda de Música Maestro Jairo Cláudio Silveira</strong> tem como objetivo proporcionar aos músicos a formação necessária ao desenvolvimento de suas potencialidades como elementos de auto-realização, preparação para o trabalho e para exercício constante de cidadania.
      </p>
      <div class="d-flex flex-wrap gap-3 justify-content-center musician-login-button">
        <a href="../Login/Musician/musicianLogin.php" class="btn btn-primary btn-lg rounded-pill px-4">
          Entrar como integrante
        </a>
        <a href="../Login/Adm/admLogin.php" class="btn btn-outline-info btn-lg rounded-pill px-4">
          Entrar como Maestro
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php require_once '../../general-features/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Hamburguer JS -->
  <script src="../../js/hamburguer"></script>
</body>

</html>