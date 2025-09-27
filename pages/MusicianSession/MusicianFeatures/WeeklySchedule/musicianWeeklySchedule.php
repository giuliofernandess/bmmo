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
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <header>
    <h1>Agenda Semanal</h1>
  </header>

  <a href="../../musicianPage.php">Voltar</a>

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
            <form action="day.php" method="post">
                <h2 class="day">' . $escapedTitle . '</h2>
                <p class="dayProgramation">' . nl2br($escapedContent) . '</p>
                <input type="hidden" name="day" value="' . $escapedKey . '">
                <input type="hidden" name="dayTitle" value="' . $escapedTitle . '">
                <input type="hidden" name="dayProgramation" value="' . $escapedContent . '">
                <button type="submit">Ver mais</button>
            </form>
        </div>';
    }
    ?>
  </div>

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

  <footer class="bg-light text-center py-3 mt-auto">
    <small>&copy; <?php echo date("Y"); ?> Banda Musical - Músico</small>
  </footer>
</body>
</html>
