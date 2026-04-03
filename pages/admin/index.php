<?php
require_once "../../config/config.php";
require_once BASE_PATH . "app/Auth/Auth.php";

Auth::requireRegency();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Maestro</title>

  <!-- Configurações Básicas -->
  <?php require_once BASE_PATH . "includes/basicHead.php"; ?>
</head>

<body>
  <!-- Toast de sucesso -->
  <?php include_once BASE_PATH . "includes/successToast.php"; ?>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 bg-primary">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="<?= BASE_URL ?>assets/images/band_logo.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
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
  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
    <div class="container introduction-container text-center">
      <img src="<?= BASE_URL ?>assets/images/band_logo.png" width="160" height="160" alt="Logo" class="mb-3">
      <h1 class="fw-bold">Painel do Maestro</h1>
      <p class="mb-4">
        Gerencie os músicos, partituras, cronogramas e comunicações da banda.
      </p>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">

        <!-- Card: Registrar Músico -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/admin/registerMusician/index.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-person-plus-fill fs-2 text-primary mb-2"></i>
              <h5 class="fw-bold">Cadastrar Músico</h5>
              <p class="text-muted">Adicione novos músicos à banda.</p>
            </div>
          </a>
        </div>

        <!-- Card: Lista de Músicos -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/admin/musicians/index.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-people-fill fs-2 text-success mb-2"></i>
              <h5 class="fw-bold">Relação de Músicos</h5>
              <p class="text-muted">Veja a lista completa dos integrantes.</p>
            </div>
          </a>
        </div>

        <!-- Card: Apresentações -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/admin/presentations/index.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-calendar-week-fill fs-2 text-warning mb-2"></i>
              <h5 class="fw-bold">Apresentações</h5>
              <p class="text-muted">Divulgue os próximos eventos da banda.</p>
            </div>
          </a>
        </div>

        <!-- Card: Lista de Partituras -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/admin/musicalScores/index.php"
            class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 p-3">
              <i class="bi bi-music-note-list fs-2 text-danger mb-2"></i>
              <h5 class="fw-bold">Lista de Partituras</h5>
              <p class="text-muted">Veja todas as partituras disponíveis</p>
            </div>
          </a>
        </div>

        <!-- Card: Criar Notícias -->
        <div class="col">
          <a href="<?= BASE_URL ?>pages/admin/news/index.php" class="text-decoration-none text-dark">
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