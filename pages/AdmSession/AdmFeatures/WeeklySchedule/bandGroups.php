<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Maestro</title>
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../admPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
    <div class="container introduction-container text-center">
      <img src="../../../../assets/images/logo_banda.png" width="90" height="90" alt="Logo" class="mb-3">
      <h1 class="fw-bold">Painel de Bandas</h1>
      <p class="mb-4">
        Selecione o grupo musical para gerenciar a agenda.
      </p>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
        <!-- Card Banda Principal -->
        <div class="col">
          <form action="weeklyScheduleEdit/weeklySchedule.php" method="post">
            <input type="hidden" name="bandGroup" value="Banda Principal">
            <button class="card h-100 shadow-sm border-0 p-3 text-decoration-none text-dark">
              <i class="bi bi-music-note-list fs-2 text-primary mb-2"></i>
              <h5 class="fw-bold">Banda Principal</h5>
              <p class="text-muted">Gerencie a programação do grupo principal.</p>
            </button>
          </form>
        </div>

        <!-- Card Banda Auxiliar -->
        <div class="col">
          <form action="weeklyScheduleEdit/weeklySchedule.php" method="post">
            <input type="hidden" name="bandGroup" value="Banda Auxiliar">
            <button class="card h-100 shadow-sm border-0 p-3 px-4 text-decoration-none text-dark">
              <i class="bi bi-music-note-beamed fs-2 text-success mb-2"></i>
              <h5 class="fw-bold">Banda Auxiliar</h5>
              <p class="text-muted">Gerencie a programação da banda auxiliar.</p>
            </button>
          </form>
        </div>

        <!-- Card Escola de Música -->
        <div class="col">
          <form action="weeklyScheduleEdit/weeklySchedule.php" method="post">
            <input type="hidden" name="bandGroup" value="Escola">
            <button class="card h-100 shadow-sm border-0 p-3 text-decoration-none text-dark">
              <i class="bi bi-book-fill fs-2 text-warning mb-2"></i>
              <h5 class="fw-bold">Escola de Música</h5>
              <p class="text-muted">Gerencie a agenda da escola de música.</p>
            </button>
          </form>
        </div>

        <!-- Card Fanfarra -->
        <div class="col">
          <form action="weeklyScheduleEdit/weeklySchedule.php" method="post">
            <input type="hidden" name="bandGroup" value="Fanfarra">
            <button class="card h-100 shadow-sm border-0 p-3 px-2 text-decoration-none text-dark">
              <i class="bi bi-megaphone-fill fs-2 text-danger mb-2"></i>
              <h5 class="fw-bold">Fanfarra</h5>
              <p class="text-muted">Gerencie a programação semanal da fanfarra.</p>
            </button>
          </form>
        </div>

        <!-- Card Flauta Doce -->
        <div class="col">
          <form action="weeklyScheduleEdit/weeklySchedule.php" method="post">
            <input type="hidden" name="bandGroup" value="Flauta Doce">
            <button class="card h-100 shadow-sm border-0 p-3 text-decoration-none text-dark">
              <i class="bi bi-music-note fs-2 text-info mb-2"></i>
              <h5 class="fw-bold">Flauta Doce</h5>
              <p class="text-muted">Gerencie a agenda do grupo de flauta doce.</p>
            </button>
          </form>
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
