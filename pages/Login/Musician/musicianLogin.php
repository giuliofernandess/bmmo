<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Músico - Login</title>
  <link rel="shortcut icon" href="../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../assets/css/login.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online</span>
    </a>

    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../Index/index.php" class="nav-link text-white">Início</a>
        </li>
        <li class="nav-item">
          <a href="../../Information/News/news.php" class="nav-link text-white">Notícias</a>
        </li>
        <li class="nav-item">
          <a href="../../Information/AboutTheBand/aboutTheBand.php" class="nav-link text-white">Sobre</a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main>
    <div class="d-flex flex-grow-1 align-items-center justify-content-center flex-column">
      <div class="container login-container">
        <form action="validateMusicianLogin.php" method="post" novalidate>
          <div class="mb-3">
            <label for="loginMusic" class="form-label ps-2">Login</label>
            <input type="text" name="login" id="loginMusic" class="form-control rounded-pill" required />
          </div>

          <div class="mb-4">
            <label for="passwordMusic" class="form-label ps-2">Senha</label>
            <input type="password" name="password" id="passwordMusic" class="form-control rounded-pill" required />
          </div>

          <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 d-flex align-items-center justify-content-center">Acessar</button>
        </form>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
