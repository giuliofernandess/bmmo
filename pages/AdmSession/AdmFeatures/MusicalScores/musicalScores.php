<?php
session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../../../Index/index.php'>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Partituras</title>
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../../assets/css/style.css">
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../admPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
    <div class="container introduction-container text-center">
      <img src="../../../../assets/images/logo_banda.png" width="90" height="90" alt="Logo" class="mb-3">
      <h1 class="fw-bold">Painel do Maestro</h1>
      <p class="mb-4">
        Gerencie os músicos, partituras, cronogramas e comunicações da banda.
      </p>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
        <!-- Card 1 -->
        <div class="col">
          <a href="MusicalScoresFeatures/AddMusicalScores/addMusicalScore.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-music-note-beamed fs-2 text-success mb-2"></i>
              <h5 class="fw-bold">Adicionar Partitura</h5>
              <p class="text-muted">Adicione partituras à seus músicos</p>
            </div>
          </a>
        </div>
        <!-- Card 2 -->
        <div class="col">
          <a href="MusicalScoresFeatures/ListOfMusicalScores/listOfMusicalScores.php"
            class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-music-note-list fs-2 text-danger mb-2"></i>
              <h5 class="fw-bold">Lista de Partituras</h5>
              <p class="text-muted">Veja todas as partituras disponíveis</p>
            </div>
          </a>
        </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
</body>

</html>