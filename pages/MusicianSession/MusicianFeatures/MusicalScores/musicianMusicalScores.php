<?php
session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../../../Index/index.php'>";
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Partituras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
  <style>
    .card-img-top {
      height: 200px;
      object-fit: cover;
    }

    .btn {
      transition: .2s;
    }

    .btn:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.25);
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 mb-auto">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
      <span class="fs-5 fw-bold">BMMO Online - Músico</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="../../musicianPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="container mb-5 p-5">
    <h1 class="mt-4">Partituras</h1>
    <?php
    require_once '../../../../general-features/bdConnect.php';

    if (!$connect) {
      die('Erro de conexão: ' . mysqli_connect_error());
    }

    if (!isset($_SESSION['bandGroup'])) {
      die("Erro: A informação de 'bandGroup' não foi encontrada na sessão.");
    }

    if (!isset($_SESSION['instrument'])) {
      die("Erro: A informação de 'instrument' não foi encontrada na sessão.");
    }

    $bandGroup = $_SESSION['bandGroup'];
    $instrument = $_SESSION['instrument'];
    $stmt = $connect->prepare("SELECT * FROM `musical_scores` WHERE bandGroup = ? and instrument LIKE '%$instrument%' ORDER BY musicalGenre, name ASC");
    $stmt->bind_param("s", $bandGroup,);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      die("Erro na consulta: " . $connect->error);
    }

    if ($result->num_rows == 0) {
      die("Erro: Nenhuma partitura encontrada para o grupo ou instrumento.");
    }

    if ($result && $result->num_rows > 0) {
      $currentGenre = "";

      echo "<div class='container'>";

      while ($res = $result->fetch_assoc()) {
        if ($currentGenre != $res['musicalGenre']) {
          if ($currentGenre != "") {
            echo "</div>";
          }

          $currentGenre = $res['musicalGenre'];
          echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$currentGenre</h2>";
          echo "<div class='row g-4'>";
        }

        echo "
      <div class='col-12 col-sm-6 col-lg-3'>
        <div class='card musician-card h-100 border-0 shadow-sm'>
          <img src='../../../../assets/images/musical_score.jpg' 
               class='card-img-top musical-score-img' 
               alt='Capa de Partitura'>
          <a href='../../../../assets/musical-scores/" . $res['file'] . "' download type='application/pdf'
             class='card-body d-flex flex-column text-decoration-none'>
            <h5 class='card-title fw-semibold text-center mb-3'>" . htmlspecialchars($res['name']) . "</h5>
            <button class='btn btn-outline-primary mt-auto w-100'>
              <i class='bi bi-person-lines-fill me-1'></i> Baixar Partitura
            </button>
          </a>
        </div>
      </div>";
      }

    }

    echo "</div>";
    echo "</div>";
    ?>


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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>