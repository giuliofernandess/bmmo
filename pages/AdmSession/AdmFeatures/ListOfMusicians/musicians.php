<?php

session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../../../Index/index.php'>";
}

$bandGroup = $_GET['bandGroup'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
  <title>Relação de músicos</title>
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
      <span class="fs-5 fw-bold">BMMO Online - Maestro</span>
    </a>
    <nav>
      <ul class="nav">
        <li class="nav-item">
          <a href="bandGroups.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="container mb-5 p-5">
    <?php
    require_once '../../../../general-features/bdConnect.php';

    if (!$connect) {
      echo "<div class='alert alert-danger'>Erro ao conectar com o banco de dados.</div>";
      exit;
    }

    $sql = "SELECT * FROM musicians WHERE bandGroup = '$bandGroup' ORDER BY instrument ASC";
    $result = $connect->query($sql);

    $instrument = "";

    echo "<h1 class='mt-4'>Musicos da {$bandGroup}</h1>";

    while ($res = $result->fetch_assoc()) {
      if ($instrument != $res['instrument']) {
        $instrument = $res['instrument'];
        echo "<h2 class='mt-5 border-bottom pb-2 text-primary mb-4'>$instrument</h2>";
        echo "<div class='row g-4 mt-3'>";
      }

      $image = !empty($res['image']) && file_exists("../../../../assets/images/musicians-images/{$res['image']}")
        ? "../../../../assets/images/musicians-images/{$res['image']}"
        : "../../../../assets/images/musicians-images/default.png";

      echo "
          <div class='col-12 col-md-6 col-lg-3 mt-0 mb-5 w-auto'>
            <div class='card musician-card h-100 border-0 shadow-sm'>
            <img src='{$image}' class='card-img-top' alt='Imagem de {$res['name']}'>
              <a href='Profile/musicianProfile.php?idMusician={$res['idMusician']}' class='card-body d-flex flex-column text-decoration-none'>
                <h5 class='card-title fw-semibold text-center mb-3'>{$res['name']}</h5>
                <button class='btn btn-outline-primary mt-auto w-100'>
                  <i class='bi bi-person-lines-fill me-1'></i> Ver Perfil
                </button>
              </a>
            </div>
          </div>
";
    }
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>