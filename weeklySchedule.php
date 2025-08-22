<?php
$connect = mysqli_connect('localhost', 'root', '', 'bmmo') or die('Erro de conexão'. mysqli_connect_error());
$sql = "SELECT * FROM `agenda`";
$result = $connect->query($sql);
$res = $result -> fetch_array();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agenda Semanal</title>
  <link rel="shortcut icon" href="images/logo_banda.png" type="image/x-icon" />
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    h1 {
        color: #2c3e50;
        margin-bottom: 40px;
    }

    .days {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .days div {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        width: 250px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .days div:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .day {
        color: #0077cc;
        font-size: 1.5em;
        margin-bottom: 15px;
    }

    p {
        color: #555;
        min-height: 60px;
        font-size: 1em;
        margin-bottom: 20px;
        white-space: pre-wrap;
    }

    button {
        background-color: #0077cc;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 0.95em;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #005fa3;
    }

    @media (max-width: 768px) {
        .days {
            flex-direction: column;
            align-items: center;
        }

        .days div {
            width: 80%;
        }
    }
  </style>
</head>
<body>
  <a href="admPage.php" class="back-button">Voltar</a>

  <h1 class="fw-bold">Agenda Semanal</h1>

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
        echo '
        <div>
            <form action="editDay.php" method="post">
                <h2 class="day">'.$name.'</h2>
                <p class="dayProgramation">'.nl2br($res[$key]).'</p>
                <input type="hidden" name="day" value="'.$key.'">
                <input type="hidden" name="dayTitle" value="'.$name.'">
                <input type="hidden" name="dayProgramation" value="'.htmlspecialchars($res[$key]).'">
                <button>Editar dia</button>
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
</body>
</html>
