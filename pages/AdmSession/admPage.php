<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=../Index/index.php'>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Maestro</title>

  <!-- Links -->
  <link rel="shortcut icon" href="../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/style.css">
  </style>
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>

    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../general-features/logout.php" class="nav-link text-white"><i class="bi bi-box-arrow-left text-white"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
  <div class="container introduction-container text-center">
    <img src="../../assets/images/logo_banda.png" width="90" height="90" alt="Logo" class="mb-3">
    <h1 class="fw-bold">Painel do Maestro</h1>
    <p class="mb-4">
      Gerencie os músicos, partituras, cronogramas e comunicações da banda.
    </p>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col">
        <a href="AdmFeatures/MusicianRegister/musicianRegister.php" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm border-0 p-3">
            <i class="bi bi-person-plus-fill fs-2 text-primary mb-2"></i>
            <h5 class="fw-bold">Cadastrar Músico</h5>
            <p class="text-muted">Adicione novos músicos à banda.</p>
          </div>
        </a>
      </div>

      <!-- Card 2 -->
      <div class="col">
        <a href="AdmFeatures/ListOfMusicians/musicians.php" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm border-0 p-3">
            <i class="bi bi-people-fill fs-2 text-success mb-2"></i>
            <h5 class="fw-bold">Relação de Músicos</h5>
            <p class="text-muted">Veja a lista completa dos integrantes.</p>
          </div>
        </a>
      </div>

      <!-- Card 3 -->
      <div class="col">
        <a href="AdmFeatures/WeeklySchedule/bandGroups.php" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm border-0 p-3">
            <i class="bi bi-calendar-week-fill fs-2 text-warning mb-2"></i>
            <h5 class="fw-bold">Agenda Semanal</h5>
            <p class="text-muted">Gerencie os ensaios e apresentações.</p>
          </div>
        </a>
      </div>

      <!-- Card 4 -->
      <div class="col">
        <a href="AdmFeatures/MusicalScores/musicalScores.php" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm border-0 p-3">
            <i class="bi bi-music-note-list fs-2 text-danger mb-2"></i>
            <h5 class="fw-bold">Partituras</h5>
            <p class="text-muted">Organize e disponibilize as partituras.</p>
          </div>
        </a>
      </div>

      <!-- Card 5 -->
      <div class="col">
        <a href="AdmFeatures/NewsCreate/newsCreate.php" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm border-0 p-3">
            <i class="bi bi-megaphone-fill fs-2 text-info mb-2"></i>
            <h5 class="fw-bold">Notícias</h5>
            <p class="text-muted">Compartilhe atualizações da banda.</p>
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
