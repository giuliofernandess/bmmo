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
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online</span>
    </a>

    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="#" class="nav-link text-white">Início</a>
        </li>
        <li class="nav-item">
          <a href="../Information/News/news.php" class="nav-link text-white">Notícias</a>
        </li>
        <li class="nav-item">
          <a href="../Information/AboutTheBand/aboutTheBand.php" class="nav-link text-white">Sobre</a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="container introduction-container text-center">
      <img src="../../assets/images/logo_banda.png" width="100" height="100" alt="Logo" class="mb-3">
      <h1 class="fw-bold">A Banda Online</h1>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni reiciendis repellat nihil labore ab totam culpa
        et quo! Beatae quod porro, reprehenderit placeat aut accusantium cum magni fugit assumenda illo.
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
  <footer class="mt-auto py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
      <span>&copy; Banda de Música</span>
      <div class="d-flex gap-3">
        <a href="https://www.instagram.com/bmmooficial" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>