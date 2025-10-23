<?php

session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=index.php'>";
  exit;
}

$groupId = isset($_GET['id']) ? htmlspecialchars(trim($_GET['id'])) : '';
$day = isset($_GET['day']) ? htmlspecialchars(trim($_GET['day'])) : '';
$dayTitle = isset($_GET['dayTitle']) ? htmlspecialchars(trim($_GET['dayTitle'])) : '';
$dayProgramation = isset($_GET['dayProgramation']) ? htmlspecialchars(trim($_GET['dayProgramation'])) : '';

$bandGroups = [
  '1' => 'Banda Principal',
  '2' => 'Banda Auxiliar',
  '3' => 'Escola',
  '4' => 'Fanfarra',
  '5' => 'Flauta Doce'
];

$bandGroup = $bandGroups[$groupId];

if (empty($day) || empty($dayTitle)) {
  die('Dados incompletos. Volte e tente novamente.');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar dia</title>
  <link rel="shortcut icon" href="../../../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../../../../assets/css/style.css">
  <link rel="stylesheet" href="../../../../../../assets/css/form.css">
  <style>
    .login-container {
      max-width: 800px;
    }

    .btn {
      padding: 0 0 0 12px;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../weeklySchedule.php?bandGroup=<?php echo $bandGroup ?>" class="nav-link text-white"
            style="font-size: 1.4rem;"><i class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="container login-container my-5" style="width: 90%;">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <h3 class="mb-4 text-center text-primary fs-1 fw-semibold">Programação de
          <?php echo htmlspecialchars($dayTitle); ?></h3>
        <div class="card-body">
          <form action="validateDayEdit.php" method="post">
            <div class="mb-3">
              <textarea name="dayProgramation" id="dayProgramation" rows="10" class="form-control" style="height: auto"
                ; required><?php echo htmlspecialchars($dayProgramation); ?></textarea>
            </div>
            <!-- Hidden Inputs -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($groupId); ?>">
            <input type="hidden" name="day" value="<?php echo htmlspecialchars($day); ?>">
            <div class="d-grid">
              <!-- Botão -->
              <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100">Editar Dia</button>
              </div>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>