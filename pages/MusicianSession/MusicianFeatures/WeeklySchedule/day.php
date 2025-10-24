<?php

session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../../../Index/index.php'>";
}

$day = isset($_GET['day']) ? htmlspecialchars(trim($_GET['day'])) : '';
$dayTitle = isset($_GET['dayTitle']) ? htmlspecialchars(trim($_GET['dayTitle'])) : '';
$dayProgramation = isset($_GET['dayProgramation']) ? htmlspecialchars(trim($_GET['dayProgramation'])) : '';

if (empty($day) || empty($dayTitle)) {
  die('Dados incompletos. Volte e tente novamente.');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programação de <?php echo htmlspecialchars($dayTitle); ?></title>
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Músico</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="musicianWeeklySchedule.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="container login-container my-5" style="width: 90%;">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6 mx-auto">
        <h1 class="mb-4 text-center text-primary fs-1 fw-semibold"><?php echo htmlspecialchars($dayTitle); ?></h1>
        <div class="card-body">
          <textarea name="dayProgramation" id="dayProgramation" rows="10" class="form-control" style="height: auto" ;
            disabled><?php echo htmlspecialchars($dayProgramation); ?></textarea>
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