<?php
require_once '../../../../../general-features/bdConnect.php';

if (!$connect) {
    die("Erro na conexão com o banco de dados.");
}

$bandGroup = isset($_POST['bandGroup']) ? htmlspecialchars(trim($_POST['bandGroup'])) : '';

$bandGroups = [
    'Banda Principal' => '1',
    'Banda Auxiliar' => '2',
    'Escola' => '3',
    'Fanfarra' => '4',
    'Flauta Doce' => '5'
];

if (!array_key_exists($bandGroup, $bandGroups)) {
    die("Grupo de banda inválido.");
}

$groupId = $bandGroups[$bandGroup];

$sql = "SELECT * FROM `agenda` WHERE id = '$groupId'";
$result = $connect->query($sql);

if (!$result) {
    die("Erro na consulta: " . $connect->error);
}

$res = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agenda Semanal</title>
  <link rel="shortcut icon" href="../../../../../assets/images/logo_banda.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../../../assets/css/style.css">
</head>
<body>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none">
      <img src="../../../../../assets/images/logo_banda.png" alt="Logo Banda" width="30" height="30" class="me-2">
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

  <div class="days">
    <?php
    $days = [
        'sunday' => 'Domingo',
        'monday' => 'Segunda-Feira',
        'tuesday' => 'Terça-Feira',
        'wednesday' => 'Quarta-Feira',
        'thursday' => 'Quinta-Feira',
        'friday' => 'Sexta-Feira',
        'saturday' => 'Sábado'
    ];

    foreach ($days as $key => $name) {
        $content = isset($res[$key]) ? $res[$key] : '';

        $escapedContent = htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $escapedTitle = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $escapedKey = htmlspecialchars($key, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        echo '
            <div>
                <h2 class="day">' . $escapedTitle . '</h2>
                <p class="dayProgramation">' . nl2br($escapedContent) . '</p>
                <input type="hidden" name="id" value="' . $groupId . '">
                <input type="hidden" name="day" value="' . $escapedKey . '">
                <input type="hidden" name="dayTitle" value="' . $escapedTitle . '">
                <input type="hidden" name="dayProgramation" value="' . $escapedContent . '">
                <a href="DayEdit/dayEdit.php?id=' . $groupId . '&day=' . $escapedKey . '&dayTitle=' . $escapedTitle . '&dayProgramation=' . $escapedContent .'">Editar dia</a>
            </div>';
    }
    ?>
  </div>

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
