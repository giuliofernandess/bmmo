<?php
require_once "../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";
require_once BASE_PATH . "app/DAO/MusiciansDAO.php";

$musiciansDAO = new MusiciansDAO($conn);

Auth::requireMusician();

$login = $_SESSION['musician_login'] ? trim($_SESSION['musician_login']) : null;
$musicianInfo = $musiciansDAO->findByLogin($login);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Músico</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Toast de sucesso -->
  <?php include_once BASE_PATH ."includes/successToast.php"; ?>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 bg-primary">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="<?= BASE_URL ?>assets/images/band_logo.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Músico</span>
    </a>

    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="<?= BASE_URL ?>pages/logout.php" class="nav-link text-white logout-link-icon"
            id="logout-link">
            <i class="bi bi-box-arrow-left text-white"></i>
          </a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5 px-3">
    <div class="container introduction-container text-center">
      <img src="<?= BASE_URL ?>assets/images/band_logo.png" width="160" height="160" alt="Logo" class="mb-3">
      <h1 class="fw-bold">Bem-vindo(a), <?= htmlspecialchars($musicianInfo ? $musicianInfo->getMusicianName() : ''); ?></h1>
      <p class="mb-4">
        Aqui você pode acessar suas informações, apresentações e partituras.
      </p>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
        <!-- Card 1 -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/musician/profile/index.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-person-circle fs-2 text-primary mb-2"></i>
              <h5 class="fw-bold">Meu Perfil</h5>
              <p class="text-muted">Veja suas informações detalhadas.</p>
            </div>
          </a>
        </div>

        <!-- Card 2 -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/musician/presentations/index.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-calendar-event-fill fs-2 text-success mb-2"></i>
              <h5 class="fw-bold">Apresentações</h5>
              <p class="text-muted">Veja o repertório das próximas apresentações.</p>
            </div>
          </a>
        </div>

        <!-- Card 3 -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/musician/musicalScores/index.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-music-note-beamed fs-2 text-warning mb-2"></i>
              <h5 class="fw-bold">Partituras</h5>
              <p class="text-muted">Acesse as partituras da banda.</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const logoutLink = document.querySelector('#logout-link');

      if (logoutLink) {
        logoutLink.addEventListener('click', (event) => {
          if (!confirmAction('Tem certeza que deseja sair de sua conta?')) {
            event.preventDefault();
          }
        });
      }
    });
  </script>

  <!-- Footer -->
  <?php include_once BASE_PATH . 'includes/footer.php'; ?>

  <script src="<?= BASE_URL ?>assets/js/confirmAction.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>