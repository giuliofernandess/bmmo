<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.html'>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página do Maestro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon">

  <style>
    body {
      background: #f8f9fa;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background: #0d6efd;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    .menu-card {
      transition: transform 0.2s;
    }

    .menu-card:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <h1>Bem-vindo, Maestro!</h1>
  </header>

  <!-- Conteúdo -->
  <main class="container my-5 flex-grow-1">
    <div class="row g-4">
      <!-- Card: Cadastrar Músico -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="musicianRegister.php" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Cadastrar Músico</h5>
              <p class="card-text">Adicione novos músicos à banda.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card: Relação de Músicos -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="musicians.php" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Relação de Músicos</h5>
              <p class="card-text">Veja a lista completa dos integrantes.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card: Frequência -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="#" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Frequência</h5>
              <p class="card-text">Gerencie a presença dos músicos.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card: Agenda -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="weeklySchedule.php" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Agenda</h5>
              <p class="card-text">Publique o cronograma semanal.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card: Partituras -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="#" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Partituras</h5>
              <p class="card-text">Acesse as partituras da banda.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card: Notícias -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="createNews.php" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Notícias</h5>
              <p class="card-text">Adicione notícias sobre a banda.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Card: Sair -->
      <div class="col-12 col-md-6 col-lg-4">
        <a href="admLogout.php" class="text-decoration-none">
          <div class="card menu-card shadow-sm h-100 border-danger">
            <div class="card-body text-center text-danger">
              <h5 class="card-title">Sair</h5>
              <p class="card-text">Encerrar sessão do maestro.</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-light text-center py-3 mt-auto">
    <small>&copy; <?php echo date("Y"); ?> Banda Musical - Maestro</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
