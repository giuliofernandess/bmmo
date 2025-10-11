<?php
session_start();

require_once '../../../../general-features/bdConnect.php';

if (!$connect) {
  die("Erro na conexão com o banco de dados.");
}

if (!isset($_SESSION['bandGroup'])) {
  die("Erro: A informação de 'bandGroup' não foi encontrada na sessão.");
}

$bandGroup = $_SESSION['bandGroup'];

$bandGroups = [
  'Banda Principal' => '1',
  'Banda Auxiliar' => '2',
  'Escola' => '3',
  'Fanfarra' => '4',
  'Flauta Doce' => '5'
];

if (!array_key_exists($bandGroup, $bandGroups)) {
  die("Erro: O valor de 'bandGroup' não é válido.");
}

$groupId = $bandGroups[$bandGroup];

$stmt = $connect->prepare("SELECT * FROM `agenda` WHERE id = ?");
$stmt->bind_param("i", $groupId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
  die("Erro na consulta: " . $connect->error);
}

if ($result->num_rows == 0) {
  die("Erro: Nenhuma agenda encontrada para o grupo.");
}

$res = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agenda Semanal</title>
  <link rel="shortcut icon" href="../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
  <style>
    .card-body {
      text-align: center;
    }

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

    @media screen and (min-width: 768px) {
      .card-body {
        text-align: left;
      }
    }
  </style>

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
          <a href="../../musicianPage.php" class="nav-link text-white" style="font-size: 1.4rem;"><i
              class="bi bi-arrow-90deg-left"></i></a>
        </li>
      </ul>
    </nav>
  </header>

  <main class="container my-4">
    <div class="row g-4">
      <?php

      $days = ['sunday' => 'Domingo', 'monday' => 'Segunda-Feira', 'tuesday' => 'Terça-Feira', 'wednesday' => 'Quarta-Feira', 'thursday' => 'Quinta-Feira', 'friday' => 'Sexta-Feira', 'saturday' => 'Sábado'];

      foreach ($days as $key => $name) {
        $content = isset($res[$key]) ? $res[$key] : '';

        $escapedContent = htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $escapedTitle = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $escapedKey = htmlspecialchars($key, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        echo '
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-primary fw-bold fs-3">' . $escapedTitle . '</h5>
                <p class="card-text flex-grow-1 dayProgramation text-muted fs-6">' . nl2br($escapedContent) . '</p>
                <a href="day.php?day=' . $escapedKey . '&dayTitle=' . $escapedTitle . '&dayProgramation=' . $escapedContent . '" class="btn btn-outline-primary btn-sm mt-3 align-center">
                  <i class="bi bi-pencil-square me-1"></i> Editar dia
                </a>
              </div>
            </div>
          </div>';
      }
      ?>
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
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const programations = document.querySelectorAll(".dayProgramation");
      const limit = 50;

      programations.forEach(function (p) {
        const originalText = p.innerText;
        if (originalText.length > limit) {
          p.innerText = originalText.slice(0, limit) + "...";
        }
      });
    });
  </script>

</body>

</html>